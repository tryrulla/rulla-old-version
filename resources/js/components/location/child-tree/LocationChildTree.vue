<template>
  <details open>
    <summary>Location tree</summary>

    <div class="p-1">
      <div class="font-bold">
        [{{ data.identifier }}] {{ data.name }}
      </div>

      <div
        v-if="data.children_tree"
        class="pl-2"
      >
        <location-child
          v-for="child in data.children_tree"
          :key="child.id"
          :data="child"
        />
      </div>
    </div>
  </details>
</template>

<script>
import LocationChild from './LocationChild.vue';

export default {
  name: 'LocationChildTree',
  components: { LocationChild },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
};
</script>
