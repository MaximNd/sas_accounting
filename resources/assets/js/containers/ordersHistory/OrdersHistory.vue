<template>
    <v-container fluid>
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-title>
                        <v-spacer></v-spacer>
                        <v-text-field
                            clearable
                            :value="search"
                            @input="checkSearch"
                            @change="getOrdersHistory"
                            append-icon="search"
                            label="Поиск"
                            single-line
                            hide-details>
                        </v-text-field>
                    </v-card-title>
                    <v-data-table
                        id="orders-logs-table"
                        :headers="headers"
                        :items="ordersHistory"
                        :rows-per-page-items="rowsPerPageItems"
                        :pagination.sync="pagination"
                        :total-items="totalOrdersHistoryItems"
                        :loading="loading"
                        class="elevation-1"
                        expand>
                        <template slot="items" slot-scope="props">
                            <tr @click="expand(props.item, props)">
                                <td>{{ props.item.created_at }}</td>
                                <td><router-link :to="`/orders/${props.item.order.id}`">{{ props.item.order.name }}</router-link></td>
                                <td>{{ props.item.user.full_name }}</td>
                                <td
                                    :class="{
                                        'success--text': props.item.type === 'Создание',
                                        'info--text': props.item.type === 'Обновление',
                                        'purple--text': props.item.type === 'Восстановление',
                                        'error--text': props.item.type === 'Удаление'
                                    }">
                                    {{ props.item.type }}
                                </td>
                                <td class="text-xs-right">
                                    <v-btn icon v-if="props.expanded"><v-icon>expand_less</v-icon></v-btn>
                                    <v-btn icon v-else><v-icon>expand_more</v-icon></v-btn>
                                </td>
                            </tr>
                        </template>
                        <template slot="expand" slot-scope="props">
                            <v-card flat>
                                <v-card-text>
                                    <v-container fluid v-if="props.item.type === 'Создание'">
                                        <v-layout wrap>
                                            <v-flex xs12>
                                                <v-data-table
                                                    :headers="createdDataHeaders"
                                                    :items="createdData[props.index]"
                                                    hide-actions
                                                    class="elevation-1">
                                                    <template slot="items" slot-scope="nestedProps">
                                                        <td><router-link :to="`/orders/${nestedProps.item.id}`">{{ nestedProps.item.name }}</router-link></td>
                                                        <td><router-link :to="`/clients/${nestedProps.item.client.id}`">{{ nestedProps.item.client.person_full_name }}</router-link></td>
                                                        <td>{{ nestedProps.item.client.company_name }}</td>
                                                        <td>{{ nestedProps.item.area }}</td>
                                                        <td :class="{ 'error--text': !nestedProps.item.is_sent, 'success--text': nestedProps.item.is_sent }">{{ nestedProps.item.is_sent ? 'Отправленный' : 'Неотправленный' }}</td>
                                                        <td :class="{ 'error--text': !nestedProps.item.is_agreed, 'success--text': nestedProps.item.is_agreed }">{{ nestedProps.item.is_agreed ? 'Согласованный' : 'Несогласованный' }}</td>
                                                        <td :class="{ 'error--text': !nestedProps.item.is_paid, 'success--text': nestedProps.item.is_paid }">{{ nestedProps.item.is_paid ? 'Оплаченный' : 'Неоплаченный' }}</td>
                                                        <td :class="{ 'error--text': !nestedProps.item.is_installation_finished, 'success--text': nestedProps.item.is_installation_finished }">{{ nestedProps.item.is_paid ? 'Закончен' : 'Не закончен' }}</td>
                                                    </template>
                                                </v-data-table>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    <v-container fluid grid-list-xs v-else-if="props.item.type === 'Обновление'">
                                        <v-layout wrap>
                                            <v-flex xs12 sm6 v-if="updatedData[props.index].orderData.before.length > 0">
                                                <v-card>
                                                    <v-card-title><h4>Данные заказа До:</h4></v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-list dense>
                                                        <v-list-tile v-for="(beforeData, index) in updatedData[props.index].orderData.before" :key="`order-data-before-${index}`">
                                                            <v-list-tile-content :class="{ 'red--text darken-4--text': beforeData.isChanged }" >{{ beforeData.text }}:</v-list-tile-content>
                                                            <v-list-tile-content :class="{ 'align-end': true, 'red--text darken-4--text': beforeData.isChanged }">{{ beforeData.value }}</v-list-tile-content>
                                                        </v-list-tile>
                                                    </v-list>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs12 sm6 v-if="updatedData[props.index].orderData.after.length > 0">
                                                <v-card>
                                                    <v-card-title><h4>Данные заказа После:</h4></v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-list dense>
                                                        <v-list-tile v-for="(afterData, index) in updatedData[props.index].orderData.after" :key="`order-data-after-${index}`">
                                                            <v-list-tile-content :class="{ 'success--text': afterData.isChanged }" >{{ afterData.text }}:</v-list-tile-content>
                                                            <v-list-tile-content :class="{ 'align-end': true, 'success--text': afterData.isChanged }">{{ afterData.value }}</v-list-tile-content>
                                                        </v-list-tile>
                                                    </v-list>
                                                </v-card>
                                            </v-flex>
                                        </v-layout>

                                        <v-layout wrap v-if="isServicesChanged[props.index]">
                                            <v-flex xs12 sm6>
                                                <v-card>
                                                    <v-card-title><h4>Сервисы До:</h4></v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-list dense>
                                                        <v-list-tile v-for="(beforeData, index) in updatedData[props.index].services.before" :key="`services-before-${index}`">
                                                            <v-list-tile-content :class="{ 'red--text darken-4--text': beforeData.deleted }" >{{ beforeData.name }}:</v-list-tile-content>
                                                            <v-list-tile-content :class="{ 'align-end': true, 'red--text darken-4--text': beforeData.deleted }">{{ beforeData.price }}$</v-list-tile-content>
                                                        </v-list-tile>
                                                    </v-list>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs12 sm6>
                                                <v-card>
                                                    <v-card-title><h4>Сервисы После:</h4></v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-list dense>
                                                        <v-list-tile v-for="(afterData, index) in updatedData[props.index].services.after" :key="`services-after-${index}`">
                                                            <v-list-tile-content :class="{ 'success--text': afterData.added }" >{{ afterData.name }}:</v-list-tile-content>
                                                            <v-list-tile-content :class="{ 'align-end': true, 'success--text': afterData.added }">{{ afterData.price }}$</v-list-tile-content>
                                                        </v-list-tile>
                                                    </v-list>
                                                </v-card>
                                            </v-flex>
                                        </v-layout>

                                        <v-layout wrap>
                                            <v-flex xs12 class="mt-3" v-if="updatedData[props.index].optional_services.after.added.length > 0">
                                                <div class="headline success--text mb-2">Добавленые Дополнительные сервисы</div>
                                                <v-data-table
                                                    :headers="optionalServicesHeaders"
                                                    :items="updatedData[props.index].optional_services.after.added"
                                                    hide-actions
                                                    class="elevation-1">
                                                    <template slot="items" slot-scope="nestedProps">
                                                        <td>{{ nestedProps.item.name }}</td>
                                                        <td>{{ nestedProps.item.price }}</td>
                                                        <td>{{ nestedProps.item.comment }}</td>
                                                    </template>
                                                </v-data-table>
                                            </v-flex>

                                            <v-flex xs12 class="mt-3" v-if="updatedData[props.index].optional_services.after.deleted.length > 0">
                                                <div class="headline red--text darken-4--text mb-2">Удаленные Дополнительные сервисы</div>
                                                <v-data-table
                                                    :headers="optionalServicesHeaders"
                                                    :items="updatedData[props.index].optional_services.after.deleted"
                                                    hide-actions
                                                    class="elevation-1">
                                                    <template slot="items" slot-scope="nestedProps">
                                                        <td>{{ nestedProps.item.name }}</td>
                                                        <td>{{ nestedProps.item.price }}</td>
                                                        <td>{{ nestedProps.item.comment }}</td>
                                                    </template>
                                                </v-data-table>
                                            </v-flex>

                                            <v-flex xs12 class="mt-3" v-if="updatedData[props.index].optional_services.after.changed.length > 0">
                                                <div class="headline info--text mb-2">Обновленные Дополнительные сервисы</div>
                                                <v-layout wrap>
                                                    <template v-for="index in updatedData[props.index].optional_services.before.changed.length">
                                                        <v-flex xs12 sm6 :key="`optional-services-before-${index}`">
                                                            <v-card>
                                                                <v-card-title><h4>До:</h4></v-card-title>
                                                                <v-divider></v-divider>
                                                                <v-list dense>
                                                                    <v-list-tile>
                                                                        <v-list-tile-content :class="{ 'red--text darken-4--text': updatedData[props.index].optional_services.before.changed[index - 1].name !== updatedData[props.index].optional_services.after.changed[index - 1].name }" >
                                                                            Название:
                                                                        </v-list-tile-content>
                                                                        <v-list-tile-content :class="{ 'align-end': true, 'red--text darken-4--text': updatedData[props.index].optional_services.before.changed[index - 1].name !== updatedData[props.index].optional_services.after.changed[index - 1].name }">
                                                                            {{ updatedData[props.index].optional_services.before.changed[index - 1].name }}
                                                                        </v-list-tile-content>
                                                                    </v-list-tile>
                                                                    <v-list-tile>
                                                                        <v-list-tile-content :class="{ 'red--text darken-4--text': updatedData[props.index].optional_services.before.changed[index - 1].price !== updatedData[props.index].optional_services.after.changed[index - 1].price }" >
                                                                            Цена:
                                                                        </v-list-tile-content>
                                                                        <v-list-tile-content :class="{ 'align-end': true, 'red--text darken-4--text': updatedData[props.index].optional_services.before.changed[index - 1].price !== updatedData[props.index].optional_services.after.changed[index - 1].price }">
                                                                            {{ updatedData[props.index].optional_services.before.changed[index - 1].price }}$
                                                                        </v-list-tile-content>
                                                                    </v-list-tile>
                                                                    <v-list-tile>
                                                                        <v-list-tile-content :class="{ 'red--text darken-4--text': updatedData[props.index].optional_services.before.changed[index - 1].comment !== updatedData[props.index].optional_services.after.changed[index - 1].comment }" >
                                                                            Комментарий:
                                                                        </v-list-tile-content>
                                                                        <v-list-tile-content :class="{ 'align-end': true, 'red--text darken-4--text': updatedData[props.index].optional_services.before.changed[index - 1].comment !== updatedData[props.index].optional_services.after.changed[index - 1].comment }">
                                                                            {{ updatedData[props.index].optional_services.before.changed[index - 1].comment }}
                                                                        </v-list-tile-content>
                                                                    </v-list-tile>
                                                                </v-list>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs12 sm6 :key="`optional-services-after-${index}`">
                                                            <v-card>
                                                                <v-card-title><h4>После:</h4></v-card-title>
                                                                <v-divider></v-divider>
                                                                <v-list dense>
                                                                    <v-list-tile>
                                                                        <v-list-tile-content :class="{ 'success--text': updatedData[props.index].optional_services.before.changed[index - 1].name !== updatedData[props.index].optional_services.after.changed[index - 1].name }" >
                                                                            Название:
                                                                        </v-list-tile-content>
                                                                        <v-list-tile-content :class="{ 'align-end': true, 'success--text': updatedData[props.index].optional_services.before.changed[index - 1].name !== updatedData[props.index].optional_services.after.changed[index - 1].name }">
                                                                            {{ updatedData[props.index].optional_services.after.changed[index - 1].name }}
                                                                        </v-list-tile-content>
                                                                    </v-list-tile>
                                                                    <v-list-tile>
                                                                        <v-list-tile-content :class="{ 'success--text': updatedData[props.index].optional_services.before.changed[index - 1].price !== updatedData[props.index].optional_services.after.changed[index - 1].price }" >
                                                                            Цена:
                                                                        </v-list-tile-content>
                                                                        <v-list-tile-content :class="{ 'align-end': true, 'success--text': updatedData[props.index].optional_services.before.changed[index - 1].price !== updatedData[props.index].optional_services.after.changed[index - 1].price }">
                                                                            {{ updatedData[props.index].optional_services.after.changed[index - 1].price }}$
                                                                        </v-list-tile-content>
                                                                    </v-list-tile>
                                                                    <v-list-tile>
                                                                        <v-list-tile-content :class="{ 'success--text': updatedData[props.index].optional_services.before.changed[index - 1].comment !== updatedData[props.index].optional_services.after.changed[index - 1].comment }" >
                                                                            Комментарий:
                                                                        </v-list-tile-content>
                                                                        <v-list-tile-content :class="{ 'align-end': true, 'success--text': updatedData[props.index].optional_services.before.changed[index - 1].comment !== updatedData[props.index].optional_services.after.changed[index - 1].comment }">
                                                                            {{ updatedData[props.index].optional_services.after.changed[index - 1].comment }}
                                                                        </v-list-tile-content>
                                                                    </v-list-tile>
                                                                </v-list>
                                                            </v-card>
                                                        </v-flex>
                                                    </template>
                                                </v-layout>
                                            </v-flex>
                                        </v-layout>

                                        <v-layout wrap class="mt-3" v-if="updatedData[props.index].gpsData.added.length > 0 || updatedData[props.index].gpsData.deleted.length > 0 || updatedData[props.index].gpsData.changed.length > 0">
                                            <v-flex xs12>
                                                <div class="headline text-xs-center mb-2">GPS-трекинг</div>
                                            </v-flex>
                                            <v-flex xs12 v-if="updatedData[props.index].gpsData.added.length > 0">
                                                <div class="headline success--text mb-2">Добавленые</div>
                                                <appGpsDataHistoryTable
                                                    :items="updatedData[props.index].gpsData.added">
                                                </appGpsDataHistoryTable>
                                            </v-flex>

                                            <v-flex xs12 class="mt-3" v-if="updatedData[props.index].gpsData.deleted.length > 0">
                                                <div class="headline red--text darken-4--text mb-2">Удаленные</div>
                                                <appGpsDataHistoryTable
                                                    :items="updatedData[props.index].gpsData.deleted">
                                                </appGpsDataHistoryTable>
                                            </v-flex>

                                            <v-flex xs12 class="mt-3" v-if="updatedData[props.index].gpsData.changed.length > 0">
                                                <div class="headline info--text mb-2">Обновленные</div>
                                                <appGpsDataHistoryTable
                                                    withChanged
                                                    :items="updatedData[props.index].gpsData.changed">
                                                </appGpsDataHistoryTable>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    <v-container fluid v-else-if="$auth.check('admin') && props.item.type === 'Удаление'">
                                        <v-layout wrap v-if="props.item.order.deleted_at">
                                            <v-flex xs12 sm6 md4 lg3>
                                                <p class="title" style="margin: 0; line-height: 2.2!important;">
                                                    Нажмите чтобы восстановить:
                                                </p>
                                            </v-flex>
                                            <v-flex xs12 sm3>
                                                <v-btn :loading="restoring" :disabled="restoring" @click="restore(props.item.order.id)" class="white--text" color="purple">Восстановить</v-btn>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout v-else>
                                            <v-flex xs12>
                                                <p class="red--text text--darken-4 title" style="margin: 0; line-height: 2.2!important;">
                                                    На данный момент восстановление невозможно, так как этот заказ уже восстановлен!
                                                </p>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                            </v-card>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import GpsDataHistoryTable from './GPSDataHistoryTable/GPSDataHistoryTable';
