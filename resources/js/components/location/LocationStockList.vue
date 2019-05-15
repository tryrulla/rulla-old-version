<template>
  <details
    v-if="data.length > 0"
    open
    class="mt-4"
  >
    <summary>Stock located here</summary>
    <table class="table">
      <tr class="header">
        <th class="w-3/5">
          Item
        </th>
        <th class="w-1/5">
          Balance
        </th>
        <th class="w-1/5">
          Last updated
        </th>
      </tr>

      <tr
        v-for="row in data"
        :key="row.id"
      >
        <td>
          <router-link :to="{ name: 'types.view', params: { type: row.item.id } }">
            [{{ row.item.identifier }}] {{ row.item.name }}
          </router-link>
        </td>

        <td>
          {{ row.amount }}
        </td>

        <td>
          {{ formatDate(row.updated_at) }}
        </td>
      </tr>
    </table>
  </details>
</template>

<script>
import { formatDate } from '../../utilities';

export default {
  props: {
    data: {
      type: Array,
      required: true,
    },
    locationId: {
      type: Number,
      required: true,
    },
  },
  methods: {
    formatDate,
  },
};
</script>
