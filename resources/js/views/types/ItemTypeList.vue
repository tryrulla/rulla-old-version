<template>
  <div v-if="error">
    {{ error }}
  </div>

  <div v-else-if="!loaded">
    Loading...
  </div>

  <div v-else>
    <div class="card-header">
      <h1 class="mb-2">
        All types
      </h1>

      <router-link
        :to="{ name: 'types.new' }"
        class="button-gray"
      >
        New type
      </router-link>
    </div>

    <div v-if="data">
      <div v-if="data.data.length === 0">
        No results.
      </div>

      <table
        v-else
        class="table"
      >
        <tr class="header">
          <th>
            Identifier
          </th>
          <th class="w-1/2">
            Manufacturer
          </th>
          <th class="w-1/2">
            Model
          </th>
          <th class="whitespace-no-wrap">
            Stock type
          </th>
        </tr>
        <tr
          v-for="row in data.data"
          :key="row.id"
        >
          <td class="font-semibold">
            <router-link
              :to="{ name: 'types.view', params: { type: row.id } }"
            >
              {{ row.identifier }}
            </router-link>
          </td>
          <td>
            {{ row.manufacturer }}
          </td>
          <td>
            {{ row.model }}
          </td>
          <td>
            {{ capitalize(row.stock_type) }}
          </td>
        </tr>
      </table>

      <table
        v-if="data.data.length > 0"
        class="table"
      >
        <tr class="header">
          <th class="w-1/3">
            <button
              v-if="data.prev_page_url"
              @click="() => page = data.current_page - 1"
            >
              &leftarrow; {{ data.current_page - 1 }}
            </button>
          </th>

          <th class="w-1/3 text-center font-normal">
            Page <strong>{{ data.current_page }}</strong> of <strong>{{ data.last_page }}</strong>
          </th>

          <th class="w-1/3 text-right">
            <button
              v-if="data.next_page_url"
              @click="() => page = data.current_page + 1"
            >
              {{ data.current_page + 1 }} &rightarrow;
            </button>
          </th>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
  data() {
    return {
      page: parseInt(this.$route.query.page || '1', 10),
    };
  },
  computed: {
    ...mapState({
      error: ({ typeList }) => typeList.error,
      loaded: ({ typeList }) => typeList.loaded,
      data: ({ typeList }) => typeList.data,
    }),
  },
  watch: {
    page() {
      this.load({ page: this.page });
      this.$router.push({
        query: {
          page: this.page.toString(),
        },
      });
    },
  },
  mounted() {
    this.load({ page: this.page });
  },
  methods: {
    ...mapActions({
      load: 'typeList/load',
    }),
    capitalize(s) {
      if (typeof s !== 'string') return '';
      return s.charAt(0).toUpperCase() + s.slice(1);
    },
  },
};
</script>
