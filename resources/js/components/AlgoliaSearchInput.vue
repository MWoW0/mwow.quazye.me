<template>
    <input class="shadow text-grey-darker border border-grey-lighter w-full focus:outline-none" v-model="query" type="search" :aria-label="placeholder" :placeholder="placeholder" @keyup.enter="search()" @keyup.esc="query = ''">
</template>

<script>
    export default {
        name: "algolia-search-input",

        props: {
            resource:{
                type: String,
                required: true
            },

            placeholder: {
                type: String,
                required: false,
                default() {
                    return  __('Search for :resource ...', { resource: this.resource });
                }
            },

            options: {
                type: Object,
                required: false,
                default() {
                    return {}
                }
            }
        },

        computed: {
            appId () {
                return Laravel.algolia.id;
            },

            secret () {
                return Laravel.algolia.search_secret;
            }
        },

        watch: {
            query(value) {
                if (! value || value.length === 0) {
                    this.$emit('clear');
                }
            }
        },

        data() {
            return {
                query: '',

                client: null,
                index: null,
            }
        },

        created() {
            this.client = require('algoliasearch/lite')(this.appId, this.secret);
            this.index = this.client.initIndex(this.resource);
        },

        methods: {
            search(page = 0, perPage = 20) {
                const loader = this.$loading.show();

                const options = { page: page, hitsPerPage: perPage };
                Object.assign(options, this.options);

                this.index.search(this.query, options, (err, content) => {
                    if (err) {
                        console.error(err);
                        this.$emit('error', err);
                    } else {
                        this.$emit('results', content);
                    }

                    loader.hide();
                });
            }
        }
    }

</script>
