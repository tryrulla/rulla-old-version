<template>
    <table class="table">
        <tr class="header">
            <th colspan="5">
                Reserved items
            </th>
        </tr>

        <tr class="text-sm">
            <th>
                Status
            </th>

            <th class="w-1/3">
                Item
            </th>

            <th class="w-1/3">
                Type
            </th>

            <th class="w-1/3">
                Location
            </th>

            <th></th>
        </tr>

        <tr v-for="item in data">
            <td class="whitespace-no-wrap">
                <reservation-status
                    :item="true"
                    :status="item.status"
                ></reservation-status>
            </td>

            <td>
                <a :href="item.item.viewUrl">
                    [{{ item.item.identifier }}] {{ item.item.label }}
                </a>
            </td>

            <td>
                <a :href="item.item.type.viewUrl" v-if="item.item.type">
                    [{{ item.item.type.identifier }}] {{ item.item.type.name }}
                </a>

                <span v-else class="text-gray-700">
                    &ndash;
                </span>
            </td>

            <td>
                <a :href="item.item.location.viewUrl" v-if="item.item.location">
                    [{{ item.item.location.identifier }}] {{ item.item.location.name }}
                </a>

                <span v-else class="text-gray-700">
                    &ndash;
                </span>
            </td>

            <td class="whitespace-no-wrap">
                <button @click="() => readOut(item.item_id)" v-if="item.status === 'inStock'">
                    read out
                </button>

                <button @click="() => returnBack(item.item_id)" v-if="item.status === 'out'">
                    return
                </button>
            </td>
        </tr>
    </table>
</template>

<script>
    export default {
        props: [
            'itemData',
            'updateUrl',
        ],
        data() {
            return {
                data: this.itemData || [],
            };
        },
        methods: {
            update(data) {
                axios.put(this.updateUrl, data)
                    .then(({data}) => {
                        console.log(data);
                        this.data = data.data.items;

                        if (data.oldStatus !== data.data.status) {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert(error);
                    });
            },
            readOut(id) {
                this.update({'read-out': [id]});
            },
            returnBack(id) {
                this.update({'return': [id]});
            },
        },
    }
</script>
