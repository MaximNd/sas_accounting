<template>
    <v-dialog v-model="deleteDialog" persistent max-width="300px">
        <v-card>
            <v-card-title
                class="headline error white--text"
                primary-title>
                Удалить клиента: {{ client.person_full_name }}?
            </v-card-title>
            <v-card-actions>
                <v-btn :loading="pending" :disabled="pending" color="error" flat block @click.native="closeDialog">Нет</v-btn>
                <v-btn :loading="pending" :disabled="pending" color="success" flat block @click.native="deleteClient">Да</v-btn>
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
        client: {
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
        deleteClient() {
            this.pending = true;

            this.axios.delete(`/clients/${this.client.id}`)
                .then((data) => {
                    this.$emit('clientDeleted', this.client.id);
                    this.$emit('deleteDialogClosed', 'deleteDialog');
                    this.pending = false;
                })
                .catch(err => {
                    this.$emit('client:error');
                    console.log(err);
                    this.pending = false;
                })
        },
        closeDialog() {
            this.$emit('deleteDialogClosed', 'deleteDialog');
        }
    }
}
</script>
