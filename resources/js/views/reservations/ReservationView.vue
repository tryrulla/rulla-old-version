<template>
  <div v-if="error">
    {{ error }}
  </div>

  <div v-else-if="!loaded">
    Loading...
  </div>

  <div v-else>
    <div class="card-header">
      <div>
        <router-link :to="{ name: 'reservations.index' }">
          Reservation
        </router-link>
      </div>

      <h1>
        {{ reservation.identifier }}
      </h1>
    </div>

    <div class="mb-4">
      <add-items-button
        v-if="reservation.status === 'awaitingApproval' || reservation.status === 'planned'"
        :save="edit"
      />
    </div>

    <details open>
      <summary>Basic details</summary>

      <div class="md:flex">
        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Row type
              </th>

              <td class="w-3/4">
                Reservation
              </td>
            </tr>

            <tr>
              <th>
                Identifier
              </th>

              <td>
                {{ reservation.identifier }}
              </td>
            </tr>
            <tr>
              <th>
                Status
              </th>

              <td>
                <reservation-status
                  :status="reservation.status"
                />

                <div class="my-1">
                  <div v-if="reservation.status === 'awaitingApproval'">
                    <button
                      class="text-blue-800 hover:underline"
                      @click="() => edit({approval_status: 'approved'})"
                    >
                      approve
                    </button>

                    <button
                      class="text-blue-800 hover:underline"
                      @click="() => edit({approval_status: 'rejected'})"
                    >
                      reject
                    </button>
                  </div>

                  <div v-if="reservation.status === 'rejected' || reservation.status === 'planned'">
                    <button
                      class="text-blue-800 hover:underline"
                      @click="() => edit({approval_status: 'awaiting'})"
                    >
                      un-{{ reservation.status === 'rejected' ? 'reject' : 'accept' }}
                    </button>
                  </div>

                  <div v-if="canCancel">
                    <button
                      class="text-blue-800 hover:underline"
                      @click="() => edit({cancelled: true})"
                    >
                      cancel
                    </button>
                  </div>

                  <div v-if="reservation.status === 'cancelled'">
                    <button
                      class="text-blue-800 hover:underline"
                      @click="() => edit({cancelled: false})"
                    >
                      un-cancel
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>

        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Start date
              </th>

              <td>
                <formatted-date :date="reservation.starts_at" />
              </td>
            </tr>

            <tr>
              <th>
                End date
              </th>

              <td>
                <formatted-date :date="reservation.ends_at" />
              </td>
            </tr>

            <tr>
              <th>
                Duration
              </th>

              <td>
                {{ duration }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </details>

    <details open>
      <summary>Author details</summary>

      <div class="md:flex">
        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Identifier
              </th>

              <td class="w-3/4">
                {{ reservation.author.identifier }}
              </td>
            </tr>

            <tr>
              <th>
                Name
              </th>

              <td>
                {{ reservation.author.name }}
              </td>
            </tr>
          </table>
        </div>

        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Username
              </th>

              <td>
                {{ reservation.author.username }}
              </td>
            </tr>

            <tr>
              <th>
                E-mail
              </th>

              <td>
                {{ reservation.author.email }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </details>

    <details open>
      <summary>
        Reserved items
      </summary>

      <div>
        <table class="table">
          <tr class="header">
            <th>
              Status
            </th>

            <th class="w-1/3">
              Item
            </th>

            <th class="w-1/3">
              Type
            </th>

            <th class="w-1/3">
              Location
            </th>

            <th />
          </tr>

          <tr
            v-for="item in items"
            :key="item.id"
          >
            <td class="whitespace-no-wrap">
              <reservation-status
                :item="true"
                :status="item.status"
              />
            </td>

            <td>
              <router-link :to="{ name: 'instances.view', params: { instance: item.item.id } }">
                [{{ item.item.identifier }}] {{ item.item.label }}
              </router-link>
            </td>

            <td>
              <router-link
                v-if="item.item.type"
                :to="{ name: 'types.view', params: { type: item.item.type.id } }"
              >
                [{{ item.item.type.identifier }}] {{ item.item.type.name }}
              </router-link>

              <span
                v-else
                class="text-gray-700"
              >
                &ndash;
              </span>
            </td>

            <td>
              <router-link
                v-if="item.item.location"
                :to="{ name: 'locations.view', params: { location: item.item.location.id } }"
              >
                [{{ item.item.location.identifier }}] {{ item.item.location.name }}
              </router-link>

              <span
                v-else
                class="text-gray-700"
              >
                &ndash;
              </span>
            </td>

            <td class="whitespace-no-wrap text-right">
              <button
                v-if="item.status !== 'out' && canModifyItemStatus"
                class="text-blue-800 hover:underline"
                @click="() => edit({'read-out': [item.item_id]})"
              >
                read out
              </button>

              <button
                v-if="item.status === 'out' && canModifyItemStatus"
                class="text-blue-800 hover:underline"
                @click="() => edit({'return': [item.item_id]})"
              >
                return
              </button>
            </td>
          </tr>
        </table>
      </div>
    </details>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import { sortBy } from 'lodash';
import { dateDiff } from '../../utilities';
import ReservationStatus from '../../components/reservations/ReservationStatus.vue';
import FormattedDate from '../../components/FormattedDate.vue';
import AddItemsButton from '../../components/reservations/AddItemsButton.vue';

export default {
  components: { AddItemsButton, FormattedDate, ReservationStatus },
  computed: {
    id() {
      return parseInt(this.$route.params.reservation || '1', 10);
    },
    ...mapState({
      error: ({ reservation }) => reservation.error,
      loaded: ({ reservation }) => reservation.loaded,
      reservation: ({ reservation }) => reservation.reservation,
    }),
    duration() {
      return dateDiff(this.reservation.starts_at, this.reservation.ends_at);
    },
    canModifyItemStatus() {
      return [
        'planned',
        'out',
        'overdue',
      ].includes(this.reservation.status);
    },
    canCancel() {
      return [
        'awaitingApproval',
        'planned',
      ].includes(this.reservation.status);
    },
    items() {
      return sortBy(this.reservation.items, ['item_id']);
    },
  },
  mounted() {
    this.load({ id: this.id });
  },
  methods: {
    reload() {
      this.load({ id: this.id });
    },
    ...mapActions({
      load: 'reservation/load',
      edit: 'reservation/edit',
    }),
  },
};
</script>
