<template>
    <div class="px-8 pt-6 pb-8 bg-white shadow-md rounded mb-4 flex flex-col my-2" v-if="currentUser">
        <heading>Hello, {{ currentUser.name }}</heading>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import Heading from "@/components/Typography/Heading";

    export default {
        name: "Dashboard",
        components: {Heading},
        computed: {
            ...mapGetters([
                'currentUser'
            ])
        }
    }
</script>
