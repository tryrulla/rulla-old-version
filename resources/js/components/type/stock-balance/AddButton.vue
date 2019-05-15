<template>
  <div>
    <button
      class="px-2 inline-block"
      @click="open = true"
    >
      add
    </button>

    <modal
      :open="open"
      @close="open = false"
    >
      <div class="bg-white shadow rounded-lg w-screen-1/2">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
          <h1 class="text-xl text-black font-bold">
            Add Stock Balance
          </h1>
        </div>

        <div
          v-if="loading"
          class="p-4"
        >
          Loading...
        </div>

        <div
          v-else-if="error"
          class="p-4"
        >
          {{ error }}
        </div>

        <div
          v-else-if="suggestions"
          class="p-4"
        >
          <div class="flex my-2">
            <div class="w-1/3">
              Location
            </div>

            <div class="w-2/3">
              <v-select
                v-model="selectedLocation"
                v-autofocus-select
                :get-option-label="location => `[${location.identifier}] ${location.name}`"
                :reduce="location => location.id"
                :options="suggestions"
              />

              <div
                v-if="locationError"
                class="text-xs text-red-700"
              >
                {{ locationError }}
              </div>
            </div>
          </div>

          <div class="flex my-2">
            <div class="w-1/3">
              <label
                for="amount"
                class="cursor-pointer"
              >
                Amount
              </label>
            </div>

            <div class="w-2/3">
              <input
                id="amount"
                v-model="selectedAmount"
                type="number"
                class="input-text"
                @keyup.enter="submit"
              >

              <div
                v-if="amountError"
                class="text-xs text-red-700"
              >
                {{ amountError }}
              </div>
            </div>
          </div>

          <div class="flex">
            <div class="w-1/3" />
            <div class="w-2/3">
              <button
                class="button-white"
                @click="submit"
              >
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from '../../../axios';
import Modal from '../../modals/Modal.vue';

const defaultData = {
  open: false,

  loading: false,
  suggestions: null,
  error: null,
  locationError: null,
  amountError: null,

  selectedLocation: null,
  selectedAmount: 0,
};

export default {
  name: 'AddButton',
  components: { Modal },
  props: {
    typeId: {
      type: Number,
      required: true,
    },
    save: {
      type: Function,
      required: true,
    },
  },
  data() {
    return Object.assign({}, defaultData);
  },
  computed: {
    ...mapGetters(['apiBaseUrl']),
  },
  watch: {
    open(newValue) {
      if (newValue && !this.loading && !this.suggestions) {
        this.loading = true;

        axios.get(`${this.apiBaseUrl}/types/${this.typeId}/suggest-location`)
          .then(({ data }) => {
            this.suggestions = data;
            this.error = null;
            this.loading = false;
          }).catch((error) => {
            console.error(error);
            this.loading = false;
            this.suggestions = null;
            this.error = error.toString();
          });
      }
    },
    selectedAmount() {
      this.amountError = null;
    },
    selectedLocation() {
      this.locationError = null;
    },
  },
  methods: {
    submit() {
      if (!this.selectedLocation) {
        this.locationError = 'You must select a location.';
        return;
      }

      if (this.selectedAmount <= 0) {
        this.amountError = 'Amount must be at least one.';
        return;
      }

      this.open = false;
      this.save({ location: this.selectedLocation, amount: this.selectedAmount });
      this.selectedAmount = null;
      this.selectedLocation = null;
      this.suggestions = null;
    },
  },
};
</script>
