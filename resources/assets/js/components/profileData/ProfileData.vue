<template>
    <v-card class="scroll-x-data">
        <v-card-text>
            <v-layout align-center justify-center>
                <v-avatar
                    :size="$vuetify.breakpoint.xlOnly ? 250 : 200">
                    <img
                        :src="`/storage/${user.image}`"
                        :style="{
                            width: $vuetify.breakpoint.xlOnly ? 250 : 200,
                            height: $vuetify.breakpoint.xlOnly ? 250 : 200
                        }"
                        alt="avatar">
                </v-avatar>
            </v-layout>
        </v-card-text>
        <v-card-text>
            <v-layout class="pl-3 pr-3 pb-3" wrap align-center justify-center>
                <v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs5>ФИО:</v-flex><v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs7>{{ fullName }}</v-flex>
                <v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs5>Должность:</v-flex><v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs7>{{ user.position }}</v-flex>
                <v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs5>Role:</v-flex><v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs7>{{ user.role }}</v-flex>
                <v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs5>Email:</v-flex><v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs7>{{ user.email }}</v-flex>
                <v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs5>Тел:</v-flex><v-flex :class="{ userData: $vuetify.breakpoint.lgAndDown, 'userData-xl': $vuetify.breakpoint.xlOnly }" xs7>{{ user.telephone }}</v-flex>
            </v-layout>
        </v-card-text>
        <v-card-actions>
            <v-layout wrap>
                <v-flex xs12 :sm6="!isSelf" v-if="isSelf || $auth.user().role === 'admin'">
                    <v-btn @click="openDialog('updateDialog')" style="font-size: 20px;" flat block color="info">
                        <v-icon left>edit</v-icon>
                        Изменить
                    </v-btn>
                </v-flex>
                <v-flex xs12 sm6 v-if="$auth.user().role === 'admin' && !isSelf">
                    <v-btn @click="openDialog('deleteDialog')" style="font-size: 20px;" flat block color="error">
                        <v-icon left>delete</v-icon>
                        Удалить
                    </v-btn>
                </v-flex>
            </v-layout>
            <appUpdateProfileData
                :oldUserData="user"
                :dialog="updateDialog"
                @dialogClosed="closeDialog('updateDialog')"
                @userDataUpdated="updateUserData"
                @validation-error="setSnack('error', 'Неверно введенные данные!')"
                @update-error="setSnack('error', 'Ошибка!')">
                </appUpdateProfileData>
            <appDeleteUser
                :user="user"
                :dialog="deleteDialog"
                @dialogClosed="closeDialog('deleteDialog')"
                @userDeleted="deleteUser"></appDeleteUser>
        </v-card-actions>
        <v-snackbar v-model="snack" :timeout="snackTimeout" :color="snackColor" bottom right>
            {{ snackText }}
        </v-snackbar>
    </v-card>
</template>

<script>
import UpdateProfileData from './updateProfileData/UpdateProfileData';
import DeleteUser from './deleteUser/DeleteUser';

export default {
    data() {
        return {
            snack: false,
            snackTimeout: 2000,
            snackColor: '',
            snackText: '',
            updateDialog: false,
            deleteDialog: false
        };
    },
    props: {
        user: {
            required: true,
            type: Object
        }
    },
    computed: {
        fullName() {
            return `${this.user.last_name} ${this.user.first_name} ${this.user.mid_name}`;
        },
        isSelf() {
            return this.$auth.user().id === this.user.id;
        }
    },
    methods: {
        openDialog(which) {
            this[which] = true;
        },
        closeDialog(which) {
            this[which] = false;
        },
        updateUserData(user) {
            this.$emit('updatedUserData', user);
            this.setSnack('success', 'Профиль обновлен');
        },
        deleteUser() {
            this.$emit('deleteUser');
        },
        setSnack(color, text) {
            this.snack = true;
            this.snackColor = color;
            this.snackText = text;
        }
    },
    components: {
        appUpdateProfileData: UpdateProfileData,
        appDeleteUser: DeleteUser
    }
}
</script>

<style scoped>
    .userData {
        font-size: 18px;
        margin-bottom: 6px;
    }

    .userData-xl {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .scroll-x-data {
        overflow-x: scroll;
    }

    img {
        object-fit: cover;
    }
</style>
