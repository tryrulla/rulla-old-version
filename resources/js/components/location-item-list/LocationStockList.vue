<template>
    <div class="mt-4" v-if="data.length > 0">
        <table class="table">
            <tr class="header">
                <th colspan="4">
                    Stock located here
                </th>
            </tr>

            <tr class="text-sm">
                <th class="w-2/5">Item</th>
                <th class="w-1/5">Balance</th>
                <th class="w-1/5">Last updated</th>
                <th></th>
            </tr>

            <tr v-for="row in data">
                <td>
                    <a :href="row.viewUrl">
                        [{{ row.identifier }}] {{ row.name }}
                    </a>
                </td>

                <td>
                    {{ getBalanceHere(row).amount }}
                </td>

                <td>
                    {{ formatDate(getBalanceHere(row).updated_at) }}
                </td>

                <td class="text-right">
                    <a class="text-blue-800 underline hover:no-underline" :href="row.viewUrl">
                        View
                    </a>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {formatDate} from "../../utilities";

    export default {
        props: ['url', 'locationId'],
        mounted() {
            this.load();
        },
        methods: {
            load() {
                axios.get(this.url)
                    .then(({data}) => {
                        this.data = data;
                    });
            },
            getBalanceHere(row) {
                return row.stock_balances.filter(it => it.location_id === this.locationId)[0];
            },
            formatDate(date) {
                return formatDate(date);
            },
        },
        data() {
            return {
                data: [],
            };
        },
    }
</script>
