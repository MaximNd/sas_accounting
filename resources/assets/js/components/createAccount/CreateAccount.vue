<template>
    <v-dialog v-model="createAccountDialog" persistent max-width="550px">
        <v-btn slot="activator" color="primary">Создать аккаунт</v-btn>
        <v-card>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-layout wrap>
                                <v-flex xs12 d-flex>
                                    <v-avatar
                                        @click="onPickFile"
                                        raised
                                        size="250">
                                        <img :src="avatarPreview === '' ? uploadAvatarImage : avatarPreview" alt="avatar">
                                    </v-avatar>
                                    <input v-validate="'image'" data-vv-as=" " data-vv-name="image" @change="onFilePicked($event)" style="display:none;" type="file" ref="avatar">
                                </v-flex>
                                <v-flex xs12>
                                    <div class="img-err error--text" v-if="errors.has('image')">
                                        {{ errors.collect('image')[0] }}
                                    </div>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex class="mt-4" xs12 v-if="isNewAvatarSelected" d-flex>
                            <v-btn raised color="error" @click="deleteSelectedAvatar">Убрать изображение</v-btn>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|max:30'"
                                data-vv-name="last_name"
                                data-vv-as=" "
                                :error-messages="errors.collect('last_name')"
                                v-model="user.last_name"
                                label="Фамилия"
                                required></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|max:30'"
                                data-vv-name="first_name"
                                data-vv-as=" "
                                :error-messages="errors.collect('first_name')"
                                v-model="user.first_name"
                                label="Имя"
                                required></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|max:30'"
                                data-vv-name="mid_name"
                                data-vv-as=" "
                                :error-messages="errors.collect('mid_name')"
                                v-model="user.mid_name"
                                label="Отчество"
                                required></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|email|unique'"
                                data-vv-name="email"
                                data-vv-as="email"
                                data-vv-delay="500"
                                :error-messages="errors.collect('email')"
                                v-model="user.email"
                                label="Email"
                                required></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|max:30'"
                                data-vv-name="position"
                                data-vv-as=" "
                                :error-messages="errors.collect('position')"
                                v-model="user.position"
                                label="Должность"
                                required></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-select
                                v-validate="'required|included:admin,user'"
                                data-vv-name="role"
                                data-vv-as=" "
                                :error-messages="errors.collect('role')"
                                v-model="user.role"
                                :items="['admin', 'user']"
                                label="Role"
                                required></v-select>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|max:20'"
                                data-vv-name="telephone"
                                data-vv-as=" "
                                :error-messages="errors.collect('telephone')"
                                v-model="user.telephone"
                                label="Телефон"
                                required></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :loading="pending" :disabled="pending" color="error" flat @click.native="createAccountDialog = false">Закрыть</v-btn>
                <v-btn :loading="pending" :disabled="pending" color="success" flat @click.native="createAccount">Создать</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import { uploadImage } from './../../constants/images';

function initialData() {
    return {
        createAccountDialog: false,
        avatarPreview: '',
        uploadAvatarImage: uploadImage,
        isNewAvatarSelected: false,
        pending: false,
        user: {
            last_name: '',
            first_name: '',
            mid_name: '',
            position: '',
            role: '',
            email: '',
            telephone: '',
            image: ''
        }
    };
};

export default {
    data() {
        return {
            ...initialData()
        };
    },
    methods: {
        createAccount() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation:error');
                        return;
                    }
                    const formData = new FormData();
                    formData.append('last_name', this.user.last_name);
                    formData.append('first_name', this.user.first_name);
                    formData.append('mid_name', this.user.mid_name);
                    formData.append('position', this.user.position);
                    formData.append('role', this.user.role);
                    formData.append('email', this.user.email);
                    formData.append('telephone', this.user.telephone);
                    if (this.isNewAvatarSelected) {
                        formData.append('image', this.user.image);
                    }
                    this.pending = true;
                    this.axios.post('/users', formData)
                        .then(({ data }) => {
                            this.$emit('account:created', data);
                            this.reset();
                        })
                        .catch(err => {
                            console.log(err);
                            this.$emit('account:error');
                            this.pending = false;
                        });
                });
        },
        onPickFile() {
            this.$refs.avatar.click();
        },
        onFilePicked(event) {
            this.user.image = event.target.files[0];
            this.avatarPreview = URL.createObjectURL(this.user.image);
            this.isNewAvatarSelected = true;
        },
        deleteSelectedAvatar() {
            this.$validator.errors.remove('image');
            this.$refs.avatar.value = '';
            this.avatarPreview = '';
            this.isNewAvatarSelected = false;
            this.user.image = '';
        },
        reset() {
            Object.assign(this.$data, initialData());
        }
    },
    created() {
        this.$validator.extend('unique', {
            validate: value => new Promise((resolve, reject) => {
                this.axios.get(`/users/unique-email/${value}`)
                    .then(data => {
                        return resolve({
                            valid: true
                        });
                    })
                    .catch(err => {
                        return resolve({
                            valid: false,
                            data: {
                                message: err.response.data.errors.email[0]
                            }
                        });
                    });
            }),
            getMessage: (field, params, data) => data.message
        });
    }
}
</script>

<style scoped>
    .img-err {
        width: 100%;
        text-align: center;
        font-size: 20px;
        padding: 5px;
    }

    img {
        cursor: pointer;
        object-fit: cover;
        width: 250px;
        height: 250px;
        transition: transform 1s;
    }

    img:hover {
        transform: scale(1.03);
    }
</style>
