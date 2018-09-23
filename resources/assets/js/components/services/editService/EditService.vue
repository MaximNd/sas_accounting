<template>
    <v-dialog v-model="editDialog" persistent max-width="550px">
        <v-card>
            <v-card-title>
                <span class="headline">Редактировать услугу</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required'"
                                data-vv-name="name"
                                :error-messages="errors.collect('name')"
                                v-model="editedService.name"
                                label="Название"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|decimal:2'"
                                data-vv-name="price"
                                :error-messages="errors.collect('price')"
                                v-model="editedService.price"
                                append-icon="attach_money"
                                label="Цена за гектар"></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="editService">Сохранить</v-btn>
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
        service: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            pending: false,
            editedService: {}
        };
    },
    watch: {
        service(newVal) {
            this.editedService = { ...newVal };
        }
    },
    methods: {
        editService() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation:error');
                        return;
                    }
                    this.pending = true;
                    const payload = {
                        id: this.service.id,
                        isService: true,
                        service: {
                            name: this.editedService.name,
                            price: this.editedService.price,
                            type: 'Услуга'
                        },
                        log: {
                            before: JSON.stringify(this.service),
                            after: JSON.stringify(this.editedService)
                        }
                    };
                    this.$store.dispatch('editEquipment', payload)
                        .then((data) => {
                            this.$emit('editDialogClosed', 'editDialog');
                            this.$emit('service-updated');
                            this.pending = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$emit('service:error');
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
