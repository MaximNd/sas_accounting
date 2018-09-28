<template>
    <v-dialog v-model="createDialog" persistent max-width="1200px">
        <v-card>
            <v-card-title>
                <span class="headline">Создать услугу</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 offset-sm1 sm10>
                            <v-text-field
                                v-validate="'required'"
                                data-vv-name="name"
                                :error-messages="errors.collect('name')"
                                v-model="newService.name"
                                label="Название"></v-text-field>
                        </v-flex>
                        <v-flex xs12 offset-sm1 sm10>
                            <v-text-field
                                v-validate="'required|decimal:2'"
                                data-vv-name="price"
                                :error-messages="errors.collect('price')"
                                v-model="newService.price"
                                append-icon="attach_money"
                                label="Цена за гектар"></v-text-field>
                        </v-flex>
                        <v-flex xs12 offset-sm1 sm10>
                            <v-select
                                v-validate="`required|${includedNamesForPDFLayoutField}`"
                                data-vv-name="pdf_layout"
                                :error-messages="errors.collect('pdf_layout')"
                                v-model="newService.pdf_layout"
                                :items="pdfLayoutNames"
                                label="Макет PDF"></v-select>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="createService">Сохранить</v-btn>
            </v-card-actions>
            <template v-if="newService.pdf_layout">
                <v-card-title>
                    <span class="headline">Превью макета {{ newService.pdf_layout }}</span>
                </v-card-title>
                <v-card-text :class="{ 'service-preview': $vuetify.breakpoint.mdAndDown }">
                    <appPDF :gpsData="fakeGPSData" :services="[newService]" oneServicePreview></appPDF>
                </v-card-text>
            </template>
            <template v-else>
                <v-card-title>
                    <span class="headline">Вибирете один из макетов чтоб посмотреть превью</span>
                </v-card-title>
            </template>
        </v-card>
    </v-dialog>
</template>

<script>
import pdfLayoutNames from './../../../constants/ServicesPreviewNames.js';
import PDF from './../../order/PDF/PDF';

export default {
    props: {
        createDialog: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            fakeGPSData: [
                {id:1,order_id:1,order:1,image:'/storage/transport_fake.png',mark:'Ms. Golda Mosciski',model:'',year_of_issue:'',fuel_type:'',power:'',number:'',gps_tracker:{id:13,image:'equipment_FAKE.png',name:'Model:493',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'Датчики уровня топлива','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'},fuel_gauge:[{id:13,image:'equipment_FAKE.png',name:'Model:500',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'GPS-трекеры','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'},{id:13,image:'/storage/equipment_FAKE.png',name:'Model:500',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'Датчики уровня топлива','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'}],counter:'',rf_id:'',reader_of_trailed_equipment:'',can_reader:'',deaerator:'',additional_equipment:[],cn03:[],rs01:[],created_at:'2018-09-28 15:29:18',updated_at:'2018-09-28 15:29:18'}
            ],
            pending: false,
            pdfLayoutNames: [
                pdfLayoutNames.CONNEC_TO_PLATFORM,
                pdfLayoutNames.FIELD_MAPPING_BY_DRONES,
                pdfLayoutNames.FIELD_MAPPING_BY_PHYSICAL_MEASUREMENT,
                pdfLayoutNames.LAND_BANK_ACCOUNTING,
                pdfLayoutNames.GPS_TRACKING,
                pdfLayoutNames.PARTOL,
                pdfLayoutNames.NDVI,
                pdfLayoutNames.COUNTING_SEEDLINGS,
                pdfLayoutNames.PHOTO_VIDEO,
                pdfLayoutNames.SAS_MAPPER,
                pdfLayoutNames.CHEMICAL_SOIL_ANALYSIS,
                pdfLayoutNames.MEASURING_THE_HARDNESS_OF_THE_SOIL,
                pdfLayoutNames.INTEGRATION_1C
            ],
            newService: {
                name: '',
                price: '',
                pdf_layout: '',
                type: 'Услуга'
            }
        };
    },
    computed: {
        includedNamesForPDFLayoutField() {
            return `included:${this.pdfLayoutNames.join(',')}`;
        }
    },
    methods: {
        createService() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation:error');
                        return;
                    }
                    this.pending = true;
                    this.$store.dispatch('createEquipment', this.newService)
                        .then((data) => {
                            this.$emit('createDialogClosed', 'createDialog');
                            this.$emit('service-created');
                            this.newService.name = '';
                            this.newService.price = '';
                            this.newService.pdf_layout = '';
                            this.pending = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$emit('service:error');
                            this.pending = false;
                        });
                });
        },
        closeDialog() {
            this.$emit('createDialogClosed', 'createDialog');
        }
    },
    components: {
        appPDF: PDF
    }
}
</script>

<style scoped>
    .service-preview {
        padding: 0;
        margin: 0 auto;
        overflow: scroll;
    }
</style>
