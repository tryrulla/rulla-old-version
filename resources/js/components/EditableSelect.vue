<template>
    <div>
        <div class="group">
            <span @dblclick="openEditor">{{ selected.label }}</span>
            <button class="text-gray-600 text-xs hidden group-hover:inline" @click="openEditor">
                <i class="fas fa-pen"></i>
            </button>
        </div>

        <modal :open="editing" @close="editing = false">
            <div class="card w-screen-1/2">
                <div class="card-header">
                    <h1>Change {{ name }}</h1>
                </div>

                <div class="p-4">
                    <div class="md:flex">
                        <div class="md:w-1/3"></div>

                        <div class="md:w-1/3">
                            <select v-model="value" class="input-select" id="new">
                                <option v-for="option in options" :value="option.value" :selected="value === option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    export default {
        props: {
            id: String,
            name: String,

            url: String,
            initialValue: String,
            options: Array,
            refresh: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                editing: false,
                value: this.initialValue
            };
        },
        computed: {
            selected() {
                return this.options.filter(it => it.value === this.value)[0];
            },
        },
        methods: {
            openEditor() {
                this.editing = true;
            },
        },
        watch: {
            value(value) {
                if (!this.editing) {
                    return;
                }

                this.editing = false;

                axios.put(this.url, {
                    [this.id]: value
                }).then(() => {
                    if (this.refresh) {
                        window.location.reload();
                    }
                }).catch(error => {
                    console.error(error);
                    alert(error);
                });
            },
        },
    };
</script>
