<template>
    <v-container class="bg-primary" fluid v-if="$auth.ready()">
        <v-layout row fill-height align-center justify-center>
            <v-flex sm12 md5 lg4 xl3>
                <v-card class="pl-3 pr-3 pb-4 pt-2">
                    <v-card-media src="/images/logo.png" :contain="true" height="100px"></v-card-media>
                    <v-form @submit.prevent="sendEmail">
                        <v-card-text>
                            <v-flex xs12>
                                <v-text-field
                                    v-validate="'required|email'"
                                    data-vv-name="email"
                                    :error-messages="errors.collect('email')"
                                    hint="На данный E-Mail адрес будет отправлена ссылка для сброса пароля"
                                    persistent-hint
                                    autofocus
                                    v-model="email"
                                    label="Email"
                                    required></v-text-field>
                            </v-flex>
                        </v-card-text>
                        <v-card-actions>
                            <v-layout align-center justify-center>
                                <v-btn
                                    type="submit"
                                    @click.prevent="sendEmail"
                                    color="primary"
                                    :loading="pending"
                                    :disabled="pending">Отправить ссылку для сброса пароля<v-icon right>send</v-icon></v-btn>
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
            email: '',
            pending: false
        };
    },
    methods: {
        sendEmail() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) return;
                    this.pending = true;
                    localStorage.setItem('email_for_password_reset', this.email );
                    return this.axios.post('/password/email', { email: this.email });
                })
                .then(res => {
                    this.pending = false;
                })
                .catch(err => {
                    console.log(err);
                    this.pending = false;
                });
        }
    }
}
</script>
