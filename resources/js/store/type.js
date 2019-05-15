/* eslint no-param-reassign: 0 */
import axios from '../axios';

export default {
  namespaced: true,
  state: {
    loaded: false,
    error: null,
    type: null,
  },
  getters: {
    id: state => (state.type || {}).id,
    identifier: state => (state.type || {}).identifier,
  },
  mutations: {
    startLoading(state) {
      state.type = null;
      state.error = null;
      state.loaded = false;
    },
    loaded(state, data) {
      state.type = data;
      state.error = null;
      state.loaded = true;
    },
    loadingFailed(state, error) {
      state.type = null;
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
      const url = `${rootGetters.apiBaseUrl}/types/${id}`;
      axios.get(url)
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('loadingFailed', error));
    },
    edit({ commit, getters, rootGetters }, { id, value }) {
      const url = `${rootGetters.apiBaseUrl}/types/${getters.id}`;
      axios.put(url, { [id]: value })
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('savingFailed', error));
    },
    saveStock({ commit, getters, rootGetters }, update) {
      const url = `${rootGetters.apiBaseUrl}/types/${getters.id}/update-stock`;
      axios.post(url, update)
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('savingFailed', error));
    },
  },
};
