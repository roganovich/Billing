<template>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>

    <div v-else>
        <div class="mt-1">
            <h5 class="card-title">История операций</h5>
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
                    <td>{{ item.account.code }}</td>
                    <td>{{ item.type }}</td>
                    <td>{{ item.status }}</td>
                    <td>{{ item.amount }}</td>
                    <td>{{ item.balance }}</td>
                    <td>{{ short_date(item.updated_at) }}</td>
                    <td>
                        <router-link
                            title="Редактировать"
                            :to="{name: 'operations_view', params: {id: item.id}}"
                            class="btn btn-sm btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
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
//import moment from 'moment';

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
            return date; //moment(String(date)).format('DD.MM.YYYY hh:mm');
        },
    },
}
</script>
