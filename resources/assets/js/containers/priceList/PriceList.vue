<template>
    <v-container fluid>
        <v-layout>
            <v-flex xs12>
                <v-expansion-panel popout expand>
                    <v-expansion-panel-content
                        class="elevation-1"
                        v-for="(item, index) in gruppedEquipments"
                        :key="index">
                        <div slot="header">{{ item.name }}</div>
                        <appEquipment v-if="item.name !== 'Услуги'" :type="item.name" :equipment="item.data"></appEquipment>
                        <appServices v-else :services="item.data"></appServices>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import Equipment from './../../components/equipment/Equipment';
import Services from './../../components/services/Services';

export default {
    computed: {
        ...mapGetters([
            'gpsTrackers',
            'fuelLevelSensors',
            'fuelFlowmeters',
            'identification',
            'optionalEquipment',
            'services'
        ]),
        gruppedEquipments() {
            return [
                { name: 'GPS-трекеры', data: this.gpsTrackers },
                { name: 'Датчики уровня топлива', data: this.fuelLevelSensors },
                { name: 'Расходомеры топлива', data: this.fuelFlowmeters },
                { name: 'Идентификация', data: this.identification },
                { name: 'Дополнительное оборудование', data: this.optionalEquipment },
                { name: 'Услуги', data: this.services }
            ];
        }
    },
    created() {
        this.$store.dispatch('getPriseList');
    },
    beforeRouteLeave(to, from, next) {
        this.$store.dispatch('reset');
        next();
    },
    components: {
        appEquipment: Equipment,
        appServices: Services
    }
}
</script>
