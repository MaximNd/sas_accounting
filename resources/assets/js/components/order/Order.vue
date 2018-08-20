<template>
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
                            <v-text-field v-model="orderData.area" label="Площадь"></v-text-field>
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
</template>

<script>
import CreateClient from './../CreateClient/CreateClient';

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
            orderData: {
                name: '',
                client: null,
                area: '',
                services: [
                    { name: 'Электронные карты', value: false, column: 'electronic_cards' },
                    { name: 'GPS-трекинг', value: false, column: 'gps_tracking' },
                    { name: 'Беспилотники', value: false, column: 'drones' },
                    { name: 'Химический анализ почвы', value: false, column: 'chemical_soil_analysis' },
                    { name: 'Учет земельного банка', value: false, column: 'land_bank_registrations' },
                    { name: 'Консалтинг', value: false, column: 'consulting' },
                    { name: 'Дифференцированное внесение', value: false, column: 'differentiated_application' },
                    { name: 'Автономная метеостанция', value: false, column: 'auto_meteorolo_station' }
                ]
            },
            clients: [],
            isClientCreation: false
        };
    },
    computed: {
        switcherBtnText() {
            return this.isClientCreation ? 'Выбрать клиента' : 'Создать клиента';
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
        }
    },
    created() {
        this.getClients();
    },
    components: {
        appCreateClient: CreateClient
    }
}
</script>
