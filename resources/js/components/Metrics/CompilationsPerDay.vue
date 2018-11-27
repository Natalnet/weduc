<template>
    <TrendMetric :card="card"></TrendMetric>
</template>

<script>
    import TrendMetric from './TrendMetric'

    export default {
        name: "CompilationsPerDay",

        components: {
            TrendMetric,
        },

        data: () => ({
            card: {
                class: "App\\Metrics\\CompilationsPerDay",
                component: "trend-metric",
                name: "Compilações por Dia",
                onlyOnDetail: false,
                prefixComponent: false,
                ranges: [{label: "30 Dias", value: 30}, {label: "60 Dias", value: 60}, {label: "90 Dias", value: 90}],
                uriKey: "compilations-per-day",
                width: "1/3"
            }
        })
    }
</script>