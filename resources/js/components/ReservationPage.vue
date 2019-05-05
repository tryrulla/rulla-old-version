<template>
    <div>
        <div class="p-4 pb-0" v-if="false">
            <b>Actions: </b>
        </div>

        <div class="md:flex">
            <div class="md:w-1/2 p-4">
                <table class="table">
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

                            <div class="my-2" v-if="reservation.status === 'awaitingApproval'">
                                <button @click="() => update({approval_status: 'approved'})" class="text-blue-800 hover:underline">
                                    approve
                                </button>

                                <button @click="() => update({approval_status: 'rejected'})" class="text-blue-800 hover:underline">
                                    reject
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="mt-2">
                        <th>
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

                <table class="table mt-4">
                    <tr class="header">
                        <th colspan="2">
                            Author
                        </th>
                    </tr>

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

                    <tr>
                        <th>
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

            <div class="md:w-1/2 p-4">
                <table class="table">
                    <tr class="header">
                        <th colspan="5">
                            Reserved items
                        </th>
                    </tr>

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

                    <tr v-for="item in reservation.items">
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
                                    v-if="item.status === 'inStock' && canModifyItemStatus"
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
        </div>
    </div>
</template>

<script>
    import {dateDiff} from '../utilities';

    export default {
        props: [
            'data',
            'updateUrl',
        ],
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
