<template>
    <div v-if="loading">
        Loading...
    </div>

    <div v-else-if="error">
        <span class="text-red-800">{{ error }}</span>
    </div>

    <div v-else>
        <v-select v-model="selected"
              :getOptionLabel="label"
              :reduce="it => it.id"
              :options="data"></v-select>

        <input type="hidden" :name="name" v-model="selected">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
                data: null,
                error: null,
                selected: this.value || null,
            };
        },
        mounted() {
            axios.get(this.url)
                .then(({data}) => {
                    this.loading = false;
                    this.data = data;
                    this.error = null;
                }).catch(error => {
                    console.error(error);
                    this.loading = false;
                    this.data = null;
                    this.error = error.toString();
                });
        },
        props: {
            url: String,
            name: String,
            value: Number,
            label: {
                type: Function,
                default: it => `[${it.identifier}] ${it.name}`,
            },
        },
    }
</script>
