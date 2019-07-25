<template>
    <default-field :attribute="attribute" :label="label" :errors="errors" :showErrors="false">
        <template slot="field">
            <div class="custom-file">
                <input
                        ref="fileField"
                        type="file"
                        class="custom-file-input"
                        :class="{'is-invalid': hasError}"
                        :id="attribute"
                        @change="fileChange">
                <label class="custom-file-label" :for="attribute">{{ currentLabel }}</label>
                <div v-if="hasError" class="invalid-feedback">
                    {{ firstError }}
                </div>
            </div>
        </template>
    </default-field>
</template>

<script>
    import HandlesValidationErrors from '../HandlesValidationErrors.js'
    import FormField from '../FormField.js'

    export default {
        mixins: [HandlesValidationErrors, FormField],

        data: () => ({
            placeholder_label: 'Escolher arquivo...',
            fileName: '',
        }),

        computed: {
            /**
             * The current label of the file field
             */
            currentLabel() {
                return this.fileName || this.placeholder_label
            },
        },

        methods: {
            /**
             * Responds to the file change
             */
            fileChange() {
                let path = event.target.value
                let fileName = path.match(/[^\\/]*$/)[0]
                this.fileName = fileName
                this.fieldValue = this.$refs.fileField.files[0]
            },

        },
    }
</script>