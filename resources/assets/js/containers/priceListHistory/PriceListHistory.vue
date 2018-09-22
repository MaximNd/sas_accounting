<template>
    <v-container fluid>
        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-title>
                        <v-spacer></v-spacer>
                        <v-text-field
                            clearable
                            :value="search"
                            @input="checkSearch"
                            @change="getPriceListHistory"
                            append-icon="search"
                            label="Поиск"
                            single-line
                            hide-details>
                        </v-text-field>
                    </v-card-title>
                    <v-data-table
                        :headers="headers"
                        :items="priceListHistory"
                        :rows-per-page-items="rowsPerPageItems"
                        :pagination.sync="pagination"
                        :total-items="totalPriceListHistoryItems"
                        :loading="loading"
                        class="elevation-1"
                        expand>
                        <template slot="items" slot-scope="props">
                            <tr @click="expand(props.item, props)">
                                <td>{{ props.item.created_at }}</td>
                                <td>{{ props.item.equipment.name }}</td>
                                <td>{{ props.item.user.full_name }}</td>
                                <td
                                    :class="{
                                        'success--text': props.item.type === 'Создание',
                                        'info--text': props.item.type === 'Обновление',
                                        'purple--text': props.item.type === 'Восстановление',
                                        'error--text': props.item.type === 'Удаление'
                                    }">
                                    {{ props.item.type }}
                                </td>
                                <td class="text-xs-right">
                                    <v-btn icon v-if="props.expanded"><v-icon>expand_less</v-icon></v-btn>
                                    <v-btn icon v-else><v-icon>expand_more</v-icon></v-btn>
                                </td>
                            </tr>
                        </template>
                        <template slot="expand" slot-scope="props">
                            <v-card flat>
                                <v-card-text>
                                    <v-container fluid grid-list-xs v-if="props.item.type === 'Обновление'">
                                        <v-layout wrap>
                                            <v-flex xs12 sm6>
                                                <v-card>
                                                    <v-card-title><h4>До:</h4></v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-list dense>
                                                        <v-list-tile v-for="(beforeData, index) in updatedData[props.index].before" :key="`key-${index}`">
                                                            <v-list-tile-content :class="{ 'red--text darken-4--text': beforeData.isChanged }" >{{ beforeData.text }}:</v-list-tile-content>
                                                            <v-list-tile-content v-if="beforeData.text === 'Изображение'" :class="{ 'align-end': true, 'red--text darken-4--text': beforeData.isChanged }">
                                                                <img :style="{width: '60px'}" :src="`/storage/${beforeData.value}`" alt="image">
                                                            </v-list-tile-content>
                                                            <v-list-tile-content v-else :class="{ 'align-end': true, 'red--text darken-4--text': beforeData.isChanged }">{{ beforeData.value }}</v-list-tile-content>
                                                        </v-list-tile>
                                                    </v-list>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs12 sm6>
                                                <v-card>
                                                    <v-card-title><h4>После:</h4></v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-list dense>
                                                        <v-list-tile v-for="(afterData, index) in updatedData[props.index].after" :key="`key-${index}`">
                                                            <v-list-tile-content :class="{ 'success--text': afterData.isChanged }" >{{ afterData.text }}:</v-list-tile-content>
                                                            <v-list-tile-content v-if="afterData.text === 'Изображение'" :class="{ 'align-end': true, 'success--text': afterData.isChanged }">
                                                                <img :style="{width: '60px'}" :src="`/storage/${afterData.value}`" alt="image">
                                                            </v-list-tile-content>
                                                            <v-list-tile-content v-else :class="{ 'align-end': true, 'success--text': afterData.isChanged }">{{ afterData.value }}</v-list-tile-content>
                                                        </v-list-tile>
                                                    </v-list>
                                                </v-card>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    <v-container fluid v-if="props.item.type === 'Создание'">
                                        <v-layout wrap>
                                            <v-flex xs12>
                                                <v-data-table
                                                    :headers="createdData[props.index].headers"
                                                    :items="createdData[props.index].items"
                                                    hide-actions
                                                    class="elevation-1">
                                                    <template slot="items" slot-scope="nestedProps">
                                                        <td v-if="createdData[props.index].items[0].type !== 'Услуга'">
                                                            <img :style="{width: '60px'}" :src="`/storage/${nestedProps.item.image}`" alt="image">
                                                        </td>
                                                        <td>{{ nestedProps.item.name }}</td>
                                                        <td v-if="createdData[props.index].items[0].type !== 'Услуга'" class="text-xs-right">{{ nestedProps.item.type }}</td>
                                                        <td v-if="createdData[props.index].items[0].type !== 'Услуга'" class="text-xs-right">{{ nestedProps.item.incoming_price }}</td>
                                                        <td class="text-xs-right">{{ nestedProps.item.price }}</td>
                                                        <td v-if="createdData[props.index].items[0].type !== 'Услуга'" class="text-xs-right">{{ nestedProps.item.installation_price_for_one }}</td>
                                                        <td v-if="createdData[props.index].items[0].type !== 'Услуга'" class="text-xs-right">{{ nestedProps.item.installation_price_for_two }}</td>
                                                        <td v-if="createdData[props.index].items[0].type !== 'Услуга'" class="text-xs-right">{{ nestedProps.item.installation_price_for_three }}</td>
                                                        <td v-if="createdData[props.index].items[0].type !== 'Услуга'" class="text-xs-right">{{ nestedProps.item.description }}</td>
                                                        <td v-if="createdData[props.index].items[0].type === 'Услуга'" class="text-xs-right">{{ nestedProps.item.created_at }}</td>
                                                    </template>
                                                </v-data-table>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                    <v-container fluid v-if="$auth.check('admin') && props.item.type === 'Удаление'">
                                        <v-layout wrap v-if="props.item.equipment.deleted_at">
                                            <v-flex xs12 sm6 md4 lg3>
                                                <p class="title" style="margin: 0; line-height: 2.2!important;">
                                                    Нажмите чтобы восстановить:
                                                </p>
                                            </v-flex>
                                            <v-flex xs12 sm3>
                                                <v-btn :loading="restoring" :disabled="restoring" @click="restore(props.item.equipment.id)" class="white--text" color="purple">Восстановить</v-btn>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout v-else>
                                            <v-flex xs12>
                                                <p class="red--text text--darken-4 title" style="margin: 0; line-height: 2.2!important;">
                                                    На данный момент восстановление невозможно, так как оборудование/услуга восстановлена!
                                                </p>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                            </v-card>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            createdDataHeaders: {
                equipment: [
                    { text: 'Изображение', align: 'left', value: 'image', sortable: false },
                    { text: 'Модель', align: 'left', value: 'name', sortable: false },
                    { text: 'Категория', align: 'right', value: 'type', sortable: false },
                    { text: 'Входящая цена $', align: 'right', value: 'incoming_price', sortable: false },
                    { text: 'Цена $', align: 'right', value: 'price', sortable: false },
                    { text: 'Монтаж 1шт. ₴', align: 'right', value: 'installation_price_for_one', sortable: false },
                    { text: 'Монтаж 2шт. ₴', align: 'right', value: 'installation_price_for_two', sortable: false },
                    { text: 'Монтаж 3шт. ₴', align: 'right', value: 'installation_price_for_three', sortable: false },
                    { text: 'Описание', align: 'right', value: 'description', sortable: false }
                ],
                service: [
                    { text: 'Название', align: 'left', value: 'name', sortable: false },
                    { text: 'Цена $', align: 'right', value: 'price', sortable: false },
                    { text: 'Дата создания', align: 'right', value: 'created_at', sortable: false }
                ]
            },
            permissibleKeysMap: {
                equipment: {
                    image: 'Изображение',
                    name: 'Модель',
                    incoming_price: 'Входящая Цена',
                    price: 'Цена',
                    installation_price_for_one: 'Монтаж 1шт.',
                    installation_price_for_two: 'Монтаж 2шт.',
                    installation_price_for_three: 'Монтаж 3шт.',
                    type: 'Категория',
                    description: 'Описание'
                },
                service: {
                    name: 'Назване',
                    price: 'Цена'
                }
            },
            search: '',
            totalPriceListHistoryItems: 0,
            priceListHistory: [],
            rowsPerPageItems: [10, 15, 20, 25, 30, 50],
            loading: true,
            restoring: false,
            pagination: {
                rowsPerPage: 10,
                sortBy: 'created_at',
                descending: true
            },
            headers: [
                {
                    text: 'Дата',
                    align: 'left',
                    value: 'created_at'
                },
                { text: 'Оборудование/Услуга', value: 'equipment.name' },
                { text: 'Сотрудник', value: 'user.full_name' },
                { text: 'Действие', value: 'type' },
                { text: 'Подробно', value: '', align: 'right', sortable: false }
            ]
        };
    },
    computed: {
        createdData() {
            return this.priceListHistory.reduce((createdData, priceListHistoryData, index) => {
                if (priceListHistoryData.type === 'Создание') {
                    const isService = priceListHistoryData.equipment.type === 'Услуга';
                    const key = isService ? 'service' : 'equipment';
                    createdData[index] = {
                        headers: this.createdDataHeaders[key],
                        items: [JSON.parse(priceListHistoryData.after)]
                    };
                }
                return createdData;
            }, {});
        },
        updatedData() {
            return this.priceListHistory.reduce((updatedData, priceListHistoryData, index) => {
                if (priceListHistoryData.type === 'Обновление') {
                    const isService = priceListHistoryData.equipment.type === 'Услуга';
                    const keyForPermissibleKeys = isService ? 'service' : 'equipment';
                    const permissibleKeys = Object.keys(this.permissibleKeysMap[keyForPermissibleKeys]);
                    updatedData[index] = { before: [], after: [] };
                    const before = JSON.parse(priceListHistoryData.before);
                    const after = JSON.parse(priceListHistoryData.after);
                    updatedData[index].before = Object.keys(before).reduce((beforeData, key) => {
                        if (permissibleKeys.includes(key)) {
                            beforeData.push({ text: this.permissibleKeysMap[keyForPermissibleKeys][key], value: before[key], isChanged: before[key] !== after[key] });
                        }
                        return beforeData;
                    }, []);
                    updatedData[index].after = Object.keys(after).reduce((afterData, key) => {
                        if (permissibleKeys.includes(key)) {
                            afterData.push({ text: this.permissibleKeysMap[keyForPermissibleKeys][key], value: after[key], isChanged: before[key] !== after[key] });
                        }
                        return afterData;
                    }, []);
                }
                return updatedData;
            }, {});
        }
    },
    watch: {
        pagination: {
            handler: 'getPriceListHistory',
            deep: true
        }
    },
    methods: {
        getPriceListHistory() {
            this.loading = true;
            const { sortBy, descending, page, rowsPerPage } = this.pagination;
            const params = {};
            params.page = page;
            params.per_page = rowsPerPage
            if (this.search !== '') {
                params.query = this.search;
            }
            if (sortBy) {
                const direction = descending ? 'desc' : 'asc';
                params.direction = direction;
                params.sortBy = sortBy;
            }

            this.axios.get('/price-list/logs', { params })
                .then(({data}) => {
                    this.totalPriceListHistoryItems = data.total;
                    this.priceListHistory = data.data;//.map(data => ({ ...data, before: JSON.parse(data.before), after: JSON.parse(data.after) }));
                    this.loading = false;
                    this.restoring = false;
                })
                .catch(err => {
                    console.log(err);
                    this.loading = false;
                    this.restoring = false;
                });
        },
        checkSearch(value) {
            this.search = value;
            setTimeout(() => {
                if (this.search === value) {
                    this.getPriceListHistory();
                }
            }, 1500);
        },
        expand(item, props) {
            if (item.type !== 'Восстановление') {
                props.expanded = !props.expanded;
            }
        },
        restore(id) {
            this.restoring = true;
            this.axios.put(`/price-list/${id}/restore`)
                .then(() => this.getPriceListHistory())
                .catch(err => console.log(err));
        }
    }
}
</script>

<style scoped>
    a {
        text-decoration: none;
    }
</style>
