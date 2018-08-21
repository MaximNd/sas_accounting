import Vue from 'vue';

const state = {
    equipmentList: []
};

const getters = {
    gpsTrackers(state) {
        return state.equipmentList.filter(equipment => equipment.type === 'GPS-трекеры');
    },
    fuelLevelSensors(state) {
        return state.equipmentList.filter(equipment => equipment.type === 'Датчики уровня топлива');
    },
    fuelFlowmeters(state) {
        return state.equipmentList.filter(equipment => equipment.type === 'Расходомеры топлива');
    },
    identification(state) {
        return state.equipmentList.filter(equipment => equipment.type === 'Идентификация');
    },
    optionalEquipment(state) {
        return state.equipmentList.filter(equipment => equipment.type === 'Дополнительное оборудование');
    },
    services(state) {
        return state.equipmentList.filter(service => service.type === 'Услуга');
    }
};

const mutations = {
    SET_EQUIPMENT_LIST(state, payload) {
        state.equipmentList = payload;
    },
    ADD_EQUIPMENT(state, payload) {
        state.equipmentList.push(payload);
    },
    EDIT_EQUIPMENT(state, payload) {
        const { id, isService, ...editedData } = payload;
        const index = state.equipmentList.findIndex(equipment => parseInt(equipment.id) === parseInt(id));
        if (isService) {
            const newService = { ...state.equipmentList[index], ...editedData.service };
            state.equipmentList.splice(index, 1, newService);
        } else {
            const newEquipment = { ...state.equipmentList[index], ...editedData.equipment };
            state.equipmentList.splice(index, 1, newEquipment);
        }
    },
    DELETE_EQUIPMENT(state, payload) {
        const index = state.equipmentList.findIndex(equipment => parseInt(equipment.id) === parseInt(payload));
        state.equipmentList.splice(index, 1);
    }
};

const actions = {
    createEquipment({ commit }, payload) {
        return new Promise((resolve, reject) => {
            Vue.axios.post('/price-list', payload)
                .then(({data}) => {
                    commit('ADD_EQUIPMENT', data);
                    resolve(data);
                })
                .catch(err => reject(err));
        });
    },
    editEquipment({ commit }, payload) {
        const { id, ...editedData } = payload;
        return new Promise((resolve, reject) => {
            Vue.axios.put(`/price-list/${id}`, editedData)
                .then(({data}) => {
                    commit('EDIT_EQUIPMENT', payload);
                    resolve(data);
                })
                .catch(err => reject(err));
        });
    },
    getPriseList({ commit }) {
        Vue.axios.get('/price-list')
            .then(({data}) => {
                commit('SET_EQUIPMENT_LIST', data);
            })
            .catch(err => console.log(err));
    },
    deleteEquipment({ commit }, payload) {
        return new Promise((resolve, reject) => {
            Vue.axios.delete(`/price-list/${payload}`)
                .then(({data}) => {
                    commit('DELETE_EQUIPMENT', payload);
                    resolve(data);
                })
                .catch(err => reject(err));
        });
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
