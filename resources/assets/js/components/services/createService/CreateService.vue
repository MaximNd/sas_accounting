<template>
    <v-dialog v-model="createDialog" persistent max-width="550px">
        <v-card>
            <v-card-title>
                <span class="headline">Создать услугу</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-text-field v-model="newService.name" label="Название"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="newService.price" append-icon="attach_money" label="Цена за гектар"></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="createService">Сохранить</v-btn>
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
        }
    },
    data() {
        return {
            pending: false,
            newService: {
                name: '',
                price: '',
                type: 'Услуга'
            }
        };
    },
    methods: {
        createService() {
            this.pending = true;
            this.$store.dispatch('createEquipment', this.newService)
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
