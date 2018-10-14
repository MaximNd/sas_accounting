<template>
    <v-container fluid>
        <v-layout wrap>
            <v-flex xs12 d-flex justify-center>
                <appOrder
                    ref="order"
                    v-if="order"
                    :order="order"
                    :isCreation="false"
                    @order:update="updateOrder"></appOrder>
                <v-progress-circular
                    v-else
                    :width="10"
                    :size="150"
                    color="primary"
                    indeterminate>
                    Загрузка...
                </v-progress-circular>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import Order from './../../components/order/Order';

export default {
    data() {
        return {
            order: null,
            isUnsavedData: false
        };
    },
    methods: {
        updateOrder(order) {
            this.order = order;
        },
        isNoChange() {
            const {
                oldOrderData,
                updatedOrderData,
                oldOrderServicesData,
                updatedOrderServicesData,
                oldOrderGPSData,
                updatedOrderGPSData,
                oldOrderOptionalServices,
                updatedOrderOptionalServices,
                oldOrderPrices,
                updatedOrderPrices
            } = this.$refs.order.getOldAndUpdatedData();
            const old = { oldOrderData, oldOrderServicesData, oldOrderGPSData, oldOrderOptionalServices, oldOrderPrices };
            const updated = { updatedOrderData, updatedOrderServicesData, updatedOrderGPSData, updatedOrderOptionalServices, updatedOrderPrices };
            return this.$refs.order.isNoCange(old, updated);
        }
    },
    created() {
        this.axios.get(`/order/${this.$route.params.id}`)
            .then(({data}) => {
                this.updateOrder(data);
            })
            .catch(err => console.log(err));
    },
    mounted() {
        const that = this;
        window.onbeforeunload = function (e) {
            const noChange = that.isNoChange();
            let returnVal = null;
            if (!noChange) {
                returnVal = 'На странице есть несохраненные данные. Вы действительно хотите уйти?';
            }
            return returnVal;
        };
    },
    beforeRouteLeave(to, from, next) {
        const noChange = this.isNoChange();
        if (noChange) {
            window.onbeforeunload = undefined;
            this.$store.dispatch('reset');
            return next();
        } else {
            if (confirm('На странице есть несохраненные данные. Вы действительно хотите уйти?')) {
                window.onbeforeunload = undefined;
                this.$store.dispatch('reset');
                return next();
            }
        }
    },
    components: {
        appOrder: Order
    }
}
</script>
