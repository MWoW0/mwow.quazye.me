<template>
    <div class="px-8 pt-6 pb-8 bg-white shadow-md rounded mb-4 flex flex-col my-2">
        <span v-tooltip="{ content: __('Your in-game rank.'), placement: 'left' }">
            <font-awesome-icon icon="shield-check"></font-awesome-icon>
            {{ currentUser && currentUser.type }}
        </span>

        <hr></hr>

        <resource-form>
            <div class="flex flex-wrap -mx-3 mb-6">
                <text-field :form="form" attribute="name"></text-field>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <text-field v-tooltip="__('Your game login name.')" :form="form" attribute="account_name" label="Account"></text-field>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <email-field v-tooltip="__('Your email, will be used for recovery and battle.net login.')" :form="form" attribute="email"></email-field>
            </div>

            <small class="italic text-grey-darker text-sm mb-2">
                {{ __('Password can be changed by logging out and requesting a password reset email.') }}
            </small>

            <action-button @click="$store.dispatch('updateCurrentUser', form)" :processing="form.processing" :successful="form.successful">
                {{ __('Save') }}
            </action-button>
        </resource-form>
    </div>
</template>

<script>
    import Tooltip from 'Tooltip.js';
    import Form from 'form-backend-validation';
    import { mapGetters } from 'vuex'
    import ResourceForm from "@/components/ResourceForm";
    import TextField from "@/components/Forms/TextField";
    import EmailField from "@/components/Forms/EmailField";
    import ActionButton from "@/components/Forms/ActionButton";

    export default {
        name: "user-info",

        components: {ActionButton, EmailField, TextField, ResourceForm },

        data() {
            return {
                form: new Form({
                    name: '',
                    account_name: '',
                    email: ''
                })
            }
        },

        watch: {
            currentUser: {
                handler: function (user) {
                    if (user) {
                        this.fillForm(user);
                    }
                },

                immediate: true
            }
        },

        computed: {
            ...mapGetters([
                'currentUser'
            ])
        },

        methods: {
            fillForm(user = null) {
                user = user ? user : this.currentUser;

                this.form.name = user.name;
                this.form.account_name = user.account_name;
                this.form.email = user.email;
            }
        }
    }
</script>