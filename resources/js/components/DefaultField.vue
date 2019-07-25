<template>
    <div class="form-group">
        <slot>
            <label :for="attribute">{{ fieldLabel }}</label>
        </slot>
        <slot name="field"/>
        <div v-if="hasError && showErrors" class="invalid-feedback">
            {{ firstError }}
        </div>
    </div>
</template>

<script>
    import { Errors } from 'form-backend-validation'
    import HandlesValidationErrors from '../HandlesValidationErrors.js'
    export default {
        mixins: [HandlesValidationErrors],
        props: {
            attribute: { type: String, required: true },
            label: { type: String },
            helpText: { type: String },
            showHelpText: { type: Boolean, default: true },
            showErrors: { type: Boolean, default: true },
        },
        computed: {
            fieldLabel() {
                // If the field name is purposefully an empty string, then
                // let's show it as such
                if (this.label === '') {
                    return ''
                }
                return this.label
            },
        },
    }
</script>