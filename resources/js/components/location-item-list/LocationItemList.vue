<template>
    <div>
        <location-instance-list
            :url="instanceUrl"
        ></location-instance-list>

        <location-stock-list
            :url="stockUrl"
            :location-id="locationId"
        ></location-stock-list>
    </div>
</template>

<script>
    import LocationInstanceList from './LocationInstanceList.vue';
    import LocationStockList from './LocationStockList.vue';

    export default {
        components: {
            LocationInstanceList,
            LocationStockList,
        },
        props: ['instanceUrl', 'stockUrl', 'locationId']
    }
</script>
