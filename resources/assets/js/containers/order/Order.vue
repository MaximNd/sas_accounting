<template>
    <v-container fluid>
        <v-layout wrap>
            <v-flex xs12 d-flex justify-center>
                <appOrder
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
            order: null
        };
    },
    methods: {
        updateOrder(order) {
            this.order = order;
        }
    },
    created() {
        this.axios.get(`/order/${this.$route.params.id}`)
            .then(({data}) => {
                this.updateOrder(data);
            })
            .catch(err => console.log(err));
    },
    beforeRouteLeave(to, from, next) {
        this.$store.dispatch('reset');
        next();
    },
    components: {
        appOrder: Order
    }
}
</script>
