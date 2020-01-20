/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import App from './App.vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import routes from '@/routes.js';
import eventBus from '@/plugins/event-bus.js';
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import  TableComponentPlugin, { TableComponent, TableColumn } from "vue-table-component";
import 'vue-table-component/docs/table-component.css';
import 'alertifyjs/build/css/alertify.min.css';
import VueAlertify from 'vue-alertify';


require('./bootstrap');

window.Vue = require('vue');
Vue.use(eventBus)
Vue.use(VueRouter);
Vue.use(VueAxios,axios);
Vue.use(VueAlertify,{
    notifier: {
        delay: 5,
        position: 'top-right',
        closeButton: true,
    }
});


const protocol = window.location.protocol;
const domain = window.location.host;

if (domain == 'localhost') {
  axios.defaults.baseURL = `${protocol}//${domain}/hatos-lecheros/public/api`;
}else{
  axios.defaults.baseURL = `${protocol}//${domain}/api`;
}

// axios.defaults.baseURL = 'http://hatos-lecheros.test/api';

const router = new VueRouter({

	routes: routes,
    mode: 'history',

})

Vue.router = router;


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//Configuracion de websanova/auth

Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

TableComponentPlugin.settings({
    tableClass: '',
    theadClass: '',
    tbodyClass: '',
    filterPlaceholder: 'Filtrar',
    filterNoResults: 'No hay resultados',
});


library.add(fas) 

Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('table-component', TableComponent);
Vue.component('table-column', TableColumn);

App.router = Vue.router;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
//     router: router,
//     render: app => app(App)
// });


new Vue(App).$mount('#app');