<template>
  <div>
    <button
      class="inline-block text-xs"
      @click="open = true"
    >
      edit
    </button>

    <modal
      :open="open"
      @close="open = false"
    >
      <div class="bg-white shadow rounded-lg w-screen-1/2">
        <div class="bg-gray-400 p-4 rounded-t flex justify-between">
          <h1 class="text-xl text-black font-bold">
            Update Stock Balance
          </h1>
        </div>

        <div
          v-if="loading"
          class="p-4"
        >
          Loading...
        </div>

        <div
          v-else
          class="p-4"
        >
          <div class="flex my-2">
            <div class="w-1/3">
              Location
            </div>

            <div class="w-2/3">
              [{{ row.location.identifier }}] {{ row.location.name }}
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
                v-autofocus
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

          <div class="flex my-2">
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
import Modal from '../../modals/Modal.vue';

const defaultData = {
  open: false,
  amountError: null,
  loading: false,
};

export default {
  name: 'EditButton',
  components: { Modal },
  props: {
    save: {
      type: Function,
      required: true,
    },
    row: {
      type: Object,
      required: true,
    },
  },
  data() {
    return Object.assign({}, defaultData, { selectedAmount: this.row.amount });
  },
  methods: {
    submit() {
      if (this.selectedAmount <= 0) {
        this.amountError = 'Amount must be at least one.';
        return;
      }

      this.open = false;
      this.save({ location: this.row.location_id, amount: this.selectedAmount });
    },
  },
};
</script>
