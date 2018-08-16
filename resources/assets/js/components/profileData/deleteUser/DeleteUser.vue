<template>
    <v-dialog v-model="dialog" persistent max-width="300px">
        <v-card>
            <v-card-title
                class="headline error white--text"
                primary-title>
                Удалить пользователя: {{ full_name }}?
            </v-card-title>
            <v-card-actions>
                <v-btn :loading="pending" :disabled="pending" color="error" flat block @click.native="closeDialog">Нет</v-btn>
                <v-btn :loading="pending" :disabled="pending" color="success" flat block @click.native="deleteUser">Да</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data() {
        return {
            pending: false
        };
    },
    props: {
        dialog: {
            type: Boolean,
            required: true
        },
        user: {
            type: Object,
            required: true
        }
    },
    computed: {
        full_name() {
            return `${this.user.last_name} ${this.user.first_name} ${this.user.mid_name}`;
        }
    },
    methods: {
        deleteUser() {
            this.pending = true;
            this.axios.delete(`/users/${this.user.id}`)
                .then(({data}) => {
                    this.pending = false;
                    this.$emit('userDeleted');
                    this.$emit('dialogClosed');
                })
                .catch(err => {
                    this.pending = false;
                    console.log(err);
                });
        },
        closeDialog() {
            this.$emit('dialogClosed');
        }
    }
}
</script>
