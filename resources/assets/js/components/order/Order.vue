<template>
    <v-card class="elevation-0 bg-card">
        <template v-if="isShowOrderContent">
            <v-card>
                <v-card-text>
                    <v-form>
                        <template v-if="isCreation">
                            <v-btn @click="resetData" color="primary">Обнулить данные</v-btn>
                        </template>
                        <template v-if="!isCreation">
                            <v-btn @click="recalculatePrices" :disabled="loading" :loading="loading" color="primary">Пересчитать цены</v-btn>
                            <v-select
                                v-model="selectedPrices"
                                :items="orderData.prices"
                                @change="saveOrderDataToLocalStorage"
                                item-text="created_at"
                                return-object>
                            </v-select>
                        </template>
                        <v-container grid-list-md>
                            <v-layout justify-start wrap>
                                <v-flex xs12 md3 offset-md2>
                                    <v-menu
                                        ref="dollarDateMenu"
                                        slot="append-outer"
                                        :close-on-content-click="false"
                                        v-model="dollarDateCalendar"
                                        :nudge-right="33"
                                        :return-value.sync="orderData.dollar_date"
                                        lazy
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        min-width="290px">
                                        <v-text-field
                                            slot="activator"
                                            v-validate="'required|date_format:YYYY-MM-DD'"
                                            data-vv-name="dollar_date"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('dollar_date')"
                                            v-model="orderData.dollar_date"
                                            label="Дата курса доллара"
                                            readonly>
                                            <div :slot="$vuetify.breakpoint.smAndDown ? 'append-outer' : 'prepend'">
                                                <v-icon
                                                    color="info">
                                                    date_range
                                                </v-icon>
                                            </div>
                                        </v-text-field>
                                        <v-date-picker
                                            v-model="orderData.dollar_date"
                                            @input="$refs.dollarDateMenu.save(orderData.dollar_date)"
                                            :max="new Date().toISOString().slice(0, 10)"></v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <v-flex xs12 md3>
                                    <v-text-field
                                        v-validate="'required|decimal|min_value:0'"
                                        data-vv-name="dollar_rate"
                                        data-vv-as=" "
                                        :error-messages="errors.collect('dollar_rate')"
                                        @input="replaceComma($event, orderData, 'dollar_rate')"
                                        @change="saveOrderDataToLocalStorage"
                                        :value="orderData.dollar_rate"
                                        label="Курс Доллара"
                                        :readonly="!isDollarRateEditing">
                                        <v-slide-x-reverse-transition
                                            slot="append-outer"
                                            mode="out-in">
                                            <v-icon
                                                :color="isDollarRateEditing ? 'success' : 'info'"
                                                :key="`icon-${isDollarRateEditing}`"
                                                @click="switchDollarEditing"
                                                v-text="isDollarRateEditing ? 'done_all' : 'edit'"
                                            ></v-icon>
                                        </v-slide-x-reverse-transition>
                                    </v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout v-if="isCreation" wrap :justify-center="$vuetify.breakpoint.mdAndUp" :justify-start="$vuetify.breakpoint.smAndDown">
                                <v-flex xs12 sm7 md6>
                                    <v-autocomplete
                                        v-if="!isClientCreation"
                                        v-validate="`required|included:${clients.map(client => client.id).join(',')}`"
                                        data-vv-name="client"
                                        :error-messages="errors.collect('client')"
                                        v-model="orderData.client"
                                        :items="clients"
                                        @change="saveOrderDataToLocalStorage"
                                        hide-selected
                                        item-text="text"
                                        item-value="id"
                                        label="Вибирете клиента"
                                        hint="Если в списке нету нужного клиента, то вы можете его создать"
                                        persistent-hint>
                                    </v-autocomplete>
                                    <appCreateClient
                                        v-if="isClientCreation"
                                        :clients="clients"
                                        @existingClientSelected="selectExistingClient"
                                        @clientCreated="selectCreatedClient">
                                    </appCreateClient>
                                </v-flex>
                                <v-flex xs12 sm3 md2>
                                    <v-btn :block="$vuetify.breakpoint.xsOnly" color="primary" @click="isClientCreation = !isClientCreation">
                                        <v-icon small left>compare_arrows</v-icon>
                                        {{ switcherBtnText }}
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                            <v-layout v-else wrap justify-start>
                                <v-flex xs12 offset-md2 md6>
                                    <v-text-field
                                        label="Клиент"
                                        readonly
                                        :value="orderData.client && `${orderData.client.person_full_name} (${orderData.client.company_name})`">
                                    </v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout wrap>
                                <v-flex xs12 offset-md2 md9 lg8 xl6>
                                    <v-layout wrap>
                                        <v-flex xs12 class="mt-3">
                                            <div class="title font-weight-regular">
                                                Статусы заказа:
                                            </div>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-switch
                                                v-validate="{ required: true, included: [true, false] }"
                                                data-vv-name="is_sent"
                                                data-vv-as=" "
                                                :error-messages="errors.collect('is_sent')"
                                                v-model="orderData.statuses.is_sent"
                                                @change="saveOrderDataToLocalStorage"
                                                color="success"
                                                :label="isSentStatus">
                                            </v-switch>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-switch
                                                v-validate="{ required: true, included: [true, false] }"
                                                data-vv-name="is_agreed"
                                                data-vv-as=" "
                                                :error-messages="errors.collect('is_agreed')"
                                                v-model="orderData.statuses.is_agreed"
                                                @change="saveOrderDataToLocalStorage"
                                                color="success"
                                                :label="isAgreedStatus">
                                            </v-switch>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-switch
                                                v-validate="{ required: true, included: [true, false] }"
                                                data-vv-name="is_paid"
                                                data-vv-as=" "
                                                :error-messages="errors.collect('is_paid')"
                                                v-model="orderData.statuses.is_paid"
                                                @change="saveOrderDataToLocalStorage"
                                                color="success"
                                                :label="isPaidStatus">
                                            </v-switch>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-switch
                                                v-validate="{ required: true, included: [true, false] }"
                                                data-vv-name="is_installation_finished"
                                                data-vv-as=" "
                                                :error-messages="errors.collect('is_installation_finished')"
                                                v-model="orderData.statuses.is_installation_finished"
                                                @change="saveOrderDataToLocalStorage"
                                                color="success"
                                                :label="isInstallationFinishedStatus">
                                            </v-switch>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                                <v-flex xs12 offset-md2 md6>
                                    <v-text-field
                                        v-validate="'required|max:100'"
                                        data-vv-name="name"
                                        data-vv-as=" "
                                        :error-messages="errors.collect('name')"
                                        v-model="orderData.name"
                                        @change="saveOrderDataToLocalStorage"
                                        label="Название заказа"></v-text-field>
                                </v-flex>
                                <v-flex xs12 offset-md2 md6>
                                    <v-text-field
                                        v-validate="'required|decimal:2|min_value:0'"
                                        data-vv-name="area"
                                        data-vv-as=" "
                                        :error-messages="errors.collect('area')"
                                        @input="replaceComma($event, orderData, 'area')"
                                        @change="saveOrderDataToLocalStorage"
                                        :value="orderData.area"
                                        label="Площадь"
                                        :suffix="`${priceForArea}$`"></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout wrap v-if="services.length > 0">
                                <v-flex xs12 offset-md2 class="mt-2">
                                    <div class="title font-weight-regular">
                                        Услуги:
                                    </div>
                                </v-flex>
                                <v-flex xs12 offset-md2 md10 v-for="(service, index) in services" :key="`service-${index}`">
                                    <v-checkbox
                                        :key="`service-checkbox-${index}`"
                                        :style="{ padding: 0, margin: index !== 0 ? 0 : false }"
                                        :label="service.name"
                                        v-model="orderData.services"
                                        @change="saveOrderDataToLocalStorage"
                                        :value="service"></v-checkbox>
                                </v-flex>
                                <v-flex xs12 offset-md2 class="mt-2">
                                    <div class="title font-weight-regular">
                                        Дополнительные услуги:
                                    </div>
                                    <div class="mt-2">
                                        <v-btn @click="addOptionalService" style="margin-left: 0;" color="success">Добавить</v-btn>
                                    </div>
                                </v-flex>
                                <v-flex xs12 offset-md2 md6 v-for="(optionalService, index) in orderData.optional_services" :key="`optional-service-${index}`">
                                    <v-card>
                                        <v-card-text>
                                            <v-text-field
                                                v-validate="'required|max:30'"
                                                :data-vv-name="`optional_service_name-${index}`"
                                                data-vv-as=" "
                                                :error-messages="errors.collect(`optional_service_name-${index}`)"
                                                label="Название"
                                                v-model="orderData.optional_services[index].name"
                                                @change="saveOrderDataToLocalStorage">
                                            </v-text-field>
                                            <v-text-field
                                                v-validate="'required|decimal:2|min_value:0'"
                                                :data-vv-name="`optional_service_price-${index}`"
                                                data-vv-as=" "
                                                :error-messages="errors.collect(`optional_service_price-${index}`)"
                                                @input="replaceComma($event, orderData.optional_services[index], 'price', `optional_service_price-${index}`)"
                                                @change="saveOrderDataToLocalStorage"
                                                :value="orderData.optional_services[index].price"
                                                label="Цена">
                                            </v-text-field>
                                            <v-textarea
                                                v-validate="'required'"
                                                :data-vv-name="`optional_service_comment-${index}`"
                                                data-vv-as=" "
                                                :error-messages="errors.collect(`optional_service_comment-${index}`)"
                                                label="Комментарий"
                                                v-model="orderData.optional_services[index].comment"
                                                @change="saveOrderDataToLocalStorage">
                                            </v-textarea>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-btn @click="deleteOptionalService(index)" color="error">Удалить</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-form>
                </v-card-text>
            </v-card>

            <v-card class="mt-3 mb-5">
                <template v-if="isGPSServiceSelected">
                    <v-card-title class="justify-center" primary-title>
                        <div class="headline gps-tracking-header">GPS-трекинг</div>
                    </v-card-title>
                    <v-card-text>
                        <appGPSData
                            v-if="orderData.GPSData"
                            ref="GPSData"
                            :validator="$validator"
                            :orderGPSData="orderData.GPSData"
                            :dollarRate="orderData.dollar_rate"
                            :orderName="orderData.name"
                            :gpsTrackers="gpsTrackers"
                            :fuelLevelSensors="fuelLevelSensors"
                            :fuelFlowmeters="fuelFlowmeters"
                            :identification="identification"
                            :optionalEquipment="optionalEquipment"
                            :gruppedEquipment="gruppedEquipment"
                            :pricesForEquipment="pricesForEquipment"
                            :equipmentDiscount="orderData.equipment_discount"
                            :installationDiscount="orderData.installation_discount"
                            :pricePerDay="orderData.price_for_day"
                            :days="orderData.days"
                            :priceForTransportationPerKm="orderData.price_for_transportation_per_km"
                            :transportationKms="orderData.transportation_kms"
                            :numberOfTrips="orderData.number_of_trips"
                            :route="orderData.route"
                            :cachedData="groupedCachedData"
                            :defaultRowCount="defaultRowCount"
                            @update:orderGPSData="updateOrderGPSData"
                            @add-nested-data:orderGPSData="addNestedDataInOrderGPSData"
                            @delete-nested-data:orderGPSData="deleteNestedDataInOrderGPSData"
                            @copy-values:orderGPSData="copySelectedInOrderGPSData"
                            @drag-n-drop-gps-data="dragNDropGPSData"
                            @rowAdded="addRowToOrderGPSData"
                            @row:spread="spreadRow"
                            @delete:rows="deleteRowsFromOrderGPSData"
                            @delete:cache="deleteCache">
                        </appGPSData>
                        <v-progress-linear
                            v-else
                            :width="10"
                            :size="100"
                            color="primary"
                            indeterminate>
                        </v-progress-linear>
                    </v-card-text>
                </template>
                <v-card-text>
                    <v-layout wrap v-if="isGPSServiceSelected">
                        <v-flex order-xs2 order-sm1 xs12 sm6>
                            <v-container fluid grid-list-xs>
                                <v-layout wrap>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0|max_value:100'"
                                            data-vv-name="installation_discount"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('installation_discount')"
                                            @input="replaceComma($event, orderData, 'installation_discount')"
                                            @change="saveOrderDataToLocalStorage"
                                            :value="orderData.installation_discount"
                                            label="Скидка на монтаж оборудования"
                                            append-icon="%">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0'"
                                            data-vv-name="allInstallationPrice"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('allInstallationPrice')"
                                            :value="allInstallationPrice"
                                            label="Монтаж оборудования"
                                            readonly
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0|max_value:100'"
                                            data-vv-name="equipment_discount"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('equipment_discount')"
                                            @input="replaceComma($event, orderData, 'equipment_discount')"
                                            @change="saveOrderDataToLocalStorage"
                                            :value="orderData.equipment_discount"
                                            label="Скидка на оборудование"
                                            append-icon="%">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0'"
                                            data-vv-name="allEquipmentPrice"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('allEquipmentPrice')"
                                            :value="allEquipmentPrice"
                                            label="Оборудование"
                                            readonly
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0'"
                                            data-vv-name="price_for_day"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('price_for_day')"
                                            @input="replaceComma($event, orderData, 'price_for_day')"
                                            @change="saveOrderDataToLocalStorage"
                                            :value="orderData.price_for_day"
                                            label="Цена за 1 день командировки"
                                            :readonly="!isPriceForDayEditing"
                                            append-icon="₴">
                                            <v-slide-x-reverse-transition
                                                slot="append-outer"
                                                mode="out-in">
                                                <v-icon
                                                    :color="isPriceForDayEditing ? 'success' : 'info'"
                                                    :key="`icon-${isPriceForDayEditing}`"
                                                    @click="switchPriceForDayEditing"
                                                    v-text="isPriceForDayEditing ? 'done_all' : 'edit'"
                                                ></v-icon>
                                            </v-slide-x-reverse-transition>
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:0|min_value:1'"
                                            data-vv-name="days"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('days')"
                                            v-model="orderData.days"
                                            @change="saveOrderDataToLocalStorage"
                                            label="Дней командировки"
                                            :hint="`Фиксированая цена ${orderData.price_for_day} грн/день`"
                                            persistent-hint>
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0'"
                                            data-vv-name="priceForDays"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('priceForDays')"
                                            :value="priceForDays"
                                            label="Командировки / проживание"
                                            readonly
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0'"
                                            data-vv-name="price_for_transportation_per_km"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('price_for_transportation_per_km')"
                                            @input="replaceComma($event, orderData, 'price_for_transportation_per_km')"
                                            @change="saveOrderDataToLocalStorage"
                                            :value="orderData.price_for_transportation_per_km"
                                            label="Цена за 1км"
                                            :readonly="!isPriceForTransportationPerKmEditing"
                                            append-icon="₴">
                                            <v-slide-x-reverse-transition
                                                slot="append-outer"
                                                mode="out-in">
                                                <v-icon
                                                    :color="isPriceForTransportationPerKmEditing ? 'success' : 'info'"
                                                    :key="`icon-${isPriceForTransportationPerKmEditing}`"
                                                    @click="switchPriceForTransportationPerKmEditing"
                                                    v-text="isPriceForTransportationPerKmEditing ? 'done_all' : 'edit'"
                                                ></v-icon>
                                            </v-slide-x-reverse-transition>
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0'"
                                            data-vv-name="transportation_kms"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('transportation_kms')"
                                            @input="replaceComma($event, orderData, 'transportation_kms')"
                                            @change="saveOrderDataToLocalStorage"
                                            :value="orderData.transportation_kms"
                                            label="Растояние км"
                                            :hint="`Фиксированая цена ${orderData.price_for_transportation_per_km} грн/км`"
                                            persistent-hint>
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:0|min_value:1'"
                                            data-vv-name="number_of_trips"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('number_of_trips')"
                                            v-model="orderData.number_of_trips"
                                            @change="saveOrderDataToLocalStorage"
                                            label="Количество поездок"
                                            :type="'number'"
                                            min="1">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|max:30'"
                                            data-vv-name="route"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('route')"
                                            v-model="orderData.route"
                                            @change="saveOrderDataToLocalStorage"
                                            label="Маршрут">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            v-validate="'required|decimal:2|min_value:0'"
                                            data-vv-name="transportationPrice"
                                            data-vv-as=" "
                                            :error-messages="errors.collect('transportationPrice')"
                                            :value="transportationPrice"
                                            label="Транспортные расходы"
                                            readonly
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-flex>
                        <v-flex order-xs1 order-sm2 xs12 sm6>
                            <appEquipmentData
                                v-if="orderData.GPSData"
                                :gruppedEquipment="gruppedEquipment">
                            </appEquipmentData>
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex xs12>
                            <v-container fluid grid-list-xs>
                                <v-layout>
                                    <v-flex xs12>
                                        <div class="text-xs-left display-1 font-weight-bold">
                                            СУММА ВСЕГО: {{ formattedFinalPrice }}
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-layout justify-center :class="{ 'mb-4': isCreation }">
                        <v-flex v-if="isCreation" xs12 sm11 md3>
                            <v-btn
                                block large color="primary"
                                :loading="orderInCreation"
                                :disabled="orderInCreation"
                                @click="createOrder">
                                Создать заказ
                            </v-btn>
                        </v-flex>
                        <v-flex v-else xs12 md8>
                            <v-container fluid grid-list-md>
                                <v-layout wrap justify-center>
                                    <v-flex xs12 sm6>
                                        <v-dialog
                                            v-model="orderUpdating"
                                            persistent
                                            width="300">
                                            <v-card
                                                color="primary"
                                                dark>
                                                <v-card-text>
                                                    Обновление данных..
                                                    <v-progress-linear
                                                        color="white"
                                                        class="mb-0"
                                                        indeterminate>
                                                    </v-progress-linear>
                                                </v-card-text>
                                            </v-card>
                                        </v-dialog>
                                        <v-btn
                                            @click="updateOrder"
                                            large
                                            block
                                            color="info"
                                            :disabled="loading"
                                            :loading="loading">
                                                <v-icon left>backup</v-icon>Сохранить
                                        </v-btn>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-dialog
                                            v-model="pdfLoading"
                                            persistent
                                            width="300">
                                            <v-card
                                                color="primary"
                                                dark>
                                                <v-card-text>
                                                    {{ pdfLoadStatus }} <template v-if="pdfLoaded !== 0">({{ pdfLoaded }}МБ)</template>
                                                    <v-progress-linear
                                                        indeterminate
                                                        color="white"
                                                        class="mb-0">
                                                    </v-progress-linear>
                                                </v-card-text>
                                            </v-card>
                                        </v-dialog>
                                        <v-btn
                                            @click="createPDF"
                                            color="primary"
                                            large
                                            block
                                            :disabled="loading"
                                            :loading="loading">
                                                Создать PDF <v-icon right>get_app</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-flex>
                    </v-layout>
                </v-card-actions>
                <v-card-actions v-if="!isCreation">
                    <v-layout justify-center class="mb-4">
                        <v-flex xs12 sm8 md6>
                            <appOrderPDF :orderID="order.id"></appOrderPDF>
                        </v-flex>
                    </v-layout>
                </v-card-actions>
            </v-card>

            <v-expansion-panel popout class="mt-3" v-if="!isCreation">
                <v-expansion-panel-content
                    ref="scroll-pdf-target"
                    class="elevation-1">
                    <div slot="header" class="headline pdf-preview">PDF превью</div>
                    <v-card>
                        <v-card-text :class="{ 'pdf-preview-overflow': $vuetify.breakpoint.lgAndDown }">
                            <appPDF
                                v-scroll="onScroll"
                                :dollarRate="orderData.dollar_rate"
                                :dollarDate="orderData.dollar_date"
                                :optionalServices="orderData.optional_services"
                                :services="orderData.services"
                                :gpsData="orderData.GPSData"
                                :gruppedEquipment="gruppedEquipment"
                                :equipmentPrice="allEquipmentPrice"
                                :installationPrice="allInstallationPrice"
                                :transportPrice="transportationPrice"
                                :priceForDays="priceForDays"
                                :finalPrice="finalPrice"
                                :servicePrices="servicePrices"></appPDF>
                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </template>
        <template v-else>
            <v-layout wrap>
                <v-flex xs12 d-flex justify-center>
                    <v-progress-circular
                        :width="10"
                        :size="150"
                        color="primary"
                        indeterminate>
                        Инициализация...
                    </v-progress-circular>
                </v-flex>
            </v-layout>
        </template>
        <v-snackbar v-model="snack" :timeout="snackTimeout" :color="snackColor">
            {{ snackText }}
        </v-snackbar>
        <transition
                appear
                enter-class=""
                enter-active-class="animated popIn"
                leave-class=""
                leave-active-class="animated popOut"
                mode="out-in">
            <v-btn
                v-if="isShowScrollBtn"
                @click="scrollToPDF"
                @dblclick="scrollToTop"
                color="info" fixed bottom right fab>
                <v-icon>keyboard_arrow_up</v-icon>
            </v-btn>
        </transition>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
