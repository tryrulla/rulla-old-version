import Vue from 'vue';
import VueRouter from 'vue-router';

import IndexView from './views/IndexView.vue';
import ItemInstanceListView from './views/instances/ItemInstanceList.vue';
import ItemInstanceView from './views/instances/ItemInstanceView.vue';
import NewInstanceFormView from './views/instances/NewInstanceForm.vue';
import ItemFaultView from './views/instances/faults/ItemFaultView.vue';
import NewFaultView from './views/instances/faults/NewFault.vue';
import LocationListView from './views/locations/LocationList.vue';
import LocationView from './views/locations/LocationView.vue';
import NewLocationFormView from './views/locations/NewLocationForm.vue';
import ReservationListView from './views/reservations/ReservationList.vue';
import NewReservationFormView from './views/reservations/NewReservationForm.vue';
import ReservationView from './views/reservations/ReservationView.vue';
import ItemTypeListView from './views/types/ItemTypeList.vue';
import ItemTypeView from './views/types/ItemTypeView.vue';
import NewTypeFormView from './views/types/NewTypeForm.vue';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    { name: 'home', path: '/', component: IndexView },
    { name: 'instances.index', path: '/instances', component: ItemInstanceListView },
    { name: 'instances.new', path: '/instances/new', component: NewInstanceFormView },
    { name: 'instances.view', path: '/instances/:instance', component: ItemInstanceView },
    { name: 'faults.new', path: '/faults/new', component: NewFaultView },
    { name: 'instances.fault', path: '/instances/:instance/fault/:fault', component: ItemFaultView },
    { name: 'locations.index', path: '/locations', component: LocationListView },
    { name: 'locations.new', path: '/locations/new', component: NewLocationFormView },
    { name: 'locations.view', path: '/locations/:location', component: LocationView },
    { name: 'reservations.index', path: '/reservations', component: ReservationListView },
    { name: 'reservations.new', path: '/reservations/new', component: NewReservationFormView },
    { name: 'reservations.view', path: '/reservations/:reservation', component: ReservationView },
    { name: 'types.index', path: '/types', component: ItemTypeListView },
    { name: 'types.new', path: '/types/new', component: NewTypeFormView },
    { name: 'types.view', path: '/types/:type', component: ItemTypeView },
  ],
});

export default router;
