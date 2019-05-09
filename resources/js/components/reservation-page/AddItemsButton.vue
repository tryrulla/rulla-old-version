<template>
    <div>
        <button @click="open = true">
            add
        </button>

        <modal :open="open" @close="open = false">
            <div class="bg-white shadow rounded-lg w-screen-1/2">
                <div class="bg-gray-400 p-4 rounded-t flex justify-between">
                    <h1 class="text-xl text-black font-bold">Add Items to Reservation</h1>
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
                            Items
                        </div>

                        <div class="w-2/3">
                            <v-select v-model="selected"
                                      :getOptionLabel="getLabel"
                                      :reduce="({id}) => id"
                                      :multiple="true"
                                      :options="suggestions"></v-select>

                            <div v-if="error" class="text-xs text-red-700">{{ error }}</div>
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
    const defaultData = () => ({
        open: false,
        loading: false,
        error: null,
        suggestions: null,
        selected: [],
    });

    export default {
        name: 'add-items-button',
        props: [
            'save',
            'itemUrl',
        ],
        data() {
            return defaultData();
        },
        methods: {
            getLabel(it) {
                let string = `[${it.identifier}] ${it.label}`;

                if (it.type) {
                    string += ` ([${it.type.identifier}] ${it.type.name})`;
                }

                if (it.location) {
                    string += ` ([${it.location.identifier}] ${it.location.name})`;
                }

                return string;
            },
            submit() {
                this.save({'add-items': this.selected});

                this.selected = [];
                this.open = false;
            },
        },
        watch: {
            open(newValue) {
                if (newValue && !this.loading && !this.suggestions) {
                    this.loading = true;

                    axios.get(this.itemUrl)
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
        },
    }
</script>