import CreateClient from './../client/createClient/CreateClient';
import GPSData from './gpsData/GPSData';
import EquipmentData from './EquipmentData/EquipmentData';
import PDF from './PDF/PDF';
import OrderPDF from './OrderPDF/OrderPDF';
import dcopy from 'deep-copy';
import utils from './../../mixins/utils.js';
import setStyles from './../../mixins/stylesMixins.js'
import forms from './../../mixins/forms.js';
import formatter from 'accounting';
import diff from 'deep-diff';
import pdfLayoutNames from './../../constants/ServicesPreviewNames.js';
import { uploadImage } from './../../constants/images';

export default {
    mixins: [utils, setStyles, forms],
    props: {
        isCreation: {
            type: Boolean,
            required: false,
            default: false
        },
        order: {
            type: Object,
            required: false
        }
    },
    data() {
        const todayDate = this.getTodaysDate();
        return {
            initialized: false,
            creationInitialized: false,
            pdfLoaded: 0,
            pdfLoadStatus: 'Создание Документа',
            pdfLoading: false,
            orderUpdating: false,
            loading: false,
            isDollarRateEditing: false,
            isPriceForDayEditing: false,
            isPriceForTransportationPerKmEditing: false,
            snack: false,
            dollarDateCalendar: false,
            snackColor: '',
            snackText: '',
            snackTimeout: 1500,
            defaultRowCount: 0,
            initialGPSRowData: {
                id: 1,
                order: 1,
                multiplier: 1,
                image: '',
                type: '',
                mark: '',
                model: '',
                year_of_issue: '',
                fuel_type: '',
                power: '',
                number: '',
                gps_tracker: '',
                fuel_gauge: [],
                counter: '',
                rf_id: '',
                reader_of_trailed_equipment: '',
                // connect_module: '',
                can_reader: '',
                deaerator_small: '',
                deaerator_large: '',
                // deaerator: '',
                additional_equipment: [],
                cn03: [],
                rs01: [],
                manual_installation_price: 0
            },
            mappedColumnNames: {
                gps_tracker: 'GPS трекер',
                fuel_gauge: 'ДУТ',
                counter: 'Лічильник',
                rf_id: 'RFID водія',
                reader_of_trailed_equipment: 'Зчитувач причіпного',
                can_reader: 'CAN reader',
                deaerator_small: 'Деаэратор малий',
                deaerator_large: 'Деаэратор великий',
                cn03: 'Модуль CN03',
                rs01: 'Модуль RS01',
                additional_equipment: ''
            },
            cachedData: [],
            orderInCreation: false,
            oldOrder: {},
            selectedPrices: null,
            orderData: {
                name: '',
                client: null,
                statuses: { is_sent: false, is_agreed: false, is_paid: false, is_installation_finished: false },
                area: '',
                dollar_rate: 0.00,
                dollar_date: todayDate,
                installation_discount: 0,
                equipment_discount: 0,
                days: '',
                price_for_day: 720,
                price_for_transportation_per_km: 4.2,
                number_of_trips: 2,
                transportation_kms: '',
                route: '',
                prices: [],
                services: [],
                optional_services: [],
                GPSData: null
            },
            clients: [],
            isClientCreation: false,
            isShowScrollBtn: false
        };
    },
    computed: {
        ...mapGetters({
            'newPriceList': 'priceList',
            'gps': 'gpsTrackers',
            'fuelLvl': 'fuelLevelSensors',
            'fuelFlmtrs': 'fuelFlowmeters',
            'idfication': 'identification',
            'optEquip': 'optionalEquipment',
            'srvcs': 'services'
        }),
        gpsTrackers() {
            if (this.isCreation) return this.gps;
            return this.gps.map(gpsRow => {
                let updatedPrices = [];
                if (!this.isUndefined(this.selectedPrices) && !this.isNull(this.selectedPrices)) {
                    updatedPrices = this.selectedPrices.prices.find(row => row.id === gpsRow.id);
                }
                return {
                    ...gpsRow,
                    ...updatedPrices
                }
            });
        },
        fuelLevelSensors() {
            if (this.isCreation) return this.fuelLvl;
            return this.fuelLvl.map(fuelLvlRow => {
                let updatedPrices = [];
                if (!this.isUndefined(this.selectedPrices) && !this.isNull(this.selectedPrices)) {
                    updatedPrices = this.selectedPrices.prices.find(row => row.id === fuelLvlRow.id);
                }
                return {
                    ...fuelLvlRow,
                    ...updatedPrices
                }
            });
        },
        fuelFlowmeters() {
            if (this.isCreation) {
                return this.fuelFlmtrs;
            }
            return this.fuelFlmtrs.map(fuelFlmtrsRow => {
                let updatedPrices = [];
                if (!this.isUndefined(this.selectedPrices) && !this.isNull(this.selectedPrices)) {
                    updatedPrices = this.selectedPrices.prices.find(row => row.id === fuelFlmtrsRow.id);
                }
                return {
                    ...fuelFlmtrsRow,
                    ...updatedPrices
                }
            });
        },
        identification() {
            if (this.isCreation) {
                return this.idfication;
            }
            return this.idfication.map(idficationRow => {
                let updatedPrices = [];
                if (!this.isUndefined(this.selectedPrices) && !this.isNull(this.selectedPrices)) {
                    updatedPrices = this.selectedPrices.prices.find(row => row.id === idficationRow.id);
                }
                return {
                    ...idficationRow,
                    ...updatedPrices
                }
            });
        },
        optionalEquipment() {
            if (this.isCreation) {
                return this.optEquip;
            }
            return this.optEquip.map(optEquipRow => {
                let updatedPrices = [];
                if (!this.isUndefined(this.selectedPrices) && !this.isNull(this.selectedPrices)) {
                    updatedPrices = this.selectedPrices.prices.find(row => row.id === optEquipRow.id);
                }
                return {
                    ...optEquipRow,
                    ...updatedPrices
                }
            });
        },
        services() {
            if (this.isCreation) {
                return this.srvcs;
            }
            return this.srvcs.map(srvcsRow => {
                let updatedPrices = [];
                if (!this.isUndefined(this.selectedPrices) && !this.isNull(this.selectedPrices)) {
                    updatedPrices = this.selectedPrices.prices.find(row => row.id === srvcsRow.id);
                }
                return {
                    ...srvcsRow,
                    ...updatedPrices
                }
            });
        },
        priceList() {
            return [
                ...this.gpsTrackers,
                ...this.fuelLevelSensors,
                ...this.fuelFlowmeters,
                ...this.identification,
                ...this.optionalEquipment,
                ...this.services
            ];
        },
        switcherBtnText() {
            return this.isClientCreation ? 'Выбрать клиента' : 'Создать клиента';
        },
        isSentStatus() {
            return this.orderData.statuses.is_sent ? 'Отправленный' : 'Неотправленный';
        },
        isAgreedStatus() {
            return this.orderData.statuses.is_agreed ? 'Согласованный' : 'Несогласованный';
        },
        isPaidStatus() {
            return this.orderData.statuses.is_paid ? 'Оплаченный' : 'Неоплаченный';
        },
        isInstallationFinishedStatus() {
            return this.orderData.statuses.is_installation_finished ? 'Монтаж закончен' : 'Монтаж не закончен';
        },
        isShowOrderContent() {
            if (this.isCreation) {
                return this.creationInitialized;
            }
            return this.initialized;
        },
        isGPSServiceSelected() {
            return this.orderData.services.some(service => service.pdf_layout === pdfLayoutNames.ENGINEER_PROJECT);
        },
        formattedDollarDate() {
            return this.orderData.dollar_date.split('-').join('');
        },
        groupedCachedData() {
            return this.cachedData.reduce((groupedCache, cache) => {
                if (groupedCache[cache.column_name]) {
                    groupedCache[cache.column_name].push(cache);
                } else {
                    groupedCache[cache.column_name] = [cache]
                }
                return groupedCache;
            }, {});
        },
        gpsTrackingData() {
            return this.orderData.GPSData.map(gpsRow => {
                const multiplier = (gpsRow.multiplier < 1) ? 1 : gpsRow.multiplier;
                return {
                    equipment: Object.keys(gpsRow).reduce((equipment, key) => {
                        if (Object.keys(this.mappedColumnNames).indexOf(key) !== -1) {
                            if (Array.isArray(gpsRow[key])) {
                                let gpsRowArray = gpsRow[key].filter(row => this.isObject(row));
                                if (gpsRowArray.length === 0) return equipment;
                                const equipmentMap = {};

                                for (let i = 0; i < gpsRowArray.length; ++i) {
                                    if (!equipmentMap[gpsRowArray[i].id]) {
                                        equipmentMap[gpsRowArray[i].id] = {
                                            image: `storage/${gpsRowArray[i].image}`,
                                            name: gpsRowArray[i].name,
                                            count: 1,
                                            price: gpsRowArray[i].price
                                        };
                                    } else {
                                        ++equipmentMap[gpsRowArray[i].id].count;
                                    }
                                }
                                const equipmentData = Object.keys(equipmentMap).reduce((data, id) => {
                                    data.push({
                                        image: equipmentMap[id].image,
                                        name: `${this.mappedColumnNames[key]} ${equipmentMap[id].count}шт ${equipmentMap[id].name}`,
                                        price: this.multiplyTwoFloats(equipmentMap[id].price, equipmentMap[id].count)
                                    });
                                    return data;
                                }, []);

                                equipment.push(...equipmentData);
                            } else if (this.isObject(gpsRow[key])) {
                                equipment.push({
                                    image: `storage/${gpsRow[key].image}`,
                                    name: `${this.mappedColumnNames[key]} ${gpsRow[key].name}`,
                                    price: gpsRow[key].price
                                });
                            }
                        }
                        return equipment;
                    }, []),
                    multiplier: multiplier,
                    transportImage: gpsRow.image.slice(1),
                    transportName: `${(this.isNull(gpsRow.mark) || this.isUndefined(gpsRow.mark)) ? '' : gpsRow.mark}${(this.isNull(gpsRow.model) || this.isUndefined(gpsRow.model)) ? '' : ` ${gpsRow.model}`}`
                };
            });
        },
        gruppedEquipment() {
            const countEquipment = this.orderData.GPSData.reduce((grupped, row) => {
                const multiplier = (row.multiplier < 1) ? 1 : row.multiplier;
                Object.keys(row).forEach((key) => {
                    const value = row[key];
                    if (this.isObject(value)) {
                        if (!grupped[row[key].id]) {
                            grupped[row[key].id] = {
                                type: row[key].name,
                                price: this.multiplyTwoFloats(multiplier, parseFloat(row[key].price)),
                                count: multiplier
                            };
                        } else {
                            grupped[row[key].id].count += multiplier;
                            grupped[row[key].id].price = this.addTwoFloats(grupped[row[key].id].price, this.multiplyTwoFloats(multiplier, row[key].price));
                        }
                    } else if (Array.isArray(value)) {
                        value
                            .forEach((el, index) => {
                                if (this.isUndefined(el) || this.isNull(el)) return;
                                if (!grupped[el.id]) {
                                    grupped[el.id] = {
                                        type: el.name,
                                        price: this.multiplyTwoFloats(multiplier, parseFloat(el.price)),
                                        count: multiplier
                                    };
                                } else {
                                    grupped[el.id].count += multiplier;
                                    grupped[el.id].price = this.addTwoFloats(grupped[el.id].price, this.multiplyTwoFloats(multiplier, el.price));
                                }
                            })
                    }
                });
                return grupped;
            }, {});
            const gruppedEquipment = Object.keys(countEquipment).map((key) =>({
                type: countEquipment[key].type,
                price: countEquipment[key].price,
                count: countEquipment[key].count
            }));
            return gruppedEquipment;
        },
        area() {
            return (this.orderData.area === '' || this.orderData.area === null) ? 0 : parseFloat(this.orderData.area);
        },
        servicePrices() {
            return this.orderData.services.reduce((servicePrices, service) => {
                if (service.pdf_layout === pdfLayoutNames.INTEGRATION_1C) {
                    let price = 0.0;
                    for (let i = 0; i < service.prices_for_ranges.length; ++i) {
                        if (i + 1 === service.prices_for_ranges.length) {
                            if (this.area >= parseFloat(service.prices_for_ranges[i].from)) {
                                price = this.multiplyTwoFloats(parseFloat(service.prices_for_ranges[i].price), this.area);
                                break;
                            }
                        } else if (this.area >= parseFloat(service.prices_for_ranges[i].from) && this.area < parseFloat(service.prices_for_ranges[i].to)) {
                            price = this.multiplyTwoFloats(parseFloat(service.prices_for_ranges[i].price), this.area);
                            break;
                        }
                    }
                    servicePrices.push({
                        service,
                        price
                    });
                } else if (service.pdf_layout !== pdfLayoutNames.ENGINEER_PROJECT) {
                    servicePrices.push({
                        service,
                        price: this.multiplyTwoFloats(service.price, this.area)
                    });
                }
                return servicePrices;
            }, []);
        },
        priceForArea() {
            const priceForServices = this.servicePrices.reduce((price, serviceData) => this.addTwoFloats(price, serviceData.price), 0.0);
            const finalPriceForArea = this.orderData.optional_services ? this.orderData.optional_services.reduce((price, service) => this.addTwoFloats(price, this.multiplyTwoFloats(service.price, this.area)), priceForServices) : priceForServices;
            return finalPriceForArea;
        },
        priceForDays() {
            return this.multiplyTwoFloats(this.orderData.days, this.orderData.price_for_day);
        },
        transportationPrice() {
            return this.multiplyTwoFloats(this.multiplyTwoFloats(this.orderData.price_for_transportation_per_km, this.orderData.transportation_kms), this.orderData.number_of_trips);
        },
        pricesForEquipment() {
            const defaultPrices = { equipmentPrices: [], installationPrices: [] };
            if (!this.orderData.GPSData) return defaultPrices;
            return this.orderData.GPSData.reduce((prices, row, index) => {
                prices.equipmentPrices.push({});
                const isInstallationPriceManuallySet = !!row.manual_installation_price && row.manual_installation_price !== '0';
                const manualInstallationPrice = parseFloat(row.manual_installation_price);
                const isValidManualInstallationPrice = this.isNumber(manualInstallationPrice) && manualInstallationPrice > 0;
                prices.installationPrices[index] = isInstallationPriceManuallySet && isValidManualInstallationPrice ? manualInstallationPrice : 0.00;
                Object.keys(row).forEach((key) => {
                    const value = row[key];
                    const priceKey = `${key}_price`;
                    if (this.isObject(value)) {
                        prices.equipmentPrices[index][priceKey] = row[key].price;
                        if (!isValidManualInstallationPrice || !isInstallationPriceManuallySet) {
                            prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], row[key].installation_price_for_one);
                        }
                    } else if (Array.isArray(value)) {
                        prices.equipmentPrices[index][priceKey] = 0.00;
                        const filteredEquipment = value.filter(el => !this.isUndefined(el) && !this.isNull(el));
                        if ((!isValidManualInstallationPrice || !isInstallationPriceManuallySet) && filteredEquipment.length > 0) {
                            const el = filteredEquipment[0];
                            switch (filteredEquipment.length) {
                                case 1:
                                    prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_one);
                                    break;
                                case 2:
                                    if (el.installation_price_for_two) {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_two);
                                    } else {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_one);
                                    }
                                    break;
                                case 3:
                                    if (el.installation_price_for_three) {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_three);
                                    } else if (el.installation_price_for_two) {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_two);
                                    } else {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_one);
                                    }
                                    break;
                                default:
                                    break;
                            }
                        }
                        filteredEquipment
                            .forEach((el) => {
                                prices.equipmentPrices[index][priceKey] = this.addTwoFloats(prices.equipmentPrices[index][priceKey], el.price);
                            });
                    }
                });
                return prices;
            }, defaultPrices);
        },
        allEquipmentPrice() {
            const price = this.multiplyTwoFloats(this.pricesForEquipment.equipmentPrices.reduce((price, el, index) => {
                return this.addTwoFloats(price, Object.keys(el).reduce((price, key) => this.addTwoFloats(price, this.multiplyTwoFloats(this.orderData.GPSData[index].multiplier, el[key])), 0.00));
            }, 0.00), this.orderData.dollar_rate);
            const discount = this.multiplyTwoFloats(price, this.divideTwoFloats(parseFloat(this.orderData.equipment_discount), 100));
            return this.subtractTwoFloats(price, discount);
        },
        allInstallationPrice() {
            const price = this.pricesForEquipment.installationPrices.reduce((price, el, index) => this.addTwoFloats(price, this.multiplyTwoFloats(this.orderData.GPSData[index].multiplier, el)), 0.00);
            const discount = this.multiplyTwoFloats(price, this.divideTwoFloats(parseFloat(this.orderData.installation_discount), 100));
            return this.subtractTwoFloats(price, discount);
        },
        finalPrice() {
            const areaPrice = this.multiplyTwoFloats(this.priceForArea, this.orderData.dollar_rate);
            return this.isGPSServiceSelected ? this.addTwoFloats(areaPrice, this.addTwoFloats(
                this.priceForDays, this.addTwoFloats(
                    this.transportationPrice, this.addTwoFloats(
                        this.allEquipmentPrice, this.allInstallationPrice
                    )
                )
            )) : areaPrice;
        },
        formattedFinalPrice() {
            return formatter.formatMoney(this.finalPrice, {
                symbol: "₴",
                precision: 2,
                thousand: " ",
                format: {
                    pos : "%v%s",
                    zero: "%v%s"
                }
            });
        }
    },
    watch: {
        order() {
            this.initOrder();
            this.loading = false;
            this.orderUpdating = false;
            this.snackColor = 'success';
            this.snackText = 'Сохранено';
            this.snack = true;
        },
        selectedPrices(newVal) {
            this.orderData.prices = this.orderData.prices.map(prices => ({
                ...prices,
                is_current: prices.id === newVal.id
            }));
            this.orderData.GPSData = this.orderData.GPSData.map(gpsDataRow => {
                return Object.keys(gpsDataRow).reduce((newGpsDataRow, key) => {
                    if (this.isObject(gpsDataRow[key])) {
                        newGpsDataRow[key] = this.priceList.find(priceListRow => priceListRow.id === gpsDataRow[key].id);
                    } else if (Array.isArray(gpsDataRow[key])) {
                        newGpsDataRow[key] = gpsDataRow[key].map(gpsItem => (!this.isUndefined(gpsItem) && !this.isNull(gpsItem)) ? this.priceList.find(priceListRow => priceListRow.id === gpsItem.id) : gpsItem);
                    } else {
                        newGpsDataRow[key] = gpsDataRow[key];
                    }
                    return newGpsDataRow;
                }, {});
            });
            this.orderData.services = this.orderData.services.map(orderService => this.services.find(service => service.id === orderService.id));
        },
        'orderData.dollar_date'() {
            this.getDollarRate(this.formattedDollarDate);
        }
        // services(newValue) {
        //     this.orderData.services = this.services.map(service => ({ id: service.id, name: service.name, price: service.price, value: false }));
        // }
    },
    methods: {
        onScroll(e) {
            const pdfOffset = this.$refs['scroll-pdf-target'].$el.offsetTop;
            const currentOffsetTop = window.pageYOffset || document.documentElement.scrollTop;
            this.isShowScrollBtn = currentOffsetTop >= pdfOffset;
        },
        scrollToTop() {
            this.$vuetify.goTo(0);
        },
        scrollToPDF() {
            this.$vuetify.goTo('#pdf', {
                offset: -150
            });
        },
        initOrderCreationMode() {
            this.defaultRowCount = 4;
            this.orderData.GPSData = [];
            const savedOrderData = localStorage.getItem('orderData');
            Promise.all([this.$store.dispatch('getPriseList'), this.getClients()])
                .then(() => {
                    if (savedOrderData) {
                        const parsedSavedOrderData = JSON.parse(savedOrderData);
                        const { dollar_rate, dollar_date, ...data } = parsedSavedOrderData;
                        const todayDate = this.getTodaysDate();
                        this.orderData = {
                            ...data,
                            dollar_rate: 0.00,
                            dollar_date: todayDate
                        };
                        if (parsedSavedOrderData && data.GPSData.length > 0) {
                            this.initialGPSRowData.id = data.GPSData[data.GPSData.length - 1].id + 1;
                            this.initialGPSRowData.order = data.GPSData[data.GPSData.length - 1].order + 1;
                        }
                    }
                    this.creationInitialized = true;
                });
            this.getDollarRate(this.formattedDollarDate);
        },
        initOrderModificationMode() {
            this.$store.dispatch('getPriseList')
                .then(() => {
                    this.selectedPrices = this.order.prices.find(pricesRow => pricesRow.is_current);
                    this.initOrder();
                });
        },
        initOrder() {
            let copyOrder = dcopy(this.order);
            copyOrder.services = copyOrder.services.map(serviceID => this.services.find(service => service.id === serviceID));
            let id = 0;
            copyOrder.gps_data = copyOrder.gps_data.map(gpsDataRow => {
                if (gpsDataRow.id > id) {
                    id = gpsDataRow.id;
                }
                return Object.keys(gpsDataRow).reduce((newRow, key) => {
                    if (key !== 'id' && key !== 'order' && key !== 'order_id' && key !== 'multiplier' && typeof gpsDataRow[key] === 'number') {
                        newRow[key] = this.priceList.find(data => data.id === gpsDataRow[key]);
                    } else if (Array.isArray(gpsDataRow[key])) {
                        newRow[key] = gpsDataRow[key].map(id => this.priceList.find(data => data.id === id));
                    } else if (typeof gpsDataRow[key] === 'string') {
                        newRow[key] = gpsDataRow[key];
                    } else if (this.isNull(gpsDataRow[key]) || this.isUndefined(gpsDataRow[key])) {
                        newRow[key] = '';
                    } else if (key === 'id' || key === 'order' || key === 'order_id' || key === 'multiplier') {
                        newRow[key] = gpsDataRow[key];
                    }
                    return newRow;
                }, {});
            });
            this.initialGPSRowData.id = ++id;
            this.initialGPSRowData.order = copyOrder.gps_data.length + 1;
            this.oldOrder = copyOrder;
            const newOrderData = dcopy(copyOrder);
            this.orderData.name = newOrderData.name;
            this.orderData.client = newOrderData.client;
            this.orderData.statuses = {
                is_sent: newOrderData.is_sent, is_agreed: newOrderData.is_agreed, is_paid: newOrderData.is_paid, is_installation_finished: newOrderData.is_installation_finished
            };
            this.orderData.area = newOrderData.area;
            this.orderData.dollar_rate = newOrderData.dollar_rate;
            this.orderData.dollar_date = newOrderData.dollar_date;
            this.orderData.installation_discount = newOrderData.installation_discount;
            this.orderData.equipment_discount = newOrderData.equipment_discount;
            this.orderData.days = newOrderData.days;
            this.orderData.price_for_day = newOrderData.price_for_day;
            this.orderData.price_for_transportation_per_km = newOrderData.price_for_transportation_per_km;
            this.orderData.number_of_trips = newOrderData.number_of_trips;
            this.orderData.transportation_kms = newOrderData.transportation_kms;
            this.orderData.route = newOrderData.route;
            this.orderData.services = newOrderData.services;
            this.orderData.optional_services = newOrderData.optional_services;
            this.orderData.GPSData = newOrderData.gps_data;
            this.orderData.prices = newOrderData.prices;

            this.initialized = true;
        },
        addCache(column, value) {
            this.axios.post('/cache', { cache: { column_name: column, value } })
                .then(({data}) => {
                    this.cachedData.push(data);
                    this.showSnackbar('success', 'Данные сохранены!');
                })
                .catch(err => {
                    console.log(err);
                    this.showSnackbar('error', 'Ошибка!');
                });
        },
        deleteCache(id) {
            this.axios.delete(`/cache/${id}`)
                .then(() => {
                    const index = this.cachedData.findIndex(cache => cache.id === id);
                    this.cachedData.splice(index, 1);
                    this.showSnackbar('success', 'Данные сохранены!');
                })
                .catch(err => {
                    console.log(err);
                    this.showSnackbar('error', 'Ошибка!');
                });
        },
        addOptionalService() {
            this.orderData.optional_services.push({ name: '', price: '', comment: '' });
            this.saveOrderDataToLocalStorage();
        },
        deleteOptionalService(index) {
            this.orderData.optional_services.splice(index, 1);
            this.saveOrderDataToLocalStorage();
        },
        saveOrderDataToLocalStorage() {
            if (this.isCreation) {
                localStorage.setItem('orderData', JSON.stringify(this.orderData));
                console.log('SAVED TO LOCAL STORAGE');
            }
        },
        deleteOrderDataFromLocalStorage() {
            localStorage.removeItem('orderData');
        },
        resetData() {
            this.deleteOrderDataFromLocalStorage();
            this.initialized = false;
            this.creationInitialized = false;
            this.pdfLoaded = 0;
            this.pdfLoadStatus = 'Создание Документа';
            this.pdfLoading = false;
            this.orderUpdating = false;
            this.loading = false;
            this.isDollarRateEditing = false;
            this.isPriceForDayEditing = false;
            this.isPriceForTransportationPerKmEditing = false;
            this.snack = false;
            this.dollarDateCalendar = false;
            this.snackColor = '';
            this.snackText = '';
            this.snackTimeout = 1500;
            this.defaultRowCount = 0;
            this.initialGPSRowData = {
                id: 1,
                order: 1,
                multiplier: 1,
                image: '',
                type: '',
                mark: '',
                model: '',
                year_of_issue: '',
                fuel_type: '',
                power: '',
                number: '',
                gps_tracker: '',
                fuel_gauge: [],
                counter: '',
                rf_id: '',
                reader_of_trailed_equipment: '',
                // connect_module: '',
                can_reader: '',
                deaerator_small: '',
                deaerator_large: '',
                // deaerator: '',
                additional_equipment: [],
                cn03: [],
                rs01: [],
                manual_installation_price: 0
            }
            this.mappedColumnNames = {
                gps_tracker: 'GPS трекер',
                fuel_gauge: 'ДУТ',
                counter: 'Лічильник',
                rf_id: 'RFID водія',
                reader_of_trailed_equipment: 'Зчитувач причіпного',
                can_reader: 'CAN reader',
                deaerator_small: 'Деаэратор малий',
                deaerator_large: 'Деаэратор великий',
                cn03: 'Модуль CN03',
                rs01: 'Модуль RS01',
                additional_equipment: ''
            };
            this.cachedData = [];
            this.orderInCreation = false;
            this.oldOrder = {};
            this.selectedPrices = null;
            this.orderData = {
                name: '',
                client: null,
                statuses: { is_sent: false, is_agreed: false, is_paid: false, is_installation_finished: false },
                area: '',
                dollar_rate: 0.00,
                dollar_date: this.getTodaysDate(),
                installation_discount: 0,
                equipment_discount: 0,
                days: '',
                price_for_day: 720,
                price_for_transportation_per_km: 4.2,
                number_of_trips: 2,
                transportation_kms: '',
                route: '',
                prices: [],
                services: [],
                optional_services: [],
                GPSData: null
            };
            this.clients = [];
            this.isClientCreation = false;
            this.isShowScrollBtn = false;
            this.initOrderCreationMode();
        },
        getClients() {
            return new Promise((resolve, reject) => {
                this.axios.get('/clients/all')
                    .then(({data}) => {
                        const clients = data.map(client => this.getClientWithTextValue(client));
                        this.clients = clients;
                        resolve()
                    })
                    .catch(err => {
                        console.log(err);
                        reject(err);
                    });
            });
        },
        getCachedData() {
            this.axios.get('/cache')
                .then(({data}) => {
                    this.cachedData = data;
                })
                .catch(err => (console.log(err)));
        },
        getDollarRate(date) {
            this.axios.get(`/order/dollar-rate/${date}`)
                .then(({data}) => {
                    this.orderData.dollar_rate = data[0].rate;
                    this.showSnackbar('success', 'Курс доллара установлен');
                    this.saveOrderDataToLocalStorage();
                })
                .catch(err => {
                    console.log(err);
                    this.showSnackbar('error', 'Ошибка!');
                });
        },
        switchDollarEditing() {
            this.isDollarRateEditing = !this.isDollarRateEditing;
            if (!this.isDollarRateEditing) {
                this.showSnackbar('success', 'Данные сохранены!');
            } else {
                this.showSnackbar('info', 'Редактирование курса доллара');
            }
        },
        switchPriceForDayEditing() {
            this.isPriceForDayEditing = !this.isPriceForDayEditing;
            if (!this.isPriceForDayEditing) {
                this.showSnackbar('success', 'Данные сохранены!');
            } else {
                this.showSnackbar('info', 'Редактирование цены командировки за 1 день');
            }
        },
        switchPriceForTransportationPerKmEditing() {
            this.isPriceForTransportationPerKmEditing = !this.isPriceForTransportationPerKmEditing;
            if (!this.isPriceForTransportationPerKmEditing) {
                this.showSnackbar('success', 'Данные сохранены!');
            } else {
                this.showSnackbar('info', 'Редактирование цены за 1км');
            }
        },
        recalculatePrices() {
            this.loading = true;
            // const newPrices = this.getPricesData(this.newPriceList);
            this.axios.post(`/order-prices/${this.$route.params.id}`)
                .then(({data}) => {
                    this.orderData.prices.forEach(pricesRow => { pricesRow.is_current = false; });
                    this.orderData.prices.unshift(data);
                    this.selectedPrices = data;
                    this.loading = false;
                    this.showSnackbar('success', 'Цены были успешно пересчитаны');
                    this.saveOrderDataToLocalStorage();
                })
                .catch(err => {
                    console.log(err);
                    this.loading = false;
                    this.showSnackbar('error', 'Ошибка!');
                });
        },
        showSnackbar(snackColor, snackText) {
            this.snackColor = snackColor;
            this.snackText = snackText;
            this.snack = true;
        },
        selectCreatedClient(client) {
            const updatedClient = this.getClientWithTextValue(client);
            this.clients.push(updatedClient);
            this.orderData.client = updatedClient.id;
            this.isClientCreation = false;
            this.saveOrderDataToLocalStorage();
        },
        selectExistingClient(client) {
            this.orderData.client = client.id;
            this.isClientCreation = false;
            this.saveOrderDataToLocalStorage();
        },
        getClientWithTextValue(client) {
            return { ...client, text: `${client.person_full_name} (${client.company_name})` }
        },
        updateOrderGPSData(val, index, path, nestedPath = false) {
            if (nestedPath !== false) {
                this.$set(this.orderData.GPSData[index][path], nestedPath, val);
            } else {
                this.orderData.GPSData[index][path] = val;
                if (typeof val === 'string' && val.trim().length !== 0 && path !== 'image' && path !== 'year_of_issue' && !this.cachedData.find(el => el.value === val)) {
                    this.addCache(path, val);
                }
            }
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('success', 'Данные сохранены!');
        },
        addNestedDataInOrderGPSData(row, column) {
            this.orderData.GPSData[row][column].push(undefined);
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('success', 'Данные сохранены!');
        },
        deleteNestedDataInOrderGPSData(row, column, index) {
            this.orderData.GPSData[row][column].splice(index, 1);
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('success', 'Данные сохранены!');
        },
        copySelectedInOrderGPSData(copyList) {
            for (let i = 0; i < copyList.length; ++i) {
                let value = copyList[i][0].value;
                for (let j = 1; j < copyList[i].length; ++j) {
                    let index = copyList[i][j].index;
                    let column = copyList[i][j].column;

                    if (column === 'manual_installation_price' || !column.endsWith('price')) {
                        this.$set(this.orderData.GPSData[index], column, dcopy(value));
                    }
                }
            }
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('success', 'Данные сохранены!');
        },
        addRowToOrderGPSData(count = 1) {
            for (let i = 0; i < count; ++i) {
                this.orderData.GPSData.push({
                    ...this.initialGPSRowData,
                    fuel_gauge: Array.apply(null, { length: 2 }),
                    additional_equipment: Array.apply(null, { length: 2 }),
                    cn03: Array.apply(null, { length: 2 }),
                    rs01: Array.apply(null, { length: 2 })
                });
                ++this.initialGPSRowData.id;
                ++this.initialGPSRowData.order;
            }
            if (count > 0) {
                this.saveOrderDataToLocalStorage();
                this.showSnackbar('info', `${this.declOfNum(count, ['Добавлен', 'Добавлено', 'Добавлены'])} ${count} ${this.declOfNum(count, ['ряд', 'ряда', 'рядов'])}`);
            }
        },
        spreadRow(index, rowToSpread) {
            console.log('SPREAD ROW: ', dcopy(rowToSpread));
            const count = rowToSpread.multiplier - 1;
            let nextIndex = index + 1;
            this.$set(rowToSpread, 'multiplier', 1);
            for (let i = 0; i < count; ++i, ++nextIndex) {
                const rowToInsert = dcopy(rowToSpread);
                rowToInsert.id = this.initialGPSRowData.id;
                this.orderData.GPSData.splice(nextIndex, 0, rowToInsert);
                ++this.initialGPSRowData.id;
                ++this.initialGPSRowData.order;
            }
            this.resetRowsOrderValues();
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('info', `Ряд был разложен на ${count + 1}`);
        },
        deleteRowsFromOrderGPSData(indices) {
            this.orderData.GPSData = this.orderData.GPSData.filter((_, index) => !indices.includes(index));
            this.saveOrderDataToLocalStorage();
            if (indices.length > 0) {
                this.showSnackbar('info', `${this.declOfNum(indices.length, ['Удален', 'Удалено', 'Удалены'])} ${indices.length} ${this.declOfNum(indices.length, ['ряд', 'ряда', 'рядов'])}`);
            }
        },
        dragNDropGPSData(newIndex, oldIndex) {
            const rowSelected = this.orderData.GPSData.splice(oldIndex, 1)[0];
            this.orderData.GPSData.splice(newIndex, 0, rowSelected);
            this.resetRowsOrderValues();
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('info', `Ряд был перемещён`);
        },
        resetRowsOrderValues() {
            for (let i = 0; i < this.orderData.GPSData.length; ++i) {
                this.$set(this.orderData.GPSData[i], 'order', i + 1);
            }
        },
        getPricesData(data) {
            const priceList = data || this.priceList;
            return priceList.map(priceListRow => ({
                id: priceListRow.id,
                price: priceListRow.price,
                installation_price_for_one: priceListRow.installation_price_for_one,
                installation_price_for_two: priceListRow.installation_price_for_two,
                installation_price_for_three: priceListRow.installation_price_for_three
            }));
        },
        getServicesIDs() {
            return this.orderData.services.reduce((services, service) => {
                services.push(service.id);
                return services;
            }, []);
        },
        getGPSDataIDs() {
            return this.orderData.GPSData.map(row => {
                const newRow = {};
                Object.keys(row).forEach((key) => {
                    const value = row[key];
                    if (this.isObject(value)) {
                        newRow[key] = value.id;
                    } else if (Array.isArray(value)) {
                        let ids = [];
                        value.forEach(el => {
                            if (this.isUndefined(el) || this.isNull(el) ) return;
                            ids.push(el.id);
                        });
                        newRow[key] = ids;
                    } else if (key !== 'id') {
                        newRow[key] = value;
                    }
                });
                return newRow;
            });
        },
        validateImages() {
            return this.orderData.GPSData.every(row => (row.image !== '' && row.image !== uploadImage && !this.isUndefined(row.image) && !this.isNull(row.image)));
        },
        validateServices() {
            return this.orderData.services.length > 0;
        },
        createOrder() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.showSnackbar('error', this.errors.items[0].msg);
                        return;
                    }
                    if (!this.validateServices()) {
                        this.showSnackbar('error', 'Не была выбрана ни одна услуга!');
                        return;
                    }
                    if (!this.validateImages()) {
                        this.showSnackbar('error', 'Не установлено изображение!');
                        return;
                    }
                    this.orderInCreation = true;
                    const orderData = {
                        client_id: this.orderData.client,
                        dollar_rate: this.orderData.dollar_rate,
                        dollar_date: this.orderData.dollar_date,
                        name: this.orderData.name,
                        is_sent: this.orderData.statuses.is_sent,
                        is_agreed: this.orderData.statuses.is_agreed,
                        is_paid: this.orderData.statuses.is_paid,
                        is_installation_finished: this.orderData.statuses.is_installation_finished,
                        installation_discount: this.orderData.installation_discount,
                        equipment_discount: this.orderData.equipment_discount,
                        area: this.orderData.area,
                        days: this.orderData.days,
                        price_for_day: this.orderData.price_for_day,
                        price_for_transportation_per_km: this.orderData.price_for_transportation_per_km,
                        number_of_trips: this.orderData.number_of_trips,
                        transportation_kms: this.orderData.transportation_kms,
                        route: this.orderData.route,
                        prices: this.getPricesData(),
                        services: this.getServicesIDs(),
                        optional_services: this.orderData.optional_services
                    };
                    if (this.isGPSServiceSelected) {
                        orderData.GPSData = this.getGPSDataIDs();
                    } else {
                        orderData.GPSData = [];
                    }

                    this.axios.post('/orders', orderData)
                        .then(({data}) => {
                            this.deleteOrderDataFromLocalStorage();
                            this.$router.push(`/orders/${data.id}`);
                        })
                        .catch(err => (console.log(err)))
                        .finally(() => (this.orderInCreation = false));
                });
        },
        updateOrder() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.showSnackbar('error', this.errors.items[0].msg);
                        return;
                    }
                    if (!this.validateServices()) {
                        this.showSnackbar('error', 'Не была выбрана ни одна услуга!');
                        return;
                    }
                    if (!this.validateImages()) {
                        this.showSnackbar('error', 'Не установлено изображение!');
                        return;
                    }
                    const {
                        oldOrderData,
                        updatedOrderData,
                        oldOrderServicesData,
                        updatedOrderServicesData,
                        oldOrderGPSData,
                        updatedOrderGPSData,
                        oldOrderOptionalServices,
                        updatedOrderOptionalServices,
                        oldOrderPrices,
                        updatedOrderPrices
                    } = this.getOldAndUpdatedData();

                    const old = { oldOrderData, oldOrderServicesData, oldOrderGPSData, oldOrderOptionalServices, oldOrderPrices };
                    const updated = { updatedOrderData, updatedOrderServicesData, updatedOrderGPSData, updatedOrderOptionalServices, updatedOrderPrices };
                    if (this.isNoCange(old, updated)) {
                        this.snackColor = 'warning';
                        this.snackText = 'Нет изменений';
                        this.snack = true;
                        return;
                    }

                    this.loading = true;
                    this.orderUpdating = true;

                    const currentOrderPricesID = updatedOrderPrices.find(orderPriceRow => orderPriceRow.is_current).id;

                    const deletedGPSData = oldOrderGPSData.filter(oldGPSDataRow => !updatedOrderGPSData.find(updatedGPSDataRow => updatedGPSDataRow.id === oldGPSDataRow.id));

                    const addedGPSData = updatedOrderGPSData.filter(updatedGPSDataRow => !oldOrderGPSData.find(oldGPSDataRow => oldGPSDataRow.id === updatedGPSDataRow.id));

                    const restOldOrderGPSData = oldOrderGPSData.filter(oldGPSDataRow => !deletedGPSData.find(deletedGPSDataRow => deletedGPSDataRow.id === oldGPSDataRow.id)).sort((row1, row2) => row1.id - row2.id);
                    const restUpdatedOrderGPSData = updatedOrderGPSData.filter(updatedGPSDataRow => !addedGPSData.find(addedGPSDataRow => addedGPSDataRow.id === updatedGPSDataRow.id)).sort((row1, row2) => row1.id - row2.id);

                    const editedGPSDataIndices = this.getEditedDataIndices(restOldOrderGPSData, restUpdatedOrderGPSData);

                    const restOldChangedOrderGPSData = restOldOrderGPSData.filter((_, index) => editedGPSDataIndices.includes(index));
                    const restUpdatedChangedOrderGPSData = restUpdatedOrderGPSData.filter((_, index) => editedGPSDataIndices.includes(index));

                    const deletedOptionalServices = oldOrderOptionalServices.filter(oldOptionalService => !updatedOrderOptionalServices.find(updatedOptionalService => updatedOptionalService.id === oldOptionalService.id));

                    const addedOptionalServices = updatedOrderOptionalServices.filter(updatedOptionalService => !oldOrderOptionalServices.find(oldOptionalService => oldOptionalService.id === updatedOptionalService.id));

                    const restOldOrderOptionalServices = oldOrderOptionalServices.filter(oldOptionalService => !deletedOptionalServices.find(deletedOptionalService => deletedOptionalService.id === oldOptionalService.id)).sort((row1, row2) => row1.id - row2.id);
                    const restUpdatedOrderOptionalServices = updatedOrderOptionalServices.filter(updatedOptionalService => !addedOptionalServices.find(addedOptionalService => addedOptionalService.id === updatedOptionalService.id)).sort((row1, row2) => row1.id - row2.id);

                    const editedOptionalServicesIndices = this.getEditedDataIndices(restOldOrderOptionalServices, restUpdatedOrderOptionalServices);

                    const restOldChangedOrderOptionalServices = restOldOrderOptionalServices.filter((_, index) => editedOptionalServicesIndices.includes(index));
                    const restUpdatedChangedOrderOptionalServices = restUpdatedOrderOptionalServices.filter((_, index) => editedOptionalServicesIndices.includes(index));

                    const orderDataLog = this.parseOrderDiffData(diff(oldOrderData, updatedOrderData));

                    const log = {
                        before: JSON.stringify({
                            orderData: orderDataLog.before,
                            services: oldOrderServicesData,
                            gpsData: {
                                changed: restOldChangedOrderGPSData
                            },
                            optional_services: {
                                changed: restOldChangedOrderOptionalServices
                            }
                        }),
                        after: JSON.stringify({
                            orderData: orderDataLog.after,
                            services: updatedOrderServicesData,
                            gpsData: {
                                deleted: deletedGPSData,
                                added: addedGPSData,
                                changed: restUpdatedChangedOrderGPSData
                            },
                            optional_services: {
                                deleted: deletedOptionalServices,
                                added: addedOptionalServices,
                                changed: restUpdatedChangedOrderOptionalServices
                            }
                        })
                    };

                    const newOrderData = {
                        ...orderDataLog.after,
                        currentOrderPricesID,
                        services: updatedOrderServicesData.map(service => service.id),
                        optional_services: {
                            toDelete: deletedOptionalServices.map(row => row.id),
                            toAdd: addedOptionalServices,
                            toUpdate: restUpdatedChangedOrderOptionalServices
                        },
                        GPSData: {
                            toDelete: deletedGPSData.map(row => row.id),
                            toAdd: addedGPSData.map(row => {
                                const newRow = {};
                                Object.keys(row).forEach((key) => {
                                    const value = row[key];
                                    if (this.isObject(value)) {
                                        newRow[key] = value.id;
                                    } else if (Array.isArray(value)) {
                                        let ids = [];
                                        value.forEach(el => {
                                            if (this.isUndefined(el) || this.isNull(el) ) return;
                                            ids.push(el.id);
                                        });
                                        newRow[key] = JSON.stringify(ids);
                                    } else if (key !== 'order_id' && key !== 'id') {
                                        newRow[key] = value;
                                    }
                                });
                                return newRow;
                            }),
                            toUpdate: restUpdatedChangedOrderGPSData.map(row => {
                                const newRow = {};
                                Object.keys(row).forEach((key) => {
                                    const value = row[key];
                                    if (this.isObject(value)) {
                                        newRow[key] = value.id;
                                    } else if (Array.isArray(value)) {
                                        let ids = [];
                                        value.forEach(el => {
                                            if (this.isUndefined(el) || this.isNull(el) ) return;
                                            ids.push(el.id);
                                        });
                                        newRow[key] = JSON.stringify(ids);
                                    } else if (key !== 'order_id') {
                                        newRow[key] = value;
                                    }
                                });
                                return newRow;
                            })
                        },
                        log
                    };

                    this.axios.put(`/orders/${this.$route.params.id}`, newOrderData)
                        .then(({data}) => {
                            this.$emit('order:update', data);
                        })
                        .catch(err => {
                            this.loading = false;
                            this.orderUpdating = false;
                            this.snackColor = 'error';
                            this.snackText = 'Ошибка!';
                            this.snack = true;
                        });
                });
        },
        isNoCange(old, updated) {
            return this.isUndefined(diff(old.oldOrderData, updated.updatedOrderData)) &&
            this.isUndefined(diff(old.oldOrderServicesData, updated.updatedOrderServicesData)) &&
            this.isUndefined(diff(old.oldOrderGPSData, updated.updatedOrderGPSData)) &&
            this.isUndefined(diff(old.oldOrderOptionalServices, updated.updatedOrderOptionalServices)) &&
            this.isUndefined(diff(old.oldOrderPrices, updated.updatedOrderPrices));
        },
        getOldAndUpdatedData() {
            // MAIN_DATA
            const oldOrderData = {
                name: this.oldOrder.name,
                client: this.oldOrder.client,
                is_sent: this.oldOrder.is_sent,
                is_agreed: this.oldOrder.is_agreed,
                is_paid: this.oldOrder.is_paid,
                is_installation_finished: this.oldOrder.is_installation_finished,
                area: this.oldOrder.area,
                dollar_rate: this.oldOrder.dollar_rate,
                dollar_date: this.oldOrder.dollar_date,
                installation_discount: this.oldOrder.installation_discount,
                equipment_discount: this.oldOrder.equipment_discount,
                days: this.oldOrder.days,
                price_for_day: this.oldOrder.price_for_day,
                price_for_transportation_per_km: this.oldOrder.price_for_transportation_per_km,
                number_of_trips: this.oldOrder.number_of_trips,
                transportation_kms: this.oldOrder.transportation_kms,
                route: this.oldOrder.route
            };
            const updatedOrderData = {
                name: this.orderData.name,
                client: this.oldOrder.client,
                is_sent: this.orderData.statuses.is_sent,
                is_agreed: this.orderData.statuses.is_agreed,
                is_paid: this.orderData.statuses.is_paid,
                is_installation_finished: this.orderData.statuses.is_installation_finished,
                area: this.orderData.area,
                dollar_rate: this.orderData.dollar_rate,
                dollar_date: this.orderData.dollar_date,
                installation_discount: this.orderData.installation_discount,
                equipment_discount: this.orderData.equipment_discount,
                days: this.orderData.days,
                price_for_day: this.orderData.price_for_day,
                price_for_transportation_per_km: this.orderData.price_for_transportation_per_km,
                number_of_trips: this.orderData.number_of_trips,
                transportation_kms: this.orderData.transportation_kms,
                route: this.orderData.route
            };

            // SERVICES
            const oldOrderServicesData = this.oldOrder.services;
            const updatedOrderServicesData = this.orderData.services;

            // GPS_DATA
            const oldOrderGPSData = this.oldOrder.gps_data;
            const updatedOrderGPSData = this.orderData.GPSData;

            // OPTIONAL_SERVICES
            const oldOrderOptionalServices = this.oldOrder.optional_services;
            const updatedOrderOptionalServices = this.orderData.optional_services;

            // SAVED_PRICES
            const oldOrderPrices = this.oldOrder.prices;
            const updatedOrderPrices = this.orderData.prices;
            return {
                oldOrderData,
                updatedOrderData,
                oldOrderServicesData,
                updatedOrderServicesData,
                oldOrderGPSData,
                updatedOrderGPSData,
                oldOrderOptionalServices,
                updatedOrderOptionalServices,
                oldOrderPrices,
                updatedOrderPrices
            };
        },
        parseOrderDiffData(differences) {
            const log = { before: {}, after: {} };
            if (this.isNull(differences) || this.isUndefined(differences)) return log;
            return differences.reduce((log, difference) => {
                const key = difference.path[0];
                log.before[key] = difference.lhs;
                log.after[key] = difference.rhs;
                return log;
            }, log);
        },
        getEditedDataIndices(restOldOrderData, restUpdatedOrderData) {
            const differences = diff(restOldOrderData, restUpdatedOrderData);
            if (this.isNull(differences) || this.isUndefined(differences)) return [];
            return differences.reduce((indices, difference) => {
                const index = difference.path[0];
                if (!indices.includes(index)) {
                    indices.push(index);
                }
                return indices;
            }, []);
        },
        createPDF() {
            this.loading = true;
            // this.pdfLoading = true;
            const formatterSettings = {
                symbol: '',
                precision: 2,
                thousand: ' ',
                format: {
                    pos : '%v%s',
                    zero: '%v%s'
                }
            };
            const dollarDate = this.orderData.dollar_date.split('-').reverse().join('-');
            const pdfData = this.orderData.services.reduce((data, service) => {
                data[service.pdf_layout] = {};
                if (service.pdf_layout === pdfLayoutNames.INTEGRATION_1C) {
                    data[service.pdf_layout].prices = service.prices_for_ranges.map((pricesRow, index) => [
                        { text: (index + 1 === service.prices_for_ranges.length) ? `${pricesRow.from}>` : `${pricesRow.from} - ${pricesRow.to}` },
                        { text: pricesRow.price }
                    ]);
                } else if (service.pdf_layout === pdfLayoutNames.ENGINEER_PROJECT) {
                    data[service.pdf_layout].gpsTrackingData = this.gpsTrackingData;
                    data[service.pdf_layout].gruppedEquipment = this.gruppedEquipment.map(row => [
                        { text: row.type, classes: 'prices-text-left small-text bold-text' },
                        { text: row.count, classes: 'small-text bold-text' },
                        { text: row.price, classes: 'small-text bold-text' }
                    ]);
                    data[service.pdf_layout].dollarDate = dollarDate;
                    data[service.pdf_layout].formattedEquipmentPrice = formatter.formatMoney(this.allEquipmentPrice, formatterSettings);
                    data[service.pdf_layout].formattedInstallationPrice = formatter.formatMoney(this.allInstallationPrice, formatterSettings);
                    data[service.pdf_layout].formattedTransportPrice = formatter.formatMoney(this.transportationPrice, formatterSettings);
                    data[service.pdf_layout].formattedPriceForDays = formatter.formatMoney(this.priceForDays, formatterSettings);
                    const finalPrice = this.addTwoFloats(this.addTwoFloats(this.allEquipmentPrice, this.priceForDays), this.addTwoFloats(this.allInstallationPrice, this.transportationPrice));
                    data[service.pdf_layout].formattedFinalPrice = formatter.formatMoney(finalPrice, formatterSettings);
                } else {
                    data[service.pdf_layout].price = service.price;
                }
                return data;
            }, {});

            const finalServicesPrice = this.servicePrices.reduce((price, serviceData) => this.addTwoFloats(price, serviceData.price), 0.0);
            const finalServicesPriceUAH = this.multiplyTwoFloats(this.orderData.dollar_rate, finalServicesPrice);
            pdfData.servicePrices = {
                dollarDate,
                servicePrices: this.servicePrices.map(serviceData => [
                    { text: serviceData.service.name, classes: 'prices-text-left small-text' },
                    { text: serviceData.price, classes: 'small-text bold-text' }
                ]),
                finalPrice: formatter.formatMoney(finalServicesPriceUAH, formatterSettings)
            };

            if (this.orderData.optional_services && this.orderData.optional_services.length > 0) {
                pdfData.optionalServices = this.orderData.optional_services;
            }

            pdfData.pdf_name = this.orderData.name;

            this.$store.dispatch('createPDFFile', { orderID: this.order.id, pdfData })
                .then(() => {
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                    this.loading = false;
                });
        }
    },
    created() {
        if (this.isCreation) {
            this.initOrderCreationMode();
        } else {
            this.initOrderModificationMode();
        }
        this.getCachedData();
    },
    components: {
        appCreateClient: CreateClient,
        appGPSData: GPSData,
        appEquipmentData: EquipmentData,
        appPDF: PDF,
        appOrderPDF: OrderPDF
    }
}
</script>

