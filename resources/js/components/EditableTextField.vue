<template>
    <div>
        <div v-if="(editing ? ogValue : value).length > 0" class="group rounded">
            <span @dblclick="openEditor">{{ editing ? ogValue : value }}</span>
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

                <div class="p-4">
                    <div class="flex my-2">
                        <div class="w-1/3">
                            {{ name }}
                        </div>
                        <div class="w-2/3">
                            <input class="input-text" type="text" v-model="value" v-autofocus
                                   @keyup.enter="save" @keyup.esc="cancel" />
                        </div>
                    </div>

                    <div class="flex my-2">
                        <div class="w-1/3"></div>
                        <div class="w-2/3">
                            <button class="button-white" @click="save">
                                Save
                            </button>
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
            name: String,
            id: String,
            url: String,
            initialValue: String,

            refresh: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                editing: false,
                ogValue: '',
                value: this.initialValue || ''
            };
        },
        methods: {
            openEditor() {
                this.ogValue = this.value;
                this.editing = true;
            },
            save() {
                if (!this.editing) {
                    return;
                }

                axios.put(this.url, {
                    [this.id]: this.value
                }).then(() => {
                    this.editing = false;

                    if (this.refresh) {
                        window.location.reload();
                    }
                }).catch(error => {
                    console.error(error);
                    alert(error);
                });
            },
            cancel() {
                this.editing = false;
                this.value = this.ogValue;
            },
        },
    };
</script>
