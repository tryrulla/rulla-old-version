<template>
    <div v-if="editing">
        <input class="" type="text" v-model="value" v-autofocus
               @keyup.enter="save" @keyup.esc="save" v-on:blur="save"/>
    </div>

    <div v-else-if="value.length > 0" class="group rounded">
        <span @dblclick="openEditor">{{ value }}</span>
        <button class="text-gray-600 text-xs hidden group-hover:inline" @click="openEditor">
            <i class="fas fa-pen"></i>
        </button>
    </div>

    <div v-else>
        <button @click="openEditor" class="text-gray-600">(add)</button>
    </div>
</template>

<script>
    export default {
        props: {
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
            }
        },
    };
</script>
