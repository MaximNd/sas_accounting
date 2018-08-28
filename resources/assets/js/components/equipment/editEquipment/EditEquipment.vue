<template>
    <v-dialog v-model="editDialog" persistent max-width="550px">
        <v-card>
            <v-card-title>
                <span class="headline">Редактировать оборудование</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-text-field v-model="editedEquipment.name" label="Модель"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="editedEquipment.incoming_price" append-icon="attach_money" label="Входящая цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="editedEquipment.price" append-icon="attach_money" label="Цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="editedEquipment.installation_price_for_one" append-icon="₴" label="Стоимость монтажа 1шт."></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="editedEquipment.installation_price_for_two" append-icon="₴" label="Стоимость монтажа 2шт."></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="editedEquipment.installation_price_for_three" append-icon="₴" label="Стоимость монтажа 3шт"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-textarea v-model="editedEquipment.description" label="Описание"></v-textarea>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="editEquipment">Сохранить</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        editDialog: {
            type: Boolean,
            required: true
        },
        equipment: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            pending: false,
            editedEquipment: {}
        };
    },
    watch: {
        equipment(newVal) {
            this.editedEquipment = { ...newVal };
        }
    },
    methods: {
        editEquipment() {
            this.pending = true;
            const payload = {
                id: this.equipment.id,
                isService: false,
                equipment: {
                    name: this.editedEquipment.name,
                    incoming_price: this.editedEquipment.incoming_price,
                    price: this.editedEquipment.price,
                    installation_price_for_one: this.editedEquipment.installation_price_for_one,
                    installation_price_for_two: this.editedEquipment.installation_price_for_two,
                    installation_price_for_three: this.editedEquipment.installation_price_for_three,
                    description: this.editedEquipment.description,
                    type: this.editedEquipment.type
                },
                log: {
                    before: JSON.stringify(this.equipment),
                    after: JSON.stringify(this.editedEquipment)
                }
            };
            this.$store.dispatch('editEquipment', payload)
                .then((data) => {
                    this.$emit('editDialogClosed', 'editDialog');
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.pending = false;
                });
        },
        closeDialog() {
            this.$emit('editDialogClosed', 'editDialog');
        }
    }
}
</script>
