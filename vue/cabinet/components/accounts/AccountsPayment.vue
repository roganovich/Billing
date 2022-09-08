<template>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>
    <div v-else>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <router-link :to="{name: 'cabinet'}"  title="Кабинет">Кабинет</router-link>
            </li>
            <li class="breadcrumb-item">
                <router-link :to="{name: 'accounts_index'}"  title="Мои счета">Мои счета</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Новый взнос
            </li>
        </ol>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mt-1">Новый взнос по счету</h2>
            </div>
            <div class="card-body">
                <div class="mt-1">
                    <vue-view :model="model"></vue-view>
                </div>
            </div>

            <div class="card-header">
                <h2 class="card-title mt-1">Форма оплаты</h2>
            </div>
            <div class="card-body">
                <div class="p-1">
                    <form v-on:submit.prevent="saveForm()">
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                <label class="control-label">Тип взноса</label>
                                <select v-model="model.type_id"
                                        class="form-control"
                                        v-bind:class="{ 'is-invalid': errors.type_id }"
                                        id="inputSearchTypeId">
                                    <option :value="null" disabled>Выбрать</option>
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
                                <label class="control-label">Сумма</label>
                                <input type="text"
                                       v-model="model.amount"
                                       class="form-control"
                                       v-bind:class="{ 'is-invalid': errors.amount }">
                                <div class="invalid-feedback" v-if="errors.amount">
                                    {{ errors.amount }}
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
import VueView from './view.vue';
import {VueEditor} from "vue3-editor";

export default {
    inject: ['axiosHeaders'],
    mounted() {
        this.getData(),
        this.getTypesList()
    },
    components: {
        VuePreloader,
        VueEditor,
        VueView
    },
    data: function () {
        return {
            preloader: true,
            errors: {},
            types: {},
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
                    if(resp.data){
                        app.model = resp.data;
                        app.preloader = false;
                    }
                })
                .catch(function () {
                    alert('Ошибка')
                });
        },
        getTypesList: function () {
            var app = this;
            let headers = this.axiosHeaders;

            axios.get('/api/v1/operations/typeslist', {headers})
                .then(function (resp) {
                    app.types = resp.data;
                })
                .catch(function (resp) {
                    alert('Ошибка');
                });
        },
        saveForm(e) {
            var app = this;
            app.preloader = true;
            var newModel = app.model;
            let headers = this.axiosHeaders

            axios.post('/api/v1/accounts/' + app.model_id + '/pay', newModel, {headers})
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
