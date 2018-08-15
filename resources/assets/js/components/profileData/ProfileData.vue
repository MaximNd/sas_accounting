<template>
    <v-card>
        <v-card-text>
            <v-layout align-center justify-center>
                <v-avatar
                    size="250">
                    <img :src="`/storage/${user.image}`" alt="avatar">
                </v-avatar>
            </v-layout>
        </v-card-text>
        <v-card-text>
            <v-layout class="pl-3 pr-3 pb-3" wrap align-center justify-center>
                <v-flex class="userData" xs6>ФИО:</v-flex><v-flex class="userData" xs6>{{ fullName }}</v-flex>
                <v-flex class="userData" xs6>Должность:</v-flex><v-flex class="userData" xs6>{{ user.position }}</v-flex>
                <v-flex class="userData" xs6>Role:</v-flex><v-flex class="userData" xs6>{{ user.role }}</v-flex>
                <v-flex class="userData" xs6>Email:</v-flex><v-flex class="userData" xs6></v-flex>
                <v-flex class="userData" xs6>Тел:</v-flex><v-flex class="userData" xs6>{{ user.telephone }}</v-flex>
            </v-layout>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="openDialog" class="edit-btn" flat block large color="info">
                <v-icon left medium>edit</v-icon>
                Изменить
            </v-btn>
            <appUpdateProfileData
                :oldUserData="user"
                :dialog="dialog"
                @dialogClosed="closeDialog"
                @userDataUpdated="updateUserData"></appUpdateProfileData>
        </v-card-actions>
    </v-card>
</template>

<script>
import UpdateProfileData from './updateProfileData/UpdateProfileData';

export default {
    data() {
        return {
            dialog: false
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
        }
    },
    methods: {
        openDialog() {
            this.dialog = true;
        },
        closeDialog() {
            this.dialog = false;
        },
        updateUserData(user) {
            this.$emit('updatedUserData', user);
        }
    },
    components: {
        appUpdateProfileData: UpdateProfileData
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

    img {
        object-fit: cover;
        width: 250px;
        height: 250px;
    }
</style>
