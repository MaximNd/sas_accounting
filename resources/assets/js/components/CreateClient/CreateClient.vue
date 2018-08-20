<template>
    <v-card>
        <v-dialog v-if="!isShowCancelButton" v-model="similarityDialog" persistent max-width="550">
            <v-card>
                <v-card-title primary-title class="headline error white--text">
                    Введенные данные совпадают с некоторыми данными уже существующих клиентов!
                </v-card-title>
                <v-card-text>
                    <v-list>
                        <v-list-tile v-for="(client, index) in similarClients" :key="index">
                            <v-list-tile-content>
                                <v-list-tile-title>{{ client.text }}</v-list-tile-title>
                            </v-list-tile-content>
                            <v-list-tile-action>
                                <v-btn @click="selectClient(client)" color="info" flat>Выбрать</v-btn>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn color="error" flat @click.native="cancelSimilarity">Отмена</v-btn>
                    <v-btn color="error" flat @click.native="createClient(true)">Игнорировать и создать нового клиента</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12>
                        <v-text-field autofocus v-model="clientData.person_full_name" label="Контактное лицо" required></v-text-field>
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
            <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="createClient(false)">{{ createClientBtnText }}</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import stringSimilarity from 'string-similarity';

export default {
    props: {
        isShowCancelButton: {
            type: Boolean,
            default: false,
            required: false
        },
        clients: {
            type: Array,
            default: () => [],
            required: false
        }
    },
    data() {
        return {
            pending: false,
            similarityDialog: false,
            similarClients: [],
            clientData: {
                person_full_name: '',
                company_name: ''
            }
        };
    },
    computed: {
        createClientBtnText() {
            return this.isShowCancelButton ? 'Создать' : 'Создать и выбрать';
        }
    },
    methods: {
        createClient(ignoreSimilarity) {
            if (!this.isShowCancelButton && !ignoreSimilarity) {
                this.clients.forEach(client => {
                    if (stringSimilarity.compareTwoStrings(client.person_full_name, this.clientData.person_full_name) >= 0.7 ||
                        stringSimilarity.compareTwoStrings(client.company_name, this.clientData.company_name) >= 0.7
                    ) {
                        this.similarClients.push(client);
                    }
                });
                if (this.similarClients.length > 0) {
                    this.similarityDialog = true;
                    return;
                }
            }
            this.similarityDialog = false;
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
        selectClient(client) {
            this.$emit('existingClientSelected', client);
            this.similarityDialog = false;
        },
        cancel() {
            this.$emit('dialogClosed');
        },
        cancelSimilarity() {
            this.similarityDialog = false;
            this.similarClients = [];
        }
    }
}
</script>
