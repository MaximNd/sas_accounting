<template>
    <v-card class="elevation-0 bg-card">
        <v-card>
            <v-card-text>
                <v-form>
                    <v-container grid-list-md>
                        <v-layout justify-center>
                            <v-flex xs12 offset-xs0 md2 offset-md2>
                                <v-text-field
                                    label="Курс Долара"
                                    :readonly="!isDollarRateEditing"
                                    v-model="orderData.dollar_rate">
                                    <v-slide-x-reverse-transition
                                        slot="append-outer"
                                        mode="out-in">
                                        <v-icon
                                            :color="isDollarRateEditing ? 'success' : 'info'"
                                            :key="`icon-${isDollarRateEditing}`"
                                            @click="isDollarRateEditing = !isDollarRateEditing"
                                            v-text="isDollarRateEditing ? 'mdi-check-outline' : 'mdi-circle-edit-outline'"
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
                                    :value="'Клиент (Компания)'">
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
                                    <v-flex xs12 sm4>
                                         <v-switch
                                            color="success"
                                            :label="isSentStatus"
                                            v-model="orderData.statuses.is_sent">
                                        </v-switch>
                                    </v-flex>
                                    <v-flex xs12 sm4>
                                        <v-switch
                                            color="success"
                                            :label="isAgreedStatus"
                                            v-model="orderData.statuses.is_agreed">
                                        </v-switch>
                                    </v-flex>
                                    <v-flex xs12 sm4>
                                        <v-switch
                                            color="success"
                                            :label="isPaidStatus"
                                            v-model="orderData.statuses.is_paid">
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
                            <v-flex xs12 offset-md2 md10 v-for="(service, index) in services" :key="`service-${index}`">
                                <v-checkbox :style="{ padding: 0, margin: index !== 0 ? 0 : false }" :label="service.name" v-model="orderData.services" :value="service"></v-checkbox>
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
                    @rowAdded="addRowToOrderGPSData">
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
                                    <v-btn large block color="info"><v-icon left>backup</v-icon>Сохранить</v-btn>
                                </v-flex>
                                <v-flex xs12 sm6>
                                    <v-btn large block color="primary">Скачать PDF <v-icon right>get_app</v-icon></v-btn>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-flex>
                </v-layout>
            </v-card-actions>
        </v-card>

        <v-snackbar v-model="snack" :timeout="snackTimeout" :color="snackColor">
            {{ snackText }}
        </v-snackbar>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
import CreateClient from './../CreateClient/CreateClient';
import GPSData from './gpsData/GPSData';
import EquipmentData from './EquipmentData/EquipmentData';
import dcopy from 'deep-copy';
import utils from './../../mixins/utils.js';
import formatter from 'accounting';

