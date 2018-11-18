<template>
    <div class="flex flex-wrap -mx-3 mb-6">
        <label v-if="label" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" :for="inputId">
            {{ __(label) }}
        </label>

        <trix-editor
            ref="trix"
            :id="inputId"
            :value="form[attribute]"
            @trix-change="assignFormAttribute"
            @trix-initialize="initializeTrixContent"
            @trix-attachment-add="$emit('add-file', $event.target)"
            @trix-attachment-remove="$emit('remove-file', $event.target)"
            @keydown.stop
            class="trix-content appearance-none block w-full text-grey-darker py-3 px-4 mb-3"
        ></trix-editor>

        <ul v-if="form.errors.has(attribute)" class="text-red text-xs italic">
            <li v-for="error in form.errors.get(attribute)">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script>
    import FormField from '@/mixins/FormField';
    import 'trix'
    import 'trix/dist/trix.css'

    export default {
        name: "trix-field",

        mixins: [FormField],

        methods: {
            initializeTrixContent() {
                if (this.$refs.trix && this.$refs.trix.editor) {
                    this.$refs.trix.editor.insertHTML(this.form[this.attribute])
                }
            },

            assignFormAttribute() {
                this.form[this.attribute] = this.$refs.trix.value;
            }
        }
    }
</script>
