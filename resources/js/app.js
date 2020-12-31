import './bootstrap'
import Vue from 'vue'
window.Vue = Vue;
import router from './router'
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.component('navv',require('./components/Nav').default)
new Vue({
    el: '#app',
    router
});
