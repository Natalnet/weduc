<template>
    <table
            v-if="resources.length > 0"
            class="table table-hover"
            cellpadding="0"
            cellspacing="0"
    >
        <thead></thead>
        <tbody>
            <tr
                    v-for="(resource, index) in resources"
                    :key="resource.id.value"
                    is="resource-table-row"
                    :resource="resource"
            />
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "ResourceTable"
    }
</script>