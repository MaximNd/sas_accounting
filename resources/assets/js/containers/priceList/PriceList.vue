<template>
    <v-container fluid>
        <v-layout>
            <v-flex xs12>
                <!-- <v-card>
                    <v-card-text> -->
                        <v-expansion-panel popout expand>
                            <v-expansion-panel-content
                                class="elevation-1"
                                v-for="(item, index) in gruppedEquipments"
                                :key="index">
                                <div slot="header">{{ item.name }}</div>
                                <appEquipment :type="item.name" :equipment="item.data"></appEquipment>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    <!-- </v-card-text>
                </v-card> -->
                <!-- <v-card>
                    <v-card-title>
                        <v-dialog v-model="dialog" persistent max-width="500px">
                            <v-btn slot="activator" color="info">Добавить клиента</v-btn>
                            <appCreateClient
                                isShowCancelButton
                                @dialogClosed="closeCreateDialog"
                                @clientCreated="prependClient">
                            </appCreateClient>
                        </v-dialog>
                        <v-spacer></v-spacer>
                        <v-text-field
                            clearable
                            :value="search"
                            @input="checkSearch"
                            append-icon="search"
                            label="Search"
                            single-line
                            hide-details>
                        </v-text-field>
                    </v-card-title>
                    <v-data-table
                        disable-initial-sort
                        :headers="headers"
                        :items="clients"
                        :pagination.sync="pagination"
                        :total-items="totalClients"
                        :loading="loading"
                        class="elevation-1">
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.person_full_name }}</td>
                            <td>{{ props.item.company_name }}</td>
                            <td class="text-xs-right"><v-btn color="info">Подробнее</v-btn></td>
                        </template>
                    </v-data-table>
                </v-card> -->
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import Equipment from './../../components/equipment/Equipment';

export default {
    computed: {
        ...mapGetters([
            'gpsTrackers',
            'fuelLevelSensors',
            'fuelFlowmeters',
            'identification',
            'optionalEquipment'
        ]),
        gruppedEquipments() {
            return [
                { name: 'GPS-трекеры', data: this.gpsTrackers },
                { name: 'Датчики уровня топлива', data: this.fuelLevelSensors },
                { name: 'Расходомеры топлива', data: this.fuelFlowmeters },
                { name: 'Идентификация', data: this.identification },
                { name: 'Дополнительное оборудование', data: this.optionalEquipment }
            ];
        }
    },
    created() {
        this.$store.dispatch('getPriseList');
    },
    components: {
        appEquipment: Equipment
    }
}
</script>
