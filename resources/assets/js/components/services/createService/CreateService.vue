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
                            <v-select
                                v-validate="`required|${includedNamesForPDFLayoutField}`"
                                data-vv-name="pdf_layout"
                                :error-messages="errors.collect('pdf_layout')"
                                v-model="newService.pdf_layout"
                                :items="pdfLayoutNames"
                                label="Макет PDF"></v-select>
                        </v-flex>
                        <template v-if="isSeriveSelected && is1CSelected">
                            <v-btn @click="addPriceForRange" color="success">Добавить</v-btn>
                            <v-flex xs12 offset-sm1 sm10 v-for="(priceForRange, index) in newService.prices_for_ranges" :key="`price-for-range-${index}`">
                                <v-container grid-list-lg>
                                    <v-layout>
                                        <v-flex xs12 sm4>
                                            <v-text-field
                                                :readonly="index === 0"
                                                v-validate="'required|decimal:2'"
                                                :data-vv-name="`ranged_from_${index}`"
                                                :error-messages="errors.collect(`ranged_from_${index}`)"
                                                @input="replaceComma($event, newService.prices_for_ranges[index], 'from', `ranged_from_${index}`)"
                                                :value="newService.prices_for_ranges[index].from"
                                                label="Гектаров от:"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm4>
                                            <v-text-field
                                                v-if="index + 1 === newService.prices_for_ranges.length"
                                                readonly
                                                v-model="newService.prices_for_ranges[index].to"
                                                label="Гектаров до:"></v-text-field>
                                            <v-text-field
                                                v-else
                                                v-validate="'required|decimal:2'"
                                                :data-vv-name="`ranged_to_${index}`"
                                                :error-messages="errors.collect(`ranged_to_${index}`)"
                                                @input="replaceComma($event, newService.prices_for_ranges[index], 'to', `ranged_to_${index}`)"
                                                :value="newService.prices_for_ranges[index].to"
                                                label="Гектаров до:"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm3>
                                            <v-text-field
                                                v-validate="'required|decimal:2'"
                                                :data-vv-name="`ranged_price_${index}`"
                                                :error-messages="errors.collect(`ranged_price_${index}`)"
                                                @input="replaceComma($event, newService.prices_for_ranges[index], 'price', `ranged_price_${index}`)"
                                                :value="newService.prices_for_ranges[index].price"
                                                append-icon="attach_money"
                                                label="Цена:"></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 sm1>
                                            <v-layout class="mt-0" fill-height justify-end align-center>
                                                <v-btn
                                                    v-if="$vuetify.breakpoint.xsOnly"
                                                    color="error"
                                                    block
                                                    @click="deletePriceForRange(index)">
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                                <v-btn
                                                    v-else
                                                    class="mt-1"
                                                    color="error"
                                                    flat
                                                    icon
                                                    @click="deletePriceForRange(index)">
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-flex>
                        </template>
                        <v-flex xs12 offset-sm1 sm10 v-else-if="isSeriveSelected && !isEngProjectSelected">
                            <v-text-field
                                v-validate="'required|decimal:2'"
                                data-vv-name="price"
                                :error-messages="errors.collect('price')"
                                @input="replaceComma($event, newService, 'price')"
                                :value="newService.price"
                                append-icon="attach_money"
                                label="Цена за гектар"></v-text-field>
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
                    <appPDF
                        :gpsData="fakeGPSData"
                        :services="[newService]"
                        :transportPrice="fakeTransportPrice"
                        :priceForDays="fakePriceForDays"
                        :installationPrice="fakeInstallationPrice"
                        :equipmentPrice="fakeEquipmentPrice"
                        :gruppedEquipment="fakeGruppedEquipment"
                        oneServicePreview></appPDF>
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
import forms from './../../../mixins/forms.js';
import pdfLayoutNames from './../../../constants/ServicesPreviewNames.js';
import PDF from './../../order/PDF/PDF';

export default {
    mixins: [forms],
    props: {
        createDialog: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            initialPriceForRange: {
                from: 0,
                to: '∞',
                price: 0
            },
            fakeGPSData: [
                {id:1,order_id:1,order:1,image:'/storage/transport_fake.png',mark:'Ms. Golda Mosciski',model:'',year_of_issue:'',fuel_type:'',power:'',number:'',gps_tracker:{id:13,image:'equipment_FAKE.png',name:'Model:493',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'Датчики уровня топлива','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'},fuel_gauge:[{id:13,image:'equipment_FAKE.png',name:'Model:500',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'GPS-трекеры','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'},{id:13,image:'/storage/equipment_FAKE.png',name:'Model:500',incoming_price:402.82,price:289.78,installation_price_for_one:742.6,installation_price_for_two:592.6,installation_price_for_three:542.6,type:'Датчики уровня топлива','pdf_layout':null,description:'Ut esse architecto vero nostrum sunt.',deleted_at:null,created_at:'2018-09-28 15:05:33',updated_at:'2018-09-28 15:05:33'}],counter:'',rf_id:'',reader_of_trailed_equipment:'',can_reader:'',deaerator:'',additional_equipment:[],cn03:[],rs01:[],created_at:'2018-09-28 15:29:18',updated_at:'2018-09-28 15:29:18'}
            ],
            fakeTransportPrice: 19435,
            fakePriceForDays: 20000,
            fakeInstallationPrice: 200123,
            fakeEquipmentPrice: 10000,
            fakeGruppedEquipment: [{type:'Gps-1',price:6000,count:3},{type:'GPS-2',price:300,count:1}],
            pending: false,
            pdfLayoutNames: [
                pdfLayoutNames.CONNEC_TO_PLATFORM,
                pdfLayoutNames.FIELD_MAPPING_BY_DRONES,
                pdfLayoutNames.FIELD_MAPPING_BY_PHYSICAL_MEASUREMENT,
                pdfLayoutNames.LAND_BANK_ACCOUNTING,
                pdfLayoutNames.ENGINEER_PROJECT,
                pdfLayoutNames.ENGINEER_SUPPORT,
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
                prices_for_ranges: [],
                type: 'Услуга'
            }
        };
    },
    watch: {
        'newService.pdf_layout'() {
            this.newService.price = '';
            this.newService.prices_for_ranges = [];
        }
    },
    computed: {
        includedNamesForPDFLayoutField() {
            return `included:${this.pdfLayoutNames.join(',')}`;
        },
        isSeriveSelected() {
            return !!this.newService.pdf_layout;
        },
        is1CSelected() {
            return this.newService.pdf_layout === pdfLayoutNames.INTEGRATION_1C;
        },
        isEngProjectSelected() {
            return this.newService.pdf_layout === pdfLayoutNames.ENGINEER_PROJECT;
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
                    this.newService.name = this.newService.pdf_layout;
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
        addPriceForRange() {
            const infinity = this.initialPriceForRange.to;
            this.newService.prices_for_ranges.forEach((prices, index) => {
                if (prices.to === infinity) {
                    prices.to = 0;
                }
            });
            this.newService.prices_for_ranges.push({ ...this.initialPriceForRange });

        },
        deletePriceForRange(index) {
            const infinity = this.initialPriceForRange.to;
            this.newService.prices_for_ranges.splice(index, 1);
            this.newService.prices_for_ranges[this.newService.prices_for_ranges.length - 1].to = infinity;
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
