<template>
    <v-layout class="page bg-monitoring" column>
        <v-flex>
            <div class="title-monitoring">
                Цілодобовий моніторинг
            </div>
        </v-flex>
        <v-flex style="flex-grow:1;">
            <v-layout justify-center>
                <v-flex xs10>
                    <ul class="monitoring-data-list">
                        <li v-for="(item, index) in items" :key="`data-${index}`">
                            <div class="icon"><img :src="item.icon" alt="icon"></div>
                            <div class="text">
                                <p v-html="item.html" :style="{ 'font-family': 'ProximaNovaBold', 'font-size': '22px' }"></p>
                            </div>
                        </li>
                    </ul>
                </v-flex>
            </v-layout>
        </v-flex>
        <div class="bottom-logo-monitoring">
            <img src="/storage/image4.png" alt="">
        </div>
    </v-layout>
</template>

<script>
export default {
    data() {
        return {
            items: [
                { icon: '/storage/image109.png', html: 'Постійний моніторинг <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">статусу та місця знаходження техніки</span> всього господарства через онлайн-карту' },
                { icon: '/storage/image107.png', html: 'Додавання, редагування <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">контурів полів</span> та відправлення в архів тих, які були повернуті орендодавцю' },
                { icon: '/storage/image111.png', html: 'Створення та редагування <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">техніки, обладнання, завдань</span> згідно зібраної інформації' },
                { icon: '/storage/image112.png', html: 'Створення та закриття <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">агрооперацій в полі</span>' },
                { icon: '/storage/image110.png', html: 'Слідкування <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">за простоями техніки,</span> перевищенням швидкості, з\'їздомз заданих маршрутів' },
                { icon: '/storage/image113.png', html: 'Виявлення техніки з відсутністю сигналу та <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">створення тривог</span> на техніку' },
                { icon: '/storage/image108.png', html: 'Аналіз <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">супутникових знімків,</span>1 виявлення проблемних ділянокта інформування клієнта.' },
                { icon: '/storage/image106.png', html: 'Формування <span style="font-family: ProximaNovaBold; color: rgb(25, 183, 144); font-size: 22px">оперативної звітності</span> та відправлення відповідальним особам' },
            ]
        }
    }
}
</script>

<style scoped>
    .bg-monitoring {
        background-color: #fff;
    }

    .bg-monitoring .title-monitoring {
        font-family: ProximaNovaBlack;
        font-size: 40px;
        text-align: center;
        color: #4D4D4D;
        margin-top: 25px;
    }

    .bg-monitoring .monitoring-data-list {
        padding: 0;
        margin: 0;
        margin-left: 50px;
        list-style: none;
    }

    .bg-monitoring .monitoring-data-list li {
        display: flex;
        margin-bottom: 26px;
    }

    .bg-monitoring .monitoring-data-list .icon {
        display: flex;
        align-items: center;
        padding-left: 5px;
        padding-right: 5px;
        width: 7%;
    }

    .bg-monitoring .monitoring-data-list .icon img {
        max-width: 100%;
    }

    .bg-monitoring .monitoring-data-list .text {
        padding-left: 30px;
        padding-right: 5px;
        color: #000;
        display: flex;
        align-items: center;
        width: 93%;
    }

    .bg-monitoring .monitoring-data-list .text p {
        font-size: 22px;
        margin: 0;
        padding: 0;
    }

    .bg-monitoring .bottom-logo-monitoring {
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        flex-grow: 1;
    }

    .bg-monitoring .bottom-logo-monitoring img {
        margin-right: 10px;
        margin-bottom: 10px;
        width: 200px;
    }
</style>
