<template>
    <v-container fluid grid-list-lg>
        <v-layout wrap>
            <v-flex xs12>
                <appCreateAccount
                    @account:created="addUser"
                    @account:error="setSnackBar('error', 'Ошибка!');"
                    @validation:error="setSnackBar('error', 'Неверно введенные данные!')">
                </appCreateAccount>
            </v-flex>
            <v-flex xs12 sm6 md4 v-for="(user, index) in users" :key="`user-${index}`">
                <appProfileData
                    :user="user"
                    @updatedUserData="updateUser($event, index)"
                    @deleteUser="deleteUser(index)"></appProfileData>
            </v-flex>
        </v-layout>
        <v-snackbar v-model="snack" :timeout="snackTimeout" :color="snackColor" bottom right>
            {{ snackText }}
        </v-snackbar>
    </v-container>
</template>

<script>
import CreateAccount from './../../components/createAccount/CreateAccount';
import ProfileData from './../../components/profileData/ProfileData';

export default {
    data() {
        return {
            snack: false,
            snackTimeout: 2000,
            snackColor: '',
            snackText: '',
            users: []
        };
    },
    methods: {
        getUsersMappedByRole() {
            return this.users.reduce((all, user) => {
                if (user.role === 'admin') {
                    all.admins.push(user);
                } else if (user.role === 'user') {
                    all.users.push(user);
                }
                return all;
            }, { admins: [], users: [] });
        },
        sortUsersById(users) {
            return users.sort((a, b) => a.id - b.id);
        },
        addUser(user) {
            const mappedUsers = this.getUsersMappedByRole();
            if (user.role === 'admin') {
                mappedUsers.admins.push(user);
                mappedUsers.admins = this.sortUsersById(mappedUsers.admins);
            } else if (user.role === 'user') {
                mappedUsers.users.push(user);
                mappedUsers.users = this.sortUsersById(mappedUsers.users);
            }
            this.users = [...mappedUsers.admins, ...mappedUsers.users];
            this.snackbar = true;
            this.setSnackBar('success', 'Аккаунт создан!');
        },
        updateUser(user, index) {
            this.users.splice(index, 1, user);
            const mappedUsers = this.getUsersMappedByRole();
            mappedUsers.admins = this.sortUsersById(mappedUsers.admins);
            mappedUsers.users = this.sortUsersById(mappedUsers.users);
            this.users = [...mappedUsers.admins, ...mappedUsers.users];
        },
        deleteUser(index) {
            this.users.splice(index, 1);
            this.setSnackBar('success', 'Аккаунт удален');
        },
        setSnackBar(statusColor, statusText) {
            this.snack = true;
            this.snackColor = statusColor;
            this.snackText = statusText;
        }
    },
    created() {
        this.axios.get('/users')
            .then(({data}) => {
                this.users = data;
            });
    },
    components: {
        appProfileData: ProfileData,
        appCreateAccount: CreateAccount
    }
}
</script>