<style scoped>
    .bg-card {
        background-color: transparent;
    }
    .gps-tracking-header,
    .pdf-preview {
        text-align: center;
        font-size: 28px !important;
    }
    .pdf-preview-overflow {
        padding: 0;
        margin: 0 auto;
        overflow-x: scroll;
    }
    .popIn {
        animation-name: popIn;
    }
    @keyframes popIn {
        0% {
            transform: scale3d(0, 0, 0);
            opacity: 0;
        } 20% {
            opacity: 1;
        } 40% {
            animation-timing-function: cubic-bezier(0.47, 0, 0.745, 0.715);
            transform: scale3d(1.08, 1.08, 1.08);
        } 60% {
            animation-timing-function: cubic-bezier(0.42, 0, 0.58, 1);
            transform: scale3d(1, 1, 1);
        } 80% {
            animation-timing-function: cubic-bezier(0.42, 0, 0.58, 1);
            transform: scale3d(1.03, 1.03, 1.03);
        } 100% {
            animation-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform: scale3d(1, 1, 1);
        }
    }
    .popOut {
        animation-name: popOut;
    }
    @keyframes popOut {
        0% {
            animation-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform: scale3d(1, 1, 1);
        } 60% {
            animation-timing-function: cubic-bezier(0.42, 0, 0.58, 1);
            transform: scale3d(1.08, 1.08, 1.08);
        } 80% {
            opacity: 1;
            animation-timing-function: cubic-bezier(0.42, 0, 0.58, 1);
        } 100% {
            opacity: 0;
            animation-timing-function: cubic-bezier(0.47, 0, 0.745, 0.715);
            transform: scale3d(0.3, 0.3, 0.3);
        }
    }
</style>
