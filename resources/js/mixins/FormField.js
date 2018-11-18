import { upperFirst } from 'lodash';

export default {
    props: {
        form: {
            type: Object,
            required: true
        },

        attribute: {
            type: String,
            required: false,
            default: ''
        },

        label: {
            type:String,
            required: false,
            default() {
                return upperFirst(this.attribute);
            }
        }
    },

    computed: {
        inputId() {
            return `form-field-${this._uid}`;
        },
    },

    created () {
        // $vnode.key is for list rendering, but also provides a convenient way of telling which attribute the field is for.
        // @see https://vuejs.org/v2/guide/list.html#key
        if (this.attribute && ! this.$vnode.key) {
            // this.$vnode.key = `formField[${this.attribute}]-${this._uid}`
            this.$vnode.key = this.attribute;
        }
    }
}
