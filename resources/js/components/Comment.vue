<template>
    <div class="flex pt-4 px-4">
        <div class="w-16 mr-2">
            <img class="p-2 rounded rounded-full" :alt="comment.author.name" :src="comment.author.avatar_url">
            <font-awesome-icon v-if="comment.auth.canUpdate" icon="pencil" class="cursor-pointer" @click="editing = ! editing"></font-awesome-icon>
            <font-awesome-icon v-if="comment.auth.canDelete" icon="trash" class="cursor-pointer" @click="confirmDestroy"></font-awesome-icon>
        </div>
        <div class="px-2 pt-2 flex-grow">
            <header>
                <a href="#" class="text-black no-underline">
                    <span class="font-medium">{{ comment.author.name }}</span>
                    <!--<span class="font-normal text-grey">@{{ comment.author.social_handle }}</span>-->
                </a>
                <div class="text-xs text-grey flex items-center my-1">
                    <font-awesome-icon icon="clock"></font-awesome-icon>
                    <span>{{ comment.created_at }}</span>
                </div>
            </header>

            <trix-field v-if="editing"
                        :form="form"
                        attribute="body"
                        :label="null"
                        class="appearance-none block w-full text-grey-darker py-3 px-4 mb-3"
            ></trix-field>

            <article v-else class="py-4 text-grey-darkest" v-html="comment.body"></article>

            <footer class="border-t border-grey-lighter text-sm flex">
<!--
                <a href="#" class="block no-underline text-blue flex px-4 py-2 items-center hover:bg-grey-lighter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-thumbs-up h-6 w-6 mr-1 stroke-current">
                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                    </svg>
                    <span>Like</span>
                </a>
-->
<!--
                <a href="#" class="block no-underline text-black flex px-4 py-2 items-center hover:bg-grey-lighter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-message-circle h-6 w-6 mr-1">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                    <span>Reply</span>
                </a>
-->
                <button class="bg-transparent w-full hover:bg-blue-lighter hover:text-white text-black font-semibold py-2 px-4 border border-blue hover:border-transparent rounded" @click="update" v-if="editing">
                    <font-awesome-icon icon="spinner" v-if="form.processing"></font-awesome-icon>
                    <font-awesome-icon icon="check" v-if="form.successful"></font-awesome-icon>
                    {{ __('Update') }}
                </button>
            </footer>
        </div>
    </div>
</template>

<script>
    import Form from 'form-backend-validation';
    import TrixField from "./Forms/TrixField";

    export default {
        name: "comment",
        components: {TrixField},
        props: {
            comment:{
                type:Object,
                required: true
            }
        },

        computed: {
            editorId() {
                return `comment-${this.comment.id}-editor`;
            }
        },

        data() {
            return {
                editing: false,

                form: new Form({
                    title: this.comment.title,
                    body: this.comment.body
                }).withOptions({ resetOnSuccess: false })
            }
        },

        methods: {
            async update() {
                const { data } = await this.$store.dispatch('updateComment', {
                    comment: this.comment,
                    form: this.form
                });

                this.editing = false;

                this.$emit('updated', data);
            },

            async confirmDestroy() {
                const confirmation = await this.$swal({
                    title: __('Please confirm'),
                    text: __('Do you want to delete the comment?'),
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })

                if (confirmation.value === true) {
                    this.destroy();
                }
            },

            async destroy() {
                await this.$store.dispatch('destroyComment', this.comment);

                this.$emit('deleted', this.comment);
            }
        }
    }
</script>
