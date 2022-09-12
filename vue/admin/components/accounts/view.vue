<template>
    <ol class="list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Счет</div>
                <h6 class="card-subtitle mb-2 text-muted">{{ model.code }}</h6>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Название</div>
                <h6 class="card-subtitle mb-2 text-muted">{{ model.title }}</h6>
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
                <div class="fw-bold">Дата начала</div>
                <p class="card-text">{{ model.created_at }}</p>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Описание</div>
                <div v-html="description_html"></div>
            </div>
        </li>
    </ol>
</template>

<script>

export default {
    props: {
        model: Object,
    },
    data: function () {
        return {
            description_html: null
        }
    },
    mounted() {
        this.getDescription()
    },
    methods: {
        getDescription: function () {
            let app = this;
            app.description_html = app.model.description;
        }
    }
}
</script>
