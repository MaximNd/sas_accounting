<template>
    <v-container fluid>
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-title>
                        <v-dialog v-model="dialog" persistent max-width="500px">
                            <v-btn slot="activator" color="info">Добавить клиента</v-btn>
                            <appCreateClient
                                isShowCancelButton
                                @dialogClosed="closeCreateDialog"
                                @clientCreated="prependClient">
                            </appCreateClient>
                        </v-dialog>
                        <v-spacer></v-spacer>
                        <v-text-field
                            clearable
                            :value="search"
                            @input="checkSearch"
                            append-icon="search"
                            label="Поиск"
                            single-line
                            hide-details>
                        </v-text-field>
                    </v-card-title>
                    <v-data-table
                        disable-initial-sort
                        :headers="headers"
                        :items="clients"
                        :pagination.sync="pagination"
                        :total-items="totalClients"
                        :loading="loading"
                        class="elevation-1">
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.person_full_name }}</td>
                            <td>{{ props.item.company_name }}</td>
                            <td>{{ props.item.area }}</td>
                            <td>{{ props.item.telephone }}</td>
                            <td>{{ props.item.comment }}</td>
                            <td class="text-xs-right"><v-btn color="info">Подробнее</v-btn></td>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import CreateClient from './../../components/CreateClient/CreateClient';

export default {
    data () {
        return {
            dialog: false,
            search: '',
            totalClients: 0,
            clients: [],
            loading: true,
            pagination: {
                rowsPerPage: 10
            },
            headers: [
                {
                    text: 'Контактное лицо',
                    align: 'left',
                    value: 'person_full_name'
                },
                { text: 'Компания', value: 'company_name' },
                { text: 'Площадь', value: 'area', width: '15px' },
                { text: 'Телефон', value: 'telephone' },
                { text: 'Коментарий', value: 'comment' },
                { text: '', value: '', sortable: false }
            ]
        };
    },
    watch: {
        pagination: {
            handler: 'getClients',
            deep: true
        }
    },
    methods: {
        getClients() {
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

            this.axios.get('/clients', { params })
                .then(({data}) => {
                    this.totalClients = data.total;
                    this.clients = data.data.map(client => ({...client, area: parseFloat(client.area)}));
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
                    this.getClients();
                }
            }, 1500);
        },
        closeCreateDialog() {
            this.dialog = false;
        },
        prependClient(client) {
            this.clients.unshift(client);
        }
    },
    components: {
        appCreateClient: CreateClient
    }
}
</script>
