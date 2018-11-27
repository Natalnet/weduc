<template>
    <loading-card :loading="loading">
        <h4>
            <i class="fa fa-users"></i> Usuários
        </h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Função</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(resource, index) in resources">
                    <td>{{ resource.name }}</td>
                    <td>{{ resource.email }}</td>
                    <td>{{ resource.roles }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </loading-card>
</template>

<script>
    export default {
        name: "UsersIndex",

        data: () => ({
            loading: true,
            resourceName: 'users',
            resources: []
        }),

        created() {
            this.getResource()
        },

        methods: {
            getResource() {
                axios.get('/api/' + this.resourceName)
                    .then(({data}) => {
                        this.resources = data.data.users
                        this.loading = false
                    })
            }
        }
    }
</script>