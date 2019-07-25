<template>
    <custom-modal is-large id="programslist" title="Lista de Programas" :cancel-button="false">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="list-group">
                    <button v-for="program in programs" type="button"
                            class="list-group-item list-group-item-action"
                            :class="{active: selectedProgram && selectedProgram.id == program.id}"
                            @click="selectProgram(program)">
                        {{ program.name }}
                    </button>
                </div>
            </div>
            <div class="col-lg-9 col-md-6">
                <template v-if="selectedProgram">
                    <pre class="pre-scrollable"><code>{{selectedProgram.reduc_code}}</code></pre>
                </template>
                <template v-else>
                    <div class="alert alert-info" role="alert">
                        Selecione um programa na lista!
                    </div>
                </template>
            </div>
        </div>
        <template slot="buttons">
            <button type="button" class="btn btn-secondary"
                    data-dismiss="modal" ref="dismiss">
                Cancelar
            </button>
            <button v-if="selectedProgram" type="button" class="btn btn-danger"
                    @click="deleteProgram(selectedProgram)">
                Excluir
            </button>
            <button v-if="selectedProgram" type="button" class="btn btn-primary"
                    @click="openProgram(selectedProgram)">
                Abrir
            </button>
        </template>
    </custom-modal>
</template>

<script>
    export default {
        props: {
            languageId: {
                required: true
            }
        },

        data: function () {
            return {
                programs: [],
                selectedProgram: null
            }
        },

        created() {
            this.fetchPrograms()
        },

        methods: {
            fetchPrograms() {
                axios.get('/api/programs/user/current/language/' + this.languageId)
                    .then(({data}) => {
                        this.programs = data
                    });
            },

            selectProgram(program) {
                this.selectedProgram = program
            },

            openProgram(program) {
                this.$emit('open-program', program)
                this.$refs.dismiss.click()
            },

            deleteProgram(program) {
                swal({
                    title: "Tem certeza?",
                    text: "Prosseguindo você confirma a exclusão deste programa.",
                    icon: "warning",
                    dangerMode: true,
                    buttons: ["Cancelar!", "Sim, excluir!"],
                })
                .then((shouldDelete) => {
                    if (shouldDelete) {
                        axios.delete('/api/programs/' + program.id)
                            .then(response => {
                                this.selectedProgram = null
                                this.fetchPrograms()

                                swal({
                                    title: "Programa excluído!",
                                    icon: "success",
                                });
                            })
                            .catch(error => {
                                this.errorAlert()
                            });
                    }
                });
            },

            errorAlert() {
                swal('Oops!', 'Algo deu errado.', 'error');
            }
        }
    }
</script>
