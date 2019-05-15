/* eslint no-param-reassign: 0 */
import axios from '../axios';

export default {
  namespaced: true,
  state: {
    loaded: false,
    error: null,
    location: null,
  },
  getters: {
    id: state => (state.location || {}).id,
    identifier: state => (state.location || {}).identifier,
  },
  mutations: {
    startLoading(state) {
      state.location = null;
      state.error = null;
      state.loaded = false;
    },
    loaded(state, data) {
      state.location = data;
      state.error = null;
      state.loaded = true;
    },
    loadingFailed(state, error) {
      state.location = null;
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
      const url = `${rootGetters.apiBaseUrl}/locations/${id}`;
      axios.get(url)
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('loadingFailed', error));
    },
    edit({ commit, getters, rootGetters }, { id, value }) {
      const url = `${rootGetters.apiBaseUrl}/locations/${getters.id}`;
      axios.put(url, { [id]: value })
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('savingFailed', error));
    },
  },
};
