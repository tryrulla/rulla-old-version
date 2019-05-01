<template>
    <div>
        <table class="table">
            <tr class="header">
                <th colspan="3">
                    Stock balance
                </th>

                <td class="text-right text-xs">
                    <button class="px-2 inline-block" @click="open = true">
                        add
                    </button>

                    <modal :open="open" @close="open = false">
                        <div class="card w-screen-1/2">
                            <div class="card-header">
                                <h1>Add Stock Balance</h1>
                            </div>

                            <div v-if="loading" class="p-4">
                                Loading...
                            </div>

                            <div v-else-if="error" class="p-4">
                                {{ error }}
                            </div>

                            <div class="p-4" v-else-if="suggestions">
                                <div class="flex my-2">
                                    <div class="w-1/3">
                                        Location
                                    </div>

                                    <div class="w-2/3">
                                        <v-select v-model="selectedLocation"
                                                  :getOptionLabel="location => `[${location.identifier}] ${location.name}`"
                                                  :reduce="location => location.id"
                                                  :options="suggestions"></v-select>
                                    </div>
                                </div>

                                <div class="flex my-2">
                                    <div class="w-1/3">
                                        <label for="amount" class="cursor-pointer">
                                            Amount
                                        </label>
                                    </div>

                                    <div class="w-2/3">
                                        <input v-model="selectedAmount" type="number" id="amount"
                                               class="input-text">

                                        <div v-if="amountError" class="text-xs text-red-700">{{ amountError }}</div>
                                    </div>
                                </div>

                                <div class="flex">
                                    <div class="w-1/3"></div>
                                    <div class="w-2/3">
                                        <button class="button-white" @click="addNewBalance">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </modal>
                </td>
            </tr>

            <tr>
                <th class="w-2/6">Location</th>
                <th class="w-1/6">Balance</th>
                <th class="w-2/6">Last updated</th>
                <th></th>
            </tr>

            <tr v-for="row in data">
                <td>
                    <a :href="row.location.viewUrl">
                        {{ row.location.name }}
                    </a>
                </td>

                <td>
                    {{ row.amount }}
                </td>

                <td>
                    {{ formatDate(row.created_at) }}
                </td>

                <td class="text-right text-small">
                    edit
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import moment from 'moment-timezone';
    import {upsert} from "../utilities";

    export default {
        props: ['initialData', 'saveUrl', 'suggestionUrl'],
        methods: {
            formatDate(date) {
                return moment.tz(date, 'UTC')
                    .tz(moment.tz.guess())
                    .format('Y-MM-DD kk:mm');
            },
            addNewBalance() {
                if (this.selectedAmount <= 0) {
                    this.amountError = 'Amount must be at least one.';
                    return;
                }

                this.loading = true;

                axios.post(this.saveUrl, {location: this.selectedLocation, amount: this.selectedAmount})
                    .then(({data}) => {
                        console.log(data);
                        this.data = upsert(this.data, 'location_id', data.location_id, data);

                        // ;(
                        this.open = false;
                        this.loading = false;
                        this.suggestions = null;
                        this.error = false;
                        this.amountError = false;
                        this.selectedLocation = null;
                        this.selectedAmount = null;
                    }).catch(error => {
                        this.loading = false;
                        this.suggestions = null;
                        this.error = error.toString();
                    });
            },
        },
        data() {
            return {
                data: this.initialData,

                open: false,
                loading: false,
                suggestions: null,
                error: null,
                amountError: null,

                selectedLocation: null,
                selectedAmount: 0,
            };
        },
        watch: {
            open(newValue) {
                if (newValue && !this.loading && !this.suggestions) {
                    this.loading = true;

                    axios.get(this.suggestionUrl)
                        .then(({data}) => {
                            this.suggestions = data;
                            this.error = null;
                            this.loading = false;
                        }).catch(error => {
                            this.loading = false;
                            this.suggestions = null;
                            this.error = error.toString();
                        });
                }
            },
            amount() {
                this.amountError = null;
            }
        },
    }
</script>
