<template>
    <div class="w-full px-3">
        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" :for="inputId">
            {{ __(label) }}
        </label>

        <slot :inputId="inputId" :form="form">
            <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" :id="inputId" type="email" v-model="form[attribute]">
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
        name: "email-field",

        mixins: [FormField]
    }
</script>
