<template>
    <v-layout class="page" id="page-23" column>
        <v-flex d-flex class="contacts-title" align-end>
            <p>Зв’яжіться з нами</p>
        </v-flex>
        <v-flex d-flex style="flex-grow: 2; margin-left: 50px;">
            <v-flex xs7>
                <ul class="contact-list">
                    <li v-for="(item, index) in leftData" :key="`left-${index}`" class="contact-list-item">
                        <div class="icon">
                            <img v-if="item.icon" :src="item.icon" alt="icon">
                        </div>
                        <div class="text">
                            <div class="contact-list-item-title">
                                {{ item.title }}
                            </div>
                            <div class="contact-list-item-text">
                                {{ item.text }}
                            </div>
                        </div>
                    </li>
                </ul>
            </v-flex>
            <v-flex xs5>
                <ul class="contact-list" style="margin-left: 100px;">
                    <li v-for="(item, index) in rightData" :key="`right-${index}`" class="contact-list-item">
                        <div class="icon">
                            <img v-if="item.icon" :src="item.icon" alt="icon">
                        </div>
                        <div class="text">
                            <div class="contact-list-item-text" v-html="item.text">
                            </div>
                        </div>
                    </li>
                </ul>
            </v-flex>
        </v-flex>
    </v-layout>
</template>

<script>
export default {
    data() {
        return {
            leftData: [
                { icon: '/storage/image99.png', title: 'Київ', text: 'вул. Васильківська 14, офіс 313А' },
                { title: 'Кропивницький', text: 'вул. Віктора Чмиленка 80/40, офіс 415' },
                { title: 'Черкаси', text: 'Черкаська обл. м. Золотоноша, вул. Черкаська 85' },
                { title: 'Дніпро', text: 'вул. Проспект Героїв 1к' }
            ],
            rightData: [
                { icon: '/storage/image101.png', text: '+38 044 232 41 47<br>+38 035 245 41 47<br>+38 067 322 68 82' },
                { icon: '/storage/image100.png', text: 'inform@sasagro.com' },
            ]
        };
    }
}
</script>

<style scoped>
    #page-23 {
        background-image: url('/storage/image5__.jpg');
        background-size: cover;
        background-position-y: 71%;
    }

    #page-23 .contacts-title {
        flex-grow: 2;
        font-family: ProximaNovaBold;
        font-size: 60px;
        color: #fff;
    }

    #page-23 .contacts-title p {
        text-align: center;
        margin-bottom: 10px;
    }

    #page-23 .contact-list {
        list-style: none;
        margin: 0;
        padding: 0;
        height: 100%;
    }

    #page-23 .contact-list .contact-list-item {
        margin-bottom: 40px;
        display: flex;
    }

    #page-23 .contact-list .contact-list-item .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42.23px;
    }

    #page-23 .contact-list .contact-list-item .icon img {
        max-width: 100%;
    }

    #page-23 .contact-list .contact-list-item .text {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        width: 90%;
        margin-left: 20px;
        line-height: 1.1;
    }

    #page-23 .contact-list .contact-list-item .contact-list-item-title {
        width: 100%;
        font-family: ProximaNovaBold;
        font-size: 25px;
        color: #fff;
    }

    #page-23 .contact-list .contact-list-item .contact-list-item-text {
        width: 100%;
        font-family: ProximaNova;
        font-size: 23px;
        color: #fff;
    }
</style>
