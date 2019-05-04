<template>
    <span :class="data.classNames">
        {{ data.name }}
    </span>
</template>

<script>
    export default {
        name: 'reservation-status',
        computed: {
            data() {
                return {
                    name: this.getName(this.status),
                    classNames: ['font-thin', 'tracking-wide', 'p-1', 'rounded', 'text-sm', ...this.getColors(this.status)],
                };
            },
        },
        methods: {
            getName(name) {
                switch (name) {
                    case 'rejected':
                        return 'Rejected';
                    case 'planned':
                        return 'Planned';
                    case 'awaitingApproval':
                        return 'Waiting for approval';
                    default:
                        return name;
                }
            },
            getColors(name) {
                switch (name) {
                    case 'rejected':
                        return ['bg-red-200', 'text-red-900'];
                    case 'planned':
                        return ['bg-blue-200', 'text-blue-900'];
                    case 'awaitingApproval':
                    default:
                        return ['bg-gray-200', 'text-gray-900'];
                }
            },
        },
        props: ['status'],
    };
</script>
