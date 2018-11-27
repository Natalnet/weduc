
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Atom from './Atom'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import './components'

/**
 * Sweetalert2 for Vue
 */
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

/**
 * Notifications
 */
import Notifications from 'vue-notification';
Vue.use(Notifications);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('reduc-functions', require('./components/ReducFunctions'));
require('./components/ide');
require('./components/editor');

/**
 * Finally, we'll create this Vue Router instance and register all of the
 * Atom routes. Once that is complete, we will create the Vue instance
 * and hand this router to the Vue instance. Then Atom is all ready!
 */
;(function() {
    this.CreateAtom = function(config) {
        return new Atom(config)
    }
}.call(window))

/**
 * Core UI
 */
import '@coreui/coreui';