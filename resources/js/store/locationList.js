/* eslint no-param-reassign: 0 */
import axios from '../axios';

export default {
  namespaced: true,
  state: {
    loaded: false,
    error: null,
    data: null,
  },
  mutations: {
    startLoading(state) {
      state.data = null;
      state.error = null;
      state.loaded = false;
    },
    loaded(state, data) {
      state.data = data;
      state.error = null;
      state.loaded = true;
    },
    loadingFailed(state, error) {
      state.data = null;
      state.error = error;
      state.loaded = false;
    },
  },
  actions: {
    load({ commit, rootGetters }, { page = 1 }) {
      const url = `${rootGetters.apiBaseUrl}/locations?page=${page}`;
      axios.get(url)
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('loadingFailed', error));
    },
  },
};
