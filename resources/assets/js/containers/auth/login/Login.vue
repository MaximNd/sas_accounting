<template>
    <v-container class="bg-login" fluid v-if="$auth.ready()">
        <v-layout row fill-height align-center justify-center>
            <v-flex sm12 md5 lg4 xl3>
                <v-card class="pl-3 pr-3 pb-4 pt-2">
                    <v-card-media src="/images/logo.png" :contain="true" height="100px"></v-card-media>
                    <v-form @submit.prevent="loginUser">
                        <v-card-text>
                            <v-flex xs12>
                                <v-text-field autofocus v-model="loginData.email" label="Email" required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field v-model="loginData.password" label="Password" type="password" required></v-text-field>
                            </v-flex>
                        </v-card-text>
                        <v-card-actions>
                            <v-layout align-center justify-center>
                                <v-btn
                                    type="submit"
                                    @click.prevent="loginUser"
                                    color="primary"
                                    :loading="pending"
                                    :disabled="pending">Войти<v-icon right>send</v-icon></v-btn>
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
                loginData: {
                    email: '',
                    password: ''
                },
                pending: false
            };
        },
        methods: {
            loginUser() {
                if (this.pending) return;
                this.pending = true;
                const data = {
                    client_id: 2,
                    client_secret: process.env.MIX_CLIENT_SECRET,
                    grant_type: 'password',
                    username: this.loginData.email,
                    password: this.loginData.password
                };
                this.$auth.login({
                    data,
                    success: data => {
                        this.pending = false;
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .bg-login {
        width: 100%;
        height: 100vh;
        background: rgb(8,54,94);
        background: linear-gradient(40deg, rgba(8,54,94,1) 0%, rgba(32,100,151,1) 100%);
        background-size: cover;
    }
</style>
