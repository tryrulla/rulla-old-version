/* eslint no-param-reassign: 0 */
import axios from '../axios';

export default {
  namespaced: true,
  state: {
    loaded: false,
    error: null,
    reservation: null,
  },
  getters: {
    id: state => (state.reservation || {}).id,
    identifier: state => (state.reservation || {}).identifier,
  },
  mutations: {
    startLoading(state) {
      state.reservation = null;
      state.error = null;
      state.loaded = false;
    },
    loaded(state, data) {
      state.reservation = data;
      state.error = null;
      state.loaded = true;
    },
    loadingFailed(state, error) {
      state.reservation = null;
      state.error = error;
      state.loaded = false;
    },
    savingFailed(state, error) {
      alert(error);
    },
  },
  actions: {
    load({ commit, rootGetters }, { id }) {
      commit('startLoading');
      const url = `${rootGetters.apiBaseUrl}/reservations/${id}`;
      axios.get(url)
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('loadingFailed', error));
    },
    edit({ commit, getters, rootGetters }, params) {
      const url = `${rootGetters.apiBaseUrl}/reservations/${getters.id}`;
      axios.put(url, params)
        .then(({ data }) => commit('loaded', data.data))
        .catch(error => commit('savingFailed', error));
    },
  },
};
