<template>
    <v-container fluid grid-list-lg>
        <v-layout wrap>
            <v-flex xs12 sm6 md4 v-for="(user, index) in users" :key="`user-${index}`">
                <appProfileData :user="user"></appProfileData>
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
