<template>
  <div class="card">
    <div class="card-header">
      <h1>
        New fault
      </h1>
    </div>

    <div>
      <div class="text-sm text-gray-700 mb-2">
        All fields are required unless otherwise noted.
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
        <div class="md:w-1/4">
          <label for="description">
            Description
          </label>
        </div>

        <div class="md:w-3/4">
          <textarea
            id="description"
            v-model="description"
            name="description"
            class="input-text"
          />
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <span>
            Item
          </span>
        </div>

        <div class="w-3/4">
          <v-select
            v-if="instances"
            v-model="itemId"
            :get-option-label="getLabel"
            :reduce="it => it.id"
            :options="instances"
          />
        </div>
      </div>

      <div class="md:flex my-2">
        <div class="md:w-1/4">
          <span>
            Priority
          </span>
        </div>

        <div class="md:w-3/4">
          <v-select
            v-model="priority"
            :options="['highest', 'high', 'medium', 'low', 'lowest']"
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
import { mapActions, mapGetters } from 'vuex';
import axios from '../../../axios';

export default {
  data() {
    return {
      instances: null,

      name: null,
      description: null,
      itemId: parseInt(this.$route.query.instance || '', 10) || null,
      priority: null,
    };
  },
  computed: mapGetters(['apiBaseUrl']),
  mounted() {
    axios.get(`${this.apiBaseUrl}/instances?all=1`)
      .then(({ data }) => {
        this.instances = data;
      })
      .catch((error) => {
        console.error(error);
        alert(error);
      });
  },
  methods: {
    ...mapActions({
      save: 'instance/newFault',
    }),
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
      const data = {
        name: this.name,
        description: this.description,
        item_id: this.itemId,
        priority: this.priority,
      };
      this.save(data)
        .then((fault) => {
          if (createAnother) {
            this.name = null;
            this.description = null;
            this.itemId = null;
            this.priority = null;
          } else {
            this.$router.push({
              name: 'instances.fault',
              params: {
                instance: fault.item_id,
                fault: fault.id,
              },
            });
          }
        });
    },
  },
};
</script>
