
import Vue from 'vue'
import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: `/`,
        component: require('./views/Home.vue')
    },
    {
        path: '/geocoding',
        component: require('./views/Geocoding.vue')
    },
    {
        path: '/reverse',
        component: require('./views/Reverse.vue')
    }

];

const router = new VueRouter({
    routes,
    mode:'history'

});


export default router
