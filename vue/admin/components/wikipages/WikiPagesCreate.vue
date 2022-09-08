<template>
    <div v-if="preloader">
        <vue-preloader></vue-preloader>
    </div>
    <div v-else>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'admin'}"  title="Панель">Панель</router-link>
                </li>
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'wikipages_index'}"  title="Статьи">Статьи</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Создание
                </li>
            </ol>
        </nav>
        <h1>Создание</h1>
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
                        <label class="control-label">Описание</label>
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
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Шапка</label>
                        <input type="text"
                               v-model="model.header"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.header }">
                        <div class="invalid-feedback" v-if="errors.header">
                            {{ errors.header }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Превью</label>
                        <textarea
                               v-model="model.preview"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.preview }"></textarea>
                        <div class="invalid-feedback" v-if="errors.preview">
                            {{ errors.preview }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Seo Description</label>
                        <input type="text"
                               v-model="model.seo_description"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.seo_description }">
                        <div class="invalid-feedback" v-if="errors.seo_description">
                            {{ errors.seo_description }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Seo sKeywords</label>
                        <input type="text"
                               v-model="model.seo_keywords"
                               class="form-control"
                               v-bind:class="{ 'is-invalid': errors.seo_keywords }">
                        <div class="invalid-feedback" v-if="errors.seo_keywords">
                            {{ errors.seo_keywords }}
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
            preloader: false,
            errors: {},
            model_id: null,
            model: {
                id: null,
                menu_level: null,
                slug: null,
                title: null,
                header: null,
                preview: null,
                seo_description: null,
                seo_keywords: null,
                thumb: null,
            }
        }
    },
    methods: {
        saveForm(e) {
            var app = this;
            app.preloader = true;
            var newModel = app.model;
            let headers = this.axiosHeaders

            axios.post('/api/v1/wikipages/store', newModel, {headers})
                .then(function (resp) {
                    app.$router.push({name: 'wikipages_index'});
                    app.preloader = false;
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
