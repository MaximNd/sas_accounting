<template>
    <v-card>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12>
                        <v-text-field v-model="clientData.person_full_name" label="Контактное лицо" required></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field v-model="clientData.company_name" label="Компания" required></v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
            <v-btn :disabled="pending" :loading="pending" v-if="isShowCancelButton" color="error" flat @click.native="cancel">Отмена</v-btn>
            <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="createClient">Создать</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: {
        isShowCancelButton: {
            type: Boolean,
            default: false,
            required: false
        }
    },
    data() {
        return {
            pending: false,
            clientData: {
                person_full_name: '',
                company_name: ''
            }
        };
    },
    methods: {
        createClient() {
            this.pending = true;
            this.axios.post('/clients', this.clientData)
                .then(({data}) => {
                    this.$emit('clientCreated', data);
                    this.$emit('dialogClosed');
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.pending = false;
                });
        },
        cancel() {
            this.$emit('dialogClosed');
        }
    }
}
</script>
