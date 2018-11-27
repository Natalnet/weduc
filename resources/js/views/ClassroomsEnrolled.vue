<template>
    <loading-card :loading="loading">
        <template slot="header">
            <div class="card-header">
                <i class="fa fa-users"></i> Minhas Turmas
            </div>
        </template>

        <join-classroom @joined-classroom="reload"></join-classroom>

        <table class="table">
            <thead>
            <tr>
                <th>Código</th>
                <th>Tutor</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(resource, index) in resources">
                <td>{{ resource.code }}</td>
                <td>{{ resource.coach.name }}</td>
            </tr>
            </tbody>
        </table>
    </loading-card>
</template>

<script>
    import FetchesResources from '../FetchesResources'

    export default {
        mixins: [FetchesResources],

        data: () => ({
            resourceName: 'classrooms',
            resources: []
        }),

        created() {
            this.getResources()
        },

        computed: {
            fetchEndpoint() {
                return '/api/' + this.resourceName + '/studying'
            },
        },

        methods: {
            handleResources(resources) {
                this.resources = resources.data.classrooms
            },

            reload() {
                this.loading = true
                this.getResources()
            }
        }
    }
</script>

<style scoped>

</style>