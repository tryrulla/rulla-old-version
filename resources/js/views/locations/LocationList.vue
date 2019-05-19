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
        All locations
      </h1>

      <router-link
        :to="{ name: 'locations.new' }"
        class="button-gray"
      >
        New location
      </router-link>
    </div>

    <div class="mb-2">
      <label
        for="search"
        class="text-xs text-gray-700 font-bold uppercase"
      >
        Search

        <a
          href="https://github.com/lorisleiva/laravel-search-string#the-search-string-syntax"
          target="_blank"
        >
          <i
            v-tooltip="'Click for help'"
            class="fas fa-info-circle text-gray-600 text-xs"
          />
        </a>
      </label>

      <input
        id="search"
        v-model="search"
        placeholder="Search"
        class="input-text"
      >
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
            Name
          </th>

          <th class="w-1/2">
            Parent
          </th>
        </tr>
        <tr
          v-for="row in data.data"
          :key="row.id"
        >
          <td class="font-semibold">
            <router-link
              :to="{ name: 'locations.view', params: { location: row.id } }"
            >
              {{ row.identifier }}
            </router-link>
          </td>
          <td>
            {{ row.name }}
          </td>

          <td>
            <router-link
              v-if="row.parent"
              :to="{ name: 'locations.view', params: { location: row.parent.id } }"
            >
              [{{ row.parent.identifier }}] {{ row.parent.name }}
            </router-link>

            <span
              v-else
              class="text-gray-700"
            >
              &ndash;
            </span>
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
import { mapState, mapActions } from 'vuex';
import { debounce } from 'lodash';

export default {
  data() {
    return {
      search: this.$route.query.search || '',
      page: parseInt(this.$route.query.page || '1', 10),
      debouncedSearch: debounce(this.runSearch, 500),
    };
  },
  computed: {
    ...mapState({
      error: ({ locationList }) => locationList.error,
      loaded: ({ locationList }) => locationList.loaded,
      data: ({ locationList }) => locationList.data,
    }),
  },
  watch: {
    page() {
      this.runSearch();
      this.$router.push({
        query: {
          page: this.page.toString(),
        },
      });
    },
    search() {
      this.debouncedSearch();
      this.$router.push({
        query: {
          search: this.search.length > 0 ? this.search : undefined,
        },
      });
    },
  },
  mounted() {
    this.load({ page: this.page });
  },
  methods: {
    ...mapActions({
      load: 'locationList/load',
    }),
    capitalize(s) {
      if (typeof s !== 'string') return '';
      return s.charAt(0).toUpperCase() + s.slice(1);
    },
    runSearch() {
      this.load({ page: this.page, search: this.search });
    },
  },
};
</script>
