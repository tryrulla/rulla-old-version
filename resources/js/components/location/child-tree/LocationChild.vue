<template>
  <div>
    <div>
      <router-link
        :to="{ name: 'locations.view', params: { location: data.id } }"
        class="hover:underline"
      >
        [{{ data.identifier }}] {{ data.name }}
      </router-link>
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
</template>

<script>
export default {
  name: 'LocationChild',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
};
</script>
