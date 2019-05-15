<template>
  <div>
    <location-instance-list
      :data="data.instances"
    />

    <location-stock-list
      :data="data.stock"
      :location-id="data.id"
    />
  </div>
</template>

<script>
import LocationInstanceList from './LocationInstanceList.vue';
import LocationStockList from './LocationStockList.vue';

export default {
  components: {
    LocationInstanceList,
    LocationStockList,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
};
</script>
