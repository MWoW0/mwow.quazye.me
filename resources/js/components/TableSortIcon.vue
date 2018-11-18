<template>
    <font-awesome-icon :icon="iconName" :color="iconColor"></font-awesome-icon>
</template>

<script>
    export default {
        name: "table-sort-icon",

        props: {
            sort: {
                type: Object,
                required: true
            },

            column: {
                type:String,
                required: true
            }
        },

        computed: {
            iconName() {
                return this.sort.direction === 'asc'
                    ? 'arrow-up'
                    : 'arrow-down';
            },

            iconColor() {
                return this.sort.column === this.column
                    ? 'white'
                    : 'grey';
            }
        }
    }
</script>
