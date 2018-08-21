<template>
    <v-card>
        <appEditServiceDialog
            v-if="$auth.check('admin')"
            :editDialog="dialogs.editDialog"
            :service="editedService"
            @editDialogClosed="closeDialog">
        </appEditServiceDialog>
        <appCreateServiceDialog
            v-if="$auth.check('admin')"
            :createDialog="dialogs.createDialog"
            @createDialogClosed="closeDialog">
        </appCreateServiceDialog>
        <appDeleteServiceDialog
            v-if="$auth.check('admin')"
            :deleteDialog="dialogs.deleteDialog"
            :service="deletedService"
            @deleteDialogClosed="closeDialog">
        </appDeleteServiceDialog>
        <v-card-title>
            <v-btn v-if="$auth.check('admin')" color="primary" @click="openDialog('createDialog')">Создать</v-btn>
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="search"
                label="Search"
                single-line
                hide-details>
            </v-text-field>
        </v-card-title>
        <v-data-table
            :loading="loading"
            :headers="headers"
            :items="services"
            :search="search">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td class="text-xs-right">{{ props.item.price }}</td>
                <td class="text-xs-right">{{ props.item.created_at }}</td>
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
</template>

<script>
import EditServiceDialog from './editService/EditService';
import CreateServiceDialog from './createService/CreateService';
import DeleteServiceDialog from './deleteService/DeleteService';

export default {
    props: {
        services: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            search: '',
            headers: [],
            dialogs: {
                createDialog: false,
                editDialog: false,
                deleteDialog: false
            },
            editedService: {
                name: '',
                price: ''
            },
            deletedService: {}
        };
    },
    computed: {
        loading() {
            return this.services.length === 0;
        }
    },
    methods: {
        setEditData(service) {
            this.editedService = { ...service };
            this.openDialog('editDialog');
        },
        setDeleteData(service) {
            this.deletedService = { ...service };
            this.openDialog('deleteDialog');
        },
        openDialog(which) {
            this.dialogs[which] = true;
        },
        closeDialog(which) {
            this.dialogs[which] = false;
        }
    },
    created() {
        let headers = [
            { text: 'Название', align: 'left', value: 'name' },
            { text: 'Цена $', align: 'right', value: 'price' },
            { text: 'Дата создания', align: 'right', value: 'created_at' }
        ];
        if (this.$auth.check('admin')) {
            headers.push({ text: 'Действия', align: 'right', value: 'name', sortable: false });
        }
        this.headers = headers;
    },
    components: {
        appEditServiceDialog: EditServiceDialog,
        appCreateServiceDialog: CreateServiceDialog,
        appDeleteServiceDialog: DeleteServiceDialog
    }
}
</script>
