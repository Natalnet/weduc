<template>
    <card class="loading-card">
        <div
            v-if="loading"
            class="loading"
            :class="modeClass"
        >
            <loader class="text-60" />
        </div>

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
