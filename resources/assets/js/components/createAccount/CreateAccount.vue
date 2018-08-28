<template>
    <v-dialog v-model="createAccountDialog" persistent max-width="550px">
        <v-btn slot="activator" color="primary">Создать аккаунт</v-btn>
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

function initialData() {
    return {
        createAccountDialog: false,
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
                    this.$emit('account:created', data);
                    this.reset();
                })
                .catch(err => {
                    console.log(err);
                    this.$emit('account:error');
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
