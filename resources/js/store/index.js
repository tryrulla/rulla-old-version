import Vue from 'vue';
import Vuex from 'vuex';

import type from './type';
import typeList from './typeList';
import location from './location';
import locationList from './locationList';
import reservation from './reservation';
import reservationList from './reservationList';
import instance from './instance';
import instanceList from './instanceList';
import userList from './userList';
import user from './user';

Vue.use(Vuex);

export default new Vuex.Store({
  getters: {
    apiBaseUrl() {
      return window.Rulla.apiBaseUrl;
    },
  },
  modules: {
    type,
    typeList,
    location,
    locationList,
    reservation,
    reservationList,
    instance,
    instanceList,
    userList,
    user,
  },
});