export default {
    mixins: [utils],
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
            isDollarRateEditing: false,
            snack: false,
            snackColor: '',
            snackText: '',
            snackTimeout: 1500,
            defaultRowCount: 0,
            initialGPSRowData: {
                id: 1,
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
                connect_module: '',
                can_reader: '',
                deaerator: '',
                additional_equipment: [],
                cn03: [],
                rs01: []
            },
            cachedData: [],
            newCachedData: [],
            orderInCreation: false,
            oldOrder: {},
            orderData: {
                name: '',
                client: null,
                statuses: { is_sent: false, is_agreed: false, is_paid: false },
                area: '',
                dollar_rate: 0.00,
                days: '',
                price_for_day: 720,
                price_for_transportation_per_km: '',
                number_of_trips: 2,
                transportation_kms: '',
                route: '',
                services: [],
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
            return this.orderData.services.reduce((price, service) => this.addTwoFloats(price, this.multiplyTwoFloats(service.price, area)), 0);
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
        // services(newValue) {
        //     this.orderData.services = this.services.map(service => ({ id: service.id, name: service.name, price: service.price, value: false }));
        // }
    },
    methods: {
        initOrder(priceList) {
            let copyOrder = dcopy(this.order);
            copyOrder.services = copyOrder.services.map(serviceID => this.services.find(service => service.id === serviceID));
            let id = 0;
            copyOrder.gps_data = copyOrder.gps_data.map(gpsDataRow => {
                ++id;
                return Object.keys(gpsDataRow).reduce((newRow, key) => {
                    if (key !== 'id' && typeof gpsDataRow[key] === 'number') {
                        newRow[key] = priceList.find(data => data.id === gpsDataRow[key]);
                    } else if (Array.isArray(gpsDataRow[key])) {
                        newRow[key] = gpsDataRow[key].map(id => priceList.find(data => data.id === id));
                    } else if (key !== 'id' && typeof gpsDataRow[key] === 'string') {
                        newRow[key] = gpsDataRow[key];
                    } else if (key !== 'id' && (this.isNull(gpsDataRow[key]) || this.isUndefined(gpsDataRow[key]))) {
                        newRow[key] = '';
                    }
                    return newRow;
                }, { id });
            });
            this.initialGPSRowData.id = ++id;
            this.oldOrder = copyOrder;
            const newOrderData = dcopy(copyOrder);
            this.orderData.name = newOrderData.name;
            this.orderData.client = newOrderData.client;
            this.orderData.statuses = {
                is_sent: newOrderData.is_sent, is_agreed: newOrderData.is_agreed, is_paid: newOrderData.is_paid
            };
            this.orderData.area = newOrderData.area;
            this.orderData.dollar_rate = newOrderData.dollar_rate;
            this.orderData.days = newOrderData.days;
            this.orderData.price_for_day = newOrderData.price_for_day;
            this.orderData.price_for_transportation_per_km = newOrderData.price_for_transportation_per_km;
            this.orderData.number_of_trips = newOrderData.number_of_trips;
            this.orderData.transportation_kms = newOrderData.transportation_kms;
            this.orderData.route = newOrderData.route;
            this.orderData.services = newOrderData.services;
            this.orderData.GPSData = newOrderData.gps_data;

        },
        addCache(column, value) {
            this.newCachedData.push({ column_name: column, value });
            localStorage.setItem('newCachedData', JSON.stringify(this.newCachedData));
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
            }
            if (count > 0) {
                this.saveOrderDataToLocalStorage();
                this.showSnackbar('info', `${this.declOfNum(count, ['Добавлен', 'Добавлено', 'Добавлено'])} ${count} ${this.declOfNum(count, ['ряд', 'ряда', 'рядов'])}`);
            }
        },
        dragNDropGPSData(newIndex, oldIndex) {
            const rowSelected = this.orderData.GPSData.splice(oldIndex, 1)[0];
            this.orderData.GPSData.splice(newIndex, 0, rowSelected);
            this.saveOrderDataToLocalStorage();
            this.showSnackbar('info', `Ряд был перемещён`);
        },
        createOrder() {
            this.orderInCreation = true;
            const orderData = {
                client_id: this.orderData.client,
                dollar_rate: this.orderData.dollar_rate,
                name: this.orderData.name,
                is_sent: this.orderData.statuses.is_sent,
                is_agreed: this.orderData.statuses.is_agreed,
                is_paid: this.orderData.statuses.is_paid,
                area: this.orderData.area,
                days: this.orderData.days,
                price_for_day: this.orderData.price_for_day,
                price_for_transportation_per_km: this.orderData.price_for_transportation_per_km,
                number_of_trips: this.orderData.number_of_trips,
                transportation_kms: this.orderData.transportation_kms,
                route: this.orderData.route,
                services: this.orderData.services.reduce((services, service) => {
                    services.push(service.id);
                    return services;
                }, []),
                GPSData: this.orderData.GPSData.map(row => {
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
                })
            };

            this.axios.post('/orders', orderData)
                .then(({data}) => {
                    console.log(data);

                })
                .catch(err => (console.log(err)))
                .finally(() => (this.orderInCreation = false));

            if (this.newCachedData.length > 0)
                this.axios.post('/cache', { cache: this.newCachedData });
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
                    this.initOrder(data);
                });
        }
        this.getCachedData();
        this.newCachedData = JSON.parse(localStorage.getItem('newCachedData')) || [];
        // this.orderData = JSON.parse(localStorage.getItem('orderData'));
    },
    components: {
        appCreateClient: CreateClient,
        appGPSData: GPSData,
        appEquipmentData: EquipmentData
    }
}
</script>

<style scoped>
    .bg-card {
        background-color: transparent;
    }
    .gps-tracking-header {
        font-size: 28px !important;
    }
</style>
