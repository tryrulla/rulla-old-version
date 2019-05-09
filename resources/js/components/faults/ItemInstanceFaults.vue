<template>
    <div v-if="data && data.length > 0" >
        <div class="flex justify-between" v-for="fault in data">
            <div>
                <a class="font-semibold hover:underline" :href="fault.viewUrl">
                    {{ fault.identifier }}</a>

                {{ fault.name }}
            </div>

            <div>
                <item-fault-priority :priority="fault.priority"></item-fault-priority>
                <item-fault-status :status="fault.status"></item-fault-status>
            </div>
        </div>
    </div>

    <div v-else>
        No faults recorded.
    </div>
</template>

<script>
    export default {
        props: ['data'],
    }
</script>
