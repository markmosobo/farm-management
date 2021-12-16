/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import routes from './Route';

const router = new VueRouter({
    mode: 'history',
    routes 
  });

//using vform
import Form from 'vform';
window.Form = Form;

//  //custom event
window.Fire = new Vue();

//progressbar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar,{
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
});

//sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

import Gate from './gate';
Vue.prototype.$gate = new Gate(window.user);

import ProfitChart from './components/ProfitChart.vue'
export default {
  components: {
    ProfitChart
  }
}

//using filters
Vue.filter('capitalize',function(text){
  return text.charAt(0).toUpperCase() + text.slice(1).toUpperCase()
});
Vue.filter('capitalizeFirstLetter',function(text){
  return text.charAt(0).toUpperCase() + text.slice(1)
});
// Vue.filter('formatDate', function(value) {
//    if (value) {
//       return moment(String(value)).format('MM/DD/YYYY hh:mm')
//    }
// }); 
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});


