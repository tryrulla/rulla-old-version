<template>
    <span>{{ formattedDate }}</span>
</template>

<script>
    import {formatDate} from "../utilities";

    export default {
        props: ['date'],
        computed: {
            formattedDate() {
                return formatDate(this.date);
            }
        }
    }
</script>
