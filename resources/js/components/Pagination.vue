<template>
    <ul class="flex list-reset border border-grey-light shadow rounded w-auto font-sans">
        <li v-for="page in pages" :key="page">
            <a class="block hover:text-white hover:bg-blue-lighter text-black border-r border-grey-light px-3 py-2" :class="{ 'bg-blue': current_page === page }" href="#" @click="paginate(page)">
                {{ page }}
            </a>
        </li>
    </ul>
</template>

<script>
    import { range } from 'lodash';

    export default {
        props: {
            paginate: {
                type: Function,
                required: true
            },
            last_page: {
                type: Number,
                required: true
            },
            current_page: {
                type: Number,
                required: true
            }
        },

        computed: {
            pages() {
                return range(0, this.last_page)
            }
        }
    }
</script>
