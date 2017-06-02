/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.THREE = require('../../../node_modules/three/build/three.min');
require('../../../node_modules/three/examples/js/effects/AsciiEffect');
require('../../../node_modules/three/examples/js/controls/TrackballControls');
require('../../../node_modules/three/examples/js/renderers/Projector');
require('../../../node_modules/three/examples/js/renderers/CanvasRenderer');
require('../../../node_modules/three/examples/js/libs/stats.min');
window.Vue = require('vue');
VeeValidate = require('vee-validate');
window.Vue.use(VeeValidate);

$(document).ready(function () {
    /**
     * Next, we will create a fresh Vue application instance and attach it to
     * the page. Then, you may begin adding components to this application
     * or customize the JavaScript scaffolding to fit your unique needs.
     */
    Vue.component('movie-review-form', require('./components/MovieReviewForm.vue'));
    Vue.component('three-demo', require('./components/ThreeDemo.vue'));

    const app = new Vue({
        el: '#app'
    });
});