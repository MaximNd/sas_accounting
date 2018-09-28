<template>
    <v-dialog v-model="editDialog" persistent max-width="1200px">
        <v-card>
            <v-card-title>
                <span class="headline">Редактировать услугу</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 offset-sm1 sm10>
                            <v-text-field
                                v-validate="'required'"
                                data-vv-name="name"
                                :error-messages="errors.collect('name')"
                                v-model="editedService.name"
                                label="Название"></v-text-field>
                        </v-flex>
                        <v-flex xs12 offset-sm1 sm10>
                            <v-text-field
                                v-validate="'required|decimal:2'"
                                data-vv-name="price"
                                :error-messages="errors.collect('price')"
                                v-model="editedService.price"
                                append-icon="attach_money"
                                label="Цена за гектар"></v-text-field>
                        </v-flex>
                        <v-flex xs12 offset-sm1 sm10>
                            <v-select
                                v-validate="`required|${includedNamesForPDFLayoutField}`"
                                data-vv-name="pdf_layout"
                                :error-messages="errors.collect('pdf_layout')"
                                v-model="editedService.pdf_layout"
                                :items="pdfLayoutNames"
                                label="Макет PDF"></v-select>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="editService">Сохранить</v-btn>
            </v-card-actions>
            <v-card-title>
                    <span class="headline">Превью макета {{ editedService.pdf_layout }}</span>
                </v-card-title>
                <v-card-text :class="{ 'service-preview': $vuetify.breakpoint.mdAndDown }">
                    <appPDF :gpsData="fakeGPSData" :services="[editedService]" oneServicePreview></appPDF>
                </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import pdfLayoutNames from './../../../constants/ServicesPreviewNames.js';
import PDF from './../../order/PDF/PDF';

export default {
    props: {
        editDialog: {
            type: Boolean,
            required: true
        },
        service: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            fakeGPSData: [
                {id:1,order_id:1,order:1,image:'/storage/transport_fake.png',mark:'Ms. Golda Mosciski',model:'',year_of_issue:'',fuel_type:'',power:'',number:'',gps_tracker:{id:13,image:'equipment_FAKE.png',name:'Model:493',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'Датчики уровня топлива','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'},fuel_gauge:[{id:13,image:'equipment_FAKE.png',name:'Model:500',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'GPS-трекеры','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'},{id:13,image:'/storage/equipment_FAKE.png',name:'Model:500',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'Датчики уровня топлива','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'}],counter:'',rf_id:'',reader_of_trailed_equipment:'',can_reader:'',deaerator:'',additional_equipment:[],cn03:[],rs01:[],created_at:'2018-09-28 15:29:18',updated_at:'2018-09-28 15:29:18'}
            ],
            pending: false,
            editedService: {},
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
            ]
        };
    },
    computed: {
        includedNamesForPDFLayoutField() {

            return `included:${this.pdfLayoutNames.join(',')}`;
        }
    },
    watch: {
        service(newVal) {
            this.editedService = { ...newVal };
        }
    },
    methods: {
        editService() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation:error');
                        return;
                    }
                    this.pending = true;
                    const payload = {
                        id: this.service.id,
                        isService: true,
                        service: {
                            name: this.editedService.name,
                            price: this.editedService.price,
                            pdf_layout: this.editedService.pdf_layout,
                            type: 'Услуга'
                        },
                        log: {
                            before: JSON.stringify(this.service),
                            after: JSON.stringify(this.editedService)
                        }
                    };
                    this.$store.dispatch('editEquipment', payload)
                        .then((data) => {
                            this.$emit('editDialogClosed', 'editDialog');
                            this.$emit('service-updated');
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
            this.$emit('editDialogClosed', 'editDialog');
        }
    },
    components: {
        appPDF: PDF
    }
}
</script>
