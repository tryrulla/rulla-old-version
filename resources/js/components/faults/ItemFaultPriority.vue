<template>
    <span :class="data.classNames" style="padding-bottom: 2px; padding-top: 2px; margin-bottom: 1px;">
        {{ data.name }}
    </span>
</template>

<script>
    export default {
        props: ['priority'],
        computed: {
            data() {
                return {
                    name: this.getName(this.priority),
                    classNames: ['mr-1', 'inline-block', 'font-thin', 'tracking-wide', 'px-1', 'rounded', 'text-sm', ...this.getColors(this.priority)],
                };
            },
        },
        methods: {
            getName(name) {
                switch (name) {
                    case 'highest':
                        return 'Highest';
                    case 'high':
                        return 'High';
                    case 'medium':
                        return 'Medium';
                    case 'low':
                        return 'Low';
                    case 'lowest':
                        return 'Lowest';
                    default:
                        return name;
                }
            },
            getColors(name) {
                switch (name) {
                    case 'highest':
                        return ['bg-red-300', 'border', 'border-red-500', 'text-red-900'];
                    case 'high':
                        return ['bg-red-200', 'border', 'border-red-400', 'text-red-900'];
                    case 'medium':
                        return ['bg-yellow-200', 'border', 'border-yellow-500', 'text-yellow-900'];
                    case 'low':
                        return ['bg-blue-200', 'border', 'border-blue-400', 'text-blue-900'];
                    case 'lowest':
                        return ['bg-blue-300', 'border', 'border-blue-500', 'text-blue-900'];
                    default:
                        return ['bg-gray-200', 'text-gray-900'];
                }
            }
        }
    }
</script>
