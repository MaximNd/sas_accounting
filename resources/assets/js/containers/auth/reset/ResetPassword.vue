<template>
    <v-container class="bg-primary" fluid v-if="$auth.ready()">
        <v-layout row fill-height align-center justify-center>
            <v-flex sm12 md5 lg4 xl3>
                <v-card class="pl-3 pr-3 pb-4 pt-2">
                    <v-card-media src="/images/logo.png" :contain="true" height="100px"></v-card-media>
                    <v-form @submit.prevent="resetPassword">
                        <v-card-text>
                            <v-flex xs12>
                                <v-text-field autofocus v-model="data.email" label="Email" required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field type="password" v-model="data.password" label="Password" required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field type="password" v-model="data.password_confirmation" label="Password confirmation" required></v-text-field>
                            </v-flex>
                        </v-card-text>
                        <v-card-actions>
                            <v-layout align-center justify-center>
                                <v-btn
                                    type="submit"
                                    @click.prevent="resetPassword"
                                    color="primary"
                                    :loading="pending"
                                    :disabled="pending">Поменять пароль<v-icon right>send</v-icon></v-btn>
                            </v-layout>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            data: {
                token: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            pending: false
        };
    },
    methods: {
        resetPassword() {
            this.pending = true;
            this.axios.post('/password/reset', this.data)
                .then(res => {
                    this.$router.push('/login');
                })
                .catch(err => {
                    this.pending = false;
                    console.log(err);
                });
        }
    },
    created() {
        this.data.token = this.$route.params.token;
        console.log(this.data);
    }
}
</script>
