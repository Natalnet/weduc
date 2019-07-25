<template>
    <default-field :attribute="attribute" :label="label" :errors="errors">
        <template slot="field">
            <input
                    class="w-full form-control form-input form-input-bordered"
                    :class="{'is-invalid': hasError}"
                    :id="attribute"
                    v-model="fieldValue"
            />
        </template>
    </default-field>
</template>

<script>
    import HandlesValidationErrors from '../HandlesValidationErrors.js'
    import FormField from '../FormField.js'

    export default {
        mixins: [HandlesValidationErrors, FormField],

        computed: {
            defaultAttributes() {
                return {
                    type: this.type || 'text',
                    min: this.min,
                    max: this.max,
                    step: this.step,
                    pattern: this.pattern,
                    placeholder: this.placeholder || this.name,
                    class: this.errorClasses,
                }
            },
            extraAttributes() {
                return this.defaultAttributes
                const attrs = this.extraAttributes
                return {
                    // Leave the default attributes even though we can now specify
                    // whatever attributes we like because the old number field still
                    // uses the old field attributes
                    ...this.defaultAttributes,
                    ...attrs,
                }
            },
        },
    }
</script>
