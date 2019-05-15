<template>
  <div>
    <div class="card-header">
      <h1>
        New type
      </h1>
    </div>

    <div>
      <div class="text-sm text-gray-700 mb-2">
        All fields are required unless otherwide noted.
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label for="manufacturer">
            Manufacturer
          </label>
        </div>

        <div class="md:w-3/4">
          <input
            id="manufacturer"
            v-model="manufacturer"
            name="manufacturer"
            class="input-text"
            placeholder="Manufacturer"
          >
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label for="manufacturer">
            Model
          </label>
        </div>

        <div class="md:w-3/4">
          <input
            id="model"
            v-model="model"
            name="model"
            class="input-text"
            placeholder="Model"
          >
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label>
            Stock type

            <i
              v-tooltip="'Specifies how this item is stored.<br/><br/>&ndash; Stock:'
                + 'amount of items per location<br/>&ndash; Instance: every single item is stored'"
              class="fas fa-info-circle text-gray-600 text-xs"
            />
          </label>
        </div>

        <div
          class="md:w-3/4"
        >
          <v-select
            v-model="stockType"
            placeholder="Stock type"
            :options="['instance', 'stock']"
          />
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="w-1/4" />
        <div class="w-3/4">
          <button
            class="button-white"
            @click="() => submit(false)"
          >
            Save
          </button>

          <button
            class="button-white"
            @click="() => submit(true)"
          >
            Save and create another
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from '../../axios';
import { getValidationErrors } from '../../utilities';

export default {
  data() {
    return {
      manufacturer: '',
      model: '',
      stockType: null,
    };
  },
  computed: {
    ...mapGetters(['apiBaseUrl']),
  },
  methods: {
    submit(createAnother) {
      const {
        manufacturer, model, stockType,
      } = this;

      const params = {
        manufacturer, model, stock_type: stockType,
      };

      axios.post(`${this.apiBaseUrl}/types`, params)
        .then(({ data }) => {
          if (createAnother) {
            this.manufacturer = null;
            this.model = null;
            this.stockType = null;
          } else {
            this.$router.push({
              name: 'types.view',
              params: {
                type: data.id,
              },
            });
          }
        })
        .catch((error) => {
          const validationErrors = getValidationErrors(error.response);
          if (validationErrors) {
            alert(JSON.stringify(validationErrors));
          } else {
            alert(error.message);
          }

          console.error(error);
        });
    },
  },
};
</script>
