<template>
    <v-dialog v-model="editDialog" persistent max-width="550px">
        <v-card>
            <v-card-title>
                <span class="headline">Редактировать данные клиента</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-text-field autofocus v-model="editedClient.person_full_name" label="Контактное лицо"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field v-model="editedClient.company_name" label="Компания"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'decimal:2'"
                                data-vv-name="area"
                                :error-messages="errors.collect('area')"
                                v-model="editedClient.area"
                                label="Площадь"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'max:20'"
                                data-vv-name="telephone"
                                :error-messages="errors.collect('telephone')"
                                v-model="editedClient.telephone"
                                label="Телефон"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-textarea v-model="editedClient.comment" label="Коментарий"></v-textarea>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="editClient">Сохранить</v-btn>
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
        client: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            pending: false,
            editedClient: {
                person_full_name: '',
                company_name: '',
                area: '',
                telephone: '',
                comment: ''
            }
        };
    },
    watch: {
        client(newVal) {
            this.editedClient = { ...newVal };
        }
    },
    methods: {
        editClient() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation:error');
                        return;
                    }
                    this.pending = true;
                    this.axios.put(`/clients/${this.editedClient.id}`, this.editedClient)
                        .then((data) => {
                            this.$emit('clientEdited', this.editedClient);
                            this.$emit('editDialogClosed', 'editDialog');
                            this.pending = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.pending = false;
                        });
                });
        },
        closeDialog() {
            this.$emit('editDialogClosed', 'editDialog');
        }
    }
}
</script>
