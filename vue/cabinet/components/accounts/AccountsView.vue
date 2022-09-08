<template>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>
    <div v-else class=" mt-1">
        <nav aria-label="breadcrumb">
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
        </nav>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mt-1">Информация по счету</h2>
            </div>
            <div class="card-body">
                <vue-view :model="model"></vue-view>
            </div>
            <div class="card-header">
                <h2 class="card-title mt-1">История операций</h2>
            </div>
            <div class="card-body">
                <vue-operations :model="model"></vue-operations>
            </div>
        </div>
    </div>
</template>

<script>
import VuePreloader from '../preloader.vue';
import VueView from './view.vue';
import VueOperations from './operations.vue';


import {VueEditor} from "vue3-editor";

export default {
    inject: ['axiosHeaders'],
    mounted() {
        this.getData()
    },
    components: {
        VuePreloader,
        VueEditor,
        VueView,
        VueOperations
    },
    data: function () {
        return {
            preloader: true,
            errors: {},
            model_id: null,
            model: {
                id: '',
                code: '',
                title: '',
                description: '',
                created_at: '',
            },
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
    }
}
</script>
