import Vue from 'vue';

const state = {
    fakeID: 0,
    pdf_files: []
};

const getters = {
    pdf_files(state) {
        return state.pdf_files;
    }
};

const mutations = {
    SET_PDF_FILES(state, payload) {
        state.pdf_files = payload;
        if (state.pdf_files.length > 0) {
            state.fakeID = state.pdf_files[0].id + 1;
        }
    },
    ADD_PDF_FILE(state, payload) {
        if (!payload.real) {
            state.pdf_files.unshift(payload.fake);
            ++state.fakeID;
        } else {
            const index = state.pdf_files.findIndex(pdfFile => (pdfFile.fake && pdfFile.id === payload.fake.id));
            state.pdf_files.splice(index, 1, payload.real);
        }
    },
    DELETE_PDF_FILE(state, payload) {
        const index = state.pdf_files.findIndex((pdfFile) => pdfFile.id === payload.id);
        state.pdf_files.splice(index, 1);
    }
};

const actions = {
    getPDFFiles({ commit }, payload) {
        return new Promise((resolve, reject) => {
            Vue.axios.get(`/orders_pdf/${payload.orderID}`)
                .then(({ data }) => {
                    commit('SET_PDF_FILES', data);
                    resolve();
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    createPDFFile({ commit, state }, payload) {
        const fakePDFFile = { id: ++state.fakeID, status: 'PROCESSING', fake: true };
        commit('ADD_PDF_FILE', { fake: fakePDFFile });
        return new Promise((resolve, reject) => {
            Vue.axios.post(`/orders_pdf/${payload.orderID}`, payload.pdfData)
                .then(({ data }) => {
                    commit('ADD_PDF_FILE', { fake: fakePDFFile, real: data });
                    resolve();
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    deletePDFFile({ commit }, payload) {
        return new Promise((resolve, reject) => {
            Vue.axios.delete(`/orders_pdf/${payload.id}`)
                .then(() => {
                    commit('DELETE_PDF_FILE', payload);
                    resolve();
                })
                .catch(err => {
                    reject(err);
                });
        });
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
