<template>
    <v-container fluid>
        <appDeleteOrder
            :dialog="deleteDialog"
            :deletingOrder="deletingOrder"
            @delete:order="deleteOrder"
            @deleteDialogClosed="closeDialog">
        </appDeleteOrder>
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-title>
                        <v-spacer></v-spacer>
                        <v-text-field
                            v-if="clientOrders"
                            clearable
                            v-model="search"
                            append-icon="search"
                            label="Поиск"
                            single-line
                            hide-details>
                        </v-text-field>
                        <v-text-field
                            v-else
                            clearable
                            :value="search"
                            @input="checkSearch"
                            @change="getOrders"
                            append-icon="search"
                            label="Поиск"
                            single-line
                            hide-details>
                        </v-text-field>
                    </v-card-title>
                    <v-data-table
                        v-if="clientOrders"
                        :headers="headers"
                        :items="clientOrders"
                        :search="search"
                        class="elevation-1 table-fonts">
                        <template slot="items" slot-scope="props">
                            <td><router-link :to="`/orders/${props.item.id}`">{{ props.item.name }}</router-link></td>
                            <td>{{ props.item.area }}</td>
                            <td :class="{ 'error--text': !props.item.is_sent, 'success--text': props.item.is_sent }">{{ props.item.is_sent ? 'Отправленный' : 'Неотправленный' }}</td>
                            <td :class="{ 'error--text': !props.item.is_agreed, 'success--text': props.item.is_agreed }">{{ props.item.is_agreed ? 'Согласованный' : 'Несогласованный' }}</td>
                            <td :class="{ 'error--text': !props.item.is_paid, 'success--text': props.item.is_paid }">{{ props.item.is_paid ? 'Оплаченный' : 'Неоплаченный' }}</td>
                            <td :class="{ 'error--text': !props.item.is_installation_finished, 'success--text': props.item.is_installation_finished }">{{ props.item.is_paid ? 'Закончен' : 'Не закончен' }}</td>
                            <td>{{ props.item.created_at }}</td>
                            <td v-if="$auth.check('admin')" class="justify-center layout px-0">
                                <v-btn
                                    icon
                                    @click="setDeleteOrder(props.item)">
                                    <v-icon>delete</v-icon>
                                </v-btn>
                            </td>
                        </template>
                    </v-data-table>
                    <v-data-table
                        v-else
                        :headers="headers"
                        :items="orders"
                        :pagination.sync="pagination"
                        :total-items="totalOrders"
                        :loading="loading"
                        class="elevation-1 table-fonts">
                        <template slot="items" slot-scope="props">
                            <td class="text-no-wrap"><router-link :to="`/orders/${props.item.id}`">{{ props.item.name }}</router-link></td>
                            <td class="text-no-wrap"><router-link :to="`/clients/${props.item.client.id}`">{{ props.item.client.person_full_name }}</router-link></td>
                            <td>{{ props.item.client.company_name }}</td>
                            <td>{{ props.item.area }}</td>
                            <td :class="{ 'error--text': !props.item.is_sent, 'success--text': props.item.is_sent }">{{ props.item.is_sent ? 'Отправленный' : 'Неотправленный' }}</td>
                            <td :class="{ 'error--text': !props.item.is_agreed, 'success--text': props.item.is_agreed }">{{ props.item.is_agreed ? 'Согласованный' : 'Несогласованный' }}</td>
                            <td :class="{ 'error--text': !props.item.is_paid, 'success--text': props.item.is_paid }">{{ props.item.is_paid ? 'Оплаченный' : 'Неоплаченный' }}</td>
                            <td :class="{ 'error--text': !props.item.is_installation_finished, 'success--text': props.item.is_installation_finished }">{{ props.item.is_paid ? 'Закончен' : 'Не закончен' }}</td>
                            <td>{{ props.item.created_at }}</td>
                            <td v-if="$auth.check('admin')" class="justify-center layout px-0">
                                <v-btn
                                    icon
                                    @click="setDeleteOrder(props.item)">
                                    <v-icon>delete</v-icon>
                                </v-btn>
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import DeleteOrder from './../../components/order/deleteOrder/DeleteOrder';

export default {
    props: {
        clientOrders: {
            type: Array,
            required: false,
            default: null
        }
    },
    data() {
        return {
            deleteDialog: false,
            search: '',
            totalOrders: 0,
            orders: [],
            loading: true,
            pagination: {
                rowsPerPage: 10,
                sortBy: 'created_at',
                descending: true
            },
            deletingOrder: {}
        };
    },
    computed: {
        headers() {
            let headers = [
                {
                    text: 'Название',
                    align: 'left',
                    value: 'name'
                }
            ];
            if (!this.clientOrders) {
                headers.push(
                    { text: 'Клиент', width: '100', value: 'client.person_full_name' },
                    { text: 'Компания', width: '100', value: 'client.company_name' }
                );
            }

            headers.push(
                { text: 'Площадь', width: '10', value: 'area', width: '15px' },
                { text: 'Статус отправки', value: 'is_sent' },
                { text: 'Статус согласования', value: 'is_agreed' },
                { text: 'Статус оплаты', value: 'is_paid' },
                { text: 'Статус монтажа', value: 'is_installation_finished' },
                { text: 'Дата создания', value: 'created_at' }
            );
            if (this.$auth.check('admin')) {
                headers.push({ text: 'Удаление', value: '', align: 'right', sortable: false });
            }
            return headers;
        }
    },
    watch: {
        pagination: {
            handler: 'getOrders',
            deep: true
        }
    },
    methods: {
        getOrders() {
            if (this.clientOrders) return;
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

            this.axios.get('/orders', { params })
                .then(({data}) => {
                    this.totalOrders = data.total;
                    this.orders = data.data;
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        checkSearch(value) {
            this.search = value;
            setTimeout(() => {
                if (this.search === value) {
                    this.getOrders();
                }
            }, 1500);
        },
        setDeleteOrder(order) {
            this.deletingOrder = order;
            this.openDilaog();
        },
        deleteOrder(id) {
            this.orders = this.orders.filter(order => order.id !== id);
        },
        openDilaog() {
            this.deleteDialog = true;
        },
        closeDialog() {
            this.deleteDialog = false;
        }
    },
    components: {
        appDeleteOrder: DeleteOrder
    }
}
</script>

<style scoped>
    a {
        text-decoration: none;
    }

    .table-fonts {
        font-size: 11px !important;
    }
</style>
