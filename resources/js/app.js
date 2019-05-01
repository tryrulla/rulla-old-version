import './bootstrap';
import Vue from 'vue';

import autofocus from 'vue-autofocus-directive';
import VueRouter from 'vue-router';
import PortalVue from 'portal-vue';
import VTooltip from 'v-tooltip';
import vSelect from 'vue-select';

import ItemStockBalance from './components/item-stock-balance/ItemStockBalance.vue';
import EditableTextField from './components/EditableTextField.vue';
import ItemInstanceList from './components/ItemInstanceList.vue';
import EditableSelect from './components/EditableSelect.vue';
import ItemTypeList from './components/ItemTypeList.vue';
import LocationList from './components/LocationList.vue';
import Modal from './components/Modal.vue';

Vue.directive('autofocus-select', {
    inserted: function (el) {
        el.__vue__.$refs.search.focus();
    },
});

Vue.directive('autofocus', autofocus);
Vue.component('v-select', vSelect);
Vue.use(VueRouter);
Vue.use(PortalVue);
Vue.use(VTooltip);

Vue.component('editable-text-field', EditableTextField);
Vue.component('item-stock-balance', ItemStockBalance);
Vue.component('item-instance-list', ItemInstanceList);
Vue.component('editable-select', EditableSelect);
Vue.component('item-type-list', ItemTypeList);
Vue.component('location-list', LocationList);
Vue.component('modal', Modal);

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
