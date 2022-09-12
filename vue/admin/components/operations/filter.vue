<template>
    <div class="accordion" id="accordionFilter">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <a class="accordion-button p-1" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                    Фильтрация
                </a>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse hide" aria-labelledby="headingOne"
                 data-bs-parent="#accordionFilter">
                <div class="accordion-body">
                    <form @submit.prevent="onFormSubmit">
                        <div class="row p-1">
                            <h6 class="card-title">Поиск</h6>
                            <div class="col-md-3 col-g-2">
                                <label for="inputSearchUserId" class="form-label">Пользователь</label>
                                <select v-model="itemssearch.search.user_id"
                                        class= "form-control form-control-sm"
                                        id="inputSearchUserId">
                                    <option :value="null" disabled>Выбрать</option>
                                    <option v-for="(item, id) in users" :value="item.id">
                                        {{ item.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 col-g-2">
                                <label for="inputSearchTypeId" class="form-label">Тип операции</label>
                                <select v-model="itemssearch.search.type_id"
                                        class= "form-control form-control-sm"
                                        id="inputSearchTypeId">
                                    <option :value="null" disabled>Выбрать</option>
                                    <option v-for="(item, id) in types" :value="id">
                                        {{ item }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 col-g-2">
                                <label for="inputSearchStatusId" class="form-label">Статус</label>
                                <select v-model="itemssearch.search.status_id"
                                        class= "form-control form-control-sm"
                                        id="inputSearchStatusId">
                                    <option :value="null" disabled>Выбрать</option>
                                    <option v-for="(item, id) in statuses" :value="id">
                                        {{ item }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3 col-g-2">
                                <label for="inputSearchAccount" class="form-label">Счет</label>
                                <input v-model="itemssearch.search.account"
                                       type="text" class= "form-control form-control-sm"
                                       id="inputSearchAccount"
                                       placeholder="Поиск по счету">
                            </div>
                        </div>
                        <div class="row p-1">
                            <h6 class="card-title">Сортировка</h6>
                            <div class="col-md-2 col-g-2">
                                <label for="inputSearchTypeId" class="form-label">Тип операции</label>
                                <div class="form-check" v-for="(item, id) in {'ASC':'По возрастанию', 'DESC': 'По убыванию'}">
                                    <input class="form-check-input" type="radio" v-model="itemssearch.sort.type_id" :id="'inputSearchTypeId' + id" :value="id">
                                    <label class="form-check-label" :for="'inputSearchTypeId' + id">
                                        {{ item }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 col-g-2">
                                <label for="inputSearchAccount" class="form-label">Счет</label>
                                <div class="form-check" v-for="(item, id) in {'ASC':'По возрастанию', 'DESC': 'По убыванию'}">
                                    <input class="form-check-input" type="radio" v-model="itemssearch.sort.account" :id="'inputSearchAccount' + id" :value="id">
                                    <label class="form-check-label" :for="'inputSearchAccount' + id">
                                        {{ item }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 col-g-2">
                                <label for="inputSortUpdated" class="form-label">Дата</label>
                                <div class="form-check" v-for="(item, id) in {'ASC':'По возрастанию', 'DESC': 'По убыванию'}">
                                    <input class="form-check-input" type="radio" v-model="itemssearch.sort.updated_at" :id="'inputSortUpdated' + id" :value="id">
                                    <label class="form-check-label" :for="'inputSortUpdated' + id">
                                        {{ item }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-12  col-g-12">
                                <button type="submit" class="btn btn-primary">Найти</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    inject: ['axiosHeaders'],
    props: {
        itemssearch: Object,
    },
    mounted() {
        this.getUsersList(),
        this.getStatuses(),
        this.getTypes()
    },
    data: function () {
        return {
            users: {},
            statuses: {},
            types: {}
        }
    },
    methods: {
        getUsersList: function () {
            var app = this;
            app.preloader = true;
            var itemssearch = {
                search: {},
                sort: {},
                page: 1
            };
            let headers = this.axiosHeaders;

            axios.post('/api/v1/users', itemssearch, {headers})
                .then(function (resp) {
                    app.users = resp.data.data;
                    app.preloader = false;
                })
                .catch(function (resp) {
                    alert('Ошибка');
                });
        },
        getStatuses: function () {
            var app = this;
            app.preloader = true;
            let headers = this.axiosHeaders;

            axios.get('/api/v1/operations/statuseslist', {headers})
                .then(function (resp) {
                    app.statuses = resp.data;
                    app.preloader = false;
                })
                .catch(function (resp) {
                    alert('Ошибка');
                });
        },
        getTypes: function () {
            var app = this;
            app.preloader = true;
            let headers = this.axiosHeaders;

            axios.get('/api/v1/operations/typeslist', {headers})
                .then(function (resp) {
                    app.types = resp.data;
                    app.preloader = false;
                })
                .catch(function (resp) {
                    alert('Ошибка');
                });
        },
    }
}
</script>
