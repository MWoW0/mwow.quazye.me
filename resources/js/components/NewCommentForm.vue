<template>
    <resource-form>
        <!--<text-field :form="form" attribute="title"></text-field>-->

        <trix-field :form="form" attribute="body" :label="null"></trix-field>

        <action-button color="green" :processing="form.processing" :successful="form.successful" @click="storeComment">
            {{ __('Save') }}
        </action-button>
    </resource-form>
</template>

<script>
    import Form from 'form-backend-validation';
    import ResourceForm from "./ResourceForm";
    import TextField from "./Forms/TextField";
    import TrixField from "./Forms/TrixField";
    import ActionButton from "./Forms/ActionButton";

    export default {
        name: "new-comment-form",
        components: {ActionButton, TrixField, TextField, ResourceForm},

        props: {
            /**
             * The model that's being commented on
             */
            resource: {
                type: Object,
                required: true
            },

            /**
             * The store action to dispatch
             */
            action: {
                type: String,
                required: true
            }
        },

        data: () => ({
            form: new Form({
                title: '',
                body: ''
            })
        }),

        methods: {
            async storeComment() {
                const { data } = await this.$store.dispatch(this.action, {
                    model: this.resource,
                    form: this.form
                });

                this.$emit('created', data);
            },
        }
    }
</script>
