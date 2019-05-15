<template>
  <span>{{ formattedDate }}</span>
</template>

<script>
import { formatDate } from '../utilities';

export default {
  name: 'FormattedDate',
  props: {
    date: {
      type: String,
      required: true,
    },
  },
  computed: {
    formattedDate() {
      return formatDate(this.date);
    },
  },
};
</script>
