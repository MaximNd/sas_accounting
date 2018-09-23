<template>
    <v-card>
        <appEditEquipmentDialog
            v-if="$auth.check('admin')"
            :editDialog="dialogs.editDialog"
            :equipment="editedEquipment"
            @editDialogClosed="closeDialog"
            @validation:error="setSnackBar('error', 'Неверно введенные данные!')"
            @equipment-updated="setSnackBar('success', 'Оборудование обновлено!')"
            @equipment:error="setSnackBar('error', 'Ошибка!')">
        </appEditEquipmentDialog>
        <appCreateEquipmentDialog
            v-if="$auth.check('admin')"
            :createDialog="dialogs.createDialog"
            :type="type"
            @createDialogClosed="closeDialog"
            @validation:error="setSnackBar('error', 'Неверно введенные данные!')"
            @equipment-created="setSnackBar('success', 'Оборудование создано!')"
            @equipment:error="setSnackBar('error', 'Ошибка!')" >
        </appCreateEquipmentDialog>
        <appDeleteEquipmentDialog
            v-if="$auth.check('admin')"
            :deleteDialog="dialogs.deleteDialog"
            :equipment="deletedEquipment"
            @deleteDialogClosed="closeDialog"
            @equipment-deleted="setSnackBar('success', 'Оборудование удалено!')"
            @equipment:error="setSnackBar('error', 'Ошибка!')">
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
                <td>
                    <img :style="{width: '60px'}" :src="`/storage/${props.item.image}`" alt="image">
                </td>
                <td>{{ props.item.name }}</td>
                <td class="text-xs-right">{{ props.item.incoming_price }}</td>
                <td class="text-xs-right">{{ props.item.price }}</td>
                <td v-if="isShowInstallationPrice.forOne" class="text-xs-right">{{ props.item.installation_price_for_one }}</td>
                <td v-if="isShowInstallationPrice.forTwo" class="text-xs-right">{{ props.item.installation_price_for_two }}</td>
                <td v-if="isShowInstallationPrice.forThree" class="text-xs-right">{{ props.item.installation_price_for_three }}</td>
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
        <v-snackbar v-model="snack" :timeout="snackTimeout" :color="snackColor" bottom right>
            {{ snackText }}
        </v-snackbar>
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
            snack: false,
            snackTimeout: 2000,
            snackColor: '',
            snackText: '',
            search: '',
            dialogs: {
                createDialog: false,
                editDialog: false,
                deleteDialog: false
            },
            editedEquipment: {
                image: '',
                name: '',
                incoming_price: '',
                price: '',
                installation_price_for_one: '',
                installation_price_for_two: '',
                installation_price_for_three: '',
                description: ''
            },
            deletedEquipment: {}
        };
    },
    computed: {
        loading() {
            return this.equipment.length === 0;
        },
        isShowInstallationPrice() {
            return this.equipment.reduce((isShow, equipment) => {
                return {
                    forOne: isShow.forOne || (equipment.installation_price_for_one !== null && equipment.installation_price_for_one !== ''),
                    forTwo: isShow.forTwo || (equipment.installation_price_for_two !== null && equipment.installation_price_for_two !== ''),
                    forThree: isShow.forThree || (equipment.installation_price_for_three !== null && equipment.installation_price_for_three !== ''),
                };
            }, { forOne: false, forTwo: false, forThree: false });
        },
        headers() {
            let headers = [
                { text: 'Изображение', align: 'left', value: 'image', sortable: false },
                { text: 'Модель', align: 'left', value: 'name' },
                { text: 'Входящая цена $', align: 'right', value: 'incoming_price' },
                { text: 'Цена $', align: 'right', value: 'price' }
            ];
            if (this.isShowInstallationPrice.forOne) {
                headers.push({ text: 'Монтаж 1шт. ₴', align: 'right', value: 'installation_price_for_one' });
            }
            if (this.isShowInstallationPrice.forTwo) {
                headers.push({ text: 'Монтаж 2шт. ₴', align: 'right', value: 'installation_price_for_two' });
            }
            if(this.isShowInstallationPrice.forThree) {
                headers.push({ text: 'Монтаж 3шт. ₴', align: 'right', value: 'installation_price_for_three' });
            }
            headers.push({ text: 'Описание', align: 'right', value: 'description' });
            if (this.$auth.check('admin')) {
                headers.push({ text: 'Действия', align: 'right', value: 'name', sortable: false });
            }
            return headers;
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
        },
        setSnackBar(statusColor, statusText) {
            this.snack = true;
            this.snackColor = statusColor;
            this.snackText = statusText;
        }
    },
    components: {
        appEditEquipmentDialog: EditEquipmentDialog,
        appCreateEquipmentDialog: CreateEquipmentDialog,
        appDeleteEquipmentDialog: DeleteEquipmentDialog
    }
}
</script>
