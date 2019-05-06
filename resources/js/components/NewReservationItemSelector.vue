<template>
    <div v-if="loading">
        Loading...
    </div>

    <div v-else-if="error">
        <span class="text-red-800">{{ error }}</span>
    </div>

    <div v-else>
        <v-select v-model="value"
                  placeholder="Search items..."
                  name="item_selector"
                  :getOptionLabel="getLabel"
                  :reduce="it => it.id"
                  :multiple="true"
                  :options="instances"></v-select>

        <input v-for="row in value" type="hidden" name="items[]" :value="row">
    </div>
</template>

<script>
    export default {
        props: {
            values: {
                type: Array,
                default: () => [],
            },
            url: String,
        },
        data() {
            return {
                loading: true,
                error: null,

                value: (this.values || []).map(it => parseInt(it, 10)),
            };
        },
        mounted() {
            axios.get(this.url)
                .then(({data}) => {
                    this.loading = false;
                    this.instances = data;
                    this.error = null;
                }).catch(error => {
                    console.error(error);
                    this.loading = false;
                    this.instances = null;
                    this.error = error.toString();
                });
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
        },
    };
</script>
