<template>
    <v-card>
         <v-card-title>
            <v-btn @click="addRow" color="info">Добавить</v-btn>
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="search"
                label="Поиск"
                single-line
                hide-details>
            </v-text-field>
        </v-card-title>
        <v-card-text id="text-test">
            <!-- <div style="position: relative; top: 0px; left: 0px;"> -->
                <v-data-table
                    v-model="selected"
                    item-key="id"
                    :search="search"
                    id="gps-data-table"
                    :class="{ 'gps-data-table-no-select-text': isCornerFocused }"
                    :headers="headers"
                    :items="orderGPSData"
                    disable-initial-sort
                    select-all
                    hide-actions>
                    <template slot="items" slot-scope="props">
                        <td>
                            <v-checkbox
                                v-model="props.selected"
                                primary
                                hide-details>
                            </v-checkbox>
                        </td>
                        <td class="handle">
                            ::
                        </td>
                        <td>
                            <v-avatar
                                @click="onPickFile(`image-${props.index}`)"
                                size="40"
                                tile>
                                <img :style="{cursor: 'pointer','object-fit': 'cover',width: '40px',height: '40px'}" :src="imagesPreviews[props.index] === '' ? uploadImage : imagesPreviews[props.index]" alt="image">
                            </v-avatar>
                            <input @change="onFilePicked($event, props.index)" style="display:none;" type="file" :ref="`image-${props.index}`">
                        </td>
                        <td>
                            <!-- <v-edit-dialog @click.self.stop="()=>{}" ref="dialog" :return-value.sync="props.item.mark" lazy @save="save" @cancel="cancel" @open="open('dialog')">
                                {{ props.item.mark }} -->
                                <v-text-field
                                    style="width: 100%; margin: 0;"
                                    :value="props.item.mark"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'mark')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            <!-- </v-edit-dialog> -->
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.model" lazy @save="save" @cancel="cancel">
                                {{ props.item.model }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.model"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'model')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.year_of_issue" lazy @save="save" @cancel="cancel">
                                {{ props.item.year_of_issue }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.year_of_issue"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'year_of_issue')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.fuel_type" lazy @save="save" @cancel="cancel">
                                {{ props.item.fuel_type }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.fuel_type"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'fuel_type')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.power" lazy @save="save" @cancel="cancel">
                                {{ props.item.power }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.power"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'power')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.number" lazy @save="save" @cancel="cancel">
                                {{ props.item.number }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.number"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'number')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td @click="selectCell">
                            <!-- <v-autocomplete
                                :value="props.item.gps_tracker"
                                @change="$emit('update:orderGPSData', $event, props.index, 'gps_tracker')"
                                :items="gpsTrackers"
                                item-text="name"
                                hide-selected
                                label="Вибирете GPS-трекер"
                                single-line
                                return-object>
                            </v-autocomplete> -->
                        </td>
                        <td>
                            {{ props.item.gps_tracker.price || 0 }}$
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.fuel_gauge" lazy @save="save" @cancel="cancel">
                                {{ props.item.fuel_gauge }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.fuel_gauge"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'fuel_gauge')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            price
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.counter" lazy @save="save" @cancel="cancel">
                                {{ props.item.counter }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.counter"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'counter')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.rf_id" lazy @save="save" @cancel="cancel">
                                {{ props.item.rf_id }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.rf_id"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'rf_id')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            price
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.reader_of_trailed_equipment" lazy @save="save" @cancel="cancel">
                                {{ props.item.reader_of_trailed_equipment }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.reader_of_trailed_equipment"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'reader_of_trailed_equipment')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            price
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.connect_module" lazy @save="save" @cancel="cancel">
                                {{ props.item.connect_module }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.connect_module"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'connect_module')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            price
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.can_reader" lazy @save="save" @cancel="cancel">
                                {{ props.item.can_reader }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.can_reader"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'can_reader')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            price
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.deaerator" lazy @save="save" @cancel="cancel">
                                {{ props.item.deaerator }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.deaerator"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'deaerator')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            <v-edit-dialog :return-value.sync="props.item.additional_equipment" lazy @save="save" @cancel="cancel">
                                {{ props.item.additional_equipment }}
                                <v-text-field
                                    slot="input"
                                    :value="props.item.additional_equipment"
                                    @input="$emit('update:orderGPSData', $event, props.index, 'additional_equipment')"
                                    label="Edit"
                                    single-line>
                                </v-text-field>
                            </v-edit-dialog>
                        </td>
                        <td>
                            price
                        </td>
                        <td>
                            price
                        </td>
                        <!-- <td class="text-xs-right">{{ props.item.calories }}</td>
                        <td class="text-xs-right">{{ props.item.fat }}</td>
                        <td class="text-xs-right">{{ props.item.carbs }}</td>
                        <td class="text-xs-right">{{ props.item.protein }}</td>
                        <td class="text-xs-right"> -->
                            <!-- <v-edit-dialog
                                :return-value.sync="props.item.iron"
                                large
                                lazy
                                @save="save"
                                @cancel="cancel"
                                >
                                {{ props.item.iron }}
                                <v-autocomplete
                                    slot="input"
                                    v-model="props.item.iron"
                                    :items="itemsTest"
                                    hide-selected
                                    label="Вибирете клиента"
                                    single-line
                                    autofocus>
                                </v-autocomplete>
                            </v-edit-dialog> -->
                        <!-- </td> -->
                    </template>
                </v-data-table>
                <!-- <div class="borders">
                    <div :style="{ position: 'absolute', top: 0, left: 0 }">
                        <div ref="borderTop" class="border current" :style="bordersSelectData.topBorderStyles"></div>
                        <div ref="borderleft" class="border current" :style="bordersSelectData.leftBorderStyles"></div>
                        <div ref="borderBottom" class="border current" :style="bordersSelectData.bottomBorderStyles"></div>
                        <div ref="borderRight" class="border current" :style="bordersSelectData.rightBorderStyles"></div>
                        <div ref="borderCorner" @mousedown="cornerFocused" class="border current corner" :style="bordersSelectData.cornerStyles"></div>
                    </div>
                </div> -->
            <!-- </div> -->
        </v-card-text>
        <!-- <v-snackbar v-model="snack" :timeout="snackTimeout" :color="snackColor">
            {{ snackText }}
        </v-snackbar> -->
        <v-card-text>
            <div class="hot">
                <HotTable :root="'test-hot'" :settings="settings"></HotTable>
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
import Sortable from 'sortablejs';
import setStyles from './../../../mixins/stylesMixins.js';
// require('../node_modules/handsontable/dist/handsontable.full.min.css');
// import '../node_modules/handsontable/dist/handsontable.full.min.css';
import HotTable from '@handsontable/vue';
import Handsontable from 'handsontable';

export default {
    mixins: [setStyles],
    props: {
        orderGPSData: {
            type: Array,
            required: true
        },
        gpsTrackers: {
            type: Array,
            required: true
        },
        fuelLevelSensors: {
            type: Array,
            required: true
        },
        fuelFlowmeters: {
            type: Array,
            required: true
        },
        identification: {
            type: Array,
            required: true
        },
        optionalEquipment: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            settings: {
                data: [
                    ["", "Ford", "Volvo", "Toyota", "Honda"],
                    ["2016", 10, [11,11], 12, 13],
                    ["2017", 20, 11, 14, 13],
                    ["2018", 30, 15, 12, 13]
                ],
            },
            tableBody: null,
            bordersWrapper: null,
            bordersSelectData: {
                top: {
                    el: null,
                    styles: { height: '2px', width: '0px', display: 'block', top: '0px', left: '0px' }
                },
                left: {
                    el: null,
                    styles: { height: '0px', width: '2px', display: 'block', top: '0px', left: '0px' }
                },
                bottom: {
                    el: null,
                    styles: { height: '2px', width: '0px', display: 'block', top: '0px', left: '0px' }
                },
                right: {
                    el: null,
                    styles: { height: '0px', width: '2px', display: 'block', top: '0px', left: '0px' }
                },
                corner: {
                    el: null,
                    styles: { height: '10px', width: '10px', border: '1px solid rgb(255, 255, 255)', display: 'block', top: '0px', left: '0px' }
                }
            },
            isCornerFocused: false,
            selected: [],
            snackTimeout: 1500,
            search: '',
            rowsPerPageItems: [10, 15, 20, 25, 30, 50],
            pagination: {
                rowsPerPage: 20
            },
            snack: false,
            snackColor: "",
            snackText: "",
            headers: [
                { text: '#', align: 'left', sortable: false },
                { text: 'Изображение', align: 'left', sortable: false, value: 'image' },
                { text: 'Марка', value: 'mark' },
                { text: 'Модель', value: 'model' },
                { text: 'Год выпуска', value: 'year_of_issue' },
                { text: 'Тип топлива', value: 'fuel_type' },
                { text: 'Мощность', value: 'power' },
                { text: 'Гос. номер', value: 'number' },
                { text: 'GPS-трекер', value: 'gps_tracker' },
                { text: 'Цена $ ', value: 'gps_tracker_price' },
                { text: 'ДУТ', value: 'fuel_gauge' },
                { text: 'Цена $  ', value: 'fuel_gauge_price' },
                { text: 'Счетчик', value: 'counter' },
                { text: 'RFID', value: 'rf_id' },
                { text: 'Цена $   ', value: 'rf_id_price' },
                { text: 'Cчитыватель прицепного оборудования', value: 'reader_of_trailed_equipment' },
                { text: 'Цена $    ', value: 'reader_of_trailed_equipment_price' },
                { text: 'Модуль конект', value: 'connect_module' },
                { text: 'Цена $     ', value: 'connect_module_price' },
                { text: 'CAN', value: 'can_reader' },
                { text: 'Цена $      ', value: 'can_reader_price' },
                { text: 'Деаэратор', value: 'deaerator' },
                { text: 'Дополнительное оборудование', value: 'additional_equipmen' },
                { text: 'Цена $       ', value: 'additional_equipmen_price' },
                { text: 'Монтаж оборудования', value: 'installation_of_equipment_price' },
            ],
            uploadImage: '/storage/upload-foto.png',
            imagesPreviews: [],
            cellsPosition: []
        };
    },
    methods: {
        addRow() {
            this.$emit('rowAdded');
            this.imagesPreviews.push('');
        },
        onPickFile(ref) {
            this.$refs[ref].click();
        },
        onFilePicked(event, index) {
            this.$emit('update:orderGPSData', event.target.files[0], index, 'image');
            this.$set(this.imagesPreviews, index, URL.createObjectURL(this.orderGPSData[index].image));
        },
        cornerMoved(moveEvent) {
            // moveEvent.preventDefault();
            console.log(moveEvent);
            console.log('Moved');
        },
        cornerFocused(event) {
            this.tableBody.addEventListener('mousemove', this.cornerMoved, false);
            this.tableBody.addEventListener('mouseup', this.cornerBlurred, false);
            this.isCornerFocused = true;
            console.log('Focused');
        },
        cornerBlurred(event) {
            this.tableBody.removeEventListener('mousemove', this.cornerMoved, false);
            this.isCornerFocused = false;
            console.log('Blurred');
        },
        getInitialCellsPosition() {

        },
        createBorder(position, isCorner) {
            this.bordersSelectData[position].el = document.createElement('div');
            this.bordersSelectData[position].el.classList.add('border');
            this.bordersSelectData[position].el.classList.add('current');
            if (isCorner) this.bordersSelectData[position].el.classList.add('corner');
            this.bordersWrapper.appendChild(this.bordersSelectData[position].el);
            this.setStyles(this.bordersSelectData[position].el, this.bordersSelectData[position].styles);
        },
        getCoords(elem) {
            const box = elem.getBoundingClientRect();
            const table = document.querySelector('#gps-data-table table').getBoundingClientRect();

            return {
                width: box.width,
                height: box.height,
                top: box.top - table.top,
                left: box.left - table.left
            };
        },
        positionBorders(anchor) {
            const anchorCoords = this.getCoords(anchor);
            if (this.bordersSelectData.top.el === null) {
                this.createBorder('top');
            }
            if (this.bordersSelectData.left.el === null) {
                this.createBorder('left');
            }
            if (this.bordersSelectData.bottom.el === null) {
                this.createBorder('bottom');
            }
            if (this.bordersSelectData.right.el === null) {
                this.createBorder('right');
            }
            if (this.bordersSelectData.corner.el === null) {
                this.createBorder('corner', true);
            }

            this.bordersSelectData.top.styles.top = `${anchorCoords.top - this.bordersSelectData.top.el.offsetHeight}px`;
            this.bordersSelectData.top.styles.left = `${anchorCoords.left}px`;
            this.bordersSelectData.top.styles.width = `${anchorCoords.width}px`;
            this.setStyles(this.bordersSelectData.top.el, this.bordersSelectData.top.styles);

            this.bordersSelectData.left.styles.top = `${anchorCoords.top}px`;
            this.bordersSelectData.left.styles.left = `${anchorCoords.left}px`;
            this.bordersSelectData.left.styles.height = `${anchorCoords.height}px`;
            this.setStyles(this.bordersSelectData.left.el, this.bordersSelectData.left.styles);

            this.bordersSelectData.bottom.styles.top = `${anchorCoords.top + anchor.offsetHeight}px`;
            this.bordersSelectData.bottom.styles.left = `${anchorCoords.left}px`;
            this.bordersSelectData.bottom.styles.width = `${anchorCoords.width}px`;
            this.setStyles(this.bordersSelectData.bottom.el, this.bordersSelectData.bottom.styles);

            this.bordersSelectData.right.styles.top = `${anchorCoords.top}px`;
            this.bordersSelectData.right.styles.left = `${anchorCoords.left + anchor.offsetWidth-2}px`;
            this.bordersSelectData.right.styles.height = `${anchorCoords.height}px`;
            this.setStyles(this.bordersSelectData.right.el, this.bordersSelectData.right.styles);

            this.bordersSelectData.corner.styles.top = `${anchorCoords.top + anchor.offsetHeight - 5}px`;
            this.bordersSelectData.corner.styles.left = `${anchorCoords.left + anchor.offsetWidth - 6}px`;
            this.setStyles(this.bordersSelectData.corner.el, this.bordersSelectData.corner.styles);
        },
        selectCell(event) {
            const cell = event.target;
            this.positionBorders(cell);
        },
        open(name) {
            // console.log('Before:', this.$refs[name]);
            // this.$refs[name].$el.style.display = "none";
            // this.$set(this.$refs[name]._data, 'isActive', false);
            // console.log('After:', this.$refs[name]);
            // this.$forceUpdate();
            // .isActive = false
            // console.log();
        },
        testTDClick(event) {

        },
        save() {
            this.snackColor = "success";
            this.snackText = "Данные сохранены";
            this.snack = true;
        },
        cancel() {
            this.snackColor = "error";
            this.snackText = "Действие отменено";
            this.snack = true;
        },
        close(ref) {
            this.$refs[ref].blur()
        }
    },
    created() {
        this.addRow();
    },
    mounted() {
        const tableBody = document.querySelector('#gps-data-table .v-datatable tbody');
        this.tableBody = tableBody;
        const _self = this;
        Sortable.create(tableBody, {
            handle: '.handle',
            onEnd({ newIndex, oldIndex }) {
                _self.$emit('drag-n-drop-gps-data', newIndex, oldIndex);
            }
        });
        const tableOverflow = document.querySelector('#gps-data-table .v-table__overflow');

        const borders = document.createElement('div');
        this.setStyles(borders, { position: 'absolute', top: 0, left: 0 });
        this.bordersWrapper = borders;
        tableOverflow.appendChild(borders)
        // console.log(tableBody.children);
        // setTimeout(() => {
        //     const cells = document.querySelectorAll('#gps-data-table table tbody tr td');
        //     Array.prototype.forEach.call(cells, (el) => {
        //         console.log(el.getBoundingClientRect());
        //     });
        // }, 2000);
    },
    components: {
        HotTable
    }
};
</script>

<style src="./../../../../../../node_modules/handsontable/dist/handsontable.full.min.css"></style>

<style>
    .gps-data-table-no-select-text table {
        user-select: none;
    }
    /* #gps-data-table table th {
        padding: 0 24px !important;
    } */
    #gps-data-table .v-table__overflow {
        position: relative;
    }
    #gps-data-table table {
        /* position: relative; */
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

    #gps-data-table table td {
        display: table-cell;
        padding: 0 4px;
        border-right: 1px solid rgba(202, 202, 202, 0.5);
    }
    #gps-data-table table td:nth-child(1),
    #gps-data-table table td:nth-child(2) {
        padding: 0 24px;
    }
    /* #gps-data-table table tr td:nth-child(9),
    #gps-data-table table tr td:nth-child(10) {
        position: relative;
        min-width: 130px;
        min-height: 10px;
        background-color: red;
    } */
    #gps-data-table table td:first-child {
        border-left: 1px solid rgba(202, 202, 202, 0.5);
        border-right: 1px solid rgba(202, 202, 202, 0.5);
    }
    /* #gps-data-table table th {
        padding-right: 200px;
    }
    #gps-data-table table th:nth-child(1),
    #gps-data-table table th:nth-child(2),
    #gps-data-table table th:nth-child(3) {
        padding: 0 24px;
    } */

    .border {
        position: absolute;
        font-size: 0;
        background-color: rgb(75, 135, 255);
    }
    .border .hidden {
        display: none !important;
    }
    .border .current {
        z-index: 10;
    }
    .corner {
        font-size: 0;
        cursor: crosshair;
    }
    /* .handsontable .wtBorder.area {
        z-index: 8;
    }
    .handsontable .wtBorder.fill {
        z-index: 6;
    } */
    /* #gps-data-table table td::after {
        content: "";
        position: absolute;
        width: 5px;
        height: 5px;
        background-color: red;
        top: 0;
        left: 0;
    } */

    .handle {
        cursor: move;
    }
</style>
