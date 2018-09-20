<template>
    <v-container fluid>
        <appEditClient
            :editDialog="dialogs.editDialog"
            :client="editedClient"
            @editDialogClosed="closeDialog"
            @clientEdited="editClient" />
        <appDeleteClient
            :deleteDialog="dialogs.deleteDialog"
            :client="deletedClient"
            @deleteDialogClosed="closeDialog"
            @clientDeleted="deleteClient" />
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-title>
                        <v-dialog v-model="dialogs.createDialog" persistent max-width="500px">
                            <v-btn slot="activator" color="info">Добавить клиента</v-btn>
                            <appCreateClient
                                isShowCancelButton
                                @dialogClosed="closeDialog"
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
                            <td>
                                <router-link :to="`/clients/${props.item.id}`">{{ props.item.person_full_name }}</router-link>
                            </td>
                            <td>{{ props.item.company_name }}</td>
                            <td>{{ props.item.area }}</td>
                            <td>{{ props.item.telephone }}</td>
                            <td>{{ props.item.comment }}</td>
                            <td v-if="$auth.check('admin')" class="justify-end layout px-0">
                                <v-btn
                                    icon
                                    class="mr-2"
                                    @click="setEditData(props.item)">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <v-btn
                                    icon
                                    @click="setDeleteData(props.item)">
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
import CreateClient from './../../components/client/createClient/CreateClient';
import EditClient from './../../components/client/editClient/EditClient';
import DeleteClient from './../../components/client/deleteClient/DeleteClient';

export default {
    data () {
        return {
            dialogs: {
                createDialog: false,
                editDialog: false,
                deleteDialog: false
            },
            search: '',
            totalClients: 0,
            clients: [],
            loading: true,
            pagination: {
                rowsPerPage: 10
            },
            editedClient: {},
            deletedClient: {}
        };
    },
    computed: {
        headers() {
            const headers = [
                {
                    text: 'Контактное лицо',
                    align: 'left',
                    value: 'person_full_name'
                },
                { text: 'Компания', value: 'company_name' },
                { text: 'Площадь', value: 'area', width: '15px' },
                { text: 'Телефон', value: 'telephone' },
                { text: 'Коментарий', value: 'comment' },

            ];

            if (this.$auth.check('admin')) {
                headers.push({ text: 'Действия', align: 'right', sortable: false });
            }
            return headers;
        }
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
        editClient(client) {
            const index = this.clients.findIndex(clientRow => clientRow.id === client.id);
            this.clients.splice(index, 1, client);
        },
        deleteClient(id) {
            const index = this.clients.findIndex(client => client.id === id);
            this.clients.splice(index, 1);
        },
        checkSearch(value) {
            this.search = value;
            setTimeout(() => {
                if (this.search === value) {
                    this.getClients();
                }
            }, 1500);
        },
        prependClient(client) {
            this.clients.unshift(client);
        },
        setEditData(client) {
            this.editedClient = { ...client };
            this.openDialog('editDialog');
        },
        setDeleteData(client) {
            this.deletedClient = { ...client };
            this.openDialog('deleteDialog');
        },
        openDialog(which) {
            this.dialogs[which] = true;
        },
        closeDialog(which) {
            this.dialogs[which] = false;
        }
    },
    components: {
        appCreateClient: CreateClient,
        appEditClient: EditClient,
        appDeleteClient: DeleteClient
    }
}
</script>

<style scoped>
    a {
        text-decoration: none;
    }
</style>
