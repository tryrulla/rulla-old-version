/* eslint no-param-reassign: 0 */
import axios from '../axios';
import { upsert } from '../utilities';

export default {
  namespaced: true,
  state: {
    loaded: false,
    error: null,
    instance: null,
  },
  getters: {
    id: state => (state.instance || {}).id,
    identifier: state => (state.instance || {}).identifier,
  },
  mutations: {
    startLoading(state) {
      state.instance = null;
      state.error = null;
      state.loaded = false;
    },
    loaded(state, data) {
      state.instance = data;
      state.error = null;
      state.loaded = true;
    },
    loadingFailed(state, error) {
      state.instance = null;
      state.error = error;
      state.loaded = false;
    },
    faultSaved(state, faultData) {
      state.instance.faults = upsert(state.instance.faults, 'id', faultData.id, faultData);
    },
    savingFailed(state, error) {
      alert(error);
    },
  },
  actions: {
    load({ commit, rootGetters }, { id }) {
      commit('startLoading');
      const url = `${rootGetters.apiBaseUrl}/instances/${id}`;
      axios.get(url)
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('loadingFailed', error));
    },
    edit({ commit, getters, rootGetters }, { id, value }) {
      const url = `${rootGetters.apiBaseUrl}/instances/${getters.id}`;
      axios.put(url, { [id]: value })
        .then(({ data }) => commit('loaded', data))
        .catch(error => commit('savingFailed', error));
    },
    editFault({ commit, rootGetters }, { faultId, field, value }) {
      const url = `${rootGetters.apiBaseUrl}/faults/${faultId}`;
      axios.put(url, { [field]: value })
        .then(({ data }) => commit('faultSaved', data))
        .catch(error => commit('savingFailed', error));
    },
    async newFault({ commit, rootGetters }, data) {
      const url = `${rootGetters.apiBaseUrl}/faults`;

      let fault;
      try {
        fault = (await axios.post(url, data)).data;
      } catch (e) {
        commit('savingFailed', e);
      }

      return fault;
    },
  },
};
