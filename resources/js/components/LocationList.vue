<template>
    <div class="card">
        <div class="card-header">
            <h1>
                All locations
            </h1>

            <div class="text-xs">
                <a :href="newUrl" class="text-blue-800 underline">
                    new
                </a>
            </div>
        </div>

        <div v-if="data">
            <div v-if="data.data.length === 0">
                No results.
            </div>

            <table class="table" v-else>
                <tr class="header">
                    <th class="w-1/6">
                        Identifier
                    </th>
                    <th class="w-4/6">
                        Name
                    </th>
                    <th class="w-1/6">

                    </th>
                </tr>
                <tr v-for="row in data.data">
                    <td class="font-semibold">
                        <a :href="row.viewUrl">
                            {{ row.identifier }}
                        </a>
                    </td>
                    <td>
                        {{ row.name }}
                    </td>
                    <td class="text-right">
                        <a class="text-blue-800 underline hover:no-underline" :href="row.viewUrl">
                            View
                        </a>
                    </td>
                </tr>
            </table>

            <table class="table">
                <tr class="header">
                    <th class="w-1/3">
                        <button v-if="data.prev_page_url" @click="() => this.page = data.current_page - 1">
                            &leftarrow; {{ data.current_page - 1 }}
                        </button>
                    </th>

                    <th class="w-1/3 text-center font-normal">
                        Page <strong>{{ data.current_page }}</strong> of <strong>{{ data.last_page }}</strong>
                    </th>

                    <th class="w-1/3 text-right">
                        <button v-if="data.next_page_url" @click="() => this.page = data.current_page + 1">
                            {{ data.current_page + 1 }} &rightarrow;
                        </button>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.load();
        },
        data() {
            return {
                data: null,
                page: parseInt(this.$route.query.page || '1', 10)
            };
        },
        computed: {
            fullUrl() {
                return `${this.url}?page=${this.page}`;
            }
        },
        methods: {
            load() {
                console.log(`loading data for page ${this.page}`);
                axios.get(`${this.url}?page=${this.page}`)
                    .then(({data}) => {
                        this.data = data;
                    });
            },
            capitalize(s) {
                if (typeof s !== 'string') return '';
                return s.charAt(0).toUpperCase() + s.slice(1);
            }
        },
        watch: {
            page() {
                this.load();
                this.$router.push({
                    query: {
                        page: this.page.toString()
                    }
                });
            }
        },
        props: ['url', 'newUrl']
    }
</script>
