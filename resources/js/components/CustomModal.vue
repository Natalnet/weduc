<template>
    <div class="modal fade" :id="id" tabindex="-1" role="dialog" :aria-labelledby="id + 'Label'" aria-hidden="true">
        <div class="modal-dialog" :class="{ 'modal-lg': isLarge}" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" :id="id + 'Label'">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button v-if="cancelButton" v-text="cancelButtonText" type="button" class="btn btn-secondary" data-dismiss="modal"></button>
                    <slot name="buttons"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                type: String,
                required: true
            },

            title: {
                type: String,
                required: true
            },

            isLarge: {
                type: Boolean,
                default: false
            },

            cancelButton: {
                type: Boolean,
                default: true
            },

            cancelButtonText: {
                type: String,
                default: 'Cancelar'
            }
        }
    }
</script>