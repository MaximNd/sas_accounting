<template>
    <v-dialog v-model="dialog" persistent max-width="550px">
      <v-card>
        <v-card-title>
          <span class="headline">User Profile</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
                <v-flex xs12 d-flex>
                    <v-avatar
                        v-if="!errors.has('image')"
                        @click="onPickFile"
                        raised
                        size="200">
                        <img :src="avatarPreview === '' ? uploadAvatarImage : avatarPreview" alt="avatar">
                    </v-avatar>
                    <input v-validate="'image'" data-vv-as="image" data-vv-name="image" @change="onFilePicked($event)" style="display:none;" type="file" ref="newAvatar">
                    <div class="img-err error--text" v-if="errors.has('image')">
                        {{ errors.collect('image')[0] }}
                    </div>
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
                    <v-text-field v-validate="'email'" data-vv-name="email" :error-messages="errors.collect('email')" v-model="newUserData.email" label="Email"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="authUser.role === 'admin'">
                    <v-text-field v-model="newUserData.position" label="Должность"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="authUser.role === 'admin'">
                    <v-select v-validate="'included:admin,user'" data-vv-name="role" :error-messages="errors.collect('role')" v-model="newUserData.role" :items="['admin', 'user']" label="Role"></v-select>
                </v-flex>
                <v-flex xs12>
                    <v-text-field v-validate="'max:20'" data-vv-name="telephone" :error-messages="errors.collect('telephone')" v-model="newUserData.telephone" label="Телефон"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="isSame">
                    <v-text-field v-validate="{ required: isPasswordRequired }" data-vv-name="password" name="password" :error-messages="errors.collect('password')" ref="password" v-model="newUserData.password" label="Новый пароль" type="password"></v-text-field>
                </v-flex>
                <v-flex xs12 v-if="isSame">
                    <v-text-field target="password" v-validate="{ required: isPasswordConfirmationRequired, confirmed: 'password' }" data-vv-name="password_confirmation" :error-messages="errors.collect('password_confirmation')" ref="password_confirmation" v-model="newUserData.password_confirmation" label="Подтверждение пароля" type="password"></v-text-field>
                </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
          <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="save">Сохранить</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<script>
import utils from './../../../mixins/utils.js';
import { uploadImage } from './../../../constants/images.js';

export default {
    mixins: [utils],
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
            pending: false,
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
            uploadAvatarImage: uploadImage
        };
    },
    computed: {
        isSame() {
            return this.authUser.id === this.userID;
        },
        isPasswordRequired() {
            return !this.isNull(this.newUserData.password_confirmation) &&
                    !this.isUndefined(this.newUserData.password_confirmation) &&
                    this.newUserData.password_confirmation !== '';
        },
        isPasswordConfirmationRequired() {
            return !this.isNull(this.newUserData.password) &&
                    !this.isUndefined(this.newUserData.password) &&
                    this.newUserData.password !== '';
        }
    },
    methods: {
        save() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation-error');
                        return;
                    };
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
                    this.pending = true;

                    this.axios.post(`/users/${this.userID}`, formData)
                        .then(({data}) => {
                            const { password, password_confirmation, ...newUserData } = this.newUserData;
                            const user = { ...newUserData };
                            if (this.isNewAvatarSelected) {
                                user.image = data;
                            }
                            if (this.newUserData.image === '') {
                                user.image = this.oldUserData.image;
                            }
                            this.pending = false;
                            this.$emit('userDataUpdated', user);
                            this.$emit('dialogClosed');
                            this.deleteSelectedAvatar();
                        })
                        .catch(err => {
                            this.pending = false;
                            this.$emit('update-error');
                            console.log(err);
                        });
                });
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
            this.$validator.errors.remove('image');
            this.$refs.newAvatar.value = '';
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
    .img-err {
        text-align: center;
        font-size: 20px;
        padding: 5px;
    }

    img {
        cursor: pointer;
        object-fit: cover;
        width: 200px;
        height: 200px;
        transition: transform 1s;
    }

    img:hover {
        transform: scale(1.03);
    }
</style>
