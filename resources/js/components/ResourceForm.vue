<template>
    <form @submit.prevent>
        <slot :resource="resource"></slot>
    </form>
</template>

<script>
    export default {
        name: "resource-form",
        props: {
            resource: {
                type: Object,
                required: false
            }
        }
    }
</script>
