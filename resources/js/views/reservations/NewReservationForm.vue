<template>
  <div>
    <div class="card-header">
      <h1>
        New reservation
      </h1>
    </div>

    <div>
      <div class="text-sm text-gray-700 mb-2">
        All fields are required unless otherwide noted.
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label>
            Start date & time
          </label>
        </div>

        <div class="md:w-3/4">
          <VueCtkDateTimePicker
            v-model="startsAt"
            :first-day-of-week="1"
            output-format="YYYY-MM-DDTHH:mm:ssZ"
          />
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <label>
            End date & time
          </label>
        </div>

        <div class="md:w-3/4">
          <VueCtkDateTimePicker
            v-model="endsAt"
            :first-day-of-week="1"
            output-format="YYYY-MM-DDTHH:mm:ssZ"
          />
        </div>
      </div>

      <div class="md:flex my-4">
        <div class="md:w-1/4">
          <label>
            Items
          </label>

          <div class="text-xs text-gray-700">
            You may also add items after creating the reservation.
          </div>
        </div>

        <div
          v-if="itemLoaded"
          class="md:w-3/4"
        >
          <v-select
            v-model="items"
            placeholder="Search items..."
            name="item_selector"
            :get-option-label="getLabel"
            :reduce="it => it.id"
            :multiple="true"
            :options="itemList"
          />
        </div>

        <div
          v-else
          class="md:w-3/4"
        >
          {{ itemError || 'Loading...' }}
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="w-1/4">
          <label for="approvalStatus">
            Approval status
          </label>
        </div>

        <div class="md:w-3/4">
          <v-select
            id="approvalStatus"
            v-model="approvalStatus"
            :options="['awaiting', 'approved', 'rejected']"
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
      startsAt: null,
      endsAt: null,
      items: [],
      approvalStatus: 'awaiting',

      itemList: [],
      itemLoaded: false,
      itemError: null,
    };
  },
  computed: {
    ...mapGetters(['apiBaseUrl']),
  },
  mounted() {
    axios.get(`${this.apiBaseUrl}/instances?all=true`)
      .then(({ data }) => {
        this.itemLoaded = true;
        this.itemList = data;
      })
      .catch((error) => {
        console.error(error);
        this.itemError = error.message;
      });
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
    submit(createAnother) {
      const {
        startsAt, endsAt, items, approvalStatus,
      } = this;

      const params = {
        starts_at: startsAt, ends_at: endsAt, items, approval_status: approvalStatus,
      };

      axios.post(`${this.apiBaseUrl}/reservations`, params)
        .then(({ data }) => {
          if (createAnother) {
            this.startsAt = null;
            this.endsAt = null;
            this.items = null;
          } else {
            this.$router.push({
              name: 'reservations.view',
              params: {
                reservation: data.id,
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
