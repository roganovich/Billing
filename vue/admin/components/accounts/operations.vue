<template>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
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
</template>

<script>

import moment from "moment";

export default {
    inject: ['axiosHeaders'],
    props: {
        model: Object,
    },
    data: function () {
        return {
            items: {
                meta: {
                    total: 0,
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                }
            },
            itemssearch: {
                search: {
                    account_id: null,
                },
                sort: {
                    updated_at: 'DESC',
                },
                page: 1
            },
            description_html: null
        }
    },
    mounted() {
        this.getDescription(),
        this.getResults()
    },
    methods: {
        getDescription: function () {
            let app = this;
            app.description_html = app.model.description;
        },
        getResults: function () {
            var app = this;
            if (app.model) {
                this.itemssearch.search.account_id = app.model.id;
                this.itemssearch.page = this.items.meta.current_page;
                let headers = this.axiosHeaders;

                axios.post('/api/v1/operations', this.itemssearch, {headers})
                    .then(function (resp) {
                        app.items = resp.data;
                    })
                    .catch(function (resp) {
                        alert('Ошибка');
                    });
            }

        },
        short_date(date) {
            return (date) ? moment(String(date)).format('DD.MM.YYYY hh:mm:ss') : '';
        },
    }
}
</script>
