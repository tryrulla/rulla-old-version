<template>
  <span :class="data.classNames">
    {{ data.name }}
  </span>
</template>

<script>
export default {
  name: 'ReservationStatus',
  props: {
    status: {
      type: String,
      required: true,
    },
    item: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    data() {
      return {
        name: this.getName(this.status),
        classNames: ['tag', ...this.getColors(this.status)],
      };
    },
  },
  methods: {
    getName(name) {
      if (this.item) {
        switch (name) {
          case 'inStock':
            return 'In Stock';
          case 'out':
            return 'Out';
          case 'returned':
            return 'Returned';
          default:
            return name;
        }
      }

      switch (name) {
        case 'awaitingApproval':
          return 'Waiting for approval';
        case 'rejected':
          return 'Rejected';
        case 'cancelled':
          return 'Cancelled';
        case 'planned':
          return 'Planned';
        case 'out':
          return 'Out';
        case 'overdue':
          return 'Overdue';
        case 'completed':
          return 'Completed';
        default:
          return name;
      }
    },
    getColors(name) {
      if (this.item) {
        switch (name) {
          case 'out':
            return ['bg-blue-200', 'text-blue-900'];
          case 'returned':
            return ['bg-green-200', 'text-green-900'];
          case 'inStock':
          default:
            return ['bg-white', 'border', 'border-gray-400', 'text-gray-900'];
        }
      }

      switch (name) {
        case 'rejected':
        case 'cancelled':
          return ['bg-red-200', 'text-red-900'];
        case 'planned':
          return ['bg-blue-200', 'text-blue-900'];
        case 'out':
          return ['bg-green-400', 'text-green-900'];
        case 'completed':
          return ['bg-green-200', 'text-green-900'];
        case 'overdue':
          return ['bg-red-300', 'text-red-900'];
        case 'awaitingApproval':
        default:
          return ['bg-white', 'border', 'border-gray-400', 'text-gray-900'];
      }
    },
  },
};
</script>
