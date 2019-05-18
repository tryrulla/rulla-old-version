<template>
  <div>
    <table class="table">
      <tr class="header">
        <th class="w-4/6">
          Location
        </th>
        <th class="w-1/6">
          Balance
        </th>
        <th class="w-1/6">
          Last updated
        </th>
        <td class="text-right text-xs">
          <add-button
            :type-id="typeId"
            :save="save"
          />
        </td>
      </tr>

      <tr
        v-for="row in balance"
        :key="row.id"
      >
        <td>
          <router-link :to="{ name: 'locations.view', params: { location: row.location.id } }">
            [{{ row.location.identifier }}] {{ row.location.name }}
          </router-link>
        </td>

        <td>
          {{ row.amount }}
        </td>

        <td>
          {{ formatDate(row.updated_at) }}
        </td>

        <td class="text-right text-small">
          <edit-button
            :row="row"
            :save="save"
          />
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import { formatDate } from '../../../utilities';
import AddButton from './AddButton.vue';
import EditButton from './EditButton.vue';

export default {
  name: 'StockBalance',
  components: { AddButton, EditButton },
  props: {
    typeId: {
      type: Number,
      required: true,
    },
    save: {
      type: Function,
      required: true,
    },
    balance: {
      type: Array,
      required: true,
    },
  },
  methods: {
    formatDate,
  },
};
</script>
