<template>
    <form class="form-inline">
        <div class="form-group mr-sm-3 mb-4">
            <label for="classroom_code" class="sr-only">Código</label>
            <input v-model="code" type="text" class="form-control" id="classroom_code" placeholder="Código da Turma"
                   :class="{'is-invalid': error}">
            <!--<small v-if="error" class="invalid-feedback">-->
            <!--{{ error }}-->
            <!--</small>-->
        </div>
        <button type="submit" class="btn btn-primary mb-4" @click.prevent="join">Participar da Turma</button>
    </form>
</template>

<script>
    export default {
        name: "JoinClassroom",

        data: () => ({
            code: '',
            error: null
        }),

        methods: {
            join() {
                this.error = null
                axios.post('/api/classrooms/join', {
                    code: this.code,
                })
                    .then(response => {
                        this.code = ''
                        this.$emit('joined-classroom')
                    })
                    .catch(error => {
                        if (error.response.data.errors.code) {
                            this.error = error.response.data.errors.code[0];
                            this.$toasted.show(this.error, { type: 'error' })
                        }
                    })
            },
        }
    }
</script>

<style scoped>

</style>