<template>
  <div>
    <div class="card-header">
      <h1>
        New location
      </h1>
    </div>

    <div>
      <div class="text-sm text-gray-700 mb-2">
        All fields are required unless otherwide noted.
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label for="name">
            Name
          </label>
        </div>

        <div class="md:w-3/4">
          <input
            id="name"
            v-model="name"
            name="name"
            class="input-text"
            placeholder="Name"
          >
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
        name: '',
      };
    },
    computed: {
      ...mapGetters(['apiBaseUrl']),
    },
    methods: {
      submit(createAnother) {
        const params = {
          name: this.name,
        };

        axios.post(`${this.apiBaseUrl}/locations`, params)
          .then(({ data }) => {
            if (createAnother) {
              this.name = null;
            } else {
              this.$router.push({
                name: 'locations.view',
                params: {
                  location: data.id,
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
