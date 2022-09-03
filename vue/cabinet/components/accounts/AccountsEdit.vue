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
        <div class="card-title mt-1">Редактируем {{ model.code }} ({{ model.title }})</div>
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
    computed: {
        axiosParams() {
            const params = new URLSearchParams();
            params.append('user_id', window.Laravel.user.id);
            params.append('accessToken', window.Laravel.accessToken);
            return params;
        }
    },

    methods: {
        getData: function () {
            let app = this;
            app.preloader = true;
            let id = app.$route.params.id;
            app.model_id = id;
            axios.get('/api/v1/accounts/' + id + '/get/' + '?' + this.axiosParams)
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
            // Auth
            newModel.user_id = this.axiosParams.get('user_id') ;
            newModel.accessToken = this.axiosParams.get('accessToken') ;

            axios.post('/api/v1/accounts/' + app.model_id + '/update', newModel)
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
