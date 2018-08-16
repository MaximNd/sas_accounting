<template>
    <v-container fluid grid-list-lg>
        <v-layout wrap>
            <v-flex xs12 sm6 md4 v-for="(user, index) in users" :key="`user-${index}`">
                <appProfileData
                    :user="user"
                    @updatedUserData="updateUser($event, index)"
                    @deleteUser="deleteUser(index)"></appProfileData>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import ProfileData from './../../components/profileData/ProfileData';

export default {
    data() {
        return {
            users: []
        };
    },
    methods: {
        updateUser(user, index) {
            this.users.splice(index, 1, user);
            const mappedUsers = this.users.reduce((all, user) => {
                if (user.role === 'admin') {
                    all.admins.push(user);
                } else if (user.role === 'user') {
                    all.users.push(user);
                }
                return all;
            }, { admins: [], users: [] });
            mappedUsers.admins.sort((a, b) => {
                return a.id - b.id;
            });
            mappedUsers.users.sort((a, b) => {
                return a.id - b.id;
            });
            this.users = [...mappedUsers.admins, ...mappedUsers.users];
        },
        deleteUser(index) {
            this.users.splice(index, 1);
        }
    },
    created() {
        this.axios.get('/users')
            .then(({data}) => {
                this.users = data;
            });
    },
    components: {
        appProfileData: ProfileData
    }
}
</script>
