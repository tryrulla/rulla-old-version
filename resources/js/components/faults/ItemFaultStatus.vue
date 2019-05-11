<template>
    <span :class="data.classNames" style="padding-bottom: 2px; padding-top: 2px; margin-bottom: 1px;">
        {{ data.name }}
    </span>
</template>

<script>
    export default {
        props: ['status'],
        computed: {
            data() {
                return {
                    name: this.getName(this.status),
                    classNames: ['mr-1', 'inline-block', 'font-thin', 'tracking-wide', 'px-1', 'rounded', 'text-sm', ...this.getColors(this.status)],
                };
            },
        },
        methods: {
            getName(name) {
                switch (name) {
                    case 'unconfirmed':
                        return 'Unconfirmed';
                    case 'open':
                        return 'Open';
                    case 'inService':
                        return 'In Service';
                    case 'fixed':
                        return 'Fixed';
                    case 'closed':
                        return 'Closed';
                    default:
                        return name;
                }
            },
            getColors(name) {
                switch (name) {
                    case 'unconfirmed':
                        return ['bg-gray-200', 'text-gray-900'];
                    case 'open':
                        return ['bg-white', 'border', 'border-gray-400', 'text-gray-900'];
                    case 'inService':
                        return ['bg-blue-200', 'text-blue-900'];
                    case 'fixed':
                        return ['bg-green-200', 'text-green-900'];
                    case 'closed':
                        return ['bg-red-200', 'text-red-900'];
                    default:
                        return ['bg-gray-200', 'text-gray-900'];
                }
            }
        }
    }
</script>

<style scoped>

</style>
