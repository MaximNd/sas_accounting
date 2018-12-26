import Vue from 'vue';
import Vuex from 'vuex';
import priceList from './modules/priceList';
import pdfFiles from './modules/pdfFiles';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        priceList,
        pdfFiles
    }
});
