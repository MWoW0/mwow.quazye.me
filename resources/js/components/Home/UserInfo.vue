<template>
    <resource-form class="px-8 pt-6 pb-8 bg-white shadow-md rounded mb-4 flex flex-col my-2">
        <div class="flex flex-wrap -mx-3 mb-6">
            <text-field :form="form" attribute="name"></text-field>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <email-field :form="form" attribute="email"></email-field>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6 px-3">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-country">
                {{ __('Country') }}
            </label>

            <multiselect class="appearance-none block w-full leading-tight"
                         id="grid-country"
                         :placeholder="__('Find your country.')"
                         label="name"
                         track-by="alpha2Code"
                         open-direction="bottom"
                         :options="countries"
                         :multiple="false"
                         :searchable="true"
                         :loading="loading"
                         :internal-search="false"
                         :clear-on-select="true"
                         :close-on-select="true"
                         :options-limit="300"
                         :limit="3"
                         :show-no-results="true"
                         :hide-selected="true"
                         @search-change="findCountries"
                         :value="selectedCountry"
                         @select="selectCountry"
            ></multiselect>
        </div>

        <div class="flex flex-wrap -mx-3 mb-2">
            <text-field class="w-full md:w-1/2 px-3 mb-6 md:mb-0" :form="form" attribute="city"></text-field>
            <text-field class="w-full md:w-1/2 px-3 mb-6 md:mb-0" :form="form" attribute="zip"></text-field>
        </div>
        <trix-field :form="form" attribute="biography"></trix-field>
        <trix-field :form="form" attribute="goals" label="Fitness Goals"></trix-field>

        <small class="italic text-grey-darker text-sm mb-2">
            {{ __('Password can be changed by logging out and requesting a password reset email.') }}
        </small>

        <action-button @click="$store.dispatch('updateCurrentUser', form)" :processing="form.processing" :successful="form.successful">
            {{ __('Save') }}
        </action-button>
    </resource-form>
</template>

<script>
    import Form from 'form-backend-validation';
    import Multiselect from 'vue-multiselect'
    import { mapGetters } from 'vuex'
    import ResourceForm from "@/components/ResourceForm";
    import TextField from "@/components/Forms/TextField";
    import EmailField from "@/components/Forms/EmailField";
    import SelectField from "@/components/Forms/SelectField";
    import TrixField from "@/components/Forms/TrixField";
    import ActionButton from "@/components/Forms/ActionButton";

    export default {
        name: "user-info",

        components: {ActionButton, TrixField, SelectField, EmailField, TextField, ResourceForm, Multiselect },

        data() {
            return {
                loading: false,
                countries: [],
                selectedCountry: null,

                form: new Form({
                    name: '',
                    email: '',
                    country: '',
                    city: '',
                    zip: '',
                    biography: '',
                    goals: ''
                })
            }
        },

        watch: {
            currentUser(user) {
                if (user) {
                    this.fillForm(user);
                }
            },

            immediate: true
        },

        computed: {
            ...mapGetters([
                'currentUser'
            ])
        },

        methods: {
            selectCountry(country) {
                this.selectedCountry = country;
                this.form.country = country.alpha2Code
            },

            fillForm(user = null) {
                user = user ? user : this.currentUser;

                this.form.name = user.name;
                this.form.email = user.email;
                this.form.country = user.country;
                this.form.city = user.city;
                this.form.zip = user.zip;
                this.form.biography = user.biography;
                this.form.goals = user.goals;

                this.selectedCountry = {
                    name: this.currentUser.country,
                    alpha2Code: this.currentUser.country
                }
            },

            async findCountries(name)
            {
                if (3 > name.length) {
                    return null;
                }

                this.loading = true;

                const response = await fetch(`https://restcountries.eu/rest/v2/name/${name}`);
                this.countries = await response.json();

                this.loading = false;
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
