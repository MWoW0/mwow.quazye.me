<template>
    <div class="font-sans antialiased h-screen">
        <div class="bg-grey-lightest relative h-full min-h-screen">
            <router-link :key="board.id" :to="{ name: 'community.threads.list', params: { id: board.id }  }"
                         class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4 hover:bg-blue-lighter"
                         exact v-for="board in boards">
                <font-awesome-icon :icon="board.icon" class="h-6 w-6 text-grey-darker fill-current xl:mr-2"
                                   v-if="board.icon"></font-awesome-icon>
                <div class="text-grey-darker text-xs">{{ board.name }}</div>
            </router-link>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                boards: "communityBoards"
            })
        },

        async created() {
            await this.$store.dispatch("fetchCommunityBoards")
        },

        methods: {
            routePath(board) {
                return `/community/${board.id}/threads`
            }
        }
    }
</script>
