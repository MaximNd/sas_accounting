<template>
    <v-card class="elevation-0">
         <v-card-title>
            <v-btn @click="addRow(1)" color="info">Добавить</v-btn>
            <v-btn @click="deleteSelected" color="error">Удалить выбранные</v-btn>
            <v-spacer></v-spacer>
        </v-card-title>
        <v-card-text id="text-test" class="ma-0 pa-0">
            <v-data-table
                v-model="selected"
                item-key="id"
                id="gps-data-table"
                :class="{ 'gps-data-table-no-select-text': isCornerFocused }"
                :headers="headers"
                :items="orderGPSData"
                disable-initial-sort
                select-all
                hide-actions>
                <template slot="items" slot-scope="props">
                    <td @mousedown="hideBordersAndCorner">
                        <v-checkbox
                            v-model="props.selected"
                            primary
                            hide-details>
                        </v-checkbox>
                    </td>
                    <td @mousedown="hideBordersAndCorner" class="handle">
                        ::
                    </td>
                    <td
                        :ref="`td-${props.index}-${0}`"
                        @click="selectCell($event, { index: props.index, column: 'image', columnIndex: 0, value: props.item.image })"
                        @mouseenter="selectCellToCopyList($event, { index: props.index, column: 'image', columnIndex: 0, value: props.item.image })">
                        <v-avatar
                            @dblclick="onPickFile(`image-${props.index}`)"
                            size="40"
                            tile>
                            <img :style="{cursor: 'pointer','object-fit': 'cover',width: '40px',height: '40px'}" :src="props.item.image === '' ? uploadImage : props.item.image" alt="image">
                        </v-avatar>
                        <input @change="onFilePicked($event, props.index)" style="display:none;" type="file" :ref="`image-${props.index}`">
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${1}`"
                        @click="selectCell($event, { index: props.index, column: 'mark', columnIndex: 1, value: props.item.mark })"
                        @dblclick="switchCellMode(props.index, 1, true, `mark-${props.index}-${1}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'mark', columnIndex: 1, value: props.item.mark })">
                        <template v-if="!editModCells[props.index][1]">
                            {{ props.item.mark }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`mark-${props.index}-${1}`"
                                :value="props.item.mark"
                                @change="setCellValue($event, props.index, 1, 'mark', `td-${props.index}-${1}`)"
                                :items="cachedData.mark"
                                label="Вибирете марку"
                                single-line>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 1, false, `mark-${props.index}-${1}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${2}`"
                        @click="selectCell($event, { index: props.index, column: 'model', columnIndex: 2, value: props.item.model })"
                        @dblclick="switchCellMode(props.index, 2, true, `model-${props.index}-${2}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'model', columnIndex: 2, value: props.item.model })">
                        <template v-if="!editModCells[props.index][2]">
                            {{ props.item.model }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`model-${props.index}-${2}`"
                                :value="props.item.model"
                                @change="setCellValue($event, props.index, 2, 'model', `td-${props.index}-${2}`)"
                                :items="cachedData.model"
                                label="Вибирете модель"
                                single-line>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 2, false, `model-${props.index}-${2}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${3}`"
                        @click="selectCell($event, { index: props.index, column: 'year_of_issue', columnIndex: 3, value: props.item.year_of_issue })"
                        @dblclick="switchCellMode(props.index, 3, true, `year_of_issue-${props.index}-${3}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'year_of_issue', columnIndex: 3, value: props.item.year_of_issue })">
                        <template v-if="!editModCells[props.index][3]">
                            {{ props.item.year_of_issue }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`year_of_issue-${props.index}-${3}`"
                                :value="props.item.year_of_issue"
                                @change="setCellValue($event, props.index, 3, 'year_of_issue', `td-${props.index}-${3}`)"
                                :items="Array.apply(null, { length: 100 }).map((_, i) => 1950 + i)"
                                label="Вибирете год выпуска"
                                auto
                                single-line>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 3, false, `year_of_issue-${props.index}-${3}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${4}`"
                        @click="selectCell($event, { index: props.index, column: 'fuel_type', columnIndex: 4, value: props.item.fuel_type })"
                        @dblclick="switchCellMode(props.index, 4, true, `fuel_type-${props.index}-${4}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'fuel_type', columnIndex: 4, value: props.item.fuel_type })">
                        <template v-if="!editModCells[props.index][4]">
                            {{ props.item.fuel_type }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`fuel_type-${props.index}-${4}`"
                                :value="props.item.fuel_type"
                                @change="setCellValue($event, props.index, 4, 'fuel_type', `td-${props.index}-${4}`)"
                                :items="cachedData.fuel_type"
                                label="Вибирете Тип топлива"
                                single-line>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 4, false, `fuel_type-${props.index}-${4}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${5}`"
                        @click="selectCell($event, { index: props.index, column: 'power', columnIndex: 5, value: props.item.power })"
                        @dblclick="switchCellMode(props.index, 5, true, `power-${props.index}-${5}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'power', columnIndex: 5, value: props.item.power })">
                        <template v-if="!editModCells[props.index][5]">
                            {{ props.item.power }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`power-${props.index}-${5}`"
                                :value="props.item.power"
                                @change="setCellValue($event, props.index, 5, 'power', `td-${props.index}-${5}`)"
                                :items="cachedData.power"
                                hide-selected
                                label="Вибирете мощность"
                                single-line>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 5, false, `power-${props.index}-${5}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${6}`"
                        @click="selectCell($event, { index: props.index, column: 'number', columnIndex: 6, value: props.item.number })"
                        @dblclick="switchCellMode(props.index, 6, true, `number-${props.index}-${6}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'number', columnIndex: 6, value: props.item.number })">
                        <template v-if="!editModCells[props.index][6]">
                            {{ props.item.number }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`number-${props.index}-${6}`"
                                :value="props.item.number"
                                @change="setCellValue($event, props.index, 6, 'number', `td-${props.index}-${6}`)"
                                :items="cachedData.number"
                                hide-selected
                                label="Вибирете гос. номер"
                                single-line>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 6, false, `number-${props.index}-${6}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${7}`"
                        @click="selectCell($event, { index: props.index, column: 'gps_tracker', columnIndex: 7, value: props.item.gps_tracker })"
                        @dblclick="switchCellMode(props.index, 7, true, `gps_tracker-${props.index}-${7}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'gps_tracker', columnIndex: 7, value: props.item.gps_tracker })">
                        <template v-if="!editModCells[props.index][7]">
                            {{ props.item.gps_tracker.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`gps_tracker-${props.index}-${7}`"
                                :value="props.item.gps_tracker"
                                @change="setCellValue($event, props.index, 7, 'gps_tracker', `td-${props.index}-${7}`)"
                                :items="gpsTrackers"
                                item-text="name"
                                hide-selected
                                label="Вибирете GPS-трекер"
                                single-line
                                return-object>
                            </v-autocomplete>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${8}`"
                        @click="selectCell($event, { index: props.index, column: 'gps_tracker_price', columnIndex: 8, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'gps_tracker_price', columnIndex: 8, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['gps_tracker_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][9] }"
                        :ref="`td-${props.index}-${9}`"
                        :style="{ 'min-width': editModCells[props.index][9] ? '300px' : '10px' }"
                        @click="selectCell($event, { index: props.index, column: 'fuel_gauge', columnIndex: 9, value: props.item.fuel_gauge })"
                        @dblclick="switchCellMode(props.index, 9, true, `fuel_gauge-${props.index}-${9}`, $event, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'fuel_gauge', columnIndex: 9, value: props.item.fuel_gauge })">
                        <template v-if="!editModCells[props.index][9]">
                            <v-list v-if="props.item.fuel_gauge.some(el => !isUndefined(el) && !isNull(el))">
                                <template v-for="(item, textIndex) in props.item.fuel_gauge">
                                    <v-list-tile
                                        v-if="!isUndefined(item) && !isNull(item)"
                                        :key="`fuel_gauge_text-${textIndex}`">
                                        <v-list-tile-content>
                                            <v-list-tile-title>
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
                        </template>
                        <template v-else>
                            <v-layout wrap>
                                <template v-for="(_, inputIndex) in props.item.fuel_gauge.length">
                                    <v-flex xs10 :key="`fuel_gauge_input-${inputIndex}`">
                                        <v-autocomplete
                                            :ref="`fuel_gauge-${props.index}-${9}`"
                                            :value="props.item.fuel_gauge[inputIndex]"
                                            @change="setCellValue($event, props.index, 9, 'fuel_gauge', `td-${props.index}-${9}`, inputIndex, false)"
                                            :items="fuelLevelSensors"
                                            item-text="name"
                                            clearable
                                            hide-selected
                                            label="Вибирете ДУТ"
                                            single-line
                                            return-object>
                                        </v-autocomplete>
                                    </v-flex>
                                    <v-flex xs2 class="layout align-center justify-center"  :key="`fuel_gauge_delete_btn-${inputIndex}`">
                                        <v-btn
                                            small
                                            icon
                                            @click="deleteOrderNestedData($event, props.index, 'fuel_gauge', inputIndex)">
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </template>
                                <v-flex xs12>
                                    <v-btn color="success" small @click="addNestedData($event, props.index, 'fuel_gauge')">
                                        Добавить
                                    </v-btn>
                                </v-flex>
                                <v-flex xs12>
                                    <v-btn color="info" small @click="switchCellMode(props.index, 9, false, `fuel_gauge-${props.index}-${9}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${10}`"
                        @click="selectCell($event, { index: props.index, column: 'fuel_gauge_price', columnIndex: 10, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'fuel_gauge_price', columnIndex: 10, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['fuel_gauge_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${11}`"
                        @click="selectCell($event, { index: props.index, column: 'counter', columnIndex: 11, value: props.item.counter })"
                        @dblclick="switchCellMode(props.index, 11, true, `counter-${props.index}-${11}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'counter', columnIndex: 11, value: props.item.counter })">
                        <template v-if="!editModCells[props.index][11]">
                            {{ props.item.counter.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`counter-${props.index}-${11}`"
                                :value="props.item.counter"
                                @change="setCellValue($event, props.index, 11, 'counter', `td-${props.index}-${11}`)"
                                :items="allEquipment"
                                item-text="name"
                                hide-selected
                                label="Вибирете счетчик"
                                single-line
                                return-object>
                            </v-autocomplete>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${12}`"
                        @click="selectCell($event, { index: props.index, column: 'counter_price', columnIndex: 12, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'counter_price', columnIndex: 12, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['counter_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${13}`"
                        @click="selectCell($event, { index: props.index, column: 'rf_id', columnIndex: 13, value: props.item.rf_id })"
                        @dblclick="switchCellMode(props.index, 13, true, `rf_id-${props.index}-${13}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rf_id', columnIndex: 13, value: props.item.rf_id })">
                        <template v-if="!editModCells[props.index][13]">
                            {{ props.item.rf_id.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`rf_id-${props.index}-${13}`"
                                :value="props.item.counter"
                                @change="setCellValue($event, props.index, 13, 'rf_id', `td-${props.index}-${13}`)"
                                :items="allEquipment"
                                item-text="name"
                                hide-selected
                                label="Вибирете RFID"
                                single-line
                                return-object>
                            </v-autocomplete>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${14}`"
                        @click="selectCell($event, { index: props.index, column: 'rf_id_price', columnIndex: 14, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rf_id_price', columnIndex: 14, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['rf_id_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${15}`"
                        @click="selectCell($event, { index: props.index, column: 'reader_of_trailed_equipment', columnIndex: 15, value: props.item.reader_of_trailed_equipment })"
                        @dblclick="switchCellMode(props.index, 15, true, `reader_of_trailed_equipment-${props.index}-${15}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'reader_of_trailed_equipment', columnIndex: 15, value: props.item.reader_of_trailed_equipment })">
                        <template v-if="!editModCells[props.index][15]">
                            {{ props.item.reader_of_trailed_equipment.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`reader_of_trailed_equipment-${props.index}-${15}`"
                                :value="props.item.reader_of_trailed_equipment"
                                @change="setCellValue($event, props.index, 15, 'reader_of_trailed_equipment', `td-${props.index}-${15}`)"
                                :items="allEquipment"
                                item-text="name"
                                hide-selected
                                label="Вибирете считыватель прицепного оборудования"
                                single-line
                                return-object>
                            </v-autocomplete>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${16}`"
                        @click="selectCell($event, { index: props.index, column: 'reader_of_trailed_equipment_price', columnIndex: 16, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'reader_of_trailed_equipment_price', columnIndex: 16, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['reader_of_trailed_equipment_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${17}`"
                        @click="selectCell($event, { index: props.index, column: 'connect_module', columnIndex: 17, value: props.item.connect_module })"
                        @dblclick="switchCellMode(props.index, 17, true, `connect_module-${props.index}-${17}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'connect_module', columnIndex: 17, value: props.item.connect_module })">
                        <template v-if="!editModCells[props.index][17]">
                            {{ props.item.connect_module.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`connect_module-${props.index}-${17}`"
                                :value="props.item.connect_module"
                                @change="setCellValue($event, props.index, 17, 'connect_module', `td-${props.index}-${17}`)"
                                :items="allEquipment"
                                item-text="name"
                                hide-selected
                                label="Вибирете модуль конект"
                                single-line
                                return-object>
                            </v-autocomplete>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${18}`"
                        @click="selectCell($event, { index: props.index, column: 'connect_module_price', columnIndex: 18, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'connect_module_price', columnIndex: 18, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['connect_module_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${19}`"
                        @click="selectCell($event, { index: props.index, column: 'can_reader', columnIndex: 19, value: props.item.can_reader })"
                        @dblclick="switchCellMode(props.index, 19, true, `can_reader-${props.index}-${19}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'can_reader', columnIndex: 19, value: props.item.can_reader })">
                        <template v-if="!editModCells[props.index][19]">
                            {{ props.item.can_reader.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`can_reader-${props.index}-${19}`"
                                :value="props.item.can_reader"
                                @change="setCellValue($event, props.index, 19, 'can_reader', `td-${props.index}-${19}`)"
                                :items="allEquipment"
                                item-text="name"
                                hide-selected
                                label="Вибирете CAN"
                                single-line
                                return-object>
                            </v-autocomplete>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${20}`"
                        @click="selectCell($event, { index: props.index, column: 'can_reader_price', columnIndex: 20, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'can_reader_price', columnIndex: 20, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['can_reader_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${21}`"
                        @click="selectCell($event, { index: props.index, column: 'deaerator', columnIndex: 21, value: props.item.deaerator })"
                        @dblclick="switchCellMode(props.index, 21, true, `deaerator-${props.index}-${21}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'deaerator', columnIndex: 21, value: props.item.deaerator })">
                        <template v-if="!editModCells[props.index][21]">
                            {{ props.item.deaerator.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`deaerator-${props.index}-${21}`"
                                :value="props.item.deaerator"
                                @change="setCellValue($event, props.index, 21, 'deaerator', `td-${props.index}-${21}`)"
                                :items="allEquipment"
                                item-text="name"
                                hide-selected
                                label="Вибирете деаэратор"
                                single-line
                                return-object>
                            </v-autocomplete>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${22}`"
                        @click="selectCell($event, { index: props.index, column: 'deaerator_price', columnIndex: 22, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'deaerator_price', columnIndex: 22, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['deaerator_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][23] }"
                        :ref="`td-${props.index}-${23}`"
                        :style="{ 'min-width': editModCells[props.index][23] ? '300px' : '10px' }"
                        @click="selectCell($event, { index: props.index, column: 'cn03', columnIndex: 23, value: props.item.cn03 })"
                        @dblclick="switchCellMode(props.index, 23, true, `cn03-${props.index}-${23}`, $event, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'cn03', columnIndex: 23, value: props.item.cn03 })">
                        <template v-if="!editModCells[props.index][23]">
                            <v-list v-if="props.item.cn03.some(el => !isUndefined(el) && !isNull(el))">
                                <template v-for="(item, textIndex) in props.item.cn03">
                                    <v-list-tile
                                        v-if="!isUndefined(item) && !isNull(item)"
                                        :key="`cn03_text-${textIndex}`">
                                        <v-list-tile-content>
                                            <v-list-tile-title>
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
                        </template>
                        <template v-else>
                            <v-layout wrap>
                                <template v-for="(_, inputIndex) in props.item.cn03.length">
                                    <v-flex xs10 :key="`cn03_input-${inputIndex}`">
                                        <v-autocomplete
                                            :ref="`cn03-${props.index}-${23}`"
                                            :value="props.item.cn03[inputIndex]"
                                            @change="setCellValue($event, props.index, 23, 'cn03', `td-${props.index}-${23}`, inputIndex, false)"
                                            :items="allEquipment"
                                            item-text="name"
                                            clearable
                                            hide-selected
                                            label="Вибирете CN03"
                                            single-line
                                            return-object>
                                        </v-autocomplete>
                                    </v-flex>
                                    <v-flex xs2 class="layout align-center justify-center"  :key="`cn03_delete_btn-${inputIndex}`">
                                        <v-btn
                                            small
                                            icon
                                            @click="deleteOrderNestedData($event, props.index, 'cn03', inputIndex)">
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </template>
                                <v-flex xs12>
                                    <v-btn color="success" small @click="addNestedData($event, props.index, 'cn03')">
                                        Добавить
                                    </v-btn>
                                </v-flex>
                                <v-flex xs12>
                                    <v-btn color="info" small @click="switchCellMode(props.index, 23, false, `cn03-${props.index}-${23}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${24}`"
                        @click="selectCell($event, { index: props.index, column: 'cn03_price', columnIndex: 24, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'cn03_price', columnIndex: 24, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['cn03_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][25] }"
                        :ref="`td-${props.index}-${25}`"
                        :style="{ 'min-width': editModCells[props.index][25] ? '300px' : '10px' }"
                        @click="selectCell($event, { index: props.index, column: 'rs01', columnIndex: 25, value: props.item.rs01 })"
                        @dblclick="switchCellMode(props.index, 25, true, `rs01-${props.index}-${25}`, $event, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rs01', columnIndex: 25, value: props.item.rs01 })">
                        <template v-if="!editModCells[props.index][25]">
                            <v-list v-if="props.item.rs01.some(el => !isUndefined(el) && !isNull(el))">
                                <template v-for="(item, textIndex) in props.item.rs01">
                                    <v-list-tile
                                        v-if="!isUndefined(item) && !isNull(item)"
                                        :key="`rs01_text-${textIndex}`">
                                        <v-list-tile-content>
                                            <v-list-tile-title>
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
                        </template>
                        <template v-else>
                            <v-layout wrap>
                                <template v-for="(_, inputIndex) in props.item.rs01.length">
                                    <v-flex xs10 :key="`rs01_input-${inputIndex}`">
                                        <v-autocomplete
                                            :ref="`rs01-${props.index}-${25}`"
                                            :value="props.item.rs01[inputIndex]"
                                            @change="setCellValue($event, props.index, 25, 'rs01', `td-${props.index}-${25}`, inputIndex, false)"
                                            :items="allEquipment"
                                            item-text="name"
                                            clearable
                                            hide-selected
                                            label="Вибирете RS01"
                                            single-line
                                            return-object>
                                        </v-autocomplete>
                                    </v-flex>
                                    <v-flex xs2 class="layout align-center justify-center"  :key="`rs01_delete_btn-${inputIndex}`">
                                        <v-btn
                                            small
                                            icon
                                            @click="deleteOrderNestedData($event, props.index, 'rs01', inputIndex)">
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </template>
                                <v-flex xs12>
                                    <v-btn color="success" small @click="addNestedData($event, props.index, 'rs01')">
                                        Добавить
                                    </v-btn>
                                </v-flex>
                                <v-flex xs12>
                                    <v-btn color="info" small @click="switchCellMode(props.index, 25, false, `rs01-${props.index}-${25}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${26}`"
                        @click="selectCell($event, { index: props.index, column: 'rs01_price', columnIndex: 26, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rs01_price', columnIndex: 26, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['rs01_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][27] }"
                        :ref="`td-${props.index}-${27}`"
                        :style="{ 'min-width': editModCells[props.index][27] ? '300px' : '10px' }"
                        @click="selectCell($event, { index: props.index, column: 'additional_equipment', columnIndex: 27, value: props.item.additional_equipment })"
                        @dblclick="switchCellMode(props.index, 27, true, `additional_equipment-${props.index}-${27}`, $event, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'additional_equipment', columnIndex: 27, value: props.item.additional_equipment })">
                        <template v-if="!editModCells[props.index][27]">
                            <v-list v-if="props.item.additional_equipment.some(el => !isUndefined(el) && !isNull(el))">
                                <template v-for="(item, textIndex) in props.item.additional_equipment">
                                    <v-list-tile
                                        v-if="!isUndefined(item) && !isNull(item)"
                                        :key="`additional_equipment_text-${textIndex}`">
                                        <v-list-tile-content>
                                            <v-list-tile-title>
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
                        </template>
                        <template v-else>
                            <v-layout wrap>
                                <template v-for="(_, inputIndex) in props.item.additional_equipment.length">
                                    <v-flex xs10 :key="`additional_equipment_input-${inputIndex}`">
                                        <v-autocomplete
                                            :ref="`additional_equipment-${props.index}-${27}`"
                                            :value="props.item.additional_equipment[inputIndex]"
                                            @change="setCellValue($event, props.index, 27, 'additional_equipment', `td-${props.index}-${27}`, inputIndex, false)"
                                            :items="optionalEquipment"
                                            item-text="name"
                                            clearable
                                            hide-selected
                                            label="Вибирете доп. оборудование"
                                            single-line
                                            return-object>
                                        </v-autocomplete>
                                    </v-flex>
                                    <v-flex xs2 class="layout align-center justify-center"  :key="`additional_equipment_delete_btn-${inputIndex}`">
                                        <v-btn
                                            small
                                            icon
                                            @click="deleteOrderNestedData($event, props.index, 'additional_equipment', inputIndex)">
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </template>
                                <v-flex xs12>
                                    <v-btn color="success" small @click="addNestedData($event, props.index, 'additional_equipment')">
                                        Добавить
                                    </v-btn>
                                </v-flex>
                                <v-flex xs12>
                                    <v-btn color="info" small @click="switchCellMode(props.index, 27, false, `additional_equipment-${props.index}-${27}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['additional_equipment_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center">
                        {{ pricesForEquipment.installationPrices[props.index] }}₴
                    </td>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
import dcopy from 'deep-copy';
import Sortable from 'sortablejs';
import setStyles from './../../../mixins/stylesMixins.js';
import utils from './../../../mixins/utils.js';

export default {
    mixins: [setStyles, utils],
    props: {
        defaultRowCount: {
            type: Number,
            required: true
        },
        orderGPSData: {
            type: Array,
            required: true
        },
        cachedData: {
            type: Object,
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
        },
        pricesForEquipment: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
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
                    styles: { display: 'block', top: '0px', left: '0px' }
                }
            },
            cachedDataTest: ['number1', 'number2', 'number3', 'number4'],
            isCornerFocused: false,
            copyList: [],
            selected: [],
            editModCells: [],
            rowsPerPageItems: [10, 15, 20, 25, 30, 50],
            pagination: {
                rowsPerPage: 20
            },
            headers: [
                { text: '#', align: 'left', sortable: false },
                { text: 'Изображение', align: 'left', sortable: false, value: 'image' },
                { text: 'Марка', value: 'mark', sortable: false },
                { text: 'Модель', value: 'model', sortable: false },
                { text: 'Год выпуска', value: 'year_of_issue', sortable: false },
                { text: 'Тип топлива', value: 'fuel_type', sortable: false },
                { text: 'Мощность', value: 'power', sortable: false },
                { text: 'Гос. номер', value: 'number', sortable: false },
                { text: 'GPS-трекер', value: 'gps_tracker', sortable: false },
                { text: 'Цена $ ', value: 'gps_tracker_price', sortable: false },
                { text: 'ДУТ', value: 'fuel_gauge', sortable: false },
                { text: 'Цена $  ', value: 'fuel_gauge_price', sortable: false },
                { text: 'Счетчик', value: 'counter', sortable: false },
                { text: 'Цена $   ', value: 'counter_price', sortable: false },
                { text: 'RFID', value: 'rf_id', sortable: false },
                { text: 'Цена $    ', value: 'rf_id_price', sortable: false },
                { text: 'Cчитыватель прицепного оборудования', value: 'reader_of_trailed_equipment', sortable: false },
                { text: 'Цена $     ', value: 'reader_of_trailed_equipment_price', sortable: false },
                { text: 'Модуль конект', value: 'connect_module', sortable: false },
                { text: 'Цена $      ', value: 'connect_module_price', sortable: false },
                { text: 'CAN', value: 'can_reader', sortable: false },
                { text: 'Цена $       ', value: 'can_reader_price', sortable: false },
                { text: 'Деаэратор', value: 'deaerator', sortable: false },
                { text: 'Цена $        ', value: 'deaerator_price', sortable: false },
                { text: 'CN03', value: 'cn03', sortable: false },
                { text: 'Цена $         ', value: 'cn03_price', sortable: false },
                { text: 'RS01', value: 'rs01', sortable: false },
                { text: 'Цена $          ', value: 'rs01_price', sortable: false },
                { text: 'Дополнительное оборудование', value: 'additional_equipment', sortable: false },
                { text: 'Цена $           ', value: 'additional_equipment_price', sortable: false },
                { text: 'Монтаж оборудования ₴', value: 'installation_of_equipment_price', sortable: false },
            ],
            uploadImage: '/storage/upload-foto.png',
            cellsPosition: []
        };
    },
    computed: {
        isReadyToCopy() {
            if (this.copyList.length === 0) return false;
            return this.copyList.reduce((isReady, list) => list.length !== 1 && isReady, true);
        },
        allEquipment() {
            return [
                { header: 'GPS-трекеры' },
                ...this.gpsTrackers,
                { divider: true },
                { header: 'Датчики уровня топлива' },
                ...this.fuelLevelSensors,
                { divider: true },
                { header: 'Расходомеры топлива' },
                ...this.fuelFlowmeters,
                { divider: true },
                { header: 'Идентификация' },
                ...this.identification,
                { divider: true },
                { header: 'Дополнительное оборудование' },
                ...this.optionalEquipment
            ];
        }
    },
    methods: {
        addRow(count = 1) {
            this.addEditModCells(count);
            this.$emit('rowAdded', count);
        },
        deleteSelected() {
            const indices = this.selected.map(selectedRow => this.orderGPSData.findIndex(row => row.id === selectedRow.id));
            this.$emit('delete:rows', indices);
            this.deleteEditModCells(indices);
            this.selected = [];
        },
        addEditModCells(count, index = false) {
            if (!index) index = this.editModCells.length-1;
            for (let i = 0; i < count; ++i) {
                this.editModCells.splice(index + i, 0, Array.apply(null, {length: this.headers.length-1}).map(() => false));
            }
        },
        swapEditModCells(newIndex, oldIndex) {
            const rowSelected = this.editModCells.splice(oldIndex, 1)[0];
            this.editModCells.splice(newIndex, 0, rowSelected);
        },
        deleteEditModCells(indices) {
            this.editModCells = this.editModCells.filter((_, index) => !indices.includes(index));
        },
        onPickFile(ref) {
            this.$refs[ref].click();
        },
        onFilePicked(event, index) {
            const formData = new FormData();
            formData.append('image', event.target.files[0]);
            this.axios.post('/orders/image', formData)
                .then(({ data }) => {
                    this.setPreview(index, `/storage/${data}`);
                });
            this.$refs[`td-${index}-0`].click();
        },
        setPreview(index, imageName) {
            this.$emit('update:orderGPSData', imageName, index, 'image');
        },
        cornerFocused(event) {
            this.tableBody.addEventListener('mouseup', this.cornerBlurred, false);
            this.isCornerFocused = true;
            console.log('Focused');
        },
        cornerBlurred(event) {
            this.isCornerFocused = false;
            if (this.isReadyToCopy) {
                this.$emit('copy-values:orderGPSData', this.copyList);
                this.clickOnTD(this.findTDEl(event));
            }
            console.log('Blurred');
        },
        hideBordersAndCorner() {
            if (this.bordersSelectData.top.el &&
                this.bordersSelectData.left.el &&
                this.bordersSelectData.bottom.el &&
                this.bordersSelectData.right.el &&
                this.bordersSelectData.corner.el) {
                    this.bordersSelectData.top.styles.display = 'none';
                    this.bordersSelectData.left.styles.display = 'none';
                    this.bordersSelectData.bottom.styles.display = 'none';
                    this.bordersSelectData.right.styles.display = 'none';
                    this.bordersSelectData.corner.styles.display = 'none';
                    this.normalizeStylesSelectBordersAndCorner();
                }
        },
        createBorder(position, isCorner) {
            this.bordersSelectData[position].el = document.createElement('div');
            this.bordersSelectData[position].el.classList.add('border');
            this.bordersSelectData[position].el.classList.add('current');
            if (isCorner) {
                this.bordersSelectData[position].el.classList.add('corner');
                this.bordersSelectData[position].el.addEventListener('mousedown', this.cornerFocused, false);
            }
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
        normalizeCorner(anchorCoords, anchor) {
            this.bordersSelectData.corner.styles.top = `${anchorCoords.top + anchor.offsetHeight - 6}px`;
            this.bordersSelectData.corner.styles.left = `${anchorCoords.left + anchor.offsetWidth - 7}px`;
            this.bordersSelectData.corner.styles.display = 'block';
        },
        normalizeSelectBorders(anchorCoords, anchor) {
            this.bordersSelectData.top.styles.top = `${anchorCoords.top - this.bordersSelectData.top.el.offsetHeight}px`;
            this.bordersSelectData.top.styles.left = `${anchorCoords.left}px`;
            this.bordersSelectData.top.styles.width = `${anchorCoords.width}px`;
            this.bordersSelectData.top.styles.display = 'block';

            this.bordersSelectData.left.styles.top = `${anchorCoords.top}px`;
            this.bordersSelectData.left.styles.left = `${anchorCoords.left}px`;
            this.bordersSelectData.left.styles.height = `${anchorCoords.height}px`;
            this.bordersSelectData.left.styles.display = 'block';

            this.bordersSelectData.bottom.styles.top = `${anchorCoords.top + anchor.offsetHeight}px`;
            this.bordersSelectData.bottom.styles.left = `${anchorCoords.left}px`;
            this.bordersSelectData.bottom.styles.width = `${anchorCoords.width}px`;
            this.bordersSelectData.bottom.styles.display = 'block';

            this.bordersSelectData.right.styles.top = `${anchorCoords.top}px`;
            this.bordersSelectData.right.styles.left = `${anchorCoords.left + anchor.offsetWidth-2}px`;
            this.bordersSelectData.right.styles.height = `${anchorCoords.height}px`;
            this.bordersSelectData.right.styles.display = 'block';
        },
        normalizeStylesSelectBordersAndCorner() {
            this.setStyles(this.bordersSelectData.top.el, this.bordersSelectData.top.styles);
            this.setStyles(this.bordersSelectData.left.el, this.bordersSelectData.left.styles);
            this.setStyles(this.bordersSelectData.bottom.el, this.bordersSelectData.bottom.styles);
            this.setStyles(this.bordersSelectData.right.el, this.bordersSelectData.right.styles);
            this.setStyles(this.bordersSelectData.corner.el, this.bordersSelectData.corner.styles);
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

            this.normalizeSelectBorders(anchorCoords, anchor);
            this.normalizeCorner(anchorCoords, anchor);
            this.normalizeStylesSelectBordersAndCorner();

        },
        findTDEl(event) {
            let index = 0;
            for (let i = 0; event.path[i].tagName != 'TD'; ++i) {
                ++index;
            }
            return index === 0 ? event.target : event.path[index];
        },
        clickOnTD(td) {
            this.$nextTick(() => {
                td.click();
            });
        },
        resetCopyList(newCell) {
            this.copyList = [ [newCell] ];
        },
        selectCell(event, data) {
            const cell = this.findTDEl(event);
            this.positionBorders(cell);
            this.resetCopyList(data);
        },
        selectCellToCopyList(event, newCell) {
            if (!this.isCornerFocused) return;
            if (newCell.index < this.copyList[0][0].index || newCell.columnIndex < this.copyList[0][0].columnIndex) return;
            // const isPrice = newCell.column.endsWith('price');
            const isAddition = ((newCell.index > this.copyList[0][this.copyList[0].length - 1].index) || (newCell.columnIndex > this.copyList[this.copyList.length - 1][0].columnIndex));
            const isDeleteion = ((newCell.index < this.copyList[0][this.copyList[0].length - 1].index) || (newCell.columnIndex < this.copyList[this.copyList.length - 1][0].columnIndex));
            let isColumnExist = false;
            let isMoreToAllIndicesOfStartData = true;
            let isEqualToAllIndicesOfStartData = true;
            for (let i = 0; i < this.copyList.length; ++i) {
                isEqualToAllIndicesOfStartData = this.copyList[i][0].index === newCell.index && isEqualToAllIndicesOfStartData;
                isMoreToAllIndicesOfStartData = newCell.index > this.copyList[i][0].index && isMoreToAllIndicesOfStartData;
                if (!isColumnExist) {
                    isColumnExist = this.copyList[i][0].column === newCell.column;
                }
            }
            const currentCell = this.findTDEl(event);
            const currentCellCoords = this.getCoords(currentCell);
            if (isAddition) {
                if (isEqualToAllIndicesOfStartData && !isColumnExist) {
                    // Reset
                    for (let i = 0; i < this.copyList.length; ++i) {
                        this.copyList[i] = [this.copyList[i][0]];
                    }
                    this.bordersSelectData.bottom.styles.top = `${currentCellCoords.top + currentCell.offsetHeight}px`;
                    this.bordersSelectData.left.styles.height = `${currentCellCoords.height}px`;
                    this.bordersSelectData.right.styles.height = `${currentCellCoords.height}px`;
                    // Create start data
                    let columnIndex = this.copyList[this.copyList.length - 1][0].columnIndex + 1;
                    while (columnIndex <= newCell.columnIndex) {
                        // set styles
                        let currentCell = this.$refs[`td-${newCell.index}-${columnIndex}`];
                        let currentCellCoords = this.getCoords(currentCell);
                        this.bordersSelectData.top.styles.width = `${parseInt(this.bordersSelectData.top.styles.width) + currentCellCoords.width}px`;
                        this.bordersSelectData.right.styles.left = `${currentCellCoords.left + currentCell.offsetWidth-2}px`;
                        this.bordersSelectData.bottom.styles.width = `${parseInt(this.bordersSelectData.bottom.styles.width) + currentCellCoords.width}px`;
                        // fill with values
                        let column = this.headers[columnIndex+1].value;
                        // let value = newCell.column === 'image' ? false : this.orderGPSData[newCell.index][column];
                        this.copyList.push([{ index: newCell.index, column, columnIndex, value: this.orderGPSData[newCell.index][column] }]);
                        ++columnIndex;
                    }
                } else if (isMoreToAllIndicesOfStartData) {
                    if (isColumnExist) {
                        let isLeftAndRightStylesSet = false;
                        this.bordersSelectData.bottom.styles.top = `${currentCellCoords.top + currentCell.offsetHeight}px`;
                        // Cells in which need to insert the copy value
                        for (let i = 0; i < this.copyList.length; ++i) {
                            let index = this.copyList[i][this.copyList[i].length-1].index + 1;
                            while (index <= newCell.index) {
                                this.copyList[i].push({ index, column: this.copyList[i][0].column });
                                if (!isLeftAndRightStylesSet) {
                                    let currentCell = this.$refs[`td-${index}-${newCell.columnIndex}`];
                                    let currentCellCoords = this.getCoords(currentCell);
                                    this.bordersSelectData.left.styles.height = `${parseInt(this.bordersSelectData.left.styles.height) + currentCellCoords.height}px`;
                                    this.bordersSelectData.right.styles.height = `${parseInt(this.bordersSelectData.right.styles.height) + currentCellCoords.height}px`;
                                }
                                ++index;
                            }
                            isLeftAndRightStylesSet = true;
                        }
                    } else {
                        this.bordersSelectData.right.styles.left = `${currentCellCoords.left + currentCell.offsetWidth-2}px`;
                        // Create start data
                        let columnIndex = this.copyList[this.copyList.length-1][0].columnIndex + 1;
                        while (columnIndex <= newCell.columnIndex) {
                            let index = this.copyList[0][0].index;
                            let column = this.headers[columnIndex+1].value;
                            let currentCell = this.$refs[`td-${index}-${columnIndex}`];
                            let currentCellCoords = this.getCoords(currentCell);
                            this.bordersSelectData.top.styles.width = `${parseInt(this.bordersSelectData.top.styles.width) + currentCellCoords.width}px`;
                            this.bordersSelectData.bottom.styles.width = `${parseInt(this.bordersSelectData.bottom.styles.width) + currentCellCoords.width}px`;
                            this.copyList.push([{ index, column, columnIndex, value: this.orderGPSData[index][column] }]);
                            for (let i = 1; i < this.copyList[0].length; ++i) {
                                ++index;
                                this.copyList[this.copyList.length-1].push({ index, column });
                            }
                            ++columnIndex;
                        }
                        if (newCell.index > this.copyList[0][this.copyList[0].length-1].index) {
                            this.bordersSelectData.bottom.styles.top = `${currentCellCoords.top + currentCell.offsetHeight}px`;
                            // Cells in which need to insert the copy value
                            let index = this.copyList[0][this.copyList[0].length-1].index + 1;
                            while (index <= newCell.index) {
                                let currentCell = this.$refs[`td-${index}-${newCell.columnIndex}`];
                                let currentCellCoords = this.getCoords(currentCell);
                                this.bordersSelectData.left.styles.height = `${parseInt(this.bordersSelectData.left.styles.height) + currentCellCoords.height}px`;
                                this.bordersSelectData.right.styles.height = `${parseInt(this.bordersSelectData.right.styles.height) + currentCellCoords.height}px`;
                                for (let i = 0; i < this.copyList.length; ++i) {
                                    this.copyList[i].push({ index, column: this.copyList[i][0].column });
                                }
                                ++index;
                            }
                        }
                    }
                }
            }
            if (isDeleteion) {
                if (newCell.index < this.copyList[0][this.copyList[0].length-1].index) {
                    this.bordersSelectData.bottom.styles.top = `${currentCellCoords.top + currentCell.offsetHeight}px`;

                    let index = this.copyList[0][this.copyList[0].length-1].index;
                    while (index > newCell.index) {
                        let currentCell = this.$refs[`td-${index}-${newCell.columnIndex}`];
                        let currentCellCoords = this.getCoords(currentCell);
                        this.bordersSelectData.left.styles.height = `${parseInt(this.bordersSelectData.left.styles.height) - currentCellCoords.height}px`;
                        this.bordersSelectData.right.styles.height = `${parseInt(this.bordersSelectData.right.styles.height) - currentCellCoords.height}px`;
                        for (let i = 0; i < this.copyList.length; ++i) {
                            this.copyList[i].splice(this.copyList[i].length-1, 1);
                        }
                        --index;
                    }
                }
                if (newCell.columnIndex < this.copyList[this.copyList.length - 1][0].columnIndex) {
                    this.bordersSelectData.right.styles.left = `${currentCellCoords.left + currentCell.offsetWidth-2}px`;
                    // Delete column
                    // const indexForDeletion = this.copyList.findIndex((copies) => copies[0].columnIndex === newCell.columnIndex + 1);
                    let columnIndex = this.copyList[this.copyList.length - 1][0].columnIndex;
                    while (columnIndex > newCell.columnIndex) {
                        let currentCell = this.$refs[`td-${newCell.index}-${columnIndex}`];
                        let currentCellCoords = this.getCoords(currentCell);
                        this.bordersSelectData.top.styles.width = `${parseInt(this.bordersSelectData.top.styles.width) - currentCellCoords.width}px`;
                        this.bordersSelectData.bottom.styles.width = `${parseInt(this.bordersSelectData.bottom.styles.width) - currentCellCoords.width}px`;
                        this.copyList.splice(this.copyList.length - 1, 1);
                        --columnIndex;
                    }
                }
            }
            this.normalizeCorner(currentCellCoords, currentCell);
            this.normalizeStylesSelectBordersAndCorner();
        },
        switchCellMode(row, cell, mode, refName, event, autofocus = true) {
            this.$set(this.editModCells[row], cell, mode);
            if (autofocus && this.editModCells[row][cell]) {
                this.$nextTick(() => {
                    this.$refs[refName].$el.querySelector('input').click();
                });
            } else if (!autofocus && event) {
                this.clickOnTD(this.findTDEl(event));
            }
        },
        setCellValue(data, row, cell, name, td, nestedPath = false, forceSwitchMode = true) {
            this.$emit('update:orderGPSData', data, row, name, nestedPath);
            if (forceSwitchMode) this.switchCellMode(row, cell, false);
            if (td) {
                this.clickOnTD(this.$refs[td]);
            }
        },
        addNestedData(event, row, column) {
            this.$emit('add-nested-data:orderGPSData', row, column);
            this.clickOnTD(this.findTDEl(event));
        },
        deleteOrderNestedData(event, row, column, index) {
            this.$emit('delete-nested-data:orderGPSData', row, column, index);
            this.clickOnTD(this.findTDEl(event));
        },
        close(ref) {
            this.$refs[ref].blur()
        },
        isShowDivider(index, arr) {
            if (this.isUndefined(arr[index]) || this.isNull(arr[index])) return false;
            const rest = arr.slice(index+1);
            if (rest.length === 0) return false;
            if (rest.every(el => this.isUndefined(el) || this.isNull(el))) return false;
            return true;
        }
    },
    created() {
        this.addEditModCells(this.orderGPSData.length);
        this.addRow(this.defaultRowCount);
    },
    mounted() {
        const tableBody = document.querySelector('#gps-data-table .v-datatable tbody');
        this.tableBody = tableBody;
        tableBody.classList.add('gps-data-tbody');
        const _self = this;
        // document.addEventListener('click', function(event) {
        //     let target = event.target;
        //     while (target !== document) {
        //         console.log('IN EVENT TAGNAME: ', target.tagName);
        //         console.log('IN EVENT TARGET: ', target);
        //         if (target.tagName === 'TBODY') return;
        //         target = target.parentNode;
        //     }
        //     console.log('IN EVENT AND HIDE');
        //     // if (event.target.closest('.gps-data-tbody')) return;
        //     _self.hideBordersAndCorner();
        // }, false);

        Sortable.create(tableBody, {
            handle: '.handle',
            onEnd({ newIndex, oldIndex }) {
                _self.$emit('drag-n-drop-gps-data', newIndex, oldIndex);
                _self.swapEditModCells(newIndex, oldIndex);
            }
        });
        const tableOverflow = document.querySelector('#gps-data-table .v-table__overflow');

        const borders = document.createElement('div');
        this.setStyles(borders, { position: 'absolute', top: 0, left: 0 });
        this.bordersWrapper = borders;
        tableOverflow.appendChild(borders)
    }
};
</script>

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
    #gps-data-table table tr:first-child td {
        border-top: 1px solid rgba(202, 202, 202, 0.5);
    }
    #gps-data-table table td {
        display: table-cell;
        padding: 0 4px;
        border-right: 1px solid rgba(202, 202, 202, 0.5);
        border-bottom: 1px solid rgba(202, 202, 202, 0.5);
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
        transition-property: left, top, width, height;
        transition-duration: 0.1s, 0.1s, 0.1s, 0.1s;
        transition-timing-function: cubic-bezier(.89,1.2,.85,.94);
        user-select: none;
    }
    .border .current {
        z-index: 10;
    }
    .corner {
        font-size: 0;
        cursor: crosshair;
        user-select: contain;
        width: 12px;
        height: 12px;
        border: 1px solid rgb(255, 255, 255);
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
