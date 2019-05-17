<template>
  <div v-if="loaded">
    <div
      v-if="selected"
      class="group"
    >
      <router-link
        v-if="link && typeof link === 'object'"
        :to="link"
        @dblclick="openEditor"
      >{{ label(selected) }}</router-link>

      <a
        v-else-if="link"
        :href="link"
        @dblclick="openEditor"
      >{{ label(selected) }}</a>

      <span
        v-else
        @dblclick="openEditor"
      >
        <slot
          name="label"
          :selected="selected"
        >{{ label(selected) }}</slot>
      </span>

      <button
        class="text-gray-600 text-xs hidden group-hover:inline"
        @click="openEditor"
      >
        <i class="fas fa-pen" />
      </button>
    </div>

    <div v-else>
      <button
        class="text-gray-600"
        @click="openEditor"
      >
        (add)
      </button>
    </div>

    <modal
      :open="editing"
      @close="editing = false"
    >
      <div class="bg-white shadow rounded-lg w-screen-1/2">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
          <h1 class="text-xl text-black font-bold">
            Change {{ name }}
          </h1>
        </div>

        <div class="p-4 flex">
          <div class="w-1/3">
            {{ name }}
          </div>
          <div class="w-2/3">
            <v-select
              v-model="value"
              :reduce="getValue"
              :options="allowedValues"
              :get-option-label="label"
            />
          </div>
        </div>
      </div>
    </modal>
  </div>

  <div v-else>
    Loading...
  </div>
</template>

<script>
import Modal from '../modals/Modal.vue';
import axios from '../../axios';

export default {
  name: 'EditableSelect',
  components: { Modal },
  props: {
    id: {
      type: String,
      required: true,
    },

    name: {
      type: String,
      required: true,
    },

    saveValue: {
      type: Function,
      required: true,
    },

    dataUrl: {
      type: String,
      default: null,
    },

    options: {
      type: Array,
      default: () => [],
    },

    initialValue: {
      type: [String, Number, Object],
      default: null,
    },

    getValue: {
      type: Function,
      default: item => item.value,
    },

    label: {
      type: Function,
      default: item => (item || {}).label || '–',
    },

    getLink: {
      type: Function,
      default: item => ((item && item.viewUrl) ? item.viewUrl : null),
    },
  },
  data() {
    return {
      editing: false,
      loaded: false,
      allowedValues: this.options || [],
      value: this.initialValue,
    };
  },
  computed: {
    selected() {
      const matches = this.allowedValues.filter(it => this.getValue(it) === this.value);
      return matches.length === 1 ? matches[0] : null;
    },
    link() {
      return this.getLink(this.selected);
    },
  },
  watch: {
    value() {
      if (!this.editing) {
        return;
      }

      this.editing = false;
      this.saveValue({ id: this.id, value: this.value });
    },
  },
  mounted() {
    if (this.dataUrl) {
      axios.get(this.dataUrl)
        .then(({ data }) => {
          this.allowedValues = data;
          this.loaded = true;
        }).catch((error) => {
          console.error(error);
          alert(error);
        });
    } else {
      this.loaded = true;
    }
  },
  methods: {
    openEditor() {
      this.editing = true;
    },
  },
};
</script>
