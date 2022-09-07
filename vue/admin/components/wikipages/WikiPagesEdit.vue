<template>
    <div class="p-1">
        <div class="form-group mt-1">
            <router-link :to="{name: 'wikipages_index'}" class="btn btn-dark btn-sm" title="Назад">Назад</router-link>
        </div>
    </div>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>
    <div v-else class=" mt-1">
        <div class="card-title mt-1">Редактируем  {{ model.title }}</div>
        <div class="p-1">
            <form v-on:submit.prevent="saveForm()">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Заголовок</label>
                        <input type="text"
                               v-model="model.title"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.title }">
                        <div class="invalid-feedback" v-if="errors.title">
                            {{ errors.title }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Url</label>
                        <input type="text"
                               v-model="model.slug"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.slug }">
                        <div class="invalid-feedback" v-if="errors.slug">
                            {{ errors.slug }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Меню</label>
                        <input type="text"
                               v-model="model.menu_level"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.menu_level }">
                        <div class="invalid-feedback" v-if="errors.menu_level">
                            {{ errors.menu_level }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Подробнее</label>

                        <vue-editor
                            id="editor"
                            useCustomImageHandler
                            @imageAdded="handleImageAdded"
                            :editorToolbar="customToolbar"
                            class="form-control"
                            v-bind:class="{ 'is-invalid': errors.description }"
                            v-model="model.description"
                        >
                        </vue-editor>

                        <div class="invalid-feedback" v-if="errors.description">
                            {{ errors.description }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 form-group">
                        <label class="control-label">Изображение</label>
                        <input class="form-control mt-1" type="file" accept="image/*" @change="uploadThumb($event)"
                               id="thumb-input">
                        <div class="form_thumb" v-if="model.thumb">
                            <img class="thumb mt-1" v-bind:src="model.thumb" v-bind:alt="model.title"/>
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
</template>

<script>
import VuePreloader from '../preloader.vue';
import {VueEditor} from "vue3-editor";
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

            customToolbar:  [
                [{ font: [] }],
                [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                [{ size: ["small", false, "large", "huge"] }],
                ["bold", "italic", "underline", "strike"],
                [
                    { align: "" },
                    { align: "center" },
                    { align: "right" },
                    { align: "justify" }
                ],
                [{ header: 1 }, { header: 2 }],
                ["blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ color: [] }, { background: [] }],
                ["link", "image"],
                [{ direction: "rtl" }],
                ["clean"],
                ["SourceCode"]
            ],
            preloader: true,
            errors: {},
            model_id: null,
            model: {
                id: null,
                menu_level: null,
                slug: null,
                title: null,
                description: null,
                thumb: null,
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

            axios.get('/api/v1/wikipages/' + id + '/get/', {headers})
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

            axios.post('/api/v1/wikipages/' + app.model_id + '/update', newModel, {headers})
                .then(function (resp) {
                    app.$router.push({name: 'wikipages_index'});
                })
                .catch(function (resp) {
                    var errors = resp.response.data.errors;
                    for (var row in errors) {
                        app.errors[row] = errors[row][0];
                    }
                });
            app.preloader = false;
        },
        uploadThumb: function (event) {
            var app = this;
            var formData = new FormData();
            formData.append('images[]', event.target.files[0]);
            let headers = this.axiosHeaders

            axios.post('/api/v1/wikipages/addimages', formData, {headers})
                .then(function (resp) {
                    const url = resp.data.urls;
                    if (url) {
                        app.model.thumb = url[0];
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        handleImageAdded: function (file, Editor, cursorLocation, resetUploader) {
            var app = this;
            var formData = new FormData();
            formData.append("images[]", file);
            let headers = this.axiosHeaders

            axios.post('/api/v1/wikipages/addimages', formData, {headers})
                .then(function (resp) {
                    const url = resp.data.urls;
                    if (url) {
                        Editor.insertEmbed(cursorLocation, "image", url[0]);
                        resetUploader();
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
}
</script>
