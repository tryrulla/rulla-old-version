<template>
    <div>
        <button class="inline-block text-xs" @click="open = true">
            edit
        </button>

        <modal :open="open" @close="open = false">
            <div class="card w-screen-1/2">
                <div class="card-header">
                    <h1>Update Stock Balance</h1>
                </div>

                <div class="p-4" v-if="loading">
                    Loading...
                </div>

                <div class="p-4" v-else>
                    <div class="flex my-2">
                        <div class="w-1/3">
                            Location
                        </div>

                        <div class="w-2/3">
                            [{{location.identifier}}] {{ location.name }}
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
                                   v-autofocus @keyup.enter="submit"
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
        amountError: null,
        loading: false,
    };

    export default {
        name: 'edit-button',
        props: ['saveUrl', 'oldAmount', 'location', 'update'],
        data() {
            return Object.assign({}, defaultData, {selectedAmount: this.oldAmount});
        },
        methods: {
            submit() {
                if (this.selectedAmount <= 0) {
                    this.amountError = 'Amount must be at least one.';
                    return;
                }

                this.loading = true;

                axios.post(this.saveUrl, {location: this.location.id, amount: this.selectedAmount})
                    .then(({data}) => {
                        console.log({data});
                        this.update(data.location_id, data);

                        const dataToUpdate = Object.assign({}, defaultData, {selectedAmount: this.oldAmount});
                        Object.keys(dataToUpdate)
                            .forEach((key) => this[key] = dataToUpdate[key]);
                    }).catch(error => {
                        console.error(error);
                        this.loading = false;
                        this.suggestions = null;
                        this.error = error.toString();
                    });
            },
        },
    };
</script>
