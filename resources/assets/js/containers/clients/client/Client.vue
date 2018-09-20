<template>
    <v-container fluid>
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-text>
                        <v-layout justify-start wrap>
                            <v-flex xs12 sm7 offset-sm3 lg4 offset-lg4>
                                <v-text-field v-model="client.person_full_name" label="Контактное лицо" readonly></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm7 offset-sm3 lg4 offset-lg4>
                                <v-text-field v-model="client.company_name" label="Компания" readonly></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm7 offset-sm3 lg4 offset-lg4>
                                <v-text-field v-model="client.area" label="Площадь" readonly></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm7 offset-sm3 lg4 offset-lg4>
                                <v-text-field v-model="client.telephone" label="Телефон" readonly></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm7 offset-sm3 lg4 offset-lg4>
                                <v-textarea v-model="client.comment" label="Коментарий" readonly></v-textarea>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                    <v-card-text>
                        <appOrders
                            :clientOrders="client.orders">
                        </appOrders>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import Orders from './../../orders/Orders';

export default {
    data() {
        return {
            client: {
                id: '',
                person_full_name: '',
                company_name: '',
                area: '',
                telephone: '',
                comment: '',
                orders: []
            }
        };
    },
    created() {
        this.axios.get(`/clients/${this.$route.params.id}`)
            .then(({data}) => {
                this.client = data;
            })
            .catch(err => {
                console.log(err);
            });
    },
    components: {
        appOrders: Orders
    }
}
</script>
