<template>
    <v-container fluid>
        <appEditClient
            :editDialog="dialogs.editDialog"
            :client="editedClient"
            @editDialogClosed="closeDialog"
            @clientEdited="editClient"
            @client:error="setSnackBar('error', 'Ошибка!');"
            @validation:error="setSnackBar('error', 'Неверно введенные данные!')" />
        <appDeleteClient
            :deleteDialog="dialogs.deleteDialog"
            :client="deletedClient"
            @deleteDialogClosed="closeDialog"
            @client:error="setSnackBar('error', 'Ошибка!');"
            @clientDeleted="deleteClient" />
        <v-layout v-if="!isDeleted">
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
                        <v-container fluid>
                            <v-layout>
                                <v-btn color="info" @click="setEditData">
                                    Изменить
                                </v-btn>
                                <v-btn color="error" @click="setDeleteData">
                                    Удалить
                                </v-btn>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-text>
                        <appOrders
                            :clientOrders="client.orders">
                        </appOrders>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-progress-linear
            v-else
            :width="10"
            :size="100"
            color="primary"
            indeterminate>
        </v-progress-linear>
        <v-snackbar v-model="snack" :timeout="snackTimeout" :color="snackColor" bottom right>
            {{ snackText }}
        </v-snackbar>
    </v-container>
</template>

<script>
import Orders from './../../orders/Orders';
import EditClient from './../../../components/client/editClient/EditClient';
import DeleteClient from './../../../components/client/deleteClient/DeleteClient';

export default {
    data() {
        return {
            snack: false,
            snackTimeout: 2000,
            snackColor: '',
            snackText: '',
            dialogs: {
                editDialog: false,
                deleteDialog: false
            },
            client: {
                id: '',
                person_full_name: '',
                company_name: '',
                area: '',
                telephone: '',
                comment: '',
                orders: []
            },
            editedClient: {},
            deletedClient: {},
            isDeleted: false
        };
    },
    methods: {
        editClient(client) {
            this.setSnackBar('success', 'Данные клиента обновлены!');
            this.client = { ...this.client, ...client };
        },
        deleteClient() {
            this.setSnackBar('success', 'Клиент удален!');
            this.isDeleted = true;
            setTimeout(() => {
                this.$router.push('/clients');
            }, 1000);
        },
        setEditData() {
            const { orders, ...client} = this.client;
            this.editedClient = client;
            this.openDialog('editDialog');
        },
        setDeleteData() {
            const { orders, ...client} = this.client;
            this.deletedClient = client;
            this.openDialog('deleteDialog');
        },
        openDialog(which) {
            this.dialogs[which] = true;
        },
        closeDialog(which) {
            this.dialogs[which] = false;
        },
        setSnackBar(statusColor, statusText) {
            this.snack = true;
            this.snackColor = statusColor;
            this.snackText = statusText;
        }
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
        appOrders: Orders,
        appEditClient: EditClient,
        appDeleteClient: DeleteClient
    }
}
</script>
