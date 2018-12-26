<template>
    <v-list-tile>
        <v-list-tile-content>
            <v-list-tile-title :style="{ height: $vuetify.breakpoint.smAndDown ? '50px' : null }">
                <v-layout wrap align-center>
                    <v-flex xs12 sm12 md3>
                        Создание...
                    </v-flex>
                    <v-flex xs12 sm12 md9>
                        <v-progress-linear indeterminate></v-progress-linear>
                    </v-flex>
                </v-layout>
            </v-list-tile-title>
        </v-list-tile-content>
    </v-list-tile>
</template>

<script>
export default {

}
</script>

<style>

</style>
