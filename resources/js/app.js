import './bootstrap';
import Vue from 'vue';

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import autofocus from 'vue-autofocus-directive';
import PortalVue from 'portal-vue';
import VTooltip from 'v-tooltip';
import vSelect from 'vue-select';

import router from './router';
import store from './store';

window.Vue = Vue;

Vue.directive('autofocus-select', {
  inserted(el) {
    // eslint-disable-next-line no-underscore-dangle
    el.__vue__.$refs.search.focus();
  },
});

Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);
Vue.directive('autofocus', autofocus);
Vue.component('v-select', vSelect);
Vue.use(PortalVue);
Vue.use(VTooltip);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ItemInstanceList.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// eslint-disable-next-line no-new
new Vue({
  router,
  store,
  el: '#app',
});
