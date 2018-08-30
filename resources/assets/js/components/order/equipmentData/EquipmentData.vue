<template>
    <v-data-table
        :headers="headers"
        :items="gruppedEquipment"
        hide-actions
        class="elevation-1">
        <template slot="items" slot-scope="props">
            <td>{{ props.item.type }}</td>
            <td class="text-xs-center">{{ props.item.count }}</td>
        </template>
    </v-data-table>
</template>

<script>
import utils from './../../../mixins/utils.js';

export default {
    mixins: [utils],
    props: {
        orderGPSData: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            headers: [
                { text: 'Тип', align: 'left', value: 'type' },
                { text: 'Шт.', align: 'center', value: 'count' },
            ]
        };
    },
    computed: {
        gruppedEquipment() {
            const countEquipment = this.orderGPSData.reduce((grupped, row) => {
                Object.keys(row).forEach((key) => {
                    const value = row[key];
                    console.log(value);
                    if (this.isObject(value) && !(value instanceof File)) {
                        if (!grupped[row[key].id]) {
                            grupped[row[key].id] = {
                                type: row[key].name,
                                count: 1
                            };
                        } else {
                            ++grupped[row[key].id].count;
                        }
                    } else if (Array.isArray(value)) {
                        value
                            .forEach((el, index) => {
                                if (this.isUndefined(el)) return;
                                if (!grupped[el.id]) {
                                    grupped[el.id] = {
                                        type: el.name,
                                        count: 1
                                    };
                                } else {
                                    ++grupped[el.id].count;
                                }
                            })
                    }
                });
                return grupped;
            }, {});
            const gruppedEquipment = Object.keys(countEquipment).map((key) =>({ type: countEquipment[key].type, count: countEquipment[key].count }))
            return gruppedEquipment;
        }
    }
}
</script>
