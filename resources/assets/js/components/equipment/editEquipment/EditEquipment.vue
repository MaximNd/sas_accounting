<template>
    <v-dialog v-model="editDialog" persistent max-width="550px">
        <v-card>
            <v-card-title>
                <span class="headline">Редактировать оборудование</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-layout wrap>
                                <v-flex xs12 d-flex>
                                    <v-avatar
                                        @click="onPickFile"
                                        tile
                                        size="200">
                                        <img :src="imgPreview === '' ? uploadImage : imgPreview" alt="imgPreview">
                                    </v-avatar>
                                    <input v-validate="'image'" data-vv-as=" " data-vv-name="image" @change="onFilePicked($event)" style="display:none;" type="file" ref="imgPreview">
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
                                data-vv-as=" "
                                :error-messages="errors.collect('name')"
                                v-model="editedEquipment.name"
                                label="Модель"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|decimal:2|min_value:0'"
                                data-vv-name="incoming_price"
                                data-vv-as=" "
                                :error-messages="errors.collect('incoming_price')"
                                @input="replaceComma($event, editedEquipment, 'incoming_price')"
                                :value="editedEquipment.incoming_price"
                                append-icon="attach_money"
                                label="Входящая цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|decimal:2|min_value:0'"
                                data-vv-name="price"
                                data-vv-as=" "
                                :error-messages="errors.collect('price')"
                                @input="replaceComma($event, editedEquipment, 'price')"
                                :value="editedEquipment.price"
                                append-icon="attach_money"
                                label="Цена"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'required|decimal:2|min_value:0'"
                                data-vv-name="installation_price_for_one"
                                data-vv-as=" "
                                :error-messages="errors.collect('installation_price_for_one')"
                                @input="replaceComma($event, editedEquipment, 'installation_price_for_one')"
                                :value="editedEquipment.installation_price_for_one"
                                append-icon="₴"
                                label="Стоимость монтажа 1шт."></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'decimal:2|min_value:0'"
                                data-vv-name="installation_price_for_two"
                                data-vv-as=" "
                                :error-messages="errors.collect('installation_price_for_two')"
                                @input="replaceComma($event, editedEquipment, 'installation_price_for_two')"
                                :value="editedEquipment.installation_price_for_two"
                                append-icon="₴"
                                label="Стоимость монтажа 2шт."></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                v-validate="'decimal:2|min_value:0'"
                                data-vv-name="installation_price_for_three"
                                data-vv-as=" "
                                :error-messages="errors.collect('installation_price_for_three')"
                                @input="replaceComma($event, editedEquipment, 'installation_price_for_three')"
                                :value="editedEquipment.installation_price_for_three"
                                append-icon="₴"
                                label="Стоимость монтажа 3шт"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-textarea v-model="editedEquipment.description" label="Описание"></v-textarea>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="pending" :loading="pending" color="error" flat @click.native="closeDialog">Отмена</v-btn>
                <v-btn :disabled="pending" :loading="pending" color="success" flat @click.native="editEquipment">Сохранить</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import forms from './../../../mixins/forms.js';
import { uploadImage } from './../../../constants/images.js';

export default {
    mixins: [forms],
    props: {
        editDialog: {
            type: Boolean,
            required: true
        },
        equipment: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            uploadImage,
            imgPreview: '',
            pending: false,
            editedEquipment: {}
        };
    },
    watch: {
        equipment(newVal) {
            this.editedEquipment = { ...newVal };
        }
    },
    methods: {
        editEquipment() {
            this.$validator.validateAll()
                .then(isValid => {
                    if (!isValid) {
                        this.$emit('validation:error');
                        return;
                    }
                    this.pending = true;
                    const payload = {
                        id: this.equipment.id,
                        isService: false,
                        equipment: {
                            image: this.editedEquipment.image,
                            name: this.editedEquipment.name,
                            incoming_price: this.editedEquipment.incoming_price,
                            price: this.editedEquipment.price,
                            installation_price_for_one: this.editedEquipment.installation_price_for_one,
                            installation_price_for_two: this.editedEquipment.installation_price_for_two,
                            installation_price_for_three: this.editedEquipment.installation_price_for_three,
                            description: this.editedEquipment.description,
                            type: this.editedEquipment.type
                        },
                        log: {
                            before: JSON.stringify(this.equipment),
                            after: JSON.stringify(this.editedEquipment)
                        }
                    };
                    this.$store.dispatch('editEquipment', payload)
                        .then((data) => {
                            this.imgPreview = '';
                            this.$emit('editDialogClosed', 'editDialog');
                            this.$emit('equipment-updated');
                            this.pending = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$emit('equipment:error');
                            this.pending = false;
                        });
                });
        },
        onPickFile() {
            this.$refs.imgPreview.click();
        },
        onFilePicked(event) {
            const formData = new FormData();
            formData.append('image', event.target.files[0]);
            this.$store.dispatch('uploadImage', { id: this.editedEquipment.id, image: formData })
                .then(imgName => {
                    this.editedEquipment.image = imgName;
                    this.imgPreview = URL.createObjectURL(event.target.files[0]);
                    this.$refs.imgPreview.value = null;
                });
        },
        closeDialog() {
            this.imgPreview = '';
            this.$emit('editDialogClosed', 'editDialog');
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
        width: 200px;
        height: 200px;
        transition: transform 1s;
    }

    img:hover {
        transform: scale(1.03);
    }
</style>
