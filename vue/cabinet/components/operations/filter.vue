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
                                <label for="inputSearchTitle" class="form-label">Заголовок</label>
                                <input v-model="itemssearch.search.title"
                                       type="text"
                                       class= "form-control form-control-sm"
                                       id="inputSearchTitle"
                                       placeholder="Поиск по заголовку">
                            </div>
                            <div class="col-md-3 col-g-2">
                                <label for="inputSearchDescription" class="form-label">В тексте</label>
                                <input v-model="itemssearch.search.description"
                                       type="text" class= "form-control form-control-sm"
                                       id="inputSearchDescription"
                                       placeholder="Поиск в содержимом">
                            </div>
                        </div>
                        <div class="row p-1">
                            <h6 class="card-title">Сортировка</h6>
                            <div class="col-md-2 col-g-2">
                                <label for="inputSortTitle" class="form-label">Заголовок</label>
                                <div class="form-check" v-for="(item, id) in {'ASC':'По возрастанию', 'DESC': 'По убыванию'}">
                                    <input class="form-check-input" type="radio" v-model="itemssearch.sort.title" :id="'inputSortTitle' + id" :value="id">
                                    <label class="form-check-label" :for="'inputSortTitle' + id">
                                        {{ item }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 col-g-2">
                                <label for="inputSortUpdated" class="form-label">Дата обновления</label>
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
    props: {
        itemssearch: Object,
    },
    data: function () {
        return {
            parents: {}
        }
    },
}
</script>
