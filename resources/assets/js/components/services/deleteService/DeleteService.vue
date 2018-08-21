<template>
    <v-dialog v-model="deleteDialog" persistent max-width="300px">
        <v-card>
            <v-card-title
                class="headline error white--text"
                primary-title>
                Удалить услугу: {{ service.name }}?
            </v-card-title>
            <v-card-actions>
                <v-btn :loading="pending" :disabled="pending" color="error" flat block @click.native="closeDialog">Нет</v-btn>
                <v-btn :loading="pending" :disabled="pending" color="success" flat block @click.native="deleteService">Да</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        deleteDialog: {
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
            pending: false
        };
    },
    methods: {
        deleteService() {
            this.pending = true;
            this.$store.dispatch('deleteEquipment', this.service.id)
                .then((data) => {
                    this.$emit('deleteDialogClosed', 'deleteDialog');
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.pending = false;
                });
        },
        closeDialog() {
            this.$emit('deleteDialogClosed', 'deleteDialog');
        }
    }
}
</script>