import utils from './../../mixins/utils.js';

export default {
    mixins: [utils],
    data() {
        return {
            textMap: {
                dollar_rate: 'Курс доллара',
                dollar_date: 'Дата курса доллара',
                name: 'Название',
                area: 'Площадь',
                is_sent: 'Статус отправки',
                is_agreed: 'Статус согласования',
                is_paid: 'Статус оплаты',
                is_installation_finished: 'Статус монтажа',
                days: 'Дней командировки',
                installation_discount: 'Скидка на монтаж оборудования',
                equipment_discount: 'Скидка на оборудование',
                price_for_day: 'Командировки / проживание (₴)',
                price_for_transportation_per_km: 'Цена за 1км (₴)',
                number_of_trips: 'Количество поездок',
                transportation_kms: 'Растояние км',
                route: 'Маршрут'
            },
            statusesValues: {
                is_sent: {
                    accepted: 'Отправленный',
                    not_accepted: 'Неотправленный'
                },
                is_agreed: {
                    accepted: 'Согласованный',
                    not_accepted: 'Несогласованный'
                },
                is_paid: {
                    accepted: 'Оплаченный',
                    not_accepted: 'Неоплаченный'
                },
                is_installation_finished: {
                    accepted: 'Монтаж закончен',
                    not_accepted: 'Монтаж не закончен'
                },
            },
            search: '',
            totalOrdersHistoryItems: 0,
            ordersHistory: [],
            rowsPerPageItems: [10, 15, 20, 25, 30, 50],
            loading: true,
            restoring: false,
            pagination: {
                rowsPerPage: 10,
                sortBy: 'created_at',
                descending: true
            },
            headers: [
                {
                    text: 'Дата',
                    align: 'left',
                    value: 'created_at'
                },
                { text: 'Заказ', value: 'name' },
                { text: 'Сотрудник', value: 'user.full_name' },
                { text: 'Действие', value: 'type' },
                { text: 'Подробно', value: '', align: 'right', sortable: false }
            ],
            createdDataHeaders: [
                {
                    text: 'Заказ',
                    align: 'left',
                    value: 'name',
                    sortable: false
                },
                { text: 'Клиент', value: 'client.person_full_name', sortable: false },
                { text: 'Компания', value: 'client.company_name', sortable: false },
                { text: 'Площадь', value: 'area', width: '15px', sortable: false },
                { text: 'Статус отправки', value: 'is_sent', sortable: false },
                { text: 'Статус согласования', value: 'is_agreed', sortable: false },
                { text: 'Статус оплаты', value: 'is_paid', sortable: false },
                { text: 'Статус монтажа', value: 'is_installation_finished', sortable: false }
            ],
            optionalServicesHeaders: [
                {
                    text: 'Название',
                    align: 'left',
                    value: 'name',
                    sortable: false
                },
                { text: 'Цена ($)', value: 'price', sortable: false },
                { text: 'Комментарий', value: 'comment', sortable: false },
            ]
        };
    },
    computed: {
        createdData() {
            return this.ordersHistory.reduce((createdData, ordersHistoryData, index) => {
                if (ordersHistoryData.type === 'Создание') {
                    createdData[index] = [JSON.parse(ordersHistoryData.after)];
                }
                return createdData;
            }, {});
        },
        updatedData() {
            return this.ordersHistory.reduce((updatedData, ordersHistoryData, index) => {
                if (ordersHistoryData.type === 'Обновление') {
                    const before = JSON.parse(ordersHistoryData.before);
                    const after = JSON.parse(ordersHistoryData.after);
                    updatedData[index] = {
                        orderData: {
                            before: [], after: []
                        },
                        services: {
                            before: [], after: []
                        },
                        optional_services: {
                            before: [], after: []
                        },
                        gpsData: {

                        }
                    };
                    // ORDER DATA
                    const orderDataBefore = before.orderData;
                    const orderDataAfter = after.orderData;
                    updatedData[index].orderData.before = Object.keys(orderDataBefore).map((key) => ({
                        text: this.textMap[key],
                        value: !key.startsWith('is_') ? orderDataBefore[key] : this.statusesValues[key][orderDataBefore[key] ? 'accepted' : 'not_accepted'],
                        isChanged: orderDataBefore[key] !== orderDataAfter[key]
                    }));
                    updatedData[index].orderData.after = Object.keys(orderDataAfter).map((key) => ({
                        text: this.textMap[key],
                        value: !key.startsWith('is_') ? orderDataAfter[key] : this.statusesValues[key][orderDataAfter[key] ? 'accepted' : 'not_accepted'],
                        isChanged: orderDataAfter[key] !== orderDataBefore[key]
                    }));
                    // ORDER SERVICES
                    updatedData[index].services.before = before.services.map(beforeService => {
                        if (this.isUndefined(after.services.find(afterService => afterService.id === beforeService.id))) {
                            beforeService.deleted = true;
                        }
                        return { ...beforeService };
                    });
                    updatedData[index].services.after = after.services.map(afterService => {
                        if (this.isUndefined(before.services.find(beforeService => beforeService.id === afterService.id))) {
                            afterService.added = true;
                        }
                        return { ...afterService };
                    });
                    // ORDER OPTIONAL_SERVICES
                    updatedData[index].optional_services.before = {
                        changed: before.optional_services.changed
                    };
                    updatedData[index].optional_services.after = {
                        added: after.optional_services.added,
                        changed: after.optional_services.changed,
                        deleted: after.optional_services.deleted
                    };
                    // GPS_DATA
                    updatedData[index].gpsData.changed = [];
                    const checkBeforeAndAfter = (before, after) => {
                        return (this.isObject(before) && this.isObject(after) && before.id !== after.id) ||
                                (this.isObject(before) && (typeof after === 'string' || this.isNull(after) || this.isUndefined(after))) ||
                                ((typeof before === 'string' || this.isNull(before) || this.isUndefined(before)) && this.isObject(after));
                    };
                    // returns TRUE if prices are different
                    const checkPriceBeforeAndAfter = (before, after) => {
                        return ((this.isObject(before) && this.isObject(after)) && (before.price !== after.price)) ||
                            (!this.isObject(before) || !this.isObject(after));
                    };

                    for (let i = 0; i < before.gpsData.changed.length; ++i) {
                        const changedKeys = Object.keys(before.gpsData.changed[i]).reduce((changedKeys, key) => {
                            if (checkBeforeAndAfter(before.gpsData.changed[i][key], after.gpsData.changed[i][key])) {
                                changedKeys.push(key);
                                if (checkPriceBeforeAndAfter(before.gpsData.changed[i][key], after.gpsData.changed[i][key])) {
                                    changedKeys.push(`${key}_price`);
                                }
                            } else if (Array.isArray(before.gpsData.changed[i][key]) && Array.isArray(after.gpsData.changed[i][key])) {
                                if (before.gpsData.changed[i][key].length === after.gpsData.changed[i][key].length) {
                                    for (let j = 0; j < before.gpsData.changed[i][key].length; ++j) {
                                        if (checkBeforeAndAfter(before.gpsData.changed[i][key][j], after.gpsData.changed[i][key][j])) {
                                            changedKeys.push(key);
                                            if (checkPriceBeforeAndAfter(before.gpsData.changed[i][key][j], after.gpsData.changed[i][key][j])) {
                                                changedKeys.push(`${key}_price`);
                                            }
                                            break;
                                        }
                                    }
                                } else {
                                    changedKeys.push(key);
                                }
                            } else if (
                                (Array.isArray(before.gpsData.changed[i][key]) && !Array.isArray(after.gpsData.changed[i][key])) ||
                                (!Array.isArray(before.gpsData.changed[i][key]) && Array.isArray(after.gpsData.changed[i][key]))
                            ) {
                                changedKeys.push(key);
                            } else if (typeof before.gpsData.changed[i][key] === 'string' && typeof after.gpsData.changed[i][key] === 'string' && (before.gpsData.changed[i][key] !== after.gpsData.changed[i][key])) {
                                changedKeys.push(key);
                            } else if ((typeof before.gpsData.changed[i][key] === 'number' || typeof after.gpsData.changed[i][key] === 'number') && (parseInt(before.gpsData.changed[i][key]) !== parseInt(after.gpsData.changed[i][key]))) {
                                changedKeys.push(key);
                            }
                            return changedKeys;
                        }, []);
                        updatedData[index].gpsData.changed.push({
                            ...before.gpsData.changed[i],
                            id: `before-${i}`,
                            changedKeys
                        });
                        updatedData[index].gpsData.changed.push({
                            ...after.gpsData.changed[i],
                            id: `after-${i}`,
                            changedKeys
                        });
                    }

                    updatedData[index].gpsData.added = after.gpsData.added;
                    updatedData[index].gpsData.deleted = after.gpsData.deleted;
                }
                return updatedData;
            }, {});
        },
        isServicesChanged() {
            if (!this.updatedData) return [];
            return Object.keys(this.updatedData).map(key => {
                const data = this.updatedData[key];
                const servicesBefore = data.services.before;
                const servicesAfter = data.services.after;
                for (let i = 0; i < servicesBefore.length; ++i) {
                    if (servicesBefore[i].deleted) return true;
                }
                for (let i = 0; i < servicesAfter.length; ++i) {
                    if (servicesAfter[i].added) return true;
                }
                return false;
            });
        }
    },
    watch: {
        pagination: {
            handler: 'getOrdersHistory',
            deep: true
        }
    },
    methods: {
        getOrdersHistory() {
            this.loading = true;
            const { sortBy, descending, page, rowsPerPage } = this.pagination;
            const params = {};
            params.page = page;
            params.per_page = rowsPerPage
            if (this.search !== '') {
                params.query = this.search;
            }
            if (sortBy) {
                const direction = descending ? 'desc' : 'asc';
                params.direction = direction;
                params.sortBy = sortBy;
            }

            this.axios.get('/orders/logs', { params })
                .then(({data}) => {
                    this.totalOrdersHistoryItems = data.total;
                    this.ordersHistory = data.data;
                    this.loading = false;
                    this.restoring = false;
                })
                .catch(err => {
                    console.log(err);
                    this.loading = false;
                    this.restoring = false;
                });
        },
        checkSearch(value) {
            this.search = value;
            setTimeout(() => {
                if (this.search === value) {
                    this.getOrdersHistory();
                }
            }, 1500);
        },
        expand(item, props) {
            if (item.type !== 'Восстановление') {
                props.expanded = !props.expanded;
            }
        },
        restore(id) {
            this.restoring = true;
            this.axios.put(`/orders/${id}/restore`)
                .then(() => this.getOrdersHistory())
                .catch(err => {
                    console.log(err);
                    this.restoring = true;
                });
        }
    },
    components: {
        appGpsDataHistoryTable: GpsDataHistoryTable
    }
}
</script>

<style>
    a {
        text-decoration: none;
    }

    #orders-logs-table > .v-table__overflow > table.v-datatable {
        table-layout: fixed;
    }
</style>
