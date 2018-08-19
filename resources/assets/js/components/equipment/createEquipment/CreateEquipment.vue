<template>
    <v-dialog v-model="createDialog" persistent max-width="550px">
        <v-card>
            <v-card-title>
                <span class="headline">Создать оборудование</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-text-field v-model="newEquipment.model" label="Модель"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="newEquipment.incoming_price" append-icon="attach_money" label="Входящая цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="newEquipment.price" append-icon="attach_money" label="Цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="newEquipment.installation_price" append-icon="attach_money" label="Стоимость монтажа"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-textarea v-model="newEquipment.description" label="Описание"></v-textarea>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="createEquipment">Сохранить</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        createDialog: {
            type: Boolean,
            required: true
        },
        type: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            pending: false,
            newEquipment: {
                model: '',
                incoming_price: '',
                price: '',
                installation_price: '',
                description: '',
                type: ''
            }
        };
    },
    methods: {
        createEquipment() {
            this.pending = true;
            this.newEquipment.type = this.type;
            this.$store.dispatch('createEquipment', this.newEquipment)
                .then((data) => {
                    this.$emit('createDialogClosed', 'createDialog');
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.pending = false;
                });
        },
        closeDialog() {
            this.$emit('createDialogClosed', 'createDialog');
        }
    }
}
</script>
