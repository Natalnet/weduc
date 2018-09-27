<template>
    <form class="form-inline">
        <div class="form-group mx-sm-3 mb-2">
            <label for="classroom_code" class="sr-only">Código</label>
            <input v-model="code" type="text" class="form-control" id="classroom_code" placeholder="Código"
                   :class="{'is-invalid': error}">
            <!--<small v-if="error" class="invalid-feedback">-->
                <!--{{ error }}-->
            <!--</small>-->
        </div>
        <button type="submit" class="btn btn-primary mb-2" @click.prevent="create">Criar Turma</button>
    </form>
</template>

<script>
    export default {
        name: "CreateClassroom",

        data: () => ({
            code: '',
            error: null
        }),

        methods: {
            create() {
                this.error = null
                axios.post('/api/classrooms', {
                    code: this.code,
                })
                    .then(response => {
                        this.code = ''
                        this.$emit('classroom-created')
                    })
                    .catch(error => {
                        if (error.response.data.errors.code) {
                            this.error = error.response.data.errors.code[0];
                        }
                    })
            },
        }
    }
</script>