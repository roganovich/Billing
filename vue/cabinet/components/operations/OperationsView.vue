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
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mt-1">Информация по операции {{ model.id }}</h2>
            </div>
            <div class="card-body">
                <ol class="list-group-">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Счет</div>
                            <p class="card-text">
                                <router-link :to="{name: 'accounts_view', params: {id: model.account.id}}" title="Назад">{{ model.account.code }}</router-link>
                            </p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Тип</div>
                            <p class="card-text">{{ model.type }}</p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Статус</div>
                            <p class="card-text">{{ model.status }}</p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Сумма</div>
                            <p class="card-text">{{ model.amount }}</p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Баланс</div>
                            <p class="card-text">{{ model.balance }}</p>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Дата</div>
                            <p>{{ short_date(model.created_at) }}</p>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
import VuePreloader from '../preloader.vue';
import {VueEditor} from "vue3-editor";
import moment from "moment";
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
            model: {
                id: null,
                type: null,
                status: null,
                account: null,
                balance: null,
                created_at: null,
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

            axios.get('/api/v1/operations/' + id + '/get/', {headers})
                .then(function (resp) {
                    app.model = resp.data.data;
                    app.preloader = false;
                })
                .catch(function () {
                    alert('Ошибка')
                });
        },
        short_date(date) {
            return (date) ? moment(String(date)).format('DD.MM.YYYY hh:mm') : '';
        },
    }
}
</script>
