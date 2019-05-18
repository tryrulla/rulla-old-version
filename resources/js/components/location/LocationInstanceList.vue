<template>
  <details
    v-if="data.length > 0"
    open
  >
    <summary>Instances located here</summary>
    <table class="table">
      <tr class="header">
        <th class="w-1/2">
          Instance
        </th>
        <th class="w-1/2">
          Type
        </th>
      </tr>

      <tr
        v-for="row in data"
        :key="row.id"
      >
        <td>
          <router-link :to="{ name: 'instances.view', params: { instance: row.id } }">
            [{{ row.identifier }}] {{ row.label }}
          </router-link>
        </td>

        <td>
          <router-link
            v-if="row.type"
            :to="{ name: 'types.view', params: { type: row.type.id } }"
          >
            [{{ row.type.identifier }}] {{ row.type.name }}
          </router-link>

          <span v-else>
            &ndash;
          </span>
        </td>
      </tr>
    </table>
  </details>
</template>

<script>
export default {
  props: {
    data: {
      type: Array,
      required: true,
    },
  },
};
</script>
