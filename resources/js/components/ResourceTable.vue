<template>
    <div class="resource-table">
        <algolia-search-input class="my-2 p-4" :options="filtersForAlgolia" :resource="resource" @clear="fetchContent()" @results="showAlgoliaSearchResults" ref="searchInput"></algolia-search-input>

        <small class="italic text-grey-darker text-sm mb-2">
            {{ __('Showing :perPage out of :total :resource ...', { perPage: this.pagination.per_page, total: this.pagination.total, resource: this.resource }) }}
        </small>

        <table class="table-auto table" @click.prevent>
            <thead class="shadow bg-blue-light text-white">
                <tr>
                    <th class="col" v-for="(field, index) in preparedFields" :key="index" @click="sortByField(field)">
                        <table-sort-icon :column="field.attribute" :sort="sort"></table-sort-icon>
                        {{ __(field.name) }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="cursor-pointer hover:bg-blue-lighter" v-for="item in content" :key="item.id" @click="navigateToDetails(item)">
                    <td v-for="(field, index) in preparedFields" :key="index">
                        {{ item[field.attribute] }}
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination :current_page="pagination.current_page" :last_page="pagination.last_page" :paginate="paginate"></pagination>
    </div>
</template>

<script>
    import TableSortIcon from "./TableSortIcon";
    import Pagination from "./Pagination";
    import AlgoliaSearchInput from "./AlgoliaSearchInput";
    import { upperFirst, startCase, flatMap, forEach } from 'lodash';

    export default {
        name: "resource-table",
        components: {AlgoliaSearchInput, Pagination, TableSortIcon},

        props: {
            /**
             * Name of the resource we're displaying.
             */
            resource: {
                type: String,
                required: true
            },

            /**
             * The fields of the table.
             * This values can be either a string or an object.
             * Objects should consist of a name & attribute
             */
            fields: {
                type: Array,
                required: true
            },

            /**
             * Filters to pass to the API or Algolia
             */
            filters: {
                type: Object,
                required: false,
                default: () => ({})
            }
        },

        data: () => ({
            searching: false,

            sort: {
                column: null,
                direction: 'asc'
            },

            content: [],
            pagination: {
                total: 0,
                per_page: 10,
                current_page: 0,
                last_page: 0
            },
        }),

        computed: {
            /**
             * The given fields, prepared for rendering.
             *
             * @returns Array
             */
            preparedFields() {
                return this
                    .fields
                    .map(field => {
                        if (typeof field === 'object') {
                            return field;
                        }

                        return {
                            name: startCase(field),
                            attribute: field
                        }
                    });
            },

            /**
             * The sortBy clause, prepared for Spatie/laravel-query-builder
             *
             * @returns String
             */
            sortBy() {
                if (this.sort.column && this.sort.direction === 'desc') {
                    return `-${this.sort.column}`;
                }

                return this.sort.column;
            },

            filtersForAlgolia() {
                const filters = {
                    facetFilters: [],
                    numericFilters: []
                };

                forEach(this.filters, (value, key) => {
                    if (isNaN(value)) {
                        filters.facetFilters.push(`${key}:${value}`)
                    } else {
                        filters.numericFilters.push(`${key}=${value}`)
                    }
                })

                return filters;
            },

            filtersForApi() {
                return flatMap(this.filters, (value, key) => {
                    let filter = {};

                    filter[`filter[${key}]`] = value;

                    return filter;
                });
            }
        },

        mounted() {
            this.fetchContent();
        },

        methods: {
            navigateToDetails(item) {
                this.$router.push({
                    name: `${this.resource}/details`,
                    params: { id: item.id }
                });
            },

            sortByField(field) {
                if (this.sort.column === field.attribute || this.sort.column === `-${field.attribute}`) {
                    this.sort.direction = (this.sort.direction === 'asc') ? 'desc' : 'asc';
                }

                if (this.sort.direction === 'desc') {
                    this.sort.column = `-${field.attribute}`;
                } else {
                    this.sort.column = field.attribute;
                }

                this.paginate(this.pagination.current_page);
            },

            paginate(page = 0) {
                if (this.searching) {
                    this.fetchSearchResults(page);
                } else {
                    this.fetchContent(page);
                }
            },

            fetchSearchResults(page = 0) {
                this
                    .$refs
                    .searchInput
                    .search(page, this.pagination.per_page);
            },

            async fetchContent(page = 0) {
                const loader = this.$loading.show({
                    container: this.$el,
                    canCancel: true
                });

                const { data } = await this.$store.dispatch(`fetch${upperFirst(this.resource)}`, this._makeApiParams(page));

                this.content = data.data;

                this.pagination.total = data.meta.total;
                this.pagination.current_page = data.meta.current_page;
                this.pagination.last_page = data.meta.last_page;
                this.pagination.per_page = data.meta.per_page;

                loader.hide();
            },

            _makeApiParams(page) {
                const params = {
                    sort: this.sortBy,
                    page: page,
                    perPage: this.pagination.per_page
                };

                Object.assign(params, ...this.filtersForApi);

                return params;
            },

            showAlgoliaSearchResults({ hits, nbHits, hitsPerPage, nbPages, page }) {
                this.searching = true;

                this.content = hits;
                this.pagination.total = nbHits;
                this.pagination.per_page = hitsPerPage;
                this.pagination.last_page = nbPages;
                this.pagination.current_page = page;
            }
        }
    }
</script>
