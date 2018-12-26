<template>
    <v-list-tile>
        <v-list-tile-content  style="width:60%;">
            <v-list-tile-title v-if="$vuetify.breakpoint.mdAndDown" :style="{ height: $vuetify.breakpoint.mdOnly ? '30px' : null }">
                <v-layout wrap align-center>
                    <v-flex xs10>
                        <span class="error--text">Ошибка при создании</span>
                    </v-flex>
                    <v-flex xs2 class="justify-end align-center layout px-0">
                        <v-btn
                            @click="deletePDFFile"
                            :loading="loading"
                            :disabled="loading"
                            small
                            icon
                            :style="$vuetify.breakpoint.smAndDown ? {height: '20px', width: '20px'} : null">
                            <v-icon color="error" small>delete</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-list-tile-title>
            <v-list-tile-title v-else>
                <span class="error--text">Ошибка при создании</span>
            </v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-action v-if="!$vuetify.breakpoint.mdAndDown" style="width:40%;">
            <v-btn
                @click="deletePDFFile"
                :loading="loading"
                :disabled="loading"
                small
                block
                color="error">
                Удалить эту запись
            </v-btn>
        </v-list-tile-action>
    </v-list-tile>
</template>

<script>
export default {
    props: {
        pdf_file: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            loading: false
        };
    },
    methods: {
        deletePDFFile() {
            this.loading = true;
            this.$store.dispatch('deletePDFFile', this.pdf_file)
                .then(() => {
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                    this.loading = false;
                });
        }
    }
}
</script>

<style scoped>
    .pdf_icon {
        min-width: 25px;
    }
</style>
