<template>
  <div>
    <div class="card-header">
      <h1>
        New instance
      </h1>
    </div>

    <div>
      <div class="text-sm text-gray-700 mb-2">
        All fields are required unless otherwide noted.
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label for="label">
            Label <span class="text-gray-700 text-xs">(optional)</span>
          </label>
        </div>

        <div class="md:w-3/4">
          <input
            id="label"
            v-model="label"
            name="label"
            class="input-text"
            placeholder="Label"
          >
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label>
            Type <span class="text-gray-700 text-xs">(optional)</span>
          </label>
        </div>

        <div
          v-if="typesLoaded"
          class="md:w-3/4"
        >
          <v-select
            v-model="type"
            placeholder="Select type..."
            :get-option-label="it => `[${it.identifier}] ${it.name}`"
            :reduce="it => it.id"
            :options="typeList"
          />
        </div>

        <div
          v-else
          class="md:w-3/4"
        >
          {{ typesError || 'Loading...' }}
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label>
            Location <span class="text-gray-700 text-xs">(optional)</span>
          </label>
        </div>

        <div
          v-if="locationsLoaded"
          class="md:w-3/4"
        >
          <v-select
            v-model="location"
            placeholder="Select location..."
            :get-option-label="it => `[${it.identifier}] ${it.name}`"
            :reduce="it => it.id"
            :options="locationList"
          />
        </div>

        <div
          v-else
          class="md:w-3/4"
        >
          {{ typesError || 'Loading...' }}
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
      label: '',
      type: parseInt(this.$route.query.type || '', 10) || null,
      location: parseInt(this.$route.query.location || '', 10) || null,

      typeList: [],
      typesLoaded: false,
      typesError: null,

      locationList: [],
      locationsLoaded: false,
      locationsError: null,
    };
  },
  computed: {
    ...mapGetters(['apiBaseUrl']),
  },
  mounted() {
    axios.get(`${this.apiBaseUrl}/types`, { params: { all: '1', search: 'stock_type=instance' } })
      .then(({ data }) => {
        this.typesLoaded = true;
        this.typeList = data;
      })
      .catch((error) => {
        console.error(error);
        this.typesError = error.message;
      });

    axios.get(`${this.apiBaseUrl}/locations?all=true`)
      .then(({ data }) => {
        this.locationsLoaded = true;
        this.locationList = data;
      })
      .catch((error) => {
        console.error(error);
        this.locationsError = error.message;
      });
  },
  methods: {
    submit(createAnother) {
      const {
        label, type, location,
      } = this;

      const params = {
        label, type_id: type, location_id: location,
      };

      axios.post(`${this.apiBaseUrl}/instances`, params)
        .then(({ data }) => {
          if (createAnother) {
            this.label = null;
            this.type = null;
            this.location = null;
          } else {
            this.$router.push({
              name: 'instances.view',
              params: {
                instance: data.id,
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
