<template>
    <v-card class="elevation-0 bg-card">
        <template v-if="isShowOrderContent">
            <v-card>
                <v-card-text>
                    <v-form>
                        <v-container grid-list-md>
                            <v-layout justify-start wrap>
                                <v-flex xs12 md3 offset-md2>
                                    <v-text-field
                                        label="Дата курса доллара"
                                        :readonly="true"
                                        v-model="orderData.dollar_date">
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs12 md3>
                                    <v-text-field
                                        label="Курс Доллара"
                                        :readonly="!isDollarRateEditing"
                                        v-model="orderData.dollar_rate">
                                        <v-slide-x-reverse-transition
                                            slot="append-outer"
                                            mode="out-in">
                                            <v-icon
                                                :color="isDollarRateEditing ? 'success' : 'info'"
                                                :key="`icon-${isDollarRateEditing}`"
                                                @click="isDollarRateEditing = !isDollarRateEditing"
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
                                        v-model="orderData.client"
                                        :items="clients"
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
                                                color="success"
                                                :label="isSentStatus"
                                                v-model="orderData.statuses.is_sent">
                                            </v-switch>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-switch
                                                color="success"
                                                :label="isAgreedStatus"
                                                v-model="orderData.statuses.is_agreed">
                                            </v-switch>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-switch
                                                color="success"
                                                :label="isPaidStatus"
                                                v-model="orderData.statuses.is_paid">
                                            </v-switch>
                                        </v-flex>
                                        <v-flex xs12 sm6 md4>
                                            <v-switch
                                                color="success"
                                                :label="isInstallationFinishedStatus"
                                                v-model="orderData.statuses.is_installation_finished">
                                            </v-switch>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                                <v-flex xs12 offset-md2 md6>
                                    <v-text-field v-model="orderData.name" label="Название заказа"></v-text-field>
                                </v-flex>
                                <v-flex xs12 offset-md2 md6>
                                    <v-text-field v-model="orderData.area" label="Площадь" :suffix="`${priceForArea}$`"></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout wrap v-if="services.length > 0">
                                <v-flex xs12 offset-md2 class="mt-2">
                                    <div class="title font-weight-regular">
                                        Услуги:
                                    </div>
                                </v-flex>
                                <v-flex xs12 offset-md2 md10 v-for="(service, index) in services" :key="`service-${index}`">
                                    <v-checkbox :style="{ padding: 0, margin: index !== 0 ? 0 : false }" :label="service.name" v-model="orderData.services" :value="service"></v-checkbox>
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
                                                label="Название"
                                                v-model="orderData.optional_services[index].name">
                                            </v-text-field>
                                            <v-text-field
                                                label="Цена"
                                                v-model="orderData.optional_services[index].price">
                                            </v-text-field>
                                            <v-textarea
                                                label="Комментарий"
                                                v-model="orderData.optional_services[index].comment">
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
                <v-card-title class="justify-center" primary-title>
                    <div class="headline gps-tracking-header">GPS-трекинг</div>
                </v-card-title>
                <v-card-text>
                    <appGPSData
                        v-if="orderData.GPSData"
                        ref="GPSData"
                        :orderGPSData="orderData.GPSData"
                        :gpsTrackers="gpsTrackers"
                        :fuelLevelSensors="fuelLevelSensors"
                        :fuelFlowmeters="fuelFlowmeters"
                        :identification="identification"
                        :optionalEquipment="optionalEquipment"
                        :pricesForEquipment="pricesForEquipment"
                        :allEquipmentPrice="allEquipmentPrice"
                        :allInstallationPrice="allInstallationPrice"
                        :cachedData="allCacheData"
                        :defaultRowCount="defaultRowCount"
                        @update:orderGPSData="updateOrderGPSData"
                        @add-nested-data:orderGPSData="addNestedDataInOrderGPSData"
                        @delete-nested-data:orderGPSData="deleteNestedDataInOrderGPSData"
                        @copy-values:orderGPSData="copySelectedInOrderGPSData"
                        @drag-n-drop-gps-data="dragNDropGPSData"
                        @rowAdded="addRowToOrderGPSData"
                        @delete:rows="deleteRowsFromOrderGPSData">
                    </appGPSData>
                    <v-progress-linear
                        v-else
                        :width="10"
                        :size="100"
                        color="primary"
                        indeterminate>
                    </v-progress-linear>
                </v-card-text>
                <v-card-text>
                    <v-layout wrap>
                        <v-flex order-xs2 order-sm1 xs12 sm6>
                            <v-container fluid grid-list-xs>
                                <v-layout wrap>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Монтаж оборудования"
                                            readonly
                                            :value="allInstallationPrice"
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Оборудование"
                                            readonly
                                            :value="allEquipmentPrice"
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Дней командировки"
                                            hint="Фиксированая цена 720 грн/день"
                                            persistent-hint
                                            v-model="orderData.days">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Командировки / проживание"
                                            readonly
                                            :value="priceForDays"
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Цена за 1км"
                                            v-model="orderData.price_for_transportation_per_km"
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Растояние км"
                                            v-model="orderData.transportation_kms">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Количество поездок"
                                            v-model="orderData.number_of_trips"
                                            :type="'number'"
                                            min="1">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Маршрут"
                                            v-model="orderData.route">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 md8 lg6 xl4>
                                        <v-text-field
                                            label="Транспортные расходы"
                                            readonly
                                            :value="transportationPrice"
                                            append-icon="₴">
                                        </v-text-field>
                                    </v-flex>
                                    <v-flex xs8></v-flex>
                                    <v-flex xs12 class="mt-4">
                                        <div class="text-xs-left display-1 font-weight-bold">
                                            СУММА ВСЕГО: {{ formattedFinalPrice }}
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-flex>
                        <v-flex order-xs1 order-sm2 xs12 sm6>
                            <appEquipmentData
                                v-if="orderData.GPSData"
                                :orderGPSData="orderData.GPSData">
                            </appEquipmentData>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-layout justify-center class="mb-4">
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
                                                    Создание документа ({{ pdfProgress }}%)
                                                    <v-progress-linear
                                                        v-model="pdfProgress"
                                                        color="white"
                                                        class="mb-0">
                                                    </v-progress-linear>
                                                </v-card-text>
                                            </v-card>
                                        </v-dialog>
                                        <v-btn
                                            @click="createPDF"
                                            large
                                            block
                                            color="primary"
                                            :disabled="loading"
                                            :loading="loading">
                                                Скачать PDF <v-icon right>get_app</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-flex>
                    </v-layout>
                </v-card-actions>
            </v-card>

            <v-expansion-panel popout class="mt-3" v-if="!isCreation">
                <v-expansion-panel-content
                    class="elevation-1">
                    <div slot="header" class="headline pdf-preview">PDF превью</div>
                    <v-card>
                        <v-card-text>
                            <appPDF :optionalServices="orderData.optional_services" :services="orderData.services" :gpsData="orderData.GPSData"></appPDF>
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
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
import CreateClient from './../client/createClient/CreateClient';
import GPSData from './gpsData/GPSData';
import EquipmentData from './EquipmentData/EquipmentData';
import PDF from './PDF/PDF';
import dcopy from 'deep-copy';
import utils from './../../mixins/utils.js';
import setStyles from './../../mixins/stylesMixins.js'
import formatter from 'accounting';
import diff from 'deep-diff';
import html2pdf from 'html2pdf.js';
import jsPDF from 'jspdf';

