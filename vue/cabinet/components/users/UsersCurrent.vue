<template>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>
    <div v-else class=" mt-1">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mt-1">Редактируем {{ model.name }}</h2>
            </div>
            <div class="card-body">
                <div class="p-1">
                    <form v-on:submit.prevent="saveForm()">
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                <label class="control-label">Имя</label>
                                <input type="text"
                                       v-model="model.name"
                                       class="form-control"
                                       v-bind:class="{ 'is-invalid': errors.name }">
                                <div class="invalid-feedback" v-if="errors.name">
                                    {{ errors.name }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                <label class="control-label">Email</label>
                                <input type="text"
                                       v-model="model.email"
                                       class="form-control"
                                       v-bind:class="{ 'is-invalid': errors.email }">
                                <div class="invalid-feedback" v-if="errors.email">
                                    {{ errors.email }}
                                </div>
                            </div>
                        </div>

                        <div class="accordion mt-3" id="accordionPassword">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePassword" aria-expanded="true" aria-controls="collapsePassword">
                                        Изменить пароль
                                    </button>
                                </h2>
                                <div id="collapsePassword" class="accordion-collapse collapse hide" aria-labelledby="headingOne"
                                     data-bs-parent="#accordionPassword">
                                    <div class="row p-1">
                                        <div class="col-xs-12 form-group">
                                            <label class="control-label">Пароль</label>
                                            <input type="password"
                                                   v-model="model.password"
                                                   class="form-control"
                                                   v-bind:class="{ 'is-invalid': errors.password }">
                                            <div class="invalid-feedback" v-if="errors.password">
                                                {{ errors.password }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-xs-12 form-group">
                                            <label class="control-label">Повторите пароль</label>
                                            <input type="password"
                                                   v-model="model.password2"
                                                   class="form-control"
                                                   v-bind:class="{ 'is-invalid': errors.password2 }">
                                            <div class="invalid-feedback" v-if="errors.password2">
                                                {{ errors.password2 }}
                                            </div>
                                        </div>
                                    </div>
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
const headers = {
    Authorization: 'Bearer ' + window.Laravel.accessToken,
    Section: 'Cabinet-Auth'
};
export default {
    inject: ['axiosHeaders'],
    mounted() {
        this.getData()
    },
    components: {
        VuePreloader
    },
    data: function () {
        return {
            preloader: true,
            errors: {},
            model_id: null,
            model: {
                id: '',
                name: '',
                email: '',
                password: '',
                password2: '',
            }
        }
    },
    methods: {
        getData: function () {
            let app = this;
            app.preloader = true;
            let user = window.Laravel.user;
            let id = user.id;
            app.model_id = id;
            let headers = this.axiosHeaders

            axios.get('/api/v1/users/' + id + '/get/', {headers})
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

            axios.post('/api/v1/users/' + app.model_id + '/update', newModel, {headers})
                .then(function (resp) {
                    app.$router.push({name: 'users_current'});
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
