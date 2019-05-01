<template>
    <div>
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
                            <v-select v-model="selectedLocation" v-autofocus-select
                                      :getOptionLabel="location => `[${location.identifier}] ${location.name}`"
                                      :reduce="location => location.id"
                                      :options="suggestions"></v-select>

                            <div v-if="locationError" class="text-xs text-red-700">{{ locationError }}</div>
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
                                   @keyup.enter="submit"
                                   class="input-text">

                            <div v-if="amountError" class="text-xs text-red-700">{{ amountError }}</div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/3"></div>
                        <div class="w-2/3">
                            <button class="button-white" @click="submit">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    const defaultData = {
        open: false,

        loading: false,
        suggestions: null,
        error: null,
        locationError: null,
        amountError: null,

        selectedLocation: null,
        selectedAmount: 0,
    };

    export default {
        name: 'add-button',
        props: ['saveUrl', 'locationUrl', 'update'],
        data() {
            return Object.assign({}, defaultData);
        },
        methods: {
            submit() {
                if (!this.selectedLocation) {
                    this.locationError = 'You must select a location.';
                    return;
                }

                if (this.selectedAmount <= 0) {
                    this.amountError = 'Amount must be at least one.';
                    return;
                }

                this.loading = true;

                axios.post(this.saveUrl, {location: this.selectedLocation, amount: this.selectedAmount})
                    .then(({data}) => {
                        this.update(data.location_id, data);

                        Object.keys(defaultData)
                            .forEach((key) => this[key] = defaultData[key]);
                    }).catch(error => {
                        console.error(error);
                        this.loading = false;
                        this.suggestions = null;
                        this.error = error.toString();
                    });
            },
        },
        watch: {
            open(newValue) {
                if (newValue && !this.loading && !this.suggestions) {
                    this.loading = true;

                    axios.get(this.locationUrl)
                        .then(({data}) => {
                            this.suggestions = data;
                            this.error = null;
                            this.loading = false;
                        }).catch(error => {
                            console.error(error);
                            this.loading = false;
                            this.suggestions = null;
                            this.error = error.toString();
                        });
                }
            },
            selectedAmount() {
                this.amountError = null;
            },
            selectedLocation() {
                this.locationError = null;
            }
        },
    };
</script>
