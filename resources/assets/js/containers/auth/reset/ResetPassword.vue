<template>
    <v-container class="bg-primary" fluid v-if="$auth.ready()">
        <v-layout row fill-height align-center justify-center>
            <v-flex sm12 md5 lg4 xl3>
                <v-card class="pl-3 pr-3 pb-4 pt-2">
                    <v-card-media src="/images/logo.png" :contain="true" height="100px"></v-card-media>
                    <v-form @submit.prevent="resetPassword">
                        <v-card-text>
                            <v-text-field
                                style="display:none;"
                                v-validate="'required|email'"
                                data-vv-name="email"
                                v-model="data.email"
                                required></v-text-field>
                            <v-flex xs12>
                                <v-text-field
                                    v-validate="'required'"
                                    data-vv-name="password"
                                    data-vv-as="Пароль"
                                    name="password"
                                    :error-messages="errors.collect('password')"
                                    ref="password"
                                    type="password"
                                    v-model="data.password"
                                    label="Пароль"
                                    required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field
                                    target="password"
                                    v-validate="'required|confirmed:password'"
                                    data-vv-name="password_confirmation"
                                    data-vv-as="Подтверждение пароля"
                                    :error-messages="errors.collect('password_confirmation')"
                                    ref="password_confirmation"
                                    type="password"
                                    v-model="data.password_confirmation"
                                    label="Подтверждение пароля"
                                    required></v-text-field>
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
import { Validator } from 'vee-validate';

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
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) return;
                    this.pending = true;
                    return this.axios.post('/password/reset', this.data)
                })
                .then(res => {
                    if (res) {
                        this.$router.push('/login');
                        localStorage.removeItem('email_for_password_reset');
                    }
                })
                .catch(err => {
                    this.pending = false;
                    console.log(err);
                });
        }
    },
    created() {
        this.data.token = this.$route.params.token;
        this.data.email = localStorage.getItem('email_for_password_reset');
    }
}
</script>
