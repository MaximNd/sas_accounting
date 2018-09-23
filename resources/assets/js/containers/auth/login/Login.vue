<template>
    <v-container class="bg-primary" fluid v-if="$auth.ready()">
        <v-layout row fill-height align-center justify-center>
            <v-flex sm12 md5 lg4 xl3>
                <v-card class="pl-3 pr-3 pb-4 pt-2">
                    <v-card-media src="/images/logo.png" :contain="true" height="100px"></v-card-media>
                    <v-form @submit.prevent="loginUser">
                        <v-card-text>
                            <v-flex xs12>
                                <v-text-field
                                    v-validate="'required|email'"
                                    data-vv-name="email"
                                    :error-messages="errors.collect('email')"
                                    autofocus
                                    v-model="loginData.email"
                                    label="Email"
                                    required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field
                                    v-validate="'required'"
                                    data-vv-name="password"
                                    :error-messages="errors.collect('password')"
                                    v-model="loginData.password"
                                    label="Password"
                                    type="password"
                                    required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <router-link class="forgot-password" to="/password/forgot">Забыли пароль?</router-link>
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
        <v-snackbar v-model="errorSnack" :timeout="errorSnackTimeout" :color="errorSnackColor" bottom right>
            {{ errorSnackText }}
        </v-snackbar>
    </v-container>
</template>

<script>
    export default {
        $_veeValidate: {
            validator: 'new'
        },
        data() {
            return {
                errorSnack: false,
                errorSnackTimeout: 3000,
                errorSnackColor: 'error',
                errorSnackText: '',
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
                this.$validator.validateAll()
                    .then(isValid => {
                        if (!isValid) return;
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
                            success: () => {
                                this.pending = false;
                            },
                            error: error => {
                                this.pending = false;
                                if (error.response && error.response.status === 401) {
                                    this.errorSnackText = 'Неверные учетные данные!';
                                    this.errorSnack = true;
                                } else {
                                    this.errorSnackText = 'Ошибка!';
                                    this.errorSnack = true;
                                }
                            }
                        });
                    });
            }
        }
    }
</script>

<style scoped>
    .forgot-password {
        text-decoration: none;
        color: #1976d2;
        font-size: 12px;
    }

    .forgot-password:active {
        color: #1976d2;
    }

</style>
