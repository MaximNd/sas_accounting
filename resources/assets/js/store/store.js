import Vue from 'vue';
import Vuex from 'vuex';
import priceList from './modules/priceList';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        priceList
    }
});
