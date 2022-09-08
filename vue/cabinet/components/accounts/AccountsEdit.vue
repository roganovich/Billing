<template>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>
    <div v-else class=" mt-1">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <router-link :to="{name: 'cabinet'}"  title="Кабинет">Кабинет</router-link>
            </li>
            <li class="breadcrumb-item">
                <router-link :to="{name: 'accounts_index'}"  title="Мои счета">Мои счета</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ model.code }}
            </li>
        </ol>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mt-1">Редактируем {{ model.code }} ({{ model.title }})</h2>
            </div>
            <div class="card-body">
                <div class="p-1">
                    <form v-on:submit.prevent="saveForm()">
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
        </div>
    </div>
</template>

<script>
import VuePreloader from '../preloader.vue';
import {VueEditor} from "vue3-editor";

export default {
    inject: ['axiosHeaders'],
    mounted() {
        this.getData()
    },
    components: {
        VuePreloader,
        VueEditor
    },
    data: function () {
        return {
            preloader: true,
            errors: {},
            model_id: null,
            model: {
                id: '',
                title: '',
                description: '',
            }
        }
    },
    methods: {
        getData: function () {
            let app = this;
            app.preloader = true;
            let id = app.$route.params.id;
            app.model_id = id;
            let headers = this.axiosHeaders

            axios.get('/api/v1/accounts/' + id + '/get/', {headers})
                .then(function (resp) {
                    app.model = resp.data;
                    app.preloader = false;
                })
                .catch(function () {
                    alert('Ошибка')
                });
        },
        saveForm(e) {
            var app = this;
            app.preloader = true;
            var newModel = app.model;
            let headers = this.axiosHeaders

            axios.post('/api/v1/accounts/' + app.model_id + '/update', newModel, {headers})
                .then(function (resp) {
                    app.$router.push({name: 'accounts_index'});
                })
                .catch(function (resp) {
                    var errors = resp.response.data.errors;
                    for (var row in errors) {
                        app.errors[row] = errors[row][0];
                    }
                });

            app.preloader = false;
        },
    }
}
</script>
