<template>
    <v-container fluid v-if="$auth.ready()">
        <v-layout align-start justify-start>
            <v-flex sm12 md10 lg8 xl4>
                <v-card>
                    <v-card-text>
                        <v-layout align-center justify-center>
                            <v-avatar
                                :size="250"
                                color="grey lighten-4" >
                                <img src="/images/no-avatar.png" alt="avatar">
                            </v-avatar>
                        </v-layout>
                    </v-card-text>
                    <v-card-text>
                        <v-layout class="pl-3 pr-3 pb-3" wrap align-center justify-center>
                            <v-flex class="userData" xs6>ФИО:</v-flex><v-flex class="userData" xs6>{{ fullName }}</v-flex>
                            <v-flex class="userData" xs6>Должность:</v-flex><v-flex class="userData" xs6>{{ user.position }}</v-flex>
                            <v-flex class="userData" xs6>Role:</v-flex><v-flex class="userData" xs6>{{ user.role }}</v-flex>
                            <v-flex class="userData" xs6>Email:</v-flex><v-flex class="userData" xs6>{{ user.email }}</v-flex>
                            <v-flex class="userData" xs6>Тел:</v-flex><v-flex class="userData" xs6>{{ user.telephone }}</v-flex>
                        </v-layout>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn class="edit-btn" flat block large color="info">
                            <v-icon left medium>edit</v-icon>
                            Изменить
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            user: {}
        };
    },
    computed: {
        fullName() {
            return `${this.user.last_name} ${this.user.first_name} ${this.user.mid_name}`;
        }
    },
    created() {
        if (parseInt(this.$auth.user().id) === parseInt(this.$route.params.id)) {
            this.user = this.$auth.user();
        } else {
            // TODO Fetch User by ID
        }
    }
}
</script>

<style scoped>
    .userData {
        font-size: 22px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .edit-btn {
        font-size: 22px;
    }
</style>

