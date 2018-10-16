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
        gruppedEquipment: {
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
    }
}
</script>
