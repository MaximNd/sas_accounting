<template>
    <v-container v-if="gpsData" fluid id="pdf">
        <v-layout class="page" id="page-1" wrap>
            <v-flex xs12 class="main-logo-container">
                <img class="main-logo-img" src="/storage/image0.png" alt="">
            </v-flex>
            <v-flex xs12>
                <p class="text-group">GROUP</p>
                <p class="text-year font-weight-light">Since 1998</p>
            </v-flex>
            <v-flex xs12>
                <v-layout justify-space-around align-center>
                    <v-flex xs3>
                        <img class="bottom-imgs" src="/storage/image8.png" alt="">
                    </v-flex>
                    <v-flex xs5>
                        <img class="bottom-imgs agrosphera-img" src="/storage/image7.png" alt="">
                    </v-flex>
                    <v-flex xs2>
                        <div class="last-bottom-img-wrapper">
                            <img class="dnipro-img bottom-imgs" src="/storage/image9.png" alt="">
                            <span class="text-dnipro font-weight-medium">Dnipro</span>
                        </div>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <div class="html2pdf__page-break"></div>
        <v-layout class="page" id="page-2" wrap>
            <div class="logo">
                <img src="/storage/image8.png" alt="logo">
            </div>
            <div class="text">
                Рішення для ефективного агроменеджменту
            </div>
        </v-layout>
        <div class="html2pdf__page-break"></div>
        <appConnectionToPlatformTitle />
        <div class="html2pdf__page-break"></div>
        <appConnectionToPlatformProgramPart />
        <div class="html2pdf__page-break"></div>
        <appFieldsMapping byDrones />
        <div class="html2pdf__page-break"></div>
        <appFieldsMapping :byDrones="false" />
        <div class="html2pdf__page-break"></div>
        <appLandBankRegistrationTitle />
        <div class="html2pdf__page-break"></div>
        <appLandBankRegistrationList />
        <div class="html2pdf__page-break"></div>
        <appGPSTrackingTitle />
        <div class="html2pdf__page-break"></div>
        <template v-for="(gpsData, index) in gpsTrackingData">
            <appGPSTrackingData
            :key="`gps-data-${index}`"
            :equipment="gpsData.equipment"
            :transportImage="gpsData.transportImage" />
            <div class="html2pdf__page-break" :key="`gps-data-page-break-${index}`"></div>
        </template>
        <appPatrol />
        <div class="html2pdf__page-break"></div>
        <appNDVI />
        <div class="html2pdf__page-break"></div>
        <appCountingSeedlings />
        <div class="html2pdf__page-break"></div>
        <appAeroVisualReviewTitle />
        <div class="html2pdf__page-break"></div>
        <appAeroVisualReviewData page="first" />
        <div class="html2pdf__page-break"></div>
        <appAeroVisualReviewData page="second" />
        <div class="html2pdf__page-break"></div>
        <appSASMapper />
        <div class="html2pdf__page-break"></div>
        <appChemicalAnalisisOfSoils />
        <div class="html2pdf__page-break"></div>
        <appSoilHardnessMeasuring />
        <div class="html2pdf__page-break"></div>
        <appIntegration1C />
        <div class="html2pdf__page-break"></div>
        <appPrices1C />
        <div class="html2pdf__page-break"></div>
        <appOptionalServices />
        <div class="html2pdf__page-break"></div>
        <appContacts />
        <div class="html2pdf__page-break"></div>
    </v-container>
</template>

<script>
import utils from './../../../mixins/utils.js';
import ConnectionToPlatformTitle from './connectionToPlatform/ConnectionToPlatformTitle';
import ConnectionToPlatformProgramPart from './connectionToPlatform/ConnectionToPlatformProgramPart';

import FieldsMapping from './fieldsMapping/FeildsMapping';

import LandBankRegistrationTitle from './landBankRegistration/LandBankRegistrationTitle';
import LandBankRegistrationList from './landBankRegistration/LandBankRegistrationList';

