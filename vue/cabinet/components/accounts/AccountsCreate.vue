<template>
    <div class="p-1">
        <div class="form-group mt-1">
            <router-link :to="{name: 'accounts_index'}" class="btn btn-dark btn-sm" title="Назад">Назад</router-link>
        </div>
    </div>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>
    <div v-else class=" mt-1">
        <div class="card-title mt-1">Создание нового счета</div>
        <div class="p-1">
            <form v-on:submit.prevent="saveForm()">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Тип счета</label>
                        <select v-model="model.type_id"
                                class="form-control"
                                v-bind:class="{ 'is-invalid': errors.type_id }"
                                id="inputSearchTypeId">
                            <option></option>
                            <option v-for="(item, id) in types" :value="id">
                                {{ item }}
                            </option>
                        </select>
                        <div class="invalid-feedback" v-if="errors.type_id">
                            {{ errors.type_id }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Заголовок</label>
                        <input type="text"
                               v-model="model.title"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.title }">
                        <div class="invalid-feedback" v-if="errors.title">
                            {{ errors.title }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Описание</label>
                        <vue-editor
                            id="editor"
                            useCustomImageHandler
                            @imageAdded="handleImageAdded"
                            class="form-control"
                            v-bind:class="{ 'is-invalid': errors.description }"
                            v-model="model.description"
                        >
                        </vue-editor>
                        <div class="invalid-feedback" v-if="errors.description">
                            {{ errors.description }}
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xs-12 form-group">
                        <button class="btn btn-success">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import VuePreloader from '../preloader.vue';
import {VueEditor} from "vue3-editor";

export default {
    mounted() {
        this.getTypesList()
    },
    components: {
        VuePreloader,
        VueEditor
    },
    data: function () {
        return {
            preloader: false,
            errors: {},
            types: {},
            model_id: null,
            model: {
                id: '',
                title: '',
                type_id: '',
                user_id: '',
                description: '',
            }
        }
    },
    created() {
        if (window.Laravel.user) {
            this.user = window.Laravel.user
            this.user_id = window.Laravel.user.id
        }
    },
    computed: {
        axiosParams() {
            const params = new URLSearchParams();
            params.append('user_id', window.Laravel.user.id);
            params.append('accessToken', window.Laravel.accessToken);
            return params;
        }
    },
    methods: {
        getTypesList: function () {
            var app = this;
            app.preloader = true;
            axios.get('/api/v1/accounts/typeslist' + '?' + this.axiosParams)
                .then(function (resp) {
                    app.types = resp.data;
                    app.preloader = false;
                })
                .catch(function (resp) {
                    alert('Ошибка');
                });
        },
        saveForm(e) {
            var app = this;
            app.preloader = true;
            var newModel = app.model;
            // Auth
            newModel.user_id = this.axiosParams.get('user_id') ;
            newModel.accessToken = this.axiosParams.get('accessToken') ;

            axios.post('/api/v1/accounts/store', newModel)
                .then(function (resp) {
                    app.$router.push({name: 'accounts_index'});
                    app.preloader = false;;
                })
                .catch(function (resp) {
                    var errors = resp.response.data.errors;
                    for (var row in errors) {
                        app.errors[row] = errors[row][0];
                    }
                });
            app.preloader = false;
        },
        handleImageAdded: function (file, Editor, cursorLocation, resetUploader) {
            var app = this;

            var formData = new FormData();
            formData.append("image", file);

            axios.post('/api/v1/accounts/addimage', formData)
                .then(function (resp) {
                    const url = resp.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
}
</script>
