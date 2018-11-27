<template>
    <card class="loading-card">
        <div
            v-if="loading"
            class="loading"
            :class="modeClass"
        >
            <loader class="text-60" />
        </div>
        <template slot="header">
            <slot name="header"></slot>
        </template>

        <slot />
    </card>
</template>

<script>
export default {
    props: {
        loading: {
            type: Boolean,
            default: true,
        },

        mode: {
            type: String,
            default: 'light',
            validator: function(value) {
                return ['light', 'dark'].indexOf(value) !== -1
            },
        },
    },

    computed: {
        modeClass() {
            return this.mode == 'light' ? 'bg-white' : 'bg-90'
        },
    },
}
</script>
