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
        All reservations
      </h1>

      <router-link
        :to="{ name: 'reservations.new' }"
        class="button-gray"
      >
        New reservation
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
          <th>
            Status
          </th>

          <th class="w-1/4">
            Author
          </th>

          <th class="w-1/4">
            Starts at
          </th>
          <th class="w-1/4">
            Ends at
          </th>
        </tr>
        <tr
          v-for="row in data.data"
          :key="row.id"
        >
          <td class="font-semibold">
            <router-link :to="{ name: 'reservations.view', params: { reservation: row.id } }">
              {{ row.identifier }}
            </router-link>
          </td>
          <td class="whitespace-no-wrap">
            <reservation-status :status="row.status" />
          </td>
          <td>
            <router-link :to="{ name: 'users.view', params: { user: row.id } }" class="hover:underline">
              [{{ row.author.identifier }}] {{ row.author.name }} ({{ row.author.username }})
            </router-link>
          </td>
          <td>
            {{ formatDate(row.starts_at) }}
          </td>
          <td>
            {{ formatDate(row.ends_at) }}
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
import { debounce } from 'lodash';
import { formatDate } from '../../utilities';
import ReservationStatus from '../../components/reservations/ReservationStatus.vue';

export default {
  components: { ReservationStatus },
  data() {
    return {
      search: this.$route.query.search || '',
      page: parseInt(this.$route.query.page || '1', 10),
      debouncedSearch: debounce(this.runSearch, 500),
    };
  },
  computed: {
    ...mapState({
      error: ({ reservationList }) => reservationList.error,
      loaded: ({ reservationList }) => reservationList.loaded,
      data: ({ reservationList }) => reservationList.data,
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
    this.runSearch();
  },
  methods: {
    ...mapActions({
      load: 'reservationList/load',
    }),
    capitalize(s) {
      if (typeof s !== 'string') return '';
      return s.charAt(0).toUpperCase() + s.slice(1);
    },
    formatDate,
    runSearch() {
      this.load({ page: this.page, search: this.search });
    },
  },
};
</script>
