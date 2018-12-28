<template>
    <div class="font-sans antialiased h-screen">
        <div class="bg-grey-lightest relative h-full min-h-screen">
            <div :key="thread.id" class="group relative sidebar-item" v-for="thread in threads">
                <router-link :to="{ name: 'community.threads.show', id: thread.id }"
                             class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4 hover:bg-blue-lighter"
                             exact>
                    <div class="text-grey-darker text-xs">{{ thread.title }}</div>

                    <router-link :key="index" :to="{ name: 'community.threads.find-by-tags', tags: tag }"
                                 class="text-grey-lightest hover:text-grey-darkest" exact
                                 v-for="(tag,index) in thread.tags">
                        <small>{{ tag }}</small>
                    </router-link>

                    <p v-if="thread.description">{{ thread.description }}</p>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        props: {
            boardId: Number
        },

        computed: {
            ...mapGetters({
                threads: "communityThreads"
            })
        },

        async mounted() {
            const {data} = await this.$store.dispatch("fetchCommunityThreads", {
                boardId: this.boardId,
            })
        },
    }
</script>
