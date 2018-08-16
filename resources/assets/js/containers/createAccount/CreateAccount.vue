<template>
    <v-container fluid v-if="$auth.ready()">
        <v-layout align-start justify-start>
            <v-flex sm12 md10 lg8 xl4>
                <v-card>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 d-flex>
                                    <v-avatar
                                        @click="onPickFile"
                                        raised
                                        size="250">
                                        <img :src="avatarPreview === '' ? uploadAvatarImage : avatarPreview" alt="avatar">
                                    </v-avatar>
                                    <input @change="onFilePicked($event)" style="display:none;" type="file" ref="avatar">
                                </v-flex>
                                <v-flex class="mt-4" xs12 v-if="isNewAvatarSelected" d-flex>
                                    <v-btn raised color="error" @click="deleteSelectedAvatar">Убрать изображение</v-btn>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="user.last_name" label="Фамилия" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="user.first_name" label="Имя" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="user.mid_name" label="Отчество" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="user.email" label="Email" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="user.position" label="Должность" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-select v-model="user.role" :items="['admin', 'user']" label="Role" required></v-select>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field v-model="user.telephone" label="Телефон" required></v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-layout justify-center>
                                        <v-btn
                                            @click="createAccount"
                                            color="primary"
                                            :loading="pending"
                                            :disabled="pending">
                                            Добавить
                                        </v-btn>
                                    </v-layout>
                                </v-flex>
                                <v-snackbar
                                    v-model="snackbar"
                                    :timeout="2000"
                                    :color="statusColor"
                                    auto-height
                                    right>
                                    {{ statusText }}
                                </v-snackbar>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

function initialData() {
    return {
        avatarPreview: '',
        uploadAvatarImage: '/storage/upload-foto.png',
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
            statusText: '',
            statusColor: '',
            snackbar: false,
            ...initialData()
        };
    },
    methods: {
        createAccount() {
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
                    console.log(data);
                    this.snackbar = true;
                    this.statusColor = 'success';
                    this.statusText = 'Аккаунт создан!';
                    this.reset();
                })
                .catch(err => {
                    console.log(err);
                    this.snackbar = true;
                    this.statusColor = 'error';
                    this.statusText = 'Ошибка';
                    this.pending = false;
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
            this.avatarPreview = '';
            this.isNewAvatarSelected = false;
            this.user.image = '';
        },
        reset() {
            Object.assign(this.$data, initialData());
        }
    }
}
</script>

<style scoped>
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