import GPSTrackingTitle from './GPSTracking/GPSTrackingTitle';
import GPSTrackingData from './GPSTracking/GPSTrackingData';

import Patrol from './patrol/Patrol';

import NDVI from './NDVI/NDVI';

import CountingSeedlings from './countingSeedlings/CountingSeedlings';

import AeroVisualReviewTitle from './aeroVisualReview/AeroVisualReviewTitle';
import AeroVisualReviewData from './aeroVisualReview/AeroVisualReviewData';

import SASMapper from './SASMapper/SASMapper';

import ChemicalAnalisisOfSoils from './chemicalAnalysisOfSoils/ChemicalAnalysisOfSoils';

import SoilHardnessMeasuring from './soilHardnessMeasuring/SoilHardnessMeasuring';

import Integration1C from './1CIntegration/1CIntegration';
import Prices1C from './1CIntegration/1CPrices';

import OptionalServices from './optionalServices/OptionalServices';

import Contacts from './contacts/Contacts';

export default {
    mixins: [utils],
    props: {
        gpsData: {
            type: Array,
            required: false,
            default: []
        }
    },
    data() {
        return {
            mappedColumnNames: {
                gps_tracker: 'GPS трекер',
                fuel_gauge: 'ДУТ',
                counter: 'Лічильник',
                rf_id: 'RFID водія',
                reader_of_trailed_equipment: 'Зчитувач причіпного',
                can_reader: 'CAN reader',
                deaerator: 'ДРТ',
                cn03: 'Модуль CN03',
                rs01: 'Модуль RS01',
                additional_equipment: ''
            },
            gd: [
                {
                    equipment: [
                        { image: '/storage/image37.png', name: 'GPS трекер Connect', price: 103 },
                        { image: '/storage/image38.jpg', name: 'RFID водія', price: 53 },
                        { image: '/storage/image39.jpg', name: 'Зчитувач причіпного BL01', price: 56 },
                        { image: '/storage/image40.png', name: 'ДУТ 2шт BI FL Sensor 100', price: 218 },
                        { image: '/storage/image42.jpg', name: 'ДРТ DFM 250D CAN', price: 453 },
                        { image: '/storage/image36.jpg', name: 'CAN reader', price: 36 },
                        { image: '/storage/image43.jpg', name: 'Модуль CN03', price: 56 },
                        { image: '/storage/image44.jpg', name: 'Високоточна антена', price: 750 },
                        { image: '/storage/image44.jpg', name: 'Високоточна антена', price: 750 }
                    ],
                    transportImage: '/storage/image41.png'
                }
            ]
        };
    },
    computed: {
        gpsTrackingData() {
            return this.gpsData.map(gpsRow => {
                return {
                    equipment: Object.keys(gpsRow).reduce((equipment, key) => {
                        if (Object.keys(this.mappedColumnNames).indexOf(key) !== -1) {
                            if (Array.isArray(gpsRow[key])) {
                                let count = 0;
                                let gpsRowArray = gpsRow[key].slice().filter(row => this.isObject(row));
                                if (gpsRowArray.length === 0) return equipment;
                                const equipmentData = {
                                    image: ``,
                                    name: ``,
                                    price: 0
                                };
                                for (let i = 0; i < gpsRowArray.length; ++i) {
                                    for (let j = 0; j < gpsRowArray.length; ++j) {
                                        if (gpsRowArray[i].id === gpsRowArray[j].id) {
                                            ++count;
                                        }
                                    }
                                    equipmentData.image = `/storage/${gpsRowArray[i].image}`;
                                    equipmentData.name = `${this.mappedColumnNames[key]} ${count}шт ${gpsRowArray[i].name}`;
                                    equipmentData.price = this.multiplyTwoFloats(gpsRowArray[i].price, count);
                                    gpsRowArray = gpsRowArray.filter(row => row.id !== gpsRowArray[i].id);
                                }

                                equipment.push(equipmentData);
                            } else if (this.isObject(gpsRow[key])) {
                                equipment.push({
                                    image: `/storage/${gpsRow[key].image}`,
                                    name: `${this.mappedColumnNames[key]} ${gpsRow[key].name}`,
                                    price: gpsRow[key].price
                                });
                            }
                        }
                        return equipment;
                    }, []),
                    transportImage: gpsRow.image
                };
            });
        }
    },
    components: {
        appConnectionToPlatformTitle: ConnectionToPlatformTitle,
        appConnectionToPlatformProgramPart: ConnectionToPlatformProgramPart,
        appFieldsMapping: FieldsMapping,
        appLandBankRegistrationTitle: LandBankRegistrationTitle,
        appLandBankRegistrationList: LandBankRegistrationList,
        appGPSTrackingTitle: GPSTrackingTitle,
        appGPSTrackingData: GPSTrackingData,
        appPatrol: Patrol,
        appNDVI: NDVI,
        appCountingSeedlings: CountingSeedlings,
        appAeroVisualReviewTitle: AeroVisualReviewTitle,
        appAeroVisualReviewData: AeroVisualReviewData,
        appSASMapper: SASMapper,
        appChemicalAnalisisOfSoils: ChemicalAnalisisOfSoils,
        appSoilHardnessMeasuring: SoilHardnessMeasuring,
        appIntegration1C: Integration1C,
        appPrices1C: Prices1C,
        appOptionalServices: OptionalServices,
        appContacts: Contacts
    }
}
</script>

