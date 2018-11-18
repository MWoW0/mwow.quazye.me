<template>
    <div>
        <table class="table-auto table" @click.prevent>
            <thead class="shadow bg-blue-light text-white">
                <tr>
                    <slot name="headers" :sort-by="sortContent" :current-sort="sort"></slot>
                </tr>
            </thead>
            <tbody>
                <tr class="cursor-pointer hover:bg-blue-lighter" v-for="item in content" :key="item.id" @click="$emit('click', item)">
                    <slot name="columns" :item="item"></slot>
                </tr>
            </tbody>
        </table>

        <pagination :last_page="laravelMeta.last_page" :current_page="laravelMeta.current_page" :paginate="fetchContent"></pagination>
    </div>
</template>

<script>
    import Pagination from "./Pagination";
    export default {
        name: "paginated-table",

        components: {Pagination},

        props: {
            fetchWith:{
                type: Function,
                required: true
            }
        },

        data () {
            return {
                sort: {
                    column: null,
                    direction: 'asc'
                },

                content: [],
                laravelMeta: {
                    last_page: 0,
                    current_page: 0
                },
            }
        },

        mounted() {
            this.fetchContent();
        },

        methods: {
            async fetchContent(page = 0) {
                const loader = this.$loading.show({
                    container: this.$el,
                    canCancel: true
                });

                // fetch-with is expected to return a promise
                const { data } = await this.fetchWith({
                    page: page,
                    sortBy: this.sort.column,
                    sortDirection: this.sort.direction
                });

                this.content = data.data;
                this.laravelMeta = data.meta;

                loader.hide();
            },

            async sortContent (column) {
                this.sort.column = column;
                this.sort.direction = (this.sort.direction === 'desc') ? 'asc' : 'desc';

                await this.fetchContent(this.laravelMeta.current_page);
            }
        }
    }
</script>
