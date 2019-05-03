<template>
    <div class="mt-4" v-if="data.length > 0">
        <table class="table">
            <tr class="header">
                <th colspan="4">
                    Instances located here
                </th>
            </tr>

            <tr class="text-sm">
                <th class="w-2/5">Instance</th>
                <th class="w-2/5">Type</th>
                <th></th>
            </tr>

            <tr v-for="row in data">
                <td>
                    <a :href="row.viewUrl">
                        [{{ row.identifier }}] {{ row.label }}
                    </a>
                </td>

                <td>
                    <a :href="row.type.viewUrl" v-if="row.type">
                        [{{ row.type.identifier }}] {{ row.type.name }}
                    </a>

                    <span v-else>
                        &ndash;
                    </span>
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
    export default {
        props: ['url'],
        mounted() {
            this.load();
        },
        methods: {
            load() {
                axios.get(this.url)
                    .then(({data}) => {
                        this.data = data;
                    });
            }
        },
        data() {
            return {
                data: [],
            };
        },
    }
</script>