export default {
    mixins: [utils, setStyles],
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
        return {
            initialized: false,
            pdfProgress: 0,
            pdfLoading: false,
            orderUpdating: false,
            loading: false,
            isDollarRateEditing: false,
            snack: false,
            snackColor: '',
            snackText: '',
            snackTimeout: 1500,
            defaultRowCount: 0,
            initialGPSRowData: {
                id: 1,
                order: 1,
                image: '',
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
                deaerator: '',
                additional_equipment: [],
                cn03: [],
                rs01: []
            },
            priceList: [],
            cachedData: [],
            newCachedData: [],
            orderInCreation: false,
            oldOrder: {},
            orderData: {
                name: '',
                client: null,
                statuses: { is_sent: false, is_agreed: false, is_paid: false, is_installation_finished: false },
                area: '',
                dollar_rate: 0.00,
                dollar_date: '',
                days: '',
                price_for_day: 720,
                price_for_transportation_per_km: '',
                number_of_trips: 2,
                transportation_kms: '',
                route: '',
                services: [],
                optional_services: [],
                GPSData: null
            },
            clients: [],
            isClientCreation: false
        };
    },
    computed: {
        ...mapGetters([
            'gpsTrackers',
            'fuelLevelSensors',
            'fuelFlowmeters',
            'identification',
            'optionalEquipment',
            'services'
        ]),
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
                return true;
            }
            return this.initialized;
        },
        allCacheData() {
            const cache = {};
            [...this.cachedData, ...this.newCachedData].forEach((cacheData) => {
                if (cache[cacheData.column_name]) {
                    cache[cacheData.column_name].push(cacheData.value);
                } else {
                    cache[cacheData.column_name] = [cacheData.value]
                }
            });
            return cache;
        },
        priceForArea() {
            const area = (this.orderData.area === '' || this.orderData.area === null) ? 0 : parseFloat(this.orderData.area);
            const priceForServices = this.orderData.services.reduce((price, service) => this.addTwoFloats(price, this.multiplyTwoFloats(service.price, area)), 0);
            const finalPriceForArea = this.orderData.optional_services ? this.orderData.optional_services.reduce((price, service) => this.addTwoFloats(price, this.multiplyTwoFloats(service.price, area)), priceForServices) : priceForServices;
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
                prices.installationPrices[index] = 0.00;
                Object.keys(row).forEach((key) => {
                    const value = row[key];
                    const priceKey = `${key}_price`;
                    if (this.isObject(value)) {
                        prices.equipmentPrices[index][priceKey] = row[key].price;
                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], row[key].installation_price_for_one);
                    } else if (Array.isArray(value)) {
                        prices.equipmentPrices[index][priceKey] = 0.00;
                        value
                            .filter(el => !this.isUndefined(el) && !this.isNull(el))
                            .forEach((el, _, arr) => {
                                prices.equipmentPrices[index][priceKey] = this.addTwoFloats(prices.equipmentPrices[index][priceKey], el.price);
                                const arrLen = arr.length;
                                if (arrLen >= 3) {
                                    if (el.installation_price_for_three) {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_three);
                                    } else if (el.installation_price_for_two) {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_two);
                                    } else {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_one);
                                    }
                                } else if (arrLen === 2) {
                                    if (el.installation_price_for_two) {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_two);
                                    } else {
                                        prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_one);
                                    }
                                } else if (arrLen === 1) {
                                    prices.installationPrices[index] = this.addTwoFloats(prices.installationPrices[index], el.installation_price_for_one);
                                }
                            });
                    }
                });
                return prices;
            }, defaultPrices);
        },
        allEquipmentPrice() {
            return this.multiplyTwoFloats(this.pricesForEquipment.equipmentPrices.reduce((price, el) => {
                return this.addTwoFloats(price, Object.keys(el).reduce((price, key) => this.addTwoFloats(price, el[key]), 0.00));
            }, 0.00), this.orderData.dollar_rate);
        },
        allInstallationPrice() {
            return this.pricesForEquipment.installationPrices.reduce((price, el) => this.addTwoFloats(price, el), 0.00);
        },
        finalPrice() {
            return this.addTwoFloats(
                this.multiplyTwoFloats(
                    this.priceForArea, this.orderData.dollar_rate
                ), this.addTwoFloats(
                    this.priceForDays, this.addTwoFloats(
                        this.transportationPrice, this.addTwoFloats(
                            this.allEquipmentPrice, this.allInstallationPrice
                        )
                    )
                )
            );
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
        order: {
            deep: true,
            handler() {
                this.initOrder();
                this.loading = false;
                this.orderUpdating = false;
                this.snackColor = 'success';
                this.snackText = 'Сохранено';
                this.snack = true;
            }
        }
        // services(newValue) {
        //     this.orderData.services = this.services.map(service => ({ id: service.id, name: service.name, price: service.price, value: false }));
        // }
    },
    methods: {
        initOrder() {
            let copyOrder = dcopy(this.order);
            copyOrder.services = copyOrder.services.map(serviceID => this.services.find(service => service.id === serviceID));
            let id = 0;
            copyOrder.gps_data = copyOrder.gps_data.map(gpsDataRow => {
                if (gpsDataRow.id > id) {
                    id = gpsDataRow.id;
                }
                return Object.keys(gpsDataRow).reduce((newRow, key) => {
                    if (key !== 'id' && key !== 'order' && key !== 'order_id' && typeof gpsDataRow[key] === 'number') {
                        newRow[key] = this.priceList.find(data => data.id === gpsDataRow[key]);
                    } else if (Array.isArray(gpsDataRow[key])) {
                        newRow[key] = gpsDataRow[key].map(id => this.priceList.find(data => data.id === id));
                    } else if (typeof gpsDataRow[key] === 'string') {
                        newRow[key] = gpsDataRow[key];
                    } else if (this.isNull(gpsDataRow[key]) || this.isUndefined(gpsDataRow[key])) {
                        newRow[key] = '';
                    } else if (key === 'id' || key === 'order' || key === 'order_id') {
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
            this.orderData.days = newOrderData.days;
            this.orderData.price_for_day = newOrderData.price_for_day;
            this.orderData.price_for_transportation_per_km = newOrderData.price_for_transportation_per_km;
            this.orderData.number_of_trips = newOrderData.number_of_trips;
            this.orderData.transportation_kms = newOrderData.transportation_kms;
            this.orderData.route = newOrderData.route;
            this.orderData.services = newOrderData.services;
            this.orderData.optional_services = newOrderData.optional_services;
            this.orderData.GPSData = newOrderData.gps_data;

            this.initialized = true;
        },
        addCache(column, value) {
            this.newCachedData.push({ column_name: column, value });
            localStorage.setItem('newCachedData', JSON.stringify(this.newCachedData));
        },
        addOptionalService() {
            this.orderData.optional_services.push({ name: '', price: '', comment: '' });
        },
        deleteOptionalService(index) {
            this.orderData.optional_services.splice(index, 1);
        },
        saveOrderDataToLocalStorage() {
            localStorage.setItem('orderData', JSON.stringify(this.orderData));
        },
        getClients() {
            this.axios.get('/clients/all')
                .then(({data}) => {
                    const clients = data.map(client => this.getClientWithTextValue(client));
                    this.clients = clients;
                })
                .catch(err => (console.log(err)));
        },
        getCachedData() {
            this.axios.get('/cache')
                .then(({data}) => {
                    this.cachedData = data;
                })
                .catch(err => (console.log(err)));
        },
        getDollarRate() {
            this.axios.get('/order/dollar-rate')
            .then(({data}) => {
                this.orderData.dollar_rate = data[0].rate;
                this.orderData.dollar_date = data[0].exchangedate;
            })
            .catch(err => console.log(err))
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
        },
        selectExistingClient(client) {
            this.orderData.client = client.id;
            this.isClientCreation = false;
        },
        getClientWithTextValue(client) {
            return { ...client, text: `${client.person_full_name} (${client.company_name})` }
        },
        updateOrderGPSData(val, index, path, nestedPath = false) {
            if (nestedPath !== false) {
                this.$set(this.orderData.GPSData[index][path], nestedPath, val);
            } else {
                this.orderData.GPSData[index][path] = val;
                if (typeof val === 'string' && path !== 'image' && path !== 'year_of_issue' && !this.cachedData.find(el => el.value === val)) {
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

                    if (!column.endsWith('price')) {
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
        deleteRowsFromOrderGPSData(indices) {
            this.orderData.GPSData = this.orderData.GPSData.filter((_, index) => !indices.includes(index));
            if (indices.length > 0) {
                this.saveOrderDataToLocalStorage();
                this.showSnackbar('info', `${this.declOfNum(indices.length, ['Удален', 'Удалено', 'Удалены'])} ${indices.length} ${this.declOfNum(indices.length, ['ряд', 'ряда', 'рядов'])}`);
            }
        },
        dragNDropGPSData(newIndex, oldIndex) {
            const rowSelected = this.orderData.GPSData.splice(oldIndex, 1)[0];
            this.orderData.GPSData.splice(newIndex, 0, rowSelected);
            for (let i = 0; i < this.orderData.GPSData.length; ++i) {
                this.$set(this.orderData.GPSData[i], 'order', i + 1);
            }
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('info', `Ряд был перемещён`);
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
        createOrder() {
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
                area: this.orderData.area,
                days: this.orderData.days,
                price_for_day: this.orderData.price_for_day,
                price_for_transportation_per_km: this.orderData.price_for_transportation_per_km,
                number_of_trips: this.orderData.number_of_trips,
                transportation_kms: this.orderData.transportation_kms,
                route: this.orderData.route,
                services: this.getServicesIDs(),
                optional_services: this.orderData.optional_services,
                GPSData: this.getGPSDataIDs()
            };

            this.axios.post('/orders', orderData)
                .then(({data}) => {
                    this.$router.push(`/orders/${data.id}`);
                })
                .catch(err => (console.log(err)))
                .finally(() => (this.orderInCreation = false));

            if (this.newCachedData.length > 0)
                this.axios.post('/cache', { cache: this.newCachedData });
        },
        updateOrder() {
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

            if(this.isUndefined(diff(oldOrderData, updatedOrderData)) &&
                this.isUndefined(diff(oldOrderServicesData, updatedOrderServicesData)) &&
                this.isUndefined(diff(oldOrderGPSData, updatedOrderGPSData)) &&
                this.isUndefined(diff(oldOrderOptionalServices, updatedOrderOptionalServices))) {
                this.snackColor = 'warning';
                this.snackText = 'Нет изменений';
                this.snack = true;
                return;
            }

            this.loading = true;
            this.orderUpdating = true;




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
            this.pdfLoading = true;

            const element = document.getElementById('pdf');
            const format = [852.5, 606.5];
            const opt = {
                margin:       0,
                filename:     'myfile.pdf',
                image:        { type: 'jpeg', quality: 0.95 },
                html2canvas:  { scale: 1, imageTimeout: 0 },
                jsPDF:        { unit: 'pt', format, orientation: 'l' }
            };
            const childreninWrapperCount = 20;
            const pages = 10;
            const pageWidth = 1137.5;
            const pageHeight = 808;
            const children = element.children;
            const pdfPages = children.length / 2;
            const wrappers = [];
            const countWrappers = Math.ceil(children.length / childreninWrapperCount);
            const doc = new jsPDF(opt.jsPDF);
            const pageSize = jsPDF.getPageSize(opt.jsPDF);
            const imgPromises = [];

            const getImages = () => new Promise((resolve, reject) => {
                for (let i = 0; i < countWrappers; ++i) {
                    wrappers.push(document.createElement('div'));
                    wrappers[i].classList.add('container');
                    wrappers[i].classList.add('fluid');
                    const wrapperHeight = this.multiplyTwoFloats(pageHeight, pages);
                    this.setStyles(wrappers[i], {
                        'font-family': 'ProximaNova',
                        padding: 0,
                        width: '1137.5px',
                        height: `${wrapperHeight}px`
                    });
                    for (let j = i * childreninWrapperCount; j < childreninWrapperCount + (i * childreninWrapperCount); ++j) {
                        if (!children[j]) break;
                        const clone = children[j].cloneNode(true);
                        wrappers[i].appendChild(clone);

                    }
                    imgPromises.push(html2pdf().from(wrappers[i]).set(opt).outputImg());
                }
                resolve()
            });

            const setImages = () => new Promise((resolve, reject) => {
                return Promise.all(imgPromises)
                    .then(data => {
                        setTimeout(() => {
                            this.pdfProgress = 80;
                        }, 100);
                        setTimeout(() => {
                            let counter = 0;
                            for (let i = 0; i < data.length; ++i) {
                                let position = 0;
                                for (let j = 0; j < pages + 1; ++j) {
                                    if (counter > pdfPages + 1) {
                                        return resolve();
                                    }
                                    if(j != 0) {
                                        doc.addPage();
                                    }
                                    doc.addImage(data[i].src, 'jpeg', opt.margin, position, pageSize.width, this.multiplyTwoFloats(format[1], pages));
                                    position = this.subtractWtoFloats(position, format[1]);
                                    ++counter;
                                }
                            }
                            resolve();
                        }, 300);
                    })
                    .catch(err => console.log(err))
            });

            const downloadPDF = () => new Promise((resolve, reject) => {
                this.pdfProgress = 90;
                const progressInterval = setInterval(() => {
                    this.pdfProgress = this.addTwoFloats(this.pdfProgress, 5);
                    if (this.pdfProgress >= 100) {
                        clearInterval(progressInterval);
                    }
                }, 300);
                setTimeout(() => {
                    const pdf = doc.output('blob');
                    const link = document.createElement('a');
                    link.setAttribute('href', window.URL.createObjectURL(pdf));
                    link.setAttribute('download', `${this.orderData.name}.pdf`);
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    resolve();
                }, 500);
            });

            setTimeout(() => {
                const progressInterval = setInterval(() => {
                    this.pdfProgress = this.addTwoFloats(this.pdfProgress, 0.7);
                    if (this.pdfProgress >= 90) {
                        clearInterval(progressInterval);
                    }
                }, 1500);
                getImages()
                    .then(() => setImages())
                    .then(() => downloadPDF())
                    .then(() => {
                        this.loading = false;
                        this.pdfLoading = false;
                        this.pdfProgress = 0;
                    })
                    .catch(err => {
                        console.log(err);
                        this.loading = false;
                        this.pdfLoading = false;
                        this.pdfProgress = 0;
                    });
            }, 500);
        }
    },
    created() {
        if (this.isCreation) {
            this.getDollarRate();
            this.getClients();
            this.$store.dispatch('getPriseList');
            this.orderData.GPSData = [];
            this.defaultRowCount = 4;
        } else {
            this.$store.dispatch('getPriseList')
                .then(data => {
                    this.priceList = data;
                    this.initOrder();
                });
        }
        this.getCachedData();
        this.newCachedData = JSON.parse(localStorage.getItem('newCachedData')) || [];
        // this.orderData = JSON.parse(localStorage.getItem('orderData'));
    },
    components: {
        appCreateClient: CreateClient,
        appGPSData: GPSData,
        appEquipmentData: EquipmentData,
        appPDF: PDF
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
</style>
