<template>
  <div>
    <table class="table">
      <tr class="header">
        <th class="w-1/2">
          Instance
        </th>
        <th class="w-1/2">
          Location
        </th>
        <th />
      </tr>

      <tr
        v-for="row in data"
        :key="row.id"
      >
        <td>
          <router-link :to="{ name: 'instances.view', params: { instance: row.id } }">
            [{{ row.identifier }}]

            <span v-if="row.label && row.label.length > 0">
              {{ row.label }}
            </span>
          </router-link>
        </td>

        <td>
          <router-link
            v-if="row.location"
            :to="{ name: 'locations.view', params: { location: row.location.id } }"
          >
            [{{ row.location.identifier }}] {{ row.location.name }}
          </router-link>

          <span v-else>
            &ndash;
          </span>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: 'InstanceList',
  props: {
    data: {
      type: Array,
      required: true,
    },
  },
};
</script>
