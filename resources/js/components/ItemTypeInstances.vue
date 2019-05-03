<template>
    <div>
        <table class="table">
            <tr class="header">
                <th colspan="3">
                    Instance
                </th>
            </tr>

            <tr class="text-sm">
                <th class="w-2/5">Instance</th>
                <th class="w-2/5">Location</th>
                <th></th>
            </tr>

            <tr v-for="row in data">
                <td>
                    <a :href="row.viewUrl">
                        [{{ row.identifier }}]
                    </a>

                    <span v-if="row.label && row.label.length > 0">
                        {{ row.label }}
                    </span>
                </td>

                <td>
                    <a :href="row.location.viewUrl" v-if="row.location">
                        [{{ row.location.identifier }}] {{ row.location.name }}
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
        props: ['data']
    }
</script>
