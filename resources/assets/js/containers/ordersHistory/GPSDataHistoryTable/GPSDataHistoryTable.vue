<template>
    <v-data-table
        :headers="gpsDataHeaders"
        :items="items"
        hide-actions
        disable-initial-sort
        class="gps-data-table elevation-1">
        <template slot="items" slot-scope="props">
            <td class="text-xs-center">
                <img style="max-width: 100%;" :src="props.item.image" alt="img">
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('mark') }">
                {{ props.item.mark }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('model') }">
                {{ props.item.model }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('year_of_issue') }">
                {{ props.item.year_of_issue }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('fuel_type') }">
                {{ props.item.fuel_type }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('power') }">
                {{ props.item.power }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('number') }">
                {{ props.item.number }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('gps_tracker') }">
                {{ props.item.gps_tracker.name }}
            </td>
            <td
                class="text-xs-center">
                <v-list v-if="props.item.fuel_gauge.some(el => !isUndefined(el) && !isNull(el))">
                    <template v-for="(item, textIndex) in props.item.fuel_gauge">
                        <v-list-tile
                            v-if="!isUndefined(item) && !isNull(item)"
                            :key="`fuel_gauge_text-${textIndex}`">
                            <v-list-tile-content>
                                <v-list-tile-title
                                    :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('fuel_gauge') }">
                                    {{ item.name }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        <v-divider
                            v-if="isShowDivider(textIndex, props.item.fuel_gauge)"
                            :key="`fuel_gauge_divider-${textIndex}`"
                        ></v-divider>
                    </template>
                </v-list>
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('counter') }">
                {{ props.item.counter.name }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('rf_id') }">
                {{ props.item.rf_id.name }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('reader_of_trailed_equipment') }">
                {{ props.item.reader_of_trailed_equipment.name }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('can_reader') }">
                {{ props.item.can_reader.name }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('deaerator_small') }">
                {{ props.item.deaerator_small.name }}
            </td>
            <td
                class="text-xs-center"
                :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('deaerator_large') }">
                {{ props.item.deaerator_large.name }}
            </td>
            <td
                class="text-xs-center">
                <v-list v-if="props.item.cn03.some(el => !isUndefined(el) && !isNull(el))">
                    <template v-for="(item, textIndex) in props.item.cn03">
                        <v-list-tile
                            v-if="!isUndefined(item) && !isNull(item)"
                            :key="`cn03_text-${textIndex}`">
                            <v-list-tile-content>
                                <v-list-tile-title
                                    :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('cn03') }">
                                    {{ item.name }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        <v-divider
                            v-if="isShowDivider(textIndex, props.item.cn03)"
                            :key="`cn03_divider-${textIndex}`"
                        ></v-divider>
                    </template>
                </v-list>
            </td>
            <td
                class="text-xs-center">
                <v-list v-if="props.item.rs01.some(el => !isUndefined(el) && !isNull(el))">
                    <template v-for="(item, textIndex) in props.item.rs01">
                        <v-list-tile
                            v-if="!isUndefined(item) && !isNull(item)"
                            :key="`rs01_text-${textIndex}`">
                            <v-list-tile-content>
                                <v-list-tile-title
                                    :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('rs01') }">
                                    {{ item.name }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        <v-divider
                            v-if="isShowDivider(textIndex, props.item.rs01)"
                            :key="`rs01_divider-${textIndex}`"
                        ></v-divider>
                    </template>
                </v-list>
            </td>
            <td
                class="text-xs-center">
                <v-list v-if="props.item.additional_equipment.some(el => !isUndefined(el) && !isNull(el))">
                    <template v-for="(item, textIndex) in props.item.additional_equipment">
                        <v-list-tile
                            v-if="!isUndefined(item) && !isNull(item)"
                            :key="`additional_equipment_text-${textIndex}`">
                            <v-list-tile-content>
                                <v-list-tile-title
                                    :class="{ [props.index % 2 === 0 ? 'red--text darken-4--text' : 'success--text']: withChanged && props.item.changedKeys.includes('additional_equipment') }">
                                    {{ item.name }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        <v-divider
                            v-if="isShowDivider(textIndex, props.item.additional_equipment)"
                            :key="`additional_equipment_divider-${textIndex}`"
                        ></v-divider>
                    </template>
                </v-list>
            </td>
        </template>
    </v-data-table>
</template>

<script>
import utils from './../../../mixins/utils.js';

export default {
    mixins: [utils],
    props: {
        withChanged: {
            type: Boolean,
            required: false,
            default: false
        },
        items: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            gpsDataHeaders: [
                { text: 'Изображение', align: 'left', sortable: false, value: 'image' },
                { text: 'Марка', align: 'center', value: 'mark', sortable: false },
                { text: 'Модель', align: 'center', value: 'model', sortable: false },
                { text: 'Год выпуска', align: 'center', value: 'year_of_issue', sortable: false },
                { text: 'Тип топлива', align: 'center', value: 'fuel_type', sortable: false },
                { text: 'Мощность', align: 'center', value: 'power', sortable: false },
                { text: 'Гос. номер', align: 'center', value: 'number', sortable: false },
                { text: 'GPS-трекер', align: 'center', value: 'gps_tracker', sortable: false },
                { text: 'ДУТ', align: 'center', value: 'fuel_gauge', sortable: false },
                { text: 'Счетчик', align: 'center', value: 'counter', sortable: false },
                { text: 'RFID', align: 'center', value: 'rf_id', sortable: false },
                { text: 'Cчитыватель прицепного оборудования', align: 'center', value: 'reader_of_trailed_equipment', sortable: false },
                { text: 'CAN', align: 'center', value: 'can_reader', sortable: false },
                { text: 'Деаэратор малый', align: 'center', value: 'deaerator_small', sortable: false },
                { text: 'Деаэратор большой', align: 'center', value: 'deaerator_large', sortable: false },
                { text: 'CN03', align: 'center', value: 'cn03', sortable: false },
                { text: 'RS01', align: 'center', value: 'rs01', sortable: false },
                { text: 'Дополнительное оборудование', align: 'center', value: 'additional_equipment', sortable: false }
            ]
        };
    },
    methods: {
        isShowDivider(index, arr) {
            if (this.isUndefined(arr[index]) || this.isNull(arr[index])) return false;
            const rest = arr.slice(index+1);
            if (rest.length === 0) return false;
            if (rest.every(el => this.isUndefined(el) || this.isNull(el))) return false;
            return true;
        }
    }
}
</script>

<style>
    .gps-data-table table {
        user-select: none;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
        margin-bottom: 10px;
        border-width: 0;
        width: 0;
        outline-width: 0;
        cursor: default;
        max-width: none;
        max-height: none;
    }
    .gps-data-table table tr:first-child td {
        border-top: 1px solid rgba(202, 202, 202, 0.5);
    }
    .gps-data-table table td {
        display: table-cell;
        padding: 0 4px !important;
        border-right: 1px solid rgba(202, 202, 202, 0.5);
        border-bottom: 1px solid rgba(202, 202, 202, 0.5);
    }
    .gps-data-table table td:nth-child(1),
    .gps-data-table table td:nth-child(2) {
        padding: 0 24px !important;
    }
    .gps-data-table table td:first-child {
        border-left: 1px solid rgba(202, 202, 202, 0.5);
        border-right: 1px solid rgba(202, 202, 202, 0.5);
    }
</style>
