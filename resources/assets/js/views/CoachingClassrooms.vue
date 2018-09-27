<template>
    <loading-card :loading="loading">
        <h4>
            <i class="fa fa-users"></i> Minhas Turmas (tutor)
        </h4>
        <table class="table">
            <thead>
            <tr>
                <th>Código</th>
                <th>Estudantes</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(resource, index) in resources">
                <td>{{ resource.code }}</td>
                <td>{{ resource.students_count }}</td>
            </tr>
            </tbody>
        </table>
        <create-classroom @classroom-created="reload"></create-classroom>
    </loading-card>
</template>

<script>
    export default {
        name: "CoachingClassrooms",

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
                axios.get('/api/' + this.resourceName + '/coaching')
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