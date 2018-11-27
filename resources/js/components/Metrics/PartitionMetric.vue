<template>
    <BasePartitionMetric
        :title="card.name"
        :chart-data="chartData"
        :loading="loading"
    />
</template>

<script>
import BasePartitionMetric from './Base/PartitionMetric'

export default {
    components: {
        BasePartitionMetric,
    },

    props: {
        card: {
            type: Object,
            required: true,
        },
        resourceName: {
            type: String,
            default: '',
        },
        resourceId: {
            type: [Number, String],
            default: '',
        },
    },

    data: () => ({
        loading: true,
        chartData: [],
    }),

    created() {
        this.fetch()
    },

    methods: {
        fetch() {
            this.loading = true

            axios.get(this.cardEndpoint).then(({ data: { value: { value } } }) => {
                this.chartData = value
                this.loading = false
            })
        },
    },
    computed: {
        cardEndpoint() {
            if (this.resourceName && this.resourceId) {
                return `/api/${this.resourceName}/${this.resourceId}/metrics/${
                    this.card.uriKey
                }`
            } else if (this.resourceName) {
                return `/api/${this.resourceName}/metrics/${this.card.uriKey}`
            } else {
                return `/api/metrics/${this.card.uriKey}`
            }
        },
    },
}
</script>
