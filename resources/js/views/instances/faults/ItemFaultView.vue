<template>
  <div v-if="error">
    {{ error }}
  </div>

  <div v-else-if="!loaded">
    Loading...
  </div>

  <div v-else-if="!fault">
    404
  </div>

  <div v-else>
    <div class="card-header">
      <div>
        <router-link
          :to="{ name: 'instances.index' }"
          class="hover:underline"
        >
          Item Instance
        </router-link>

        <span>
          /
          <router-link
            :to="{ name: 'instances.view', params: { instance: instance.id } }"
            class="hover:underline"
          >
            <span v-if="instance.label">
              [{{ instance.identifier }}] {{ instance.label }}</span>
            <span v-else>
              {{ instance.identifier }}
            </span>
          </router-link>
        </span>

        <span>
          /
          Faults
        </span>

        <span>
          /
          <b>
            {{ fault.identifier }}
          </b>
        </span>
      </div>

      <h1>
        {{ fault.name }}
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
                Item Fault
              </td>
            </tr>

            <tr>
              <th>
                Identifier
              </th>

              <td>
                {{ fault.identifier }}
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
                  :initial-value="fault.name"
                  :large="false"
                  :save-value="({id: field, value}) => edit({faultId: fault.id, field, value})"
                />
              </td>
            </tr>
          </table>
        </div>

        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Item Instance
              </th>

              <td>
                <router-link
                  :to="{ name: 'instances.view', params: { instance: instance.id } }"
                  class="hover:underline"
                >
                  <span v-if="instance.label">
                    [{{ instance.identifier }}] {{ instance.label }}</span>
                  <span v-else>
                    {{ instance.identifier }}</span>
                </router-link>
              </td>
            </tr>

            <tr>
              <th>Status</th>
              <td>
                <editable-select
                  id="status"
                  name="Status"
                  :initial-value="fault.status"
                  :options="['unconfirmed', 'open', 'inService', 'fixed', 'closed']"
                  :get-value="item => item"
                  :label="item => item"
                  :save-value="({id: field, value}) => edit({faultId: fault.id, field, value})"
                >
                  <template v-slot:label="selected">
                    <item-fault-status :status="selected.selected" />
                  </template>
                </editable-select>
              </td>
            </tr>

            <tr>
              <th>Priority</th>
              <td>
                <editable-select
                  id="priority"
                  name="Priority"
                  :initial-value="fault.priority"
                  :options="['highest', 'high', 'medium', 'low', 'lowest']"
                  :get-value="item => item"
                  :label="item => item"
                  :save-value="({id: field, value}) => edit({faultId: fault.id, field, value})"
                >
                  <template v-slot:label="selected">
                    <item-fault-priority :priority="selected.selected" />
                  </template>
                </editable-select>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </details>

    <details open>
      <summary>Description</summary>

      <editable-text-field
        id="description"
        name="Description"
        :initial-value="fault.description"
        :large="true"
        :save-value="({id: field, value}) => edit({faultId: fault.id, field, value})"
      />
    </details>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import ItemFaultStatus from '../../../components/faults/ItemFaultStatus.vue';
import ItemFaultPriority from '../../../components/faults/ItemFaultPriority.vue';
import EditableSelect from '../../../components/editing/EditableSelect.vue';
import EditableTextField from '../../../components/editing/EditableTextField.vue';

export default {
  components: {
    EditableTextField, EditableSelect, ItemFaultPriority, ItemFaultStatus,
  },
  computed: {
    instanceId() {
      return parseInt(this.$route.params.instance || '1', 10);
    },
    faultId() {
      return parseInt(this.$route.params.fault || '1', 10);
    },
    ...mapState({
      error: ({ instance }) => instance.error,
      loaded: ({ instance }) => instance.loaded,
      instance: ({ instance }) => instance.instance,
    }),
    fault() {
      if (!this.instance || !this.faultId) return null;

      return this.instance.faults
        .filter(it => it.id === this.faultId)[0];
    },
  },
  mounted() {
    this.load({ id: this.instanceId });
  },
  methods: {
    reload() {
      this.load({ id: this.instanceId });
    },
    ...mapActions({
      load: 'instance/load',
      edit: 'instance/editFault',
    }),
  },
};
</script>
