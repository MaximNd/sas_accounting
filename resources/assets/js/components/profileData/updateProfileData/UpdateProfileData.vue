<template>
    <v-dialog v-model="dialog" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">User Profile</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
                <v-flex xs12 d-flex>
                    <v-avatar
                        @click="onPickFile"
                        raised
                        size="180">
                        <img :src="avatarPreview === '' ? uploadAvatarImage : avatarPreview" alt="avatar">
                    </v-avatar>
                    <input @change="onFilePicked($event)" style="display:none;" type="file" ref="newAvatar">
                </v-flex>
                <v-flex xs12 v-if="isNewAvatarSelected" d-flex>
                    <v-btn raised color="error" @click="deleteSelectedAvatar">Убрать изображение</v-btn>
                </v-flex>
                <v-flex xs12>
                    <v-text-field v-model="newUserData.last_name" label="Фамилия"></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field v-model="newUserData.first_name" label="Имя"></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field v-model="newUserData.mid_name" label="Отчество"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="isSame">
                    <v-text-field v-model="newUserData.email" label="Email"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="authUser.role === 'admin'">
                    <v-text-field v-model="newUserData.position" label="Должность"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="authUser.role === 'admin'">
                    <v-select v-model="newUserData.role" :items="['admin', 'user']" label="Role"></v-select>
                </v-flex>
                <v-flex xs12>
                    <v-text-field v-model="newUserData.telephone" label="Телефон"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="isSame">
                    <v-text-field v-model="newUserData.password" label="Новый пароль" type="password"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="isSame">
                    <v-text-field v-model="newUserData.password_confirmation" label="Подтверждение пароля" type="password"></v-text-field>
                </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" flat @click.native="closeDialog">Close</v-btn>
          <v-btn color="success" flat @click.native="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        dialog: {
            type: Boolean,
            required: true
        },
        oldUserData: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            authUser: '',
            userID: '',
            isNewAvatarSelected: false,
            newUserData: {
                last_name: '',
                first_name: '',
                mid_name: '',
                position: '',
                role: '',
                email: '',
                telephone: '',
                image: '',
                password: '',
                password_confirmation: ''
            },
            avatarPreview: '',
            uploadAvatarImage: '/storage/no-avatar.png'
        };
    },
    computed: {
        isSame() {
            return this.authUser.id === this.userID;
        }
    },
    methods: {
        save() {
            const formData = new FormData();
            formData.append('last_name', this.newUserData.last_name);
            formData.append('first_name', this.newUserData.first_name);
            formData.append('mid_name', this.newUserData.mid_name);
            if (this.authUser.role === 'admin') {
                formData.append('position', this.newUserData.position);
                formData.append('role', this.newUserData.role);
            }
            if (this.isSame && this.newUserData.email !== this.oldUserData.email) {
                formData.append('email', this.newUserData.email);
            }
            formData.append('telephone', this.newUserData.telephone);
            if (this.isNewAvatarSelected) {
                formData.append('image', this.newUserData.image);
            }
            if ((
                this.newUserData.password !== '' && this.newUserData.password_confirmation !== '' &&
                typeof this.newUserData.password !== 'undefined' && typeof this.newUserData.password_confirmation !== 'undefined'
            ) && this.isSame) {
                formData.append('password', this.newUserData.password);
                formData.append('password_confirmation', this.newUserData.password_confirmation);
            }

            this.axios.post(`/users/${this.userID}`, formData)
                .then(({data}) => {
                    const { password, password_confirmation, ...newUserData } = this.newUserData;
                    const user = { ...newUserData };
                    if (this.isNewAvatarSelected) {
                        user.image = data;
                    }
                    this.$emit('userDataUpdated', user);
                    this.$emit('dialogClosed');
                })
                .catch(err => console.log(err));
        },
        closeDialog() {
            this.$emit('dialogClosed');
        },
        onPickFile() {
            this.$refs.newAvatar.click();
        },
        onFilePicked(event) {
            this.newUserData.image = event.target.files[0];
            this.avatarPreview = URL.createObjectURL(this.newUserData.image);
            this.isNewAvatarSelected = true;
        },
        deleteSelectedAvatar() {
            this.avatarPreview = '';
            this.isNewAvatarSelected = false;
            this.newUserData.image = '';
        }
    },
    created() {
        this.authUser = this.$auth.user();
        this.userID = this.oldUserData.id;
        this.newUserData = { ...this.oldUserData };
    }
}
</script>

<style scoped>
    img {
        cursor: pointer;
        object-fit: cover;
        width: 180px;
        height: 180px;
        transition: transform 1s;
    }

    img:hover {
        transform: scale(1.03);
    }
</style>
