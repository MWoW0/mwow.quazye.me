<template>
    <div class="w-full px-3">
        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" :for="inputId">
            {{ __(label) }}
        </label>

        <slot :input-id="inputId" :attribute="attribute" :options="options" :form="form">
            <select :id="inputId" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" v-model="form[attribute]">
                <option v-for="(option, index) in options" :attribute="index" :value="value(option, 'value')">{{ value(option, 'name') }}</option>
            </select>
        </slot>

        <ul v-if="form.errors.has(attribute)" class="text-red text-xs italic">
            <li v-for="error in form.errors.get(attribute)">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script>
    import FormField from '@/mixins/FormField';

    export default {
        name: "select-field",

        props: {
            options: {
                type: Array,
                required: false,
                default() {
                    return [];
                }
            }
        },

        mixins: [FormField],

        methods: {
            value(option, key) {
                return option[key]
                    ? option[key]
                    : option;
            }
        }
    }
</script>
