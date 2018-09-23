<template>
    <v-dialog v-model="createDialog" persistent max-width="550px">
        <v-card>
            <v-card-title>
                <span class="headline">Создать оборудование</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-layout wrap>
                                <v-flex xs12 d-flex>
                                    <v-avatar
                                        @click="onPickFile"
                                        size="200">
                                        <img :src="imgPreview === '' ? uploadImage : imgPreview" alt="imgPreview">
                                    </v-avatar>
                                    <input v-validate="'required|image'" data-vv-as="image" data-vv-name="image" @change="onFilePicked($event)" style="display:none;" type="file" ref="imgPreview">
                                </v-flex>
                                <v-flex xs12>
                                    <div class="img-err error--text" v-if="errors.has('image')">
                                        {{ errors.collect('image')[0] }}
                                    </div>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required'"
                                data-vv-name="name"
                                :error-messages="errors.collect('name')"
                                v-model="newEquipment.name"
                                label="Модель">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|decimal:2'"
                                data-vv-name="incoming_price"
                                :error-messages="errors.collect('incoming_price')"
                                v-model="newEquipment.incoming_price"
                                append-icon="attach_money"
                                label="Входящая цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|decimal:2'"
                                data-vv-name="price"
                                :error-messages="errors.collect('price')"
                                v-model="newEquipment.price"
                                append-icon="attach_money"
                                label="Цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|decimal:2'"
                                data-vv-name="installation_price_for_one"
                                :error-messages="errors.collect('installation_price_for_one')"
                                v-model="newEquipment.installation_price_for_one"
                                append-icon="₴"
                                label="Стоимость монтажа 1шт."></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'decimal:2'"
                                data-vv-name="installation_price_for_two"
                                :error-messages="errors.collect('installation_price_for_two')"
                                v-model="newEquipment.installation_price_for_two"
                                append-icon="₴"
                                label="Стоимость монтажа 2шт."></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'decimal:2'"
                                data-vv-name="installation_price_for_three"
                                :error-messages="errors.collect('installation_price_for_three')"
                                v-model="newEquipment.installation_price_for_three"
                                append-icon="₴"
                                label="Стоимость монтажа 3шт."></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-textarea v-model="newEquipment.description" label="Описание"></v-textarea>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="createEquipment">Сохранить</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        createDialog: {
            type: Boolean,
            required: true
        },
        type: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            pending: false,
            uploadImage: '/storage/upload-foto.png',
            imgPreview: '',
            newEquipment: {
                image: '',
                name: '',
                incoming_price: '',
                price: '',
                installation_price_for_one: '',
                installation_price_for_two: '',
                installation_price_for_three: '',
                description: '',
                type: ''
            }
        };
    },
    methods: {
        createEquipment() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation:error');
                        return;
                    }
                    this.pending = true;
                    this.newEquipment.type = this.type;
                    const formData = new FormData();
                    formData.append('image', this.newEquipment.image);
                    formData.append('name', this.newEquipment.name);
                    formData.append('incoming_price', this.newEquipment.incoming_price);
                    formData.append('price', this.newEquipment.price);
                    formData.append('installation_price_for_one', this.newEquipment.installation_price_for_one);
                    formData.append('installation_price_for_two', this.newEquipment.installation_price_for_two);
                    formData.append('installation_price_for_three', this.newEquipment.installation_price_for_three);
                    formData.append('description', this.newEquipment.description);
                    formData.append('type', this.newEquipment.type);

                    this.$store.dispatch('createEquipment', formData)
                        .then((data) => {
                            this.$emit('equipment-created');
                            this.$emit('createDialogClosed', 'createDialog');
                            this.pending = false;
                        })
                        .catch(err => {
                            this.$emit('equipment:error');
                            this.pending = false;
                            console.log(err);
                        });
                });
        },
        onPickFile() {
            this.$refs.imgPreview.click();
        },
        onFilePicked(event) {
            this.newEquipment.image = event.target.files[0];
            this.imgPreview = URL.createObjectURL(this.newEquipment.image);
        },
        closeDialog() {
            this.$emit('createDialogClosed', 'createDialog');
        }
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
        width: 200px;
        height: 200px;
        transition: transform 1s;
    }

    img:hover {
        transform: scale(1.03);
    }
</style>
