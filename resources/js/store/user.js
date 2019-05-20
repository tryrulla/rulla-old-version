/* eslint no-param-reassign: 0 */
import axios from '../axios';
import { getValidationErrors } from '../utilities';

export default {
  namespaced: true,
  state: {
    loaded: false,
    error: null,
    user: null,
  },
  getters: {
    id: state => (state.user || {}).id,
    identifier: state => (state.user || {}).identifier,
  },
  mutations: {
    startLoading(state) {
      state.user = null;
      state.error = null;
      state.loaded = false;
    },
    loaded(state, data) {
      state.user = data;
      state.error = null;
      state.loaded = true;
    },
    loadingFailed(state, error) {
      state.user = null;
      state.error = error;
      state.loaded = false;
    },
    savingFailed(state, error) {
      const validationErrors = getValidationErrors(error.response);
      if (validationErrors) {
        alert(JSON.stringify(validationErrors));
      } else {
        alert(error.message);
      }

      console.error(error);
    },
  },
  actions: {
    load({ commit, rootGetters }, { id }) {
      commit('startLoading');
      const url = `${rootGetters.apiBaseUrl}/users/${id}`;
      axios.get(url)
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('loadingFailed', error));
    },
    edit({ commit, getters, rootGetters }, { id, value }) {
      const url = `${rootGetters.apiBaseUrl}/users/${getters.id}`;
      axios.put(url, { [id]: value })
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('savingFailed', error));
    },
  },
};
