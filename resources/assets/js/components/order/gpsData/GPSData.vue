<template>
    <v-card class="elevation-0">
         <v-card-title>
            <v-card flat>
                <v-layout wrap align-start>
                    <v-flex xs12 sm3>
                        <v-text-field
                            v-model="count"
                            :error-messages="countErrors"
                            label="Количество"
                            type="number"
                            min="1">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 sm3>
                        <v-btn
                            @click="addRow(count)"
                            color="info"
                            :block="$vuetify.breakpoint.xsOnly">
                            Добавить
                        </v-btn>
                    </v-flex>
                    <v-flex xs12 sm5>
                        <v-btn
                            @click="deleteSelected"
                            color="error"
                            :block="$vuetify.breakpoint.xsOnly">
                            Удалить выбранные
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-card>
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
                        class="text-xs-center"
                        :ref="`td-${props.index}-${0}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'multiplier', columnIndex: 0, value: props.item.multiplier })"
                        @click="selectCell($event, { index: props.index, column: 'multiplier', columnIndex: 0, value: props.item.multiplier })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'multiplier', columnIndex: 0, value: props.item.multiplier })">
                        <v-text-field
                            :ref="`multiplier-${props.index}-${0}`"
                            v-validate="'required|min_value:1|numeric'"
                            :data-vv-name="`multiplier-${props.index}`"
                            data-vv-as=" "
                            :error-messages="errors.collect(`multiplier-${props.index}`)"
                            :value="props.item.multiplier"
                            @input="setCellValue($event, props.index, 0, 'multiplier', `td-${props.index}-${0}`)"
                            label="Умножитель"
                            required
                            single-line
                            type="number"
                            min="1"
                        ></v-text-field>
                        <v-btn
                            class="spread-row-btn"
                            color="info"
                            small
                            @click.stop="spreadRow(props.index)">
                            Разложить
                        </v-btn>
                    </td>
                    <td
                        class="text-xs-center"
                        :class="{ 'error-cell': errors.has(`transport-image-${props.index}`) }"
                        :ref="`td-${props.index}-${1}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'image', columnIndex: 1, value: props.item.image })"
                        @click="selectCell($event, { index: props.index, column: 'image', columnIndex: 1, value: props.item.image })"
                        @mouseenter="selectCellToCopyList($event, { index: props.index, column: 'image', columnIndex: 1, value: props.item.image })">
                        <img
                            @dblclick="onPickFile(`image-${props.index}`)"
                            v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && onPickFile(`image-${props.index}`)"
                            :style="{cursor: 'pointer', 'margin-top': props.item.image === '' ? '6px' : false, 'max-width': props.item.image === '' ? '40%' : '80%'}"
                            :src="props.item.image === '' ? uploadImage : props.item.image"
                            alt="image">
                        <input
                            :ref="`image-${props.index}`"
                            v-validate="'image'"
                            data-vv-as=" "
                            :data-vv-name="`image-${props.index}`"
                            @change="onFilePicked($event, props.index)"
                            style="display:none;"
                            type="file">
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${2}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'type', columnIndex: 2, value: props.item.type })"
                        @click="selectCell($event, { index: props.index, column: 'type', columnIndex: 2, value: props.item.type })"
                        @dblclick="switchCellMode(props.index, 2, true, `type-${props.index}-${2}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 2, true, `type-${props.index}-${2}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'type', columnIndex: 2, value: props.item.type })">
                        <template v-if="!editModCells[props.index][2]">
                            {{ getTypeText(props.item.type) }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`type-${props.index}-${2}`"
                                :value="props.item.type"
                                @change="setCellValue($event, props.index, 2, 'type', `td-${props.index}-${2}`)"
                                :items="transportTypesWithCache"
                                item-text="name"
                                item-value="value"
                                :return-object="false"
                                label="Вибирете тип"
                                single-line>
                                <template slot="no-data">
                                    <v-list-tile>
                                        <v-list-tile-content>
                                        <v-list-tile-title>
                                            Нет результатов. Нажмите <kbd>enter</kbd> чтоб создать новый.
                                        </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </template>
                                <template
                                    slot="item"
                                    slot-scope="{ index, item, parent }">
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ item.name }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-spacer></v-spacer>
                                    <v-list-tile-action @click.stop v-if="item.isCache">
                                        <v-btn
                                            icon
                                            @click.stop.prevent="$emit('delete:cache', item.id)">
                                        <v-icon>clear</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </template>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 2, false, `type-${props.index}-${2}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${3}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'mark', columnIndex: 3, value: props.item.mark })"
                        @click="selectCell($event, { index: props.index, column: 'mark', columnIndex: 3, value: props.item.mark })"
                        @dblclick="switchCellMode(props.index, 3, true, `mark-${props.index}-${3}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 3, true, `mark-${props.index}-${3}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'mark', columnIndex: 3, value: props.item.mark })">
                        <template v-if="!editModCells[props.index][3]">
                            {{ props.item.mark }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`mark-${props.index}-${3}`"
                                :value="props.item.mark"
                                @change="setCellValue($event, props.index, 3, 'mark', `td-${props.index}-${3}`)"
                                :items="[...(isUndefined(transport[props.item.type]) ? Object.keys(transport).reduce((marks, type) => [...marks, ...transport[type]], []) : transport[props.item.type]), ...markCache]"
                                item-text="name"
                                item-value="name"
                                :return-object="false"
                                label="Вибирете марку"
                                single-line>
                                <template slot="no-data">
                                    <v-list-tile>
                                        <v-list-tile-content>
                                        <v-list-tile-title>
                                            Нет результатов. Нажмите <kbd>enter</kbd> чтоб создать новый.
                                        </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </template>
                                <template
                                    slot="item"
                                    slot-scope="{ index, item, parent }">
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ item.name }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-spacer></v-spacer>
                                    <v-list-tile-action @click.stop v-if="item.isCache">
                                        <v-btn
                                            icon
                                            @click.stop.prevent="$emit('delete:cache', item.id)">
                                        <v-icon>clear</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </template>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 3, false, `mark-${props.index}-${3}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${4}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'model', columnIndex: 4, value: props.item.model })"
                        @click="selectCell($event, { index: props.index, column: 'model', columnIndex: 4, value: props.item.model })"
                        @dblclick="switchCellMode(props.index, 4, true, `model-${props.index}-${4}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 4, true, `model-${props.index}-${4}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'model', columnIndex: 4, value: props.item.model })">
                        <template v-if="!editModCells[props.index][4]">
                            {{ props.item.model }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`model-${props.index}-${4}`"
                                :value="props.item.model"
                                @change="setCellValue($event, props.index, 4, 'model', `td-${props.index}-${4}`)"
                                :items="cachedData.model"
                                item-text="value"
                                item-value="value"
                                :return-object="false"
                                label="Вибирете модель"
                                single-line>
                                <template slot="no-data">
                                    <v-list-tile>
                                        <v-list-tile-content>
                                        <v-list-tile-title>
                                            Нет результатов. Нажмите <kbd>enter</kbd> чтоб создать новый.
                                        </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </template>
                                <template
                                    slot="item"
                                    slot-scope="{ index, item, parent }">
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ item.value }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-spacer></v-spacer>
                                    <v-list-tile-action @click.stop>
                                        <v-btn
                                            icon
                                            @click.stop.prevent="$emit('delete:cache', item.id)">
                                        <v-icon>clear</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </template>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 4, false, `model-${props.index}-${4}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${5}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'year_of_issue', columnIndex: 5, value: props.item.year_of_issue })"
                        @click="selectCell($event, { index: props.index, column: 'year_of_issue', columnIndex: 5, value: props.item.year_of_issue })"
                        @dblclick="switchCellMode(props.index, 5, true, `year_of_issue-${props.index}-${5}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 5, true, `year_of_issue-${props.index}-${5}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'year_of_issue', columnIndex: 5, value: props.item.year_of_issue })">
                        <template v-if="!editModCells[props.index][5]">
                            {{ props.item.year_of_issue }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`year_of_issue-${props.index}-${5}`"
                                :value="props.item.year_of_issue"
                                @change="setCellValue($event, props.index, 5, 'year_of_issue', `td-${props.index}-${5}`)"
                                :items="Array.apply(null, { length: 100 }).map((_, i) => 1950 + i)"
                                label="Вибирете год выпуска"
                                auto
                                single-line>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 5, false, `year_of_issue-${props.index}-${5}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${6}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'fuel_type', columnIndex: 6, value: props.item.fuel_type })"
                        @click="selectCell($event, { index: props.index, column: 'fuel_type', columnIndex: 6, value: props.item.fuel_type })"
                        @dblclick="switchCellMode(props.index, 6, true, `fuel_type-${props.index}-${6}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 6, true, `fuel_type-${props.index}-${6}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'fuel_type', columnIndex: 6, value: props.item.fuel_type })">
                        <template v-if="!editModCells[props.index][6]">
                            {{ props.item.fuel_type }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`fuel_type-${props.index}-${6}`"
                                :value="props.item.fuel_type"
                                @change="setCellValue($event, props.index, 6, 'fuel_type', `td-${props.index}-${6}`)"
                                :items="cachedData.fuel_type"
                                item-text="value"
                                item-value="value"
                                :return-object="false"
                                label="Вибирете Тип топлива"
                                single-line>
                                <template slot="no-data">
                                    <v-list-tile>
                                        <v-list-tile-content>
                                        <v-list-tile-title>
                                            Нет результатов. Нажмите <kbd>enter</kbd> чтоб создать новый.
                                        </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </template>
                                <template
                                    slot="item"
                                    slot-scope="{ index, item, parent }">
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ item.value }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-spacer></v-spacer>
                                    <v-list-tile-action @click.stop>
                                        <v-btn
                                            icon
                                            @click.stop.prevent="$emit('delete:cache', item.id)">
                                        <v-icon>clear</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </template>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 6, false, `fuel_type-${props.index}-${6}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${7}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'power', columnIndex: 7, value: props.item.power })"
                        @click="selectCell($event, { index: props.index, column: 'power', columnIndex: 7, value: props.item.power })"
                        @dblclick="switchCellMode(props.index, 7, true, `power-${props.index}-${7}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 7, true, `power-${props.index}-${7}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'power', columnIndex: 7, value: props.item.power })">
                        <template v-if="!editModCells[props.index][7]">
                            {{ props.item.power }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`power-${props.index}-${7}`"
                                :value="props.item.power"
                                @change="setCellValue($event, props.index, 7, 'power', `td-${props.index}-${7}`)"
                                :items="cachedData.power"
                                item-text="value"
                                item-value="value"
                                :return-object="false"
                                hide-selected
                                label="Вибирете мощность"
                                single-line>
                                <template slot="no-data">
                                    <v-list-tile>
                                        <v-list-tile-content>
                                        <v-list-tile-title>
                                            Нет результатов. Нажмите <kbd>enter</kbd> чтоб создать новый.
                                        </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </template>
                                <template
                                    slot="item"
                                    slot-scope="{ index, item, parent }">
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ item.value }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-spacer></v-spacer>
                                    <v-list-tile-action @click.stop>
                                        <v-btn
                                            icon
                                            @click.stop.prevent="$emit('delete:cache', item.id)">
                                        <v-icon>clear</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </template>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 7, false, `power-${props.index}-${7}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${8}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'number', columnIndex: 8, value: props.item.number })"
                        @click="selectCell($event, { index: props.index, column: 'number', columnIndex: 8, value: props.item.number })"
                        @dblclick="switchCellMode(props.index, 8, true, `number-${props.index}-${8}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 8, true, `number-${props.index}-${8}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'number', columnIndex: 8, value: props.item.number })">
                        <template v-if="!editModCells[props.index][8]">
                            {{ props.item.number }}
                        </template>
                        <template v-else>
                            <v-combobox
                                :ref="`number-${props.index}-${8}`"
                                :value="props.item.number"
                                @change="setCellValue($event, props.index, 8, 'number', `td-${props.index}-${8}`)"
                                :items="cachedData.number"
                                item-text="value"
                                item-value="value"
                                :return-object="false"
                                hide-selected
                                label="Вибирете гос. номер"
                                single-line>
                                <template slot="no-data">
                                    <v-list-tile>
                                        <v-list-tile-content>
                                        <v-list-tile-title>
                                            Нет результатов. Нажмите <kbd>enter</kbd> чтоб создать новый.
                                        </v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </template>
                                <template
                                    slot="item"
                                    slot-scope="{ index, item, parent }">
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{ item.value }}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-spacer></v-spacer>
                                    <v-list-tile-action @click.stop>
                                        <v-btn
                                            icon
                                            @click.stop.prevent="$emit('delete:cache', item.id)">
                                        <v-icon>clear</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </template>
                            </v-combobox>
                            <v-btn color="info" small @click="switchCellMode(props.index, 8, false, `number-${props.index}-${8}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${9}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'gps_tracker', columnIndex: 9, value: props.item.gps_tracker })"
                        @click="selectCell($event, { index: props.index, column: 'gps_tracker', columnIndex: 9, value: props.item.gps_tracker })"
                        @dblclick="switchCellMode(props.index, 9, true, `gps_tracker-${props.index}-${9}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 9, true, `gps_tracker-${props.index}-${9}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'gps_tracker', columnIndex: 9, value: props.item.gps_tracker })">
                        <template v-if="!editModCells[props.index][9]">
                            {{ props.item.gps_tracker.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`gps_tracker-${props.index}-${9}`"
                                :value="props.item.gps_tracker"
                                @change="setCellValue($event, props.index, 9, 'gps_tracker', `td-${props.index}-${9}`)"
                                :items="gpsTrackersWithHeader"
                                item-text="name"
                                hide-selected
                                label="Вибирете GPS-трекер"
                                single-line
                                return-object>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 9, false, `gps_tracker-${props.index}-${9}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${10}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'gps_tracker_price', columnIndex: 10, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'gps_tracker_price', columnIndex: 10, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'gps_tracker_price', columnIndex: 10, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['gps_tracker_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][11] }"
                        :ref="`td-${props.index}-${11}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'fuel_gauge', columnIndex: 11, value: props.item.fuel_gauge })"
                        :style="{ 'min-width': editModCells[props.index][11] ? '300px' : '11px' }"
                        @click="selectCell($event, { index: props.index, column: 'fuel_gauge', columnIndex: 11, value: props.item.fuel_gauge })"
                        @dblclick="switchCellMode(props.index, 11, true, `fuel_gauge-${props.index}-${11}`, $event, false)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 11, true, `fuel_gauge-${props.index}-${11}`, event.srcEvent, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'fuel_gauge', columnIndex: 11, value: props.item.fuel_gauge })">
                        <template v-if="!editModCells[props.index][11]">
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
                                            :ref="`fuel_gauge-${props.index}-${11}`"
                                            :value="props.item.fuel_gauge[inputIndex]"
                                            @change="setCellValue($event, props.index, 11, 'fuel_gauge', `td-${props.index}-${11}`, inputIndex, false)"
                                            :items="fuelLevelSensorsWithHeader"
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
                                    <v-btn color="info" small @click="switchCellMode(props.index, 11, false, `fuel_gauge-${props.index}-${11}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${12}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'fuel_gauge_price', columnIndex: 12, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'fuel_gauge_price', columnIndex: 12, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'fuel_gauge_price', columnIndex: 12, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['fuel_gauge_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${13}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'counter', columnIndex: 13, value: props.item.counter })"
                        @click="selectCell($event, { index: props.index, column: 'counter', columnIndex: 13, value: props.item.counter })"
                        @dblclick="switchCellMode(props.index, 13, true, `counter-${props.index}-${13}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 13, true, `counter-${props.index}-${13}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'counter', columnIndex: 13, value: props.item.counter })">
                        <template v-if="!editModCells[props.index][13]">
                            {{ props.item.counter.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`counter-${props.index}-${13}`"
                                :value="props.item.counter"
                                @change="setCellValue($event, props.index, 13, 'counter', `td-${props.index}-${13}`)"
                                :items="fuelFlowmetersWithHeader"
                                item-text="name"
                                hide-selected
                                label="Вибирете счетчик"
                                single-line
                                return-object>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 13, false, `counter-${props.index}-${13}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${14}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'counter_price', columnIndex: 14, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'counter_price', columnIndex: 14, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'counter_price', columnIndex: 14, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['counter_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${15}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'rf_id', columnIndex: 15, value: props.item.rf_id })"
                        @click="selectCell($event, { index: props.index, column: 'rf_id', columnIndex: 15, value: props.item.rf_id })"
                        @dblclick="switchCellMode(props.index, 15, true, `rf_id-${props.index}-${15}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 15, true, `rf_id-${props.index}-${15}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rf_id', columnIndex: 15, value: props.item.rf_id })">
                        <template v-if="!editModCells[props.index][15]">
                            {{ props.item.rf_id.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`rf_id-${props.index}-${15}`"
                                :value="props.item.counter"
                                @change="setCellValue($event, props.index, 15, 'rf_id', `td-${props.index}-${15}`)"
                                :items="identificationWithHeader"
                                item-text="name"
                                hide-selected
                                label="Вибирете RFID"
                                single-line
                                return-object>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 15, false, `rf_id-${props.index}-${15}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${16}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'rf_id_price', columnIndex: 16, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'rf_id_price', columnIndex: 16, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rf_id_price', columnIndex: 16, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['rf_id_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${17}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'reader_of_trailed_equipment', columnIndex: 17, value: props.item.reader_of_trailed_equipment })"
                        @click="selectCell($event, { index: props.index, column: 'reader_of_trailed_equipment', columnIndex: 17, value: props.item.reader_of_trailed_equipment })"
                        @dblclick="switchCellMode(props.index, 17, true, `reader_of_trailed_equipment-${props.index}-${17}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 17, true, `reader_of_trailed_equipment-${props.index}-${17}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'reader_of_trailed_equipment', columnIndex: 17, value: props.item.reader_of_trailed_equipment })">
                        <template v-if="!editModCells[props.index][17]">
                            {{ props.item.reader_of_trailed_equipment.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`reader_of_trailed_equipment-${props.index}-${17}`"
                                :value="props.item.reader_of_trailed_equipment"
                                @change="setCellValue($event, props.index, 17, 'reader_of_trailed_equipment', `td-${props.index}-${17}`)"
                                :items="identificationWithHeader"
                                item-text="name"
                                hide-selected
                                label="Вибирете считыватель прицепного оборудования"
                                single-line
                                return-object>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 17, false, `reader_of_trailed_equipment-${props.index}-${17}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${18}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'reader_of_trailed_equipment_price', columnIndex: 18, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'reader_of_trailed_equipment_price', columnIndex: 18, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'reader_of_trailed_equipment_price', columnIndex: 18, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['reader_of_trailed_equipment_price'] || 0 : 0 }}$
                    </td>
                    <!-- <td
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
                    </td> -->
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${19}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'can_reader', columnIndex: 19, value: props.item.can_reader })"
                        @click="selectCell($event, { index: props.index, column: 'can_reader', columnIndex: 19, value: props.item.can_reader })"
                        @dblclick="switchCellMode(props.index, 19, true, `can_reader-${props.index}-${19}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 19, true, `can_reader-${props.index}-${19}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'can_reader', columnIndex: 19, value: props.item.can_reader })">
                        <template v-if="!editModCells[props.index][19]">
                            {{ props.item.can_reader.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`can_reader-${props.index}-${19}`"
                                :value="props.item.can_reader"
                                @change="setCellValue($event, props.index, 19, 'can_reader', `td-${props.index}-${19}`)"
                                :items="optionalEquipment"
                                item-text="name"
                                hide-selected
                                label="Вибирете CAN"
                                single-line
                                return-object>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 19, false, `can_reader-${props.index}-${19}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${20}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'can_reader_price', columnIndex: 20, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'can_reader_price', columnIndex: 20, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'can_reader_price', columnIndex: 20, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['can_reader_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${21}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'deaerator_small', columnIndex: 21, value: props.item.deaerator_small })"
                        @click="selectCell($event, { index: props.index, column: 'deaerator_small', columnIndex: 21, value: props.item.deaerator_small })"
                        @dblclick="switchCellMode(props.index, 21, true, `deaerator_small-${props.index}-${21}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 21, true, `deaerator_small-${props.index}-${21}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'deaerator_small', columnIndex: 21, value: props.item.deaerator_small })">
                        <template v-if="!editModCells[props.index][21]">
                            {{ props.item.deaerator_small.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`deaerator_small-${props.index}-${21}`"
                                :value="props.item.deaerator_small"
                                @change="setCellValue($event, props.index, 21, 'deaerator_small', `td-${props.index}-${21}`)"
                                :items="fuelFlowmetersWithHeader"
                                item-text="name"
                                hide-selected
                                label="Вибирете деаэратор"
                                single-line
                                return-object>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 21, false, `deaerator_small-${props.index}-${21}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${22}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'deaerator_small_price', columnIndex: 22, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'deaerator_small_price', columnIndex: 22, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'deaerator_small_price', columnIndex: 22, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['deaerator_small_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${23}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'deaerator_large', columnIndex: 23, value: props.item.deaerator_large })"
                        @click="selectCell($event, { index: props.index, column: 'deaerator_large', columnIndex: 23, value: props.item.deaerator_large })"
                        @dblclick="switchCellMode(props.index, 23, true, `deaerator_large-${props.index}-${23}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 23, true, `deaerator_large-${props.index}-${23}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'deaerator_large', columnIndex: 23, value: props.item.deaerator_large })">
                        <template v-if="!editModCells[props.index][23]">
                            {{ props.item.deaerator_large.name }}
                        </template>
                        <template v-else>
                            <v-autocomplete
                                :ref="`deaerator_large-${props.index}-${23}`"
                                :value="props.item.deaerator_large"
                                @change="setCellValue($event, props.index, 23, 'deaerator_large', `td-${props.index}-${23}`)"
                                :items="fuelFlowmetersWithHeader"
                                item-text="name"
                                hide-selected
                                label="Вибирете деаэратор"
                                single-line
                                return-object>
                            </v-autocomplete>
                            <v-btn color="info" small @click="switchCellMode(props.index, 23, false, `deaerator_large-${props.index}-${23}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${24}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'deaerator_large_price', columnIndex: 24, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'deaerator_large_price', columnIndex: 24, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'deaerator_large_price', columnIndex: 24, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['deaerator_large_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][25] }"
                        :ref="`td-${props.index}-${25}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'cn03', columnIndex: 25, value: props.item.cn03 })"
                        :style="{ 'min-width': editModCells[props.index][25] ? '300px' : '10px' }"
                        @click="selectCell($event, { index: props.index, column: 'cn03', columnIndex: 25, value: props.item.cn03 })"
                        @dblclick="switchCellMode(props.index, 25, true, `cn03-${props.index}-${25}`, $event, false)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 25, true, `cn03-${props.index}-${25}`, event.srcEvent, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'cn03', columnIndex: 25, value: props.item.cn03 })">
                        <template v-if="!editModCells[props.index][25]">
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
                                            :ref="`cn03-${props.index}-${25}`"
                                            :value="props.item.cn03[inputIndex]"
                                            @change="setCellValue($event, props.index, 25, 'cn03', `td-${props.index}-${25}`, inputIndex, false)"
                                            :items="optionalEquipmentWithHeader"
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
                                    <v-btn color="info" small @click="switchCellMode(props.index, 25, false, `cn03-${props.index}-${25}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${26}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'cn03_price', columnIndex: 26, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'cn03_price', columnIndex: 26, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'cn03_price', columnIndex: 26, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['cn03_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][27] }"
                        :ref="`td-${props.index}-${27}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'rs01', columnIndex: 27, value: props.item.rs01 })"
                        :style="{ 'min-width': editModCells[props.index][27] ? '300px' : '10px' }"
                        @click="selectCell($event, { index: props.index, column: 'rs01', columnIndex: 27, value: props.item.rs01 })"
                        @dblclick="switchCellMode(props.index, 27, true, `rs01-${props.index}-${27}`, $event, false)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 27, true, `rs01-${props.index}-${27}`, event.srcEvent, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rs01', columnIndex: 27, value: props.item.rs01 })">
                        <template v-if="!editModCells[props.index][27]">
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
                                            :ref="`rs01-${props.index}-${27}`"
                                            :value="props.item.rs01[inputIndex]"
                                            @change="setCellValue($event, props.index, 27, 'rs01', `td-${props.index}-${27}`, inputIndex, false)"
                                            :items="identificationWithHeader"
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
                                    <v-btn color="info" small @click="switchCellMode(props.index, 27, false, `rs01-${props.index}-${27}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${28}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'rs01_price', columnIndex: 28, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'rs01_price', columnIndex: 28, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'rs01_price', columnIndex: 28, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['rs01_price'] || 0 : 0 }}$
                    </td>
                    <td
                        :class="{ 'text-xs-center': !editModCells[props.index][29] }"
                        :ref="`td-${props.index}-${29}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'additional_equipment', columnIndex: 29, value: props.item.additional_equipment })"
                        :style="{ 'min-width': editModCells[props.index][29] ? '300px' : '10px' }"
                        @click="selectCell($event, { index: props.index, column: 'additional_equipment', columnIndex: 29, value: props.item.additional_equipment })"
                        @dblclick="switchCellMode(props.index, 29, true, `additional_equipment-${props.index}-${29}`, $event, false)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 29, true, `additional_equipment-${props.index}-${29}`, event.srcEvent, false)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'additional_equipment', columnIndex: 29, value: props.item.additional_equipment })">
                        <template v-if="!editModCells[props.index][29]">
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
                                            :ref="`additional_equipment-${props.index}-${29}`"
                                            :value="props.item.additional_equipment[inputIndex]"
                                            @change="setCellValue($event, props.index, 29, 'additional_equipment', `td-${props.index}-${29}`, inputIndex, false)"
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
                                    <v-btn color="info" small @click="switchCellMode(props.index, 29, false, `additional_equipment-${props.index}-${29}`, $event, false)">
                                        Закрыть редактирование
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </template>
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${30}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'additional_equipment_price', columnIndex: 30, value: false })"
                        @click="selectCell($event, { index: props.index, column: 'additional_equipment_price', columnIndex: 30, value: false })"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'additional_equipment_price', columnIndex: 30, value: false })">
                        {{ pricesForEquipment.equipmentPrices[props.index] ? pricesForEquipment.equipmentPrices[props.index]['additional_equipment_price'] || 0 : 0 }}$
                    </td>
                    <td
                        class="text-xs-center"
                        :ref="`td-${props.index}-${31}`"
                        :data-formobile="isMobileDevice && JSON.stringify({ index: props.index, column: 'manual_installation_price', columnIndex: 31, value: props.item.manual_installation_price })"
                        @click="selectCell($event, { index: props.index, column: 'manual_installation_price', columnIndex: 31, value: props.item.manual_installation_price })"
                        @dblclick="switchCellMode(props.index, 31, true, `manual_installation_price-${props.index}-${31}`)"
                        v-hammer:tap="event => isMobileDevice && event.tapCount == 2 && switchCellMode(props.index, 31, true, `manual_installation_price-${props.index}-${31}`)"
                        @mouseover="selectCellToCopyList($event, { index: props.index, column: 'manual_installation_price', columnIndex: 31, value: props.item.manual_installation_price })">
                        <template v-if="!editModCells[props.index][31]">
                            {{ pricesForEquipment.installationPrices[props.index] }}₴
                        </template>
                        <template v-else>
                            <v-text-field
                                v-validate="'decimal:2|min_value:0'"
                                :data-vv-name="`manual_installation_price-${props.index}`"
                                :error="errors.has(`manual_installation_price-${props.index}`)"
                                :ref="`manual_installation_price-${props.index}-${31}`"
                                :value="props.item.manual_installation_price"
                                @change="setCellValue($event, props.index, 31, 'manual_installation_price', `td-${props.index}-${31}`)"
                                label="Цена монтажа"
                                single-line>
                            </v-text-field>
                            <v-btn color="info" small @click="switchCellMode(props.index, 31, false, `manual_installation_price-${props.index}-${31}`, $event, false)">
                                Закрыть редактирование
                            </v-btn>
                        </template>
                    </td>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
import dcopy from 'deep-copy';
import Sortable from 'sortablejs';
import MobileDetect from 'mobile-detect';
import setStyles from './../../../mixins/stylesMixins.js';
import utils from './../../../mixins/utils.js';
import * as transport from './../../../constants/transport.js';
import { uploadImage } from './../../../constants/images.js';

export default {
    mixins: [setStyles, utils],
    props: {
        validator: {
            type: Object,
            required: true
        },
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
            count: 1,
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
                    styles: { height: '0px', width: '0px', display: 'block', top: '0px', left: '0px' }
                }
            },
            transportTypes: [
                { name: 'Трактор', value: transport.TRACTORS },
                { name: 'Комбайн', value: transport.COMBINES },
                { name: 'Опрыскиватель', value: transport.SPRAYERS }
            ],
            transport: {
                [transport.TRACTORS]: [
                    { name: 'John Deere', image: '/tractors/JohnDeere.png' },
                    { name: 'New Holland', image: '/tractors/NewHolland.png' },
                    { name: 'Massey Ferguson', image: '/tractors/MasseyFerguson.png' },
                    { name: 'Case IH', image: '/tractors/CaseIH.jpg' },
                    { name: 'Claas', image: '/tractors/Claas.png' },
                    { name: 'Challenger', image: '/tractors/Challenger.png' },
                    { name: 'Deutz-Fahr', image: '/tractors/Deutz-Fahr.png' },
                    { name: 'Fendt', image: '/tractors/Fendt.png' },
                    { name: 'JCB', image: '/tractors/JCB.png' },
                    { name: 'Valtra', image: '/tractors/Valtra.png' },
                    { name: 'МТЗ', image: '/tractors/MTZ.png' },
                    { name: 'ХТЗ', image: '/tractors/XTZ.png' }
                ],
                [transport.COMBINES]: [
                    { name: 'John Deere', image: '/combines/JohnDeere.png' },
                    { name: 'New Holland', image: '/combines/NewHolland.png' },
                    { name: 'Massey Ferguson', image: '/combines/MasseyFerguson.png' },
                    { name: 'Case IH', image: '/combines/CaseIH.png' },
                    { name: 'Claas', image: '/combines/Claas.png' },
                    { name: 'Deutz-Fahr', image: '/combines/Deutz-Fahr.png' },
                    { name: 'Fendt', image: '/combines/Fendt.png' },
                    { name: 'Challenger', image: '/combines/Challenger.png' },
                    { name: 'Gleaner', image: '/combines/Gleaner.png' },
                    { name: 'Sampo-Rosenlew', image: '/combines/Sampo-Rosenlew.png' },
                    { name: 'Levarda', image: '/combines/Levarda.png' },
                    { name: 'Sampo', image: '/combines/Sampo.png' }
                ],
                [transport.SPRAYERS]: [
                    { name: 'Berthoud', image: '/sprayers/Berthoud.png' },
                    { name: 'Agrifac', image: '/sprayers/Agrifac.png' },
                    { name: 'Amazone', image: '/sprayers/Amazone.png' },
                    { name: 'Bargam', image: '/sprayers/Bargam.png' },
                    { name: 'Caffini', image: '/sprayers/Caffini.png' },
                    { name: 'Caruelle', image: '/sprayers/Caruelle.png' },
                    { name: 'Case IH', image: '/sprayers/CaseIH.png' },
                    { name: 'Chalenger', image: '/sprayers/Chalenger.png' },
                    { name: 'Dammann', image: '/sprayers/Dammann.png' },
                    { name: 'Delvano', image: '/sprayers/Delvano.png' },
                    { name: 'Apache', image: '/sprayers/Apache.png' },
                    { name: 'Hagie', image: '/sprayers/Hagie.png' },
                    { name: 'Hardi', image: '/sprayers/Hardi.png' },
                    { name: 'Horsch', image: '/sprayers/Horsch.png' },
                    { name: 'Househam', image: '/sprayers/Househam.png' },
                    { name: 'Jacto', image: '/sprayers/Jacto.png' },
                    { name: 'John Deere', image: '/sprayers/JohnDeere.png' },
                    { name: 'Kuhn', image: '/sprayers/Kuhn.png' },
                    { name: 'Kverneland', image: '/sprayers/Kverneland.png' },
                    { name: 'Matrot', image: '/sprayers/Matrot.png' }
                ]
            },
            isMobileDevice: false,
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
                { text: 'X', value: 'multiplier', align: 'left', sortable: false },
                { text: 'Изображение', align: 'left', sortable: false, value: 'image' },
                { text: 'Тип', value: 'type', sortable: false },
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
                // { text: 'Модуль конект', value: 'connect_module', sortable: false },
                // { text: 'Цена $      ', value: 'connect_module_price', sortable: false },
                { text: 'CAN', value: 'can_reader', sortable: false },
                { text: 'Цена $       ', value: 'can_reader_price', sortable: false },
                { text: 'Деаэратор малый', value: 'deaerator_small', sortable: false },
                { text: 'Цена $        ', value: 'deaerator_small_price', sortable: false },
                { text: 'Деаэратор большой', value: 'deaerator_large', sortable: false },
                { text: 'Цена $         ', value: 'deaerator_large_price', sortable: false },
                { text: 'CN03', value: 'cn03', sortable: false },
                { text: 'Цена $          ', value: 'cn03_price', sortable: false },
                { text: 'RS01', value: 'rs01', sortable: false },
                { text: 'Цена $           ', value: 'rs01_price', sortable: false },
                { text: 'Дополнительное оборудование', value: 'additional_equipment', sortable: false },
                { text: 'Цена $            ', value: 'additional_equipment_price', sortable: false },
                { text: 'Монтаж оборудования ₴', value: 'manual_installation_price', sortable: false },
            ],
            uploadImage,
            cellsPosition: []
        };
    },
    computed: {
        transportTypesWithCache() {
            let cachedTypes = [];
            if (this.cachedData.type) {
                cachedTypes = this.cachedData.type.map((cache) => ({ name: cache.value, value: cache.value, isCache: true }));
            }
            return [...this.transportTypes, ...cachedTypes];
        },
        markCache() {
            let cachedMarks = [];
            if (this.cachedData.mark) {
                cachedMarks = this.cachedData.mark.map((cache) => ({ name: cache.value, image: '', isCache: true }));
            }
            return cachedMarks;
        },
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
        },
        gpsTrackersWithHeader() {
            return [
                { header: 'GPS-трекеры' },
                ...this.gpsTrackers
            ];
        },
        fuelLevelSensorsWithHeader() {
            return [
                { header: 'Датчики уровня топлива' },
                ...this.fuelLevelSensors
            ];
        },
        fuelFlowmetersWithHeader() {
            return [
                { header: 'Расходомеры топлива' },
                ...this.fuelFlowmeters
            ];
        },
        identificationWithHeader() {
            return [
                { header: 'Идентификация' },
                ...this.identification
            ];
        },
        optionalEquipmentWithHeader() {
            return [
                { header: 'Дополнительное оборудование' },
                ...this.optionalEquipment
            ];
        },
        countErrors() {
            return this.count > 0 ? [] : ['Должно быть больше нуля'];
        }
    },
    methods: {
        getTypeText(type) {
            if (this.isNull(type) || this.isUndefined(type) || type === '') return '';
            const transport = this.transportTypesWithCache.find(t => t.value === type);
            if (!transport) return '';
            return transport.name;
        },
        addRow(count = 1) {
            if (!count || count < 1) {
                return;
            }
            this.addEditModCells(count);
            this.$emit('rowAdded', count);
        },
        spreadRow(index) {
            const rowToSpread = this.orderGPSData[index];
            if (rowToSpread.multiplier <= 1) return;
            this.addEditModCells(rowToSpread.multiplier - 1, index + 1);
            this.$emit('row:spread', index, rowToSpread);
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
            if (this.isMobileDevice) {
                this.tableBody.addEventListener('touchend', this.cornerBlurred, false);
            } else {
                this.tableBody.addEventListener('mouseup', this.cornerBlurred, false);
            }
            if (this.bordersSelectData.corner.el) {
                if (this.isMobileDevice) {
                    this.bordersSelectData.corner.el.addEventListener('touchend', this.cornerBlurred, false);
                } else {
                    this.bordersSelectData.corner.el.addEventListener('mouseup', this.cornerBlurred, false);
                }
            }
            this.isCornerFocused = true;
            console.log('Focused');
        },
        cornerBlurred(event) {
            this.isCornerFocused = false;
            if (this.isMobileDevice) {
                this.tableBody.removeEventListener('touchend', this.cornerBlurred);
                this.bordersSelectData.corner.el.removeEventListener('touchend', this.cornerBlurred);
            } else {
                this.tableBody.removeEventListener('mouseup', this.cornerBlurred);
                this.bordersSelectData.corner.el.removeEventListener('mouseup', this.cornerBlurred);
            }
            if (this.isReadyToCopy) {
                this.$emit('copy-values:orderGPSData', this.copyList);
                for (let i = 0; i < this.copyList.length; ++i) {
                    const newData = this.copyList[i][0].value;
                    for (let j = 1; j < this.copyList[i].length; ++j) {
                        this.checkImageReplacement(this.copyList[i][j].index, this.copyList[i][j].column, newData);
                    }
                }
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
                if (this.isMobileDevice) {
                    this.bordersSelectData[position].el.addEventListener('touchstart', this.cornerFocused, false);
                    this.bordersSelectData[position].el.addEventListener('touchmove', (event) => {
                        event.preventDefault();
                        const realTarget = this.findTDEl(event);
                        if (realTarget !== null) {
                            const data = JSON.parse(realTarget.dataset.formobile);
                            this.selectCellToCopyList(null, data, realTarget);
                        }
                    }, false);
                } else {
                    this.bordersSelectData[position].el.addEventListener('mousedown', this.cornerFocused, false);
                }
            }
            this.bordersWrapper.appendChild(this.bordersSelectData[position].el);
            this.setStyles(this.bordersSelectData[position].el, this.bordersSelectData[position].styles);
        },
        getCoords(elem) {
            const box = elem.getBoundingClientRect();
            const table = document.querySelector('#gps-data-table table').getBoundingClientRect();

            return {
                width: Math.round(box.width),
                height: Math.round(box.height),
                top: box.top - table.top,
                left: box.left - table.left
            };
        },
        normalizeCorner(anchorCoords, anchor) {
            this.bordersSelectData.corner.styles.top = `${anchorCoords.top + anchor.offsetHeight - (this.isMobileDevice ? 12 : 6)}px`;
            this.bordersSelectData.corner.styles.left = `${anchorCoords.left + anchor.offsetWidth - (this.isMobileDevice ? 14 : 7)}px`;
            this.bordersSelectData.corner.styles.width = `${this.isMobileDevice ? 24 : 12}px`;
            this.bordersSelectData.corner.styles.height = `${this.isMobileDevice ? 24 : 12}px`;
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
            console.log('ANCHOR_COORDS: ', anchorCoords);
            console.log('ANCHOR: ', anchor);
            this.normalizeSelectBorders(anchorCoords, anchor);
            this.normalizeCorner(anchorCoords, anchor);
            this.normalizeStylesSelectBordersAndCorner();

        },
        findTDEl(event) {
            if (event instanceof TouchEvent) {
                let clientX;
                let clientY;
                if (event.type === 'touchmove') {
                    clientX = event.touches[0].clientX;
                    clientY = event.touches[0].clientY;
                } else if (event.type === 'touchend') {
                    clientX = event.changedTouches[0].clientX;
                    clientY = event.changedTouches[0].clientY;
                }
                const realTarget = document.elementFromPoint(clientX, clientY);

                if (realTarget.tagName !== 'TD') {
                    return realTarget.closest('td');
                }

                return realTarget;
            }
            let index = 0;
            const path = event.composedPath();
            for (let i = 0; path[i].tagName != 'TD'; ++i) {
                ++index;
            }
            return index === 0 ? event.target : path[index];
        },
        clickOnTD(td) {
            if (td) {
                this.$nextTick(() => {
                    td.click();
                });
            }
        },
        resetCopyList(newCell) {
            this.copyList = [ [newCell] ];
        },
        selectCell(event, data) {
            const cell = this.findTDEl(event);
            this.positionBorders(cell);
            this.resetCopyList({ ...data, value: (this.isUndefined(data.value) || this.isNull(data.value)) ? '' : data.value });
        },
        selectCellToCopyList(event, newCell, td = null) {
            if (!this.isCornerFocused) return;
            if (newCell.index < this.copyList[0][0].index || newCell.columnIndex < this.copyList[0][0].columnIndex) return;
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
            const currentCell = td || this.findTDEl(event);
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
                        let column = this.headers[columnIndex + 1].value;
                        let value = this.orderGPSData[newCell.index][column];
                        this.copyList.push([{ index: newCell.index, column, columnIndex, value: (this.isUndefined(value) || this.isNull(value)) ? '' : value }]);
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
                            let column = this.headers[columnIndex + 1].value;
                            let currentCell = this.$refs[`td-${index}-${columnIndex}`];
                            let currentCellCoords = this.getCoords(currentCell);
                            this.bordersSelectData.top.styles.width = `${parseInt(this.bordersSelectData.top.styles.width) + currentCellCoords.width}px`;
                            this.bordersSelectData.bottom.styles.width = `${parseInt(this.bordersSelectData.bottom.styles.width) + currentCellCoords.width}px`;
                            let value = this.orderGPSData[index][column];
                            this.copyList.push([{ index, column, columnIndex, value: (this.isUndefined(value) || this.isNull(value)) ? '' : value }]);
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
        checkImageReplacement(row, columnName, data) {
            if (columnName === 'type') {
                if (this.transport[data] && this.transport[data].some(t => t.name === this.orderGPSData[row].mark) && !this.isNull(this.orderGPSData[row].mark) && !this.isUndefined(this.orderGPSData[row].mark) && this.orderGPSData[row].mark !== '') {
                    const transport = this.transport[data].find(t => t.name === this.orderGPSData[row].mark);
                    const transportImg = transport ? transport.image : '';
                    this.$emit('update:orderGPSData', `/storage/transport${transportImg}`, row, 'image', false);
                }
            }
            if (columnName === 'mark') {
                if (this.transport[this.orderGPSData[row].type] && this.transport[this.orderGPSData[row].type].some(t => t.name === data) && !this.isNull(this.orderGPSData[row].type) && !this.isUndefined(this.orderGPSData[row].type) && this.orderGPSData[row].type !== '') {
                    const transport = this.transport[this.orderGPSData[row].type].find(t => t.name === data);
                    const transportImg = transport ? transport.image : '';
                    this.$emit('update:orderGPSData', `/storage/transport${transportImg}`, row, 'image', false);
                }
            }
        },
        checkNumeric(columnName, data) {
            if (columnName === 'multiplier') {
                return parseInt(data, 10);
            }
            return data;
        },
        setCellValue(data, row, cell, name, td, nestedPath = false, forceSwitchMode = true) {
            this.checkImageReplacement(row, name, data);
            data = this.checkNumeric(name, data);
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
        this.$validator = this.validator;
        const md = new MobileDetect(window.navigator.userAgent);
        this.isMobileDevice = !!md.mobile();

        if (this.editModCells.length === 0) {
            this.addEditModCells(this.orderGPSData.length);
        }
        if (this.orderGPSData.length === 0) {
            this.addRow(this.defaultRowCount);
        }
    },
    mounted() {
        const tableBody = document.querySelector('#gps-data-table .v-datatable tbody');
        this.tableBody = tableBody;
        tableBody.classList.add('gps-data-tbody');
        const _self = this;

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
    #gps-data-table {
        max-height: 1400px;
        overflow-y: scroll;
    }
    #gps-data-table .v-table__overflow {
        position: relative;
    }
    #gps-data-table table {
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
    #gps-data-table table td:first-child {
        border-left: 1px solid rgba(202, 202, 202, 0.5);
        border-right: 1px solid rgba(202, 202, 202, 0.5);
    }
    #gps-data-table .spread-row-btn {
        font-size: 10px;
        margin: 6px 0px;
        height: 20px;
        padding: 0;
    }
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
        border: 1px solid rgb(255, 255, 255);
    }
    .handle {
        cursor: move;
    }
</style>
