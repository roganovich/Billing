<template>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>

    <div v-else>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <router-link :to="{name: 'admin'}"  title="Панель">Панель</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Операций
            </li>
        </ol>
        <div class="card-header">
            <h2 class="card-title mt-1">История операций</h2>
        </div>
        <div class="mt-1">
            <vue-filter
                :itemssearch="itemssearch"
                @submit="getResults()"></vue-filter>
        </div>

        <div v-if="search">
            <vue-preloader></vue-preloader>
        </div>
        <div v-else class="mt-1">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Счет</th>
                    <th>Тип операции</th>
                    <th>Статус</th>
                    <th>Сумма</th>
                    <th>Баланс</th>
                    <th>Дата</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in items.data">
                    <td>{{ item.user.name }}</td>
                    <td>{{ item.account.code }}</td>
                    <td>{{ item.type }}</td>
                    <td>{{ item.status }}</td>
                    <td>{{ item.amount }}</td>
                    <td>{{ item.balance }}</td>
                    <td>{{ short_date(item.updated_at) }}</td>
                    <td>
                        <router-link
                            title="Информация о переводе"
                            :to="{name: 'operations_view', params: {id: item.id}}"
                            class="btn btn-sm btn-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                            </svg>
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>

            <vue-pagination :pagination="items"
                            @paginate="getResults()"
                            :offset="4">
            </vue-pagination>

        </div>
    </div>
</template>

<script>
import VuePagination from '../pagination.vue';
import VueFilter from './filter.vue';
import VuePreloader from '../preloader.vue';
import moment from 'moment';

export default {
    inject: ['axiosHeaders'],
    data: function () {
        return {
            preloader: true,
            search: true,
            items: {
                meta: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                }
            },
            offset: 4,
            itemssearch: {
                search: {
                    type_id: null,
                    status_id: null,
                    account: null,
                    status: null,
                },
                sort: {
                    type_id: null,
                    account: null,
                    updated_at: null,
                },
                page: 1
            },
        }
    },
    mounted() {
        this.getResults()
    },
    components: {
        VuePagination,
        VueFilter,
        VuePreloader
    },
    methods: {
        getResults: function () {
            var app = this;
            app.preloader = false;
            app.search = true;
            this.itemssearch.page = this.items.meta.current_page;
            let headers = this.axiosHeaders;

            axios.post('/api/v1/operations', this.itemssearch, {headers})
                .then(function (resp) {
                    app.items = resp.data;
                    app.search = false;
                })
                .catch(function (resp) {
                    alert('Ошибка');
                });
        },
        deleteEntry: function (item, index) {
            if (confirm('Вы уверены что хотите удалить? ', {title:item.title})) {
                var app = this;
                app.search = true;
                let headers = this.axiosHeaders;

                axios.delete('/api/v1/wikipages/' + item.id + '/destroy', {headers})
                    .then(function (resp) {
                        app.search = false;
                        app.$router.push({name: 'wikipages_index'});
                    })
                    .catch(function (resp) {
                        alert('Ошибка');
                    });
                this.getResults();
            }
        },
        short_date(date) {
            return (date) ? moment(String(date)).format('DD.MM.YYYY hh:mm') : '';
        },
    },
}
</script>
