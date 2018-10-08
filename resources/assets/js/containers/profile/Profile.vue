<template>
    <v-container fluid v-if="$auth.ready()">
        <v-layout align-start justify-start>
            <v-flex sm12 md10 lg4>
                <appProfileData :user="user" @updatedUserData="updateUser" />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import ProfileData from './../../components/profileData/ProfileData';

export default {
    data() {
        return {
            user: {}
        };
    },
    methods: {
        updateUser(user) {
            this.$auth.user(user);
            this.user = this.$auth.user();
        }
    },
    created() {
        this.user = this.$auth.user();
    },
    components: {
        appProfileData: ProfileData
    }
}
</script>
