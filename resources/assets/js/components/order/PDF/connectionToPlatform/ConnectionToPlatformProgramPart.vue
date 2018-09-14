<template>
    <v-layout class="page" id="page-4">
        <appLeftImage image="/storage/image20__.jpg" />
        <v-flex xs8 class="right-data">
            <div class="main-list">
                <div class="main-list-title font-weight-bold">
                    Програмна частина
                </div>
                <ul class="list">
                    <li>
                        <div class="icon"><img src="/storage/image13.png" alt="icon"></div>
                        <div class="text">
                            <p>Внесення <span class="highlighted">електронної карти полів</span> <br> до системи Cropio</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon"><img src="/storage/image17.png" alt="icon"></div>
                        <div class="text">
                            <p>Підключення модулю <span class="highlighted">GPS-моніторингу</span></p>
                        </div>
                    </li>
                    <li>
                        <div class="icon"><img src="/storage/image14.png" alt="icon"></div>
                        <div class="text">
                            <p>Проведення <span class="highlighted">тренінгів для персоналу</span> <br> по користуванню Системою</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon"><img src="/storage/image15.png" alt="icon"></div>
                        <div class="text">
                            <p>Надання <span class="highlighted">космічних знімків</span> з низькою <br> та високою роздільною здатністю</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon"><img src="/storage/image18.png" alt="icon"></div>
                        <div class="text">
                            <p>Надання <span class="highlighted">аналітичної інформації</span> щодо вегетації, вологості <br> ґрунту, температури повітря та ґрунту, накопичених та щоденних опадів з 2002 року</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon"><img src="/storage/image19.png" alt="icon"></div>
                        <div class="text">
                            <p><span class="highlighted">Можливість</span> планування агроробіт, ведення історії поля та <br> управління використанням ТМЦ</p>
                        </div>
                    </li>
                    <li>
                        <div class="icon"><img src="/storage/image16.png" alt="icon"></div>
                        <div class="text">
                            <p><span class="highlighted">Прогнозування</span> врожайності</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="logo-bottom">
                <img src="/storage/image2.png" alt="logo">
            </div>
        </v-flex>
    </v-layout>
</template>

<script>
import LeftImage from './../leftImage/LeftImage';

export default {
    components: {
        appLeftImage: LeftImage
    }
}
</script>


<style scoped>
    #page-4 .right-data {
        height: 100%;
        background-color: #525252;
    }

    #page-4 .main-list .main-list-title {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        color: #fff;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 10px;
    }

    #page-4 .main-list .list {
        padding: 0;
        margin: 0;
        margin-left: 20px;
        list-style: none;
    }

    #page-4 .main-list .list li {
        display: flex;
        margin-bottom: 26px;
    }

    #page-4 .main-list .list .icon {
        display: flex;
        align-items: center;
        width: 9%;
        padding-left: 5px;
        padding-right: 5px;
    }

    #page-4 .main-list .list .icon img {
        max-width: 100%;
    }

    #page-4 .main-list .list .text {
        width: 91%;
        padding-left: 5px;
        padding-right: 5px;
        font-family: ProximaNova;
        font-size: 22px;
        color: #fff;
        display: flex;
        align-items: center;
    }

    #page-4 .main-list .list .text .highlighted {
        font-size: 24px;
        font-weight: 600;
    }

    #page-4 .main-list .list .text p {
        margin: 0;
        padding: 0;
    }

    #page-4 .logo-bottom {
        display: flex;
        margin-top: 65px;
        justify-content: flex-end;
        align-items: flex-end;
    }

    #page-4 .logo-bottom img {
        margin-right: 20px;
        height: 70px;
    }
</style>
