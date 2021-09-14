/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueRouter from 'vue-router'
import Vuelidate from 'vuelidate'
import router from "./router";
import Vuetify from 'vuetify'
import colors from 'vuetify/lib/util/colors'
import App from './components/App'
import 'vuetify/dist/vuetify.min.css'
require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(Vuelidate);

// Vue.component('App', require('./components/App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const vuetify = new Vuetify({
    theme: {
        themes: {
            light: {
                primary: colors.green.accent2, // #E53935
                secondary: colors.green.lighten4, // #FFCDD2
                accent: colors.green.base, // #3F51B5
            },
        },
    },
});

const app = new Vue({
    el: '#app',
    router,
    vuetify,
    render: h => h(App),
});
