import './bootstrap';
import Vue from 'vue';
import VueRouter from 'vue-router';
import VTooltip from 'v-tooltip';
import vSelect from 'vue-select';

import ItemInstanceList from './components/ItemInstanceList.vue';
import ItemTypeList from './components/ItemTypeList.vue';

Vue.component('v-select', vSelect);
Vue.use(VueRouter);
Vue.use(VTooltip);

Vue.component('item-instance-list', ItemInstanceList);
Vue.component('item-type-list', ItemTypeList);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ItemInstanceList.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const router = new VueRouter({
    mode: 'history',
});

const app = new Vue({
    router,
    el: '#app',
});
