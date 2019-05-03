<template>
    <div v-if="loaded">
        <div class="group" v-if="selected">
            <a :href="link" v-if="link" @dblclick="openEditor">{{ label(selected) }}</a>
            <span @dblclick="openEditor" v-else>{{ label(selected) }}</span>

            <button class="text-gray-600 text-xs hidden group-hover:inline" @click="openEditor">
                <i class="fas fa-pen"></i>
            </button>
        </div>

        <div v-else>
            <button @click="openEditor" class="text-gray-600">(add)</button>
        </div>

        <modal :open="editing" @close="editing = false">
            <div class="card w-screen-1/2">
                <div class="card-header">
                    <h1>Change {{ name }}</h1>
                </div>

                <div class="p-4 flex">
                    <div class="w-1/3">
                        {{ name }}
                    </div>
                    <div class="w-2/3">
                        <v-select v-model="value" :reduce="getValue" :options="allowedValues" :get-option-label="label"></v-select>
                    </div>
                </div>
            </div>
        </modal>
    </div>

    <div v-else>
        Loading...
    </div>
</template>

<script>
    export default {
        props: {
            id: String,
            name: String,

            url: String,
            dataUrl: String,
            initialValue: {
                default: null,
            },

            options: {
                type: Array,
                default: () => [],
            },

            getValue: {
                type: Function,
                default: item => item.value,
            },

            label: {
                type: Function,
                default: item => (item || {}).label || '–',
            },

            getLink: {
                type: Function,
                default: item => (item && item.viewUrl) ? item.viewUrl : null,
            },

            refresh: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                editing: false,
                loaded: false,
                allowedValues: this.options,
                value: this.initialValue
            };
        },
        computed: {
            selected() {
                const matches = this.allowedValues.filter(it => this.getValue(it) === this.value);
                return matches.length === 1 ? matches[0] : null;
            },
            link() {
                return this.getLink(this.selected);
            }
        },
        methods: {
            openEditor() {
                this.editing = true;
            },
        },
        mounted() {
            if (this.dataUrl) {
                axios.get(this.dataUrl)
                    .then(({data}) => {
                        this.allowedValues = data;
                        this.loaded = true;
                    }).catch(error => {
                        console.error(error);
                        alert(error);
                    });
            } else {
                this.loaded = true;
            }
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
