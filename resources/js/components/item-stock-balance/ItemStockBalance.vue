<template>
    <div>
        <table class="table">
            <tr class="header">
                <th class="w-2/6">Location</th>
                <th class="w-1/6">Balance</th>
                <th class="w-2/6">Last updated</th>
                <td class="text-right text-xs">
                    <add-button
                        :location-url="suggestionUrl"
                        :save-url="saveUrl"
                        :update="update"
                    ></add-button>
                </td>
            </tr>

            <tr v-for="row in rows">
                <td>
                    <a :href="row.location.viewUrl">
                        [{{ row.location.identifier}}] {{ row.location.name }}
                    </a>
                </td>

                <td>
                    {{ row.amount }}
                </td>

                <td>
                    {{ formatDate(row.updated_at) }}
                </td>

                <td class="text-right text-small">
                    <edit-button
                        :location="row.location"
                        :old-amount="row.amount"
                        :save-url="saveUrl"
                        :update="update"
                    ></edit-button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {formatDate, upsert} from "../../utilities";
    import sortBy from 'lodash/sortBy';

    import AddButton from './AddButton';
    import EditButton from './EditButton';

    export default {
        props: ['initialData', 'saveUrl', 'suggestionUrl'],
        components: {
            AddButton,
            EditButton,
        },
        methods: {
            formatDate(date) {
                return formatDate(date);
            },
            update(locationId, data) {
                this.data = upsert(this.data, 'location_id', locationId, data);
                this.$forceUpdate();
            }
        },
        data() {
            return {
                data: this.initialData,
            };
        },
        computed: {
            rows() {
                return sortBy(this.data, 'location_id');
            },
        },
    }
</script>
