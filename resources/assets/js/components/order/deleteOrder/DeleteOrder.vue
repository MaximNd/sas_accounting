<template>
    <v-dialog v-model="dialog" persistent max-width="300px">
        <v-card>
            <v-card-title
                class="headline error white--text"
                primary-title>
                Удалить заказ: {{ deletingOrder.name }}?
            </v-card-title>
            <v-card-actions>
                <v-btn :loading="pending" :disabled="pending" color="error" flat block @click.native="closeDialog">Нет</v-btn>
                <v-btn :loading="pending" :disabled="pending" color="success" flat block @click.native="deleteOrder">Да</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        dialog: {
            type: Boolean,
            required: true
        },
        deletingOrder: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            pending: false
        }
    },
    methods: {
        deleteOrder() {
            this.pending = true;
            this.axios.delete(`/orders/${this.deletingOrder.id}`)
                .then((data) => {
                    this.$emit('delete:order', this.deletingOrder.id);
                    this.$emit('deleteDialogClosed');
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.pending = false;
                });
        },
        closeDialog() {
            this.$emit('deleteDialogClosed');
        }
    }
}
</script>
