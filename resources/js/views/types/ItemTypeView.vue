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
        <router-link :to="{ name: 'types.index' }">
          Item Type
        </router-link>

        /

        <b>{{ type.identifier }}</b>
      </div>

      <h1>
        {{ type.name }}
      </h1>
    </div>

    <div class="mb-4">
      <router-link
        :to="{ name: 'instances.new', query: {type: type.id} }"
        class="button-gray"
      >
        Create instance
      </router-link>
    </div>

    <div>
      <details open>
        <summary>Basic details</summary>
        <div class="md:flex">
          <div class="md:w-1/2">
            <table class="table">
              <tr>
                <th class="w-1/4">
                  Row type
                </th>

                <td class="w-3/4">
                  Item Type
                </td>
              </tr>

              <tr>
                <th>
                  Identifier
                </th>

                <td>
                  {{ type.identifier }}
                </td>
              </tr>

              <tr>
                <th>
                  Manufacturer
                </th>

                <td>
                  <editable-text-field
                    id="manufacturer"
                    name="Manufacturer"
                    :initial-value="type.manufacturer"
                    :save-value="edit"
                  />
                </td>
              </tr>

              <tr>
                <th>
                  Model
                </th>

                <td>
                  <editable-text-field
                    id="model"
                    name="Model"
                    :initial-value="type.model"
                    :save-value="edit"
                  />
                </td>
              </tr>

              <tr>
                <th>
                  Stock type
                  <i
                    v-tooltip="'Specifies how this item is stored.<br/><br/>&ndash; Stock: amount'
                      + 'of items per location<br/>&ndash; Instance: every single item is stored'"
                    class="fas fa-info-circle text-gray-600 text-xs"
                  />
                </th>

                <td>
                  <editable-select
                    id="stock_type"
                    name="Stock type"
                    :initial-value="type.stock_type"
                    :options="[{label: 'Instance', value: 'instance'},
                               {label: 'Stock', value: 'stock'}]"
                    :save-value="edit"
                  />
                </td>
              </tr>
            </table>
          </div>
        </div>
      </details>

      <details
        v-if="type.stock_type === 'stock'"
        open
      >
        <summary>
          Stock balance
        </summary>

        <stock-balance
          :type-id="type.id"
          :balance="type.stock_balances"
          :save="saveStock"
        />
      </details>

      <details
        v-else-if="type.instances.length > 0"
        open
      >
        <summary>Instances</summary>

        <instance-list
          :data="type.instances"
        />
      </details>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import EditableTextField from '../../components/editing/EditableTextField.vue';
import EditableSelect from '../../components/editing/EditableSelect.vue';
import StockBalance from '../../components/type/stock-balance/StockBalance.vue';
import InstanceList from '../../components/type/TypeInstanceList.vue';

export default {
  components: {
    InstanceList, StockBalance, EditableSelect, EditableTextField,
  },
  computed: {
    id() {
      return parseInt(this.$route.params.type || '1', 10);
    },
    ...mapState({
      error: ({ type }) => type.error,
      loaded: ({ type }) => type.loaded,
      type: ({ type }) => type.type,
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
      load: 'type/load',
      edit: 'type/edit',
      saveStock: 'type/saveStock',
    }),
  },
};
</script>
