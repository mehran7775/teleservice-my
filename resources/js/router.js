import Vue from "vue";
import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes=[
    {
        path:'/',
        component:require('./components/Home').default
    }
]

export default new VueRouter({
   routes:routes
})
