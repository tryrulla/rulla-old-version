<template>
  <table
    v-if="faults && faults.length > 0"
    class="table"
  >
    <tr class="header">
      <th>Identifier</th>
      <th>Name</th>
      <th>Priority</th>
      <th>Status</th>
    </tr>
    <tr
      v-for="fault in faults"
      :key="fault.id"
    >
      <td>
        <router-link
          :to="{ name: 'instances.fault', params: { instance: instanceId, fault: fault.id } }"
          class="font-semibold hover:underline"
        >
          {{ fault.identifier }}
        </router-link>
      </td>
      <td class="w-full">
        <router-link
          :to="{ name: 'instances.fault', params: { instance: instanceId, fault: fault.id } }"
        >
          {{ fault.name }}
        </router-link>
      </td>

      <td class="whitespace-no-wrap">
        <item-fault-priority :priority="fault.priority" />
      </td>
      <td class="whitespace-no-wrap">
        <item-fault-status :status="fault.status" />
      </td>
    </tr>
  </table>

  <div v-else>
    No faults recorded.
  </div>
</template>

<script>
import ItemFaultPriority from './ItemFaultPriority.vue';
import ItemFaultStatus from './ItemFaultStatus.vue';

export default {
  name: 'ItemFaultListing',
  components: { ItemFaultStatus, ItemFaultPriority },
  props: {
    instanceId: {
      type: Number,
      required: true,
    },
    faults: {
      type: Array,
      required: true,
    },
  },
};
</script>
