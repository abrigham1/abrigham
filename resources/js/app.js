/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
let VeeValidate = require('vee-validate');
window.Vue.use(VeeValidate);
window.THREE = require('three/build/three.min');
require('three/examples/js/effects/AsciiEffect');
require('three/examples/js/controls/TrackballControls');
require('three/examples/js/renderers/Projector');
require('three/examples/js/renderers/CanvasRenderer');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//Vue.component('movie-review-form', require('./components/MovieReviewForm.vue').default);
//Vue.component('three-demo', require('./components/ThreeDemo.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app'
});