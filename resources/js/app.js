require('./bootstrap');
require('vue-image-lightbox/dist/vue-image-lightbox.min.css');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import VueLazyLoad from 'vue-lazyload'

Vue.use(VueRouter);
Vue.use(VueLazyLoad);

let app = new Vue({
    el: '#app',

    router: new VueRouter(routes),

    data: {
        isLoggedIn : null,
        name : null
    },

    updated(){
        this.isLoggedIn = localStorage.getItem('jwt');
        this.name = localStorage.getItem('user');

        let token = localStorage.getItem('jwt');
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    },

    mounted(){
        this.isLoggedIn = localStorage.getItem('jwt');
        this.name = localStorage.getItem('user');

        let token = localStorage.getItem('jwt');
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    },

    methods: {
        logout() {
            axios.get('/api/v1/auth/logout').then(response => {
                localStorage.removeItem('jwt');
                localStorage.removeItem('user'); 
                console.log('response.data', response.data);
                this.isLoggedIn = null;
                this.name = null;

                this.$router.push({ name: 'login' });
            });  
        }
    }
});
