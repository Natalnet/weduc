<template>
    <PartitionMetric :card="card"></PartitionMetric>
</template>

<script>
    import PartitionMetric from './PartitionMetric'

    export default {
        name: "CompilationErrors",

        components: {
            PartitionMetric,
        },

        data: () => ({
            card: {
                class: "App\\Metrics\\CompilationErrors",
                component: "partition-metric",
                name: "Erros de Compilação",
                onlyOnDetail: false,
                prefixComponent: false,
                uriKey: "compilation-errors",
                width: "1/3"
            }
        })
    }
</script>