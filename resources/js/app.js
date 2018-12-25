/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Import a bootstrapped Vue-router
 *
 * @source https://router.vuejs.org
 */
import router from './router'

/**
 * Enable translations for all Vue components
 */
Vue.mixin(require('./mixins/translatable'));

/**
 * Vue-loading makes it a breeze to add a loading animation for anything, including full screen.
 * @source https://github.com/ankurk91/vue-loading-overlay
 */
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);

/**
 * Easy toast messages for Vue
 * @source https://github.com/shakee93/vue-toasted
 */
// import Toasted from 'vue-toasted';
// Vue.use(Toasted, {
//     router,
//     theme: 'bubble',
//     position: 'bottom-right',
//     duration: 6000,
// })

/**
 * Easy tooltips using Popper.js
 *
 * @source https://github.com/Akryum/v-tooltip
 */
import VTooltip from 'v-tooltip'
 
Vue.use(VTooltip)

/**
 * Configure the icons used through the app.
 */
import { library } from '@fortawesome/fontawesome-svg-core'
import { faSpinner, faCheck, faTachometer, faUser, faPlus, faComments, faClock, faArrowUp, faArrowDown, faCog, faExclamation, faCaretDown, faPencil, faTrash, faShieldCheck } from '@fortawesome/pro-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Vue from "vue";

library.add(faSpinner, faCheck, faTachometer, faUser, faPlus, faComments, faClock, faArrowUp, faArrowDown, faCog, faExclamation, faCaretDown, faPencil, faTrash, faShieldCheck )

Vue.component('font-awesome-icon', FontAwesomeIcon)

/**
 * Bind $log in Vue components to window.console.log
 * This allows logging stuff to the console, from within a template using $log(...)
 */
Vue.prototype.$log = window.console.log;

/**
 * Bind $swal to the configured SweetAlert instance on window
 * This allows accessing sweet-alert2 in templates using $swal(...)
 */
Vue.prototype.$swal = window.swal;

/**
 * VueX provides a convenient global $store for all components.
 * @source https://vuex.vuejs.org
 */
import store from './store.js';

/**
 * Instruct Vue to skip looking up a component named "trix-editor"
 */
Vue.config.ignoredElements = ['trix-editor']

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)

files.keys().map(key => {
    return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store,

    el: '#app',

    computed: {
        /**
         * Access the global Laravel object.
         */
        laravel() {
            return window.Laravel;
        }
    },

    data: () => ({
        loading: null,
    }),

    created() {
        this.$store.dispatch('fetchCurrentUser');
    },

    methods: {
        startLoading() {
            this.loading = this.$loading.show({
                container: null,
                canCancel: false
            })
        },

        finishLoading() {
            if (! this.loading) {
                return;
            }

            this.loading.hide();
        }
    }
});
