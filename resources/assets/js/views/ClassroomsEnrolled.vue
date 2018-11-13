<template>
    <loading-card :loading="loading">
        <h4>
            <i class="fa fa-users"></i> Minhas Turmas
        </h4>
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
        <join-classroom @joined-classroom="reload"></join-classroom>
    </loading-card>
</template>

<script>
    export default {
        name: "ClassroomsIndex",

        data: () => ({
            loading: true,
            resourceName: 'classrooms',
            resources: []
        }),

        created() {
            this.getResource()
        },

        methods: {
            getResource() {
                axios.get('/api/' + this.resourceName + '/studying')
                    .then(({data}) => {
                        this.resources = data.data.classrooms
                        this.loading = false
                    })
            },

            reload() {
                this.loading = true
                this.getResource()
            }
        }
    }
</script>

<style scoped>

</style>