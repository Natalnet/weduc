<template>
    <loading-card :loading="loading" class="metric-card">
        <h3 class="partition-header">
            {{ title }}
            <span class="partition-span">({{ formattedTotal}} {{'total'}})</span>
        </h3>

        <div class="partition-data">
            <ul class="partition-list">
                <li v-for="item in formattedItems" class="partition-item">
                    <span :style="{
                        backgroundColor: item.color
                    }"/>{{ item.label }} ({{item.value}} - {{ (item.value * 100 / formattedTotal).toFixed(2) }}%)
                </li>
            </ul>
        </div>

        <div
            ref="chart"
            class="partition-chart ct-chart"
            style="width: 90px; height: 90px; right: 20px; bottom: 30px; top: calc(50% + 15px);"
        />
    </loading-card>
</template>

<script>
import Chartist from 'chartist'
import 'chartist/dist/chartist.min.css'

const colorForIndex = index =>
    [
        '#F5573B',
        '#F99037',
        '#F2CB22',
        '#8FC15D',
        '#098F56',
        '#47C1BF',
        '#1693EB',
        '#6474D7',
        '#9C6ADE',
        '#E471DE',
    ][index]

export default {
    name: 'PartitionMetric',

    props: {
        loading: Boolean,
        title: String,
        chartData: Array,
    },

    data: () => ({ chartist: null }),

    watch: {
        chartData: function(newData, oldData) {
            this.renderChart()
        },
    },

    mounted() {
        this.chartist = new Chartist.Pie(this.$refs.chart, this.formattedChartData, {
            donut: true,
            donutWidth: 10,
            donutSolid: true,
            startAngle: 270,
            showLabel: false,
        })
    },

    methods: {
        renderChart() {
            this.chartist.update(this.formattedChartData)
        },
    },

    computed: {
        formattedChartData() {
            return { labels: this.formattedLabels, series: this.formattedData }
        },

        formattedItems() {
            return _(this.chartData)
                .map((item, index) => {
                    return {
                        label: item.label,
                        value: item.value,
                        color: colorForIndex(index),
                    }
                })
                .value()
        },

        formattedLabels() {
            return _(this.chartData)
                .map(item => item.label)
                .value()
        },

        formattedData() {
            return _(this.chartData)
                .map(item => item.value)
                .value()
        },

        formattedTotal() {
            return _.sumBy(this.chartData, 'value')
        },
    },
}
</script>
