<template>
  <div>
    <button
      class="button-gray"
      @click="open = true"
    >
      Add items
    </button>

    <modal
      :open="open"
      @close="open = false"
    >
      <div class="bg-white shadow rounded-lg w-screen-1/2">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
          <h1 class="text-xl text-black font-bold">
            Add Items to Reservation
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
              Items
            </div>

            <div class="w-2/3">
              <v-select
                v-model="selected"
                :get-option-label="getLabel"
                :reduce="({id}) => id"
                :multiple="true"
                :options="suggestions"
              />

              <div
                v-if="error"
                class="text-xs text-red-700"
              >
                {{ error }}
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
import axios from '../../axios';
import Modal from '../modals/Modal.vue';

const defaultData = () => ({
  open: false,
  loading: false,
  error: null,
  suggestions: null,
  selected: [],
});

export default {
  name: 'AddItemsButton',
  components: { Modal },
  props: {
    save: {
      type: Function,
      required: true,
    },
  },
  data() {
    return defaultData();
  },
  computed: {
    ...mapGetters(['apiBaseUrl']),
  },
  watch: {
    open(newValue) {
      if (newValue && !this.loading && !this.suggestions) {
        this.loading = true;

        axios.get(`${this.apiBaseUrl}/instances?all=1`)
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
  },
  methods: {
    getLabel(it) {
      let string = `[${it.identifier}] ${it.label}`;

      if (it.type) {
        string += ` ([${it.type.identifier}] ${it.type.name})`;
      }

      if (it.location) {
        string += ` ([${it.location.identifier}] ${it.location.name})`;
      }

      return string;
    },
    submit() {
      this.save({ 'add-items': this.selected });

      this.selected = [];
      this.open = false;
    },
  },
};
</script>
