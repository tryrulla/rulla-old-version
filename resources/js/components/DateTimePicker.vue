<template>
    <div>
        <VueCtkDateTimePicker
            v-model="value"
            :id="id" :firstDayOfWeek="1"
            output-format="YYYY-MM-DDTHH:mm:ssZ"
        ></VueCtkDateTimePicker>

        <input type="hidden" :name="id" v-model="value">
    </div>
</template>

<script>
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';

    export default {
        components: {VueCtkDateTimePicker},
        props: ['id', 'initialValue'],
        data() {
            return {
                value: this.initialValue || null,
            };
        }
    }
</script>
