/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';
import { createApp, h } from "vue";
import { createWebHistory, createRouter } from 'vue-router'

import App from '../../vue/cabinet/App.vue';
import {routes} from '../../vue/cabinet/routes';


const app = createApp({
    render: ()=>h(App)
})

const router = createRouter({
    history: createWebHistory(),
    routes,
})

app.use(router)
app.mount('#cabinet')

