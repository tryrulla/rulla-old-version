<template>
    <div>
        <details open>
            <summary>Basic Details</summary>

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
                                ></reservation-status>

                                <div class="my-1">
                                    <div v-if="reservation.status === 'awaitingApproval'">
                                        <button @click="() => update({approval_status: 'approved'})" class="text-blue-800 hover:underline">
                                            approve
                                        </button>

                                        <button @click="() => update({approval_status: 'rejected'})" class="text-blue-800 hover:underline">
                                            reject
                                        </button>
                                    </div>

                                    <div v-if="reservation.status === 'rejected' || reservation.status === 'planned'">
                                        <button @click="() => update({approval_status: 'awaiting'})" class="text-blue-800 hover:underline">
                                            un-{{ reservation.status === 'rejected' ? 'reject' : 'accept' }}
                                        </button>
                                    </div>

                                    <div v-if="canCancel">
                                        <button @click="() => update({cancelled: true})" class="text-blue-800 hover:underline">
                                            cancel
                                        </button>
                                    </div>

                                    <div v-if="reservation.status === 'cancelled'">
                                        <button @click="() => update({cancelled: false})" class="text-blue-800 hover:underline">
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
                                <formatted-date :date="reservation.starts_at"></formatted-date>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                End date
                            </th>

                            <td>
                                <formatted-date :date="reservation.ends_at"></formatted-date>
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

            <add-items-button
                              v-if="reservation.status === 'awaitingApproval' || reservation.status === 'planned'"
                              :save="update"
                              :item-url="itemUrl"
            ></add-items-button>

            <div>
                <table class="table">
                    <tr class="text-sm">
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

                        <th></th>
                    </tr>

                    <tr v-for="item in items">
                        <td class="whitespace-no-wrap">
                            <reservation-status
                                :item="true"
                                :status="item.status"
                            ></reservation-status>
                        </td>

                        <td>
                            <a :href="item.item.viewUrl">
                                [{{ item.item.identifier }}] {{ item.item.label }}
                            </a>
                        </td>

                        <td>
                            <a :href="item.item.type.viewUrl" v-if="item.item.type">
                                [{{ item.item.type.identifier }}] {{ item.item.type.name }}
                            </a>

                            <span v-else class="text-gray-700">
                                &ndash;
                            </span>
                        </td>

                        <td>
                            <a :href="item.item.location.viewUrl" v-if="item.item.location">
                                [{{ item.item.location.identifier }}] {{ item.item.location.name }}
                            </a>

                            <span v-else class="text-gray-700">
                                &ndash;
                            </span>
                        </td>

                        <td class="whitespace-no-wrap text-right">
                            <button @click="() => readOut(item.item_id)"
                                    v-if="item.status !== 'out' && canModifyItemStatus"
                                    class="text-blue-800 hover:underline">
                                read out
                            </button>

                            <button @click="() => returnBack(item.item_id)"
                                    v-if="item.status === 'out' && canModifyItemStatus"
                                    class="text-blue-800 hover:underline">
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
    import {dateDiff} from '../../utilities';
    import AddItemsButton from './AddItemsButton.vue';
    import sortBy from 'lodash/sortBy';

    export default {
        props: [
            'data',
            'updateUrl',
            'itemUrl',
        ],
        components: {
            AddItemsButton,
        },
        data() {
            return {
                reservation: this.data || [],
            };
        },
        computed: {
            duration() {
                return dateDiff(this.reservation.starts_at, this.reservation.ends_at);
            },
            canModifyItemStatus() {
                return [
                    'planned',
                    'out',
                    'overdue'
                ].includes(this.reservation.status);
            },
            canCancel() {
                return [
                    'awaitingApproval',
                    'planned'
                ].includes(this.reservation.status);
            },
            items() {
                return sortBy(this.reservation.items, ['item_id']);
            },
        },
        methods: {
            update(data) {
                axios.put(this.updateUrl, data)
                    .then(({data}) => {
                        this.reservation = data.data;
                    })
                    .catch(error => {
                        console.error(error);

                        if (error && error.response && error.response.data && error.response.data.message) {
                            alert(error.response.data.message);
                        } else {
                            alert(error);
                        }
                    });
            },
            readOut(id) {
                this.update({'read-out': [id]});
            },
            returnBack(id) {
                this.update({'return': [id]});
            },
        },
    }
</script>
