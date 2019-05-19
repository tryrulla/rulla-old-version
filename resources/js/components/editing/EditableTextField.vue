<template>
  <div>
    <div
      v-if="(editing ? ogValue : value).length > 0"
      class="group rounded"
      :class="large ? ['whitespace-pre-line'] : []"
    >
      <span @dblclick="openEditor">{{ editing ? ogValue : value }}</span>
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
      <div class="bg-white shadow rounded-lg w-screen-9/10 md:w-screen-1/2">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
          <h1 class="text-xl text-black font-bold">
            Change {{ name }}
          </h1>
        </div>

        <div class="p-4">
          <div class="flex my-2">
            <div class="w-1/3">
              {{ name }}
            </div>
            <div class="w-2/3">
              <textarea
                v-if="large"
                v-model="value"
                v-autofocus
                class="input-text"
                type="text"
                rows="15"
              />

              <input
                v-else
                v-model="value"
                v-autofocus
                class="input-text"
                type="text"
                @keyup.enter="save"
                @keyup.esc="cancel"
              >
            </div>
          </div>

          <div class="flex my-2">
            <div class="w-1/3" />
            <div class="w-2/3">
              <button
                class="button-white"
                @click="save"
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
import Modal from '../modals/Modal.vue';

export default {
  components: { Modal },
  props: {
    name: {
      type: String,
      required: true,
    },

    id: {
      type: String,
      required: true,
    },

    initialValue: {
      type: String,
      required: true,
    },

    large: {
      type: Boolean,
      default: false,
    },

    saveValue: {
      type: Function,
      required: true,
    },
  },
  data() {
    return {
      editing: false,
      ogValue: '',
      value: this.initialValue || '',
    };
  },
  methods: {
    openEditor() {
      this.ogValue = this.value;
      this.editing = true;
    },
    save() {
      if (!this.editing) {
        return;
      }

      this.editing = false;
      this.saveValue({ id: this.id, value: this.value });
    },
    cancel() {
      this.editing = false;
      this.value = this.ogValue;
    },
  },
};
</script>
