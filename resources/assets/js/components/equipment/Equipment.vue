<template>
    <v-card>
        <appEditEquipmentDialog
            v-if="$auth.check('admin')"
            :editDialog="dialogs.editDialog"
            :equipment="editedEquipment"
            @editDialogClosed="closeDialog">
        </appEditEquipmentDialog>
        <appCreateEquipmentDialog
            v-if="$auth.check('admin')"
            :createDialog="dialogs.createDialog"
            :type="type"
            @createDialogClosed="closeDialog">
        </appCreateEquipmentDialog>
        <appDeleteEquipmentDialog
            v-if="$auth.check('admin')"
            :deleteDialog="dialogs.deleteDialog"
            :equipment="deletedEquipment"
            @deleteDialogClosed="closeDialog">
        </appDeleteEquipmentDialog>
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
            :items="equipment"
            :search="search">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.model }}</td>
                <td class="text-xs-right">{{ props.item.incoming_price }}</td>
                <td class="text-xs-right">{{ props.item.price }}</td>
                <td class="text-xs-right">{{ props.item.installation_price }}</td>
                <td class="text-xs-right">{{ props.item.description }}</td>
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
import EditEquipmentDialog from './editEquipment/EditEquipment';
import CreateEquipmentDialog from './createEquipment/CreateEquipment';
import DeleteEquipmentDialog from './deleteEquipment/DeleteEquipment';

export default {
    props: {
        type: {
            type: String,
            required: true
        },
        equipment: {
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
            editedEquipment: {
                model: '',
                incoming_price: '',
                price: '',
                installation_price: '',
                description: ''
            },
            deletedEquipment: {}
        };
    },
    computed: {
        loading() {
            return this.equipment.length === 0;
        }
    },
    methods: {
        setEditData(equipment) {
            this.editedEquipment = { ...equipment };
            this.openDialog('editDialog');
        },
        setDeleteData(equipment) {
            this.deletedEquipment = { ...equipment };
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
            { text: 'Модель', align: 'left', value: 'model' },
            { text: 'Входящая цена $', align: 'right', value: 'incoming_price' },
            { text: 'Цена $', align: 'right', value: 'price' },
            { text: 'Стоимость монтажа $', align: 'right', value: 'installation_price' },
            { text: 'Описание', align: 'right', value: 'description' }
        ];
        if (this.$auth.check('admin')) {
            headers.push({ text: 'Действия', align: 'right', value: 'name', sortable: false });
        }
        this.headers = headers;
    },
    components: {
        appEditEquipmentDialog: EditEquipmentDialog,
        appCreateEquipmentDialog: CreateEquipmentDialog,
        appDeleteEquipmentDialog: DeleteEquipmentDialog
    }
}
</script>
