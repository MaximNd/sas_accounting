<template>
    <v-container fluid>
        <v-layout wrap>
            <v-flex xs12>
                <appOrder :isCreation="true"></appOrder>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import Order from './../../components/order/Order';

export default {
    components: {
        appOrder: Order
    }
}
</script>
