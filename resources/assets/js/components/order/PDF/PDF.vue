<template>
    <v-container fluid id="pdf">
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
        <appConnectionToPlatformFieldsMapping byDrones />
        <div class="html2pdf__page-break"></div>
        <appConnectionToPlatformFieldsMapping :byDrones="false" />
        <div class="html2pdf__page-break"></div>
        <v-layout>
            END
        </v-layout>
    </v-container>
</template>

<script>
import ConnectionToPlatformTitle from './connectionToPlatform/ConnectionToPlatformTitle';
import ConnectionToPlatformProgramPart from './connectionToPlatform/ConnectionToPlatformProgramPart';
import ConnectionToPlatformFieldsMapping from './connectionToPlatform/ConnectionToPlatformFeildsMapping';

export default {
    components: {
        appConnectionToPlatformTitle: ConnectionToPlatformTitle,
        appConnectionToPlatformProgramPart: ConnectionToPlatformProgramPart,
        appConnectionToPlatformFieldsMapping: ConnectionToPlatformFieldsMapping
    }
}
</script>

<style>
    #pdf {
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
        font-family: Roboto;
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
        font-family: Roboto;
        font-size: 76px !important;
        text-align: center;
        color: #fff;
        margin-bottom: 0;
        line-height: 1.5;
    }

    #page-1 .text-year {
        font-family: Roboto;
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
        font-family: Roboto;
        font-size: 30px;
        color: #fff;
        text-align: center;
        margin-left: 36px;
        margin-top: -30px;
    }

</style>
