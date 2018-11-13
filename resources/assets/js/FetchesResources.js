export default {
    data: () => ({
        loading: true,
    }),

    methods: {
        async getResources() {
            this.loading = true
            const {data: resources} = await Atom.request()
                .get(this.fetchEndpoint)
                .catch(error => {
                    if (error.response.status == 404) {
                        this.$router.push({name: '404'})
                        return
                    }
                })
            this.handleResources(resources)
            this.loading = false
        },
    }
}