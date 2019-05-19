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
        All instances
      </h1>

      <router-link
        :to="{ name: 'instances.new' }"
        class="button-gray"
      >
        New instance
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
        <th class="w-1/3">
          Label
        </th>
        <th class="w-1/3">
          Type
        </th>
        <th class="w-1/3">
          Location
        </th>
      </tr>
      <tr
        v-for="row in data.data"
        :key="row.id"
      >
        <td class="font-semibold">
          <router-link
            :to="{ name: 'instances.view', params: { instance: row.id } }"
          >
            {{ row.identifier }}
          </router-link>
        </td>
        <td>
          <span v-if="row.label && row.label.length > 0">
            {{ row.label }}
          </span>
          <span v-else>
            &ndash;
          </span>
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
        <td>
          <a
            v-if="row.location"
            :href="row.location.viewUrl"
          >
            [{{ row.location.identifier }}] {{ row.location.name }}
          </a>

          <span v-else>
            &ndash;
          </span>
        </td>
      </tr>
    </table>
    <table
      v-if="data.data.length > 0"
      class="table"
    >
      <tr
        v-if="data.data.length >= 1"
        class="header"
      >
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
      error: ({ instanceList }) => instanceList.error,
      loaded: ({ instanceList }) => instanceList.loaded,
      data: ({ instanceList }) => instanceList.data,
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
      load: 'instanceList/load',
    }),
    runSearch() {
      this.load({ page: this.page, search: this.search });
    },
  },
};
</script>
