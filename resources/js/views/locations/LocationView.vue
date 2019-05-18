<template>
  <div v-if="error">
    {{ error }}
  </div>

  <div v-else-if="!loaded">
    Loading...
  </div>

  <div v-else>
    <div class="card-header">
      <div>
        <router-link :to="{ name: 'locations.index' }">
          Location
        </router-link>

        <span>
          /
          <b>{{ location.identifier }}</b>
        </span>
      </div>

      <h1>
        {{ location.name }}
      </h1>
    </div>

    <details open>
      <summary>Basic details</summary>

      <div class="md:flex">
        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Row type
              </th>

              <td class="w-3/4">
                Location
              </td>
            </tr>

            <tr>
              <th>
                Identifier
              </th>

              <td>
                {{ location.identifier }}
              </td>
            </tr>

            <tr>
              <th>
                Name
              </th>

              <td>
                <editable-text-field
                  id="name"
                  name="Name"
                  :initial-value="location.name"
                  :save-value="edit"
                />
              </td>
            </tr>
          </table>
        </div>

        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Parent
              </th>
              <td>
                <editable-select
                  id="parent_id"
                  name="Parent"
                  :save-value="edit"
                  :initial-value="location.parent_id"
                  :data-url="parentUrl"
                  :label="item => `[${item.identifier}] ${item.name}`"
                  :get-link="item => ({ name: 'locations.view', params: { location: item.id } })"
                  :get-value="item => item.id"
                />
              </td>
            </tr>
          </table>
        </div>
      </div>
    </details>

    <location-item-list
      :data="location"
    />
  </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from 'vuex';
import EditableTextField from '../../components/editing/EditableTextField.vue';
import LocationItemList from '../../components/location/LocationItemList.vue';
import EditableSelect from '../../components/editing/EditableSelect.vue';

export default {
  components: { EditableSelect, LocationItemList, EditableTextField },
  computed: {
    id() {
      return parseInt(this.$route.params.location || '1', 10);
    },
    ...mapGetters([
      'apiBaseUrl',
    ]),
    ...mapState({
      error: ({ location }) => location.error,
      loaded: ({ location }) => location.loaded,
      location: ({ location }) => location.location,
    }),
    parentUrl() {
      return `${this.apiBaseUrl}/locations?all=true`;
    },
  },
  watch: {
    $route() {
      this.load({ id: this.id });
    },
  },
  mounted() {
    this.load({ id: this.id });
  },
  methods: {
    reload() {
      this.load({ id: this.id });
    },
    ...mapActions({
      load: 'location/load',
      edit: 'location/edit',
    }),
  },
};
</script>
