<template>
    <v-card class="elevation-0 bg-card">
        <v-card>
            <v-card-text>
                <v-form>
                    <v-container grid-list-md>
                        <v-layout wrap justify-center>
                            <v-flex xs12 sm6>
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
                            <v-flex xs12 sm2>
                                <v-btn :block="$vuetify.breakpoint.xsOnly" color="primary" @click="isClientCreation = !isClientCreation">
                                    <v-icon small left>compare_arrows</v-icon>
                                    {{ switcherBtnText }}
                                </v-btn>
                            </v-flex>
                        </v-layout>
                        <v-layout wrap>
                            <v-flex xs12 offset-sm2 sm6>
                                <v-text-field v-model="orderData.name" label="Название заказа"></v-text-field>
                            </v-flex>
                            <v-flex xs12 offset-sm2 sm6>
                                <v-text-field v-model="orderData.area" label="Площадь" :suffix="`${priceForArea}$`"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout wrap>
                            <v-flex xs12 offset-sm2 sm10 v-for="(service, index) in orderData.services" :key="`service-${index}`">
                                <v-checkbox :style="{ padding: 0, margin: index !== 0 ? 0 : false }" :label="service.name" v-model="orderData.services[index].value"></v-checkbox>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-form>
            </v-card-text>
        </v-card>

        <v-expansion-panel class="mt-3 mb-5" :value="0">
            <v-expansion-panel-content>
                <div slot="header" class="gps-tracking-header">GPS-трекинг</div>
                <appGPSData
                    :orderGPSData="orderData.GPSData"
                    :gpsTrackers="gpsTrackers"
                    :fuelLevelSensors="fuelLevelSensors"
                    :fuelFlowmeters="fuelFlowmeters"
                    :identification="identification"
                    :optionalEquipment="optionalEquipment"
                    @update:orderGPSData="updateOrderGPSData"
                    @drag-n-drop-gps-data="dragNDropGPSData"
                    @rowAdded="addRowToOrderGPSData">
                </appGPSData>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
import CreateClient from './../CreateClient/CreateClient';
import GPSData from './gpsData/GPSData';

export default {
    props: {
        isCreation: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    data() {
        return {
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
                fuel_gauge: '',
                counter: '',
                rf_id: '',
                reader_of_trailed_equipment: '',
                connect_module: '',
                can_reader: '',
                deaerator: '',
                additional_equipment: ''
            },
            orderData: {
                name: '',
                client: null,
                area: '',
                services: [],
                GPSData: []
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
        priceForArea() {
            const area = (this.orderData.area === '' || this.orderData.area === null) ? 0 : parseFloat(this.orderData.area);
            return this.orderData.services.reduce((price, service) => service.value ? price + (service.price * area) : price, 0);
        }
    },
    watch: {
        services(newValue) {
            this.orderData.services = this.services.map(service => ({ id: service.id, name: service.name, price: service.price, value: false }));
        }
    },
    methods: {
        getClients() {
            this.axios.get('/clients/all')
                .then(({data}) => {
                    const clients = data.map(client => this.getClientWithTextValue(client));
                    this.clients = clients;
                })
                .catch(err => (console.log(err)));
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
        updateOrderGPSData(val, index, path) {
            console.log(val, index, path);
            this.orderData.GPSData[index][path] = val;
            // this.$set(this.orderData.GPSData[index], path, val);
        },
        addRowToOrderGPSData() {
            this.orderData.GPSData.push({ ...this.initialGPSRowData });
            ++this.initialGPSRowData.id;
        },
        dragNDropGPSData(newIndex, oldIndex) {
            const rowSelected = this.orderData.GPSData.splice(oldIndex, 1)[0];
            this.orderData.GPSData.splice(newIndex, 0, rowSelected);
        }
    },
    created() {
        this.getClients();
        this.$store.dispatch('getPriseList');
    },
    components: {
        appCreateClient: CreateClient,
        appGPSData: GPSData
    }
}
</script>

<style scoped>
    .bg-card {
        background-color: transparent;
    }
    .gps-tracking-header {
        font-size: 28px;
        text-align: center;
    }
</style>