<style>
    @font-face {
        font-family: ProximaNova;
        src: url('/storage/fonts/Proxima Nova/Proxima Nova Regular.otf');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: ProximaNovaBold;
        src: url('/storage/fonts/Proxima Nova/Proxima Nova Bold.otf');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: ProximaNovaBlack;
        src: url('/storage/fonts/Proxima Nova/Proxima Nova Black.otf');
        font-weight: normal;
        font-style: normal;
    }


    #pdf {
        font-family: ProximaNova;
        padding: 0;
        width: 1137.5px;
        height: 100%;
    }

    .page {
        position: relative;
        width: 1137.5px;
        height: 807.9px;
    }

    /* ---------------------------------------------------------------- */

    #page-2 {
        background-image: url('/storage/image11.png');
        background-size: 124%;
        background-position-x: 100%;
    }

    #page-2 .logo {
        width: 100%;
    }

    #page-2 .logo img {
        display: block;
        width: 600px;
        margin: 0 auto;
        margin-top: 100px;
    }

    #page-2 .text {
        width: 600px;
        color: white;
        font-family: ProximaNovaBlack;
        line-height: 1.1;
        font-size: 64px;
        margin-left: 60px;
        margin-top: -75px;
    }

    /* ---------------------------------------------------------------- */

    #page-1 {
        background-color: #3a3a3a;
    }

    #page-1 .main-logo-container {
        width: 100%;
        padding-top: 200px;
    }

    #page-1 .main-logo-img {
        width: 400px;
        display: block;
        margin: 0 auto;
        margin-bottom: -85px;
    }

    #page-1 .text-group {
        font-family: ProximaNova;
        font-size: 76px !important;
        text-align: center;
        color: #fff;
        margin-bottom: 0;
        line-height: 1.5;
    }

    #page-1 .text-year {
        font-family: ProximaNova;
        font-size: 20px !important;
        text-align: center;
        color: #fff;
    }

    #page-1 .bottom-imgs {
        max-width: 100%;
    }

    #page-1 .last-bottom-img-wrapper {
        position: relative;
    }

    #page-1 .dnipro-img {
        margin-top: -32px;
    }

    #page-1 .text-dnipro {
        display: inline-block;
        font-family: ProximaNova;
        font-size: 30px;
        color: #fff;
        text-align: center;
        margin-left: 36px;
        margin-top: -30px;
    }

</style>
