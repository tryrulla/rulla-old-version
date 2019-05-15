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
        <router-link :to="{ name: 'instances.index' }">
          Item Instance
        </router-link>

        <span v-if="instance.label">
          /
          <b>{{ instance.identifier }}</b>
        </span>
      </div>

      <h1>
        {{ instance.label || instance.identifier }}
      </h1>
    </div>

    <div class="mb-4">
      <router-link
        :to="{ name: 'faults.new', query: {instance: instance.id} }"
        class="button-gray"
      >
        Add fault
      </router-link>
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
                Item Instance
              </td>
            </tr>

            <tr>
              <th>
                Identifier
              </th>

              <td>
                {{ instance.identifier }}
              </td>
            </tr>

            <tr>
              <th>
                Label
                <i
                  v-tooltip="'Short name/description. Will be printed on any tags.'"
                  class="fas fa-info-circle text-gray-600 text-xs"
                />
              </th>

              <td>
                <editable-text-field
                  id="label"
                  name="Label"
                  :initial-value="instance.label"
                  :large="false"
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
                Type
              </th>
              <td>
                {{ instance.type ? instance.type.name : '-' }}
              </td>
            </tr>

            <tr>
              <th>Location</th>
              <td>
                {{ instance.location ? instance.location.name : '-' }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </details>

    <details open>
      <summary>Faults</summary>

      <item-fault-listing
        :instance-id="instance.id"
        :faults="instance.faults"
      />
    </details>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import ItemFaultListing from '../../components/faults/ItemFaultListing.vue';
import EditableTextField from '../../components/editing/EditableTextField.vue';

export default {
  components: { EditableTextField, ItemFaultListing },
  computed: {
    id() {
      return parseInt(this.$route.params.instance || '1', 10);
    },
    ...mapState({
      error: ({ instance }) => instance.error,
      loaded: ({ instance }) => instance.loaded,
      instance: ({ instance }) => instance.instance,
    }),
  },
  mounted() {
    this.load({ id: this.id });
  },
  methods: {
    reload() {
      this.load({ id: this.id });
    },
    ...mapActions({
      load: 'instance/load',
      edit: 'instance/edit',
    }),
  },
};
</script>
