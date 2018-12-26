<template>
    <v-card class="elevation-2 pdf_files">
        <v-card-text>
            <v-progress-linear v-if="loading" indeterminate></v-progress-linear>
            <v-list v-else dense>
                <template v-for="(pdf_file) in pdf_files">
                    <appOrderPDFProcessing v-if="pdf_file.status === 'PROCESSING'" :key="`pdf-${pdf_file.id}`" />
                    <appOrderPDFFinished v-else-if="pdf_file.status === 'FINISHED'" :pdf_file="pdf_file" :key="`pdf-${pdf_file.id}`" />
                    <appOrderPDFFailed v-else-if="pdf_file.status === 'FAILED'" :pdf_file="pdf_file" :key="`pdf-${pdf_file.id}`" />
                </template>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<script>
import { mapGetters } from 'vuex';
import OrderPDFProcessing from './OrderPDFProcessing/OrderPDFProcessing';
import OrderPDFFinished from './OrderPDFFinished/OrderPDFFinished';
import OrderPDFFailed from './OrderPDFFailed/OrderPDFFailed';

export default {
    props: {
        orderID: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            loading: true
        };
    },
    computed: {
        ...mapGetters(['pdf_files'])
    },
    methods: {
        fetchPDFFiles() {
            this.$store.dispatch('getPDFFiles', { orderID: this.orderID })
                .then(() => {
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                    this.loading = false;
                });
        }
    },
    created() {
        this.fetchPDFFiles();
    },
    components: {
        appOrderPDFProcessing: OrderPDFProcessing,
        appOrderPDFFinished: OrderPDFFinished,
        appOrderPDFFailed: OrderPDFFailed
    }
};
</script>

<style scoped>
    .pdf_files {
        max-height: 240px;
        overflow-y: scroll;
    }
</style>

