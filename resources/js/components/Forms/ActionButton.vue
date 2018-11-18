<template>
    <button
        class="bg-transparent w-full hover:text-white text-black font-semibold py-2 px-4 border hover:border-transparent"
        :class="border"
        @click="$emit('click', $event)"
    >
        <font-awesome-icon icon="spinner" v-if="processing"></font-awesome-icon>
        <font-awesome-icon icon="check" v-if="successful"></font-awesome-icon>

        <slot></slot>
    </button>
</template>

<script>
    import { upperFirst } from 'lodash';

    export default {
        name: "action-button",

        props: {
            color: {
                type: String,
                required: false,
                default: 'blue'
            },

            processing: {
                type: Boolean,
                required: false,
                default: false,
            },

            successful: {
                type: Boolean,
                required: false,
                default: false,
            },
        },

        computed: {
            border() {
                return `hover:bg-${this.color}-dark border-${this.color}`;
            }
        }
    }
</script>
