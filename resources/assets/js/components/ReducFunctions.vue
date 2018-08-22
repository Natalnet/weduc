<template>
    <div class="card">
        <div class="card-header">
            <b>Funções R-Educ</b>
        </div>

        <!-- List group -->
        <ul class="list-group list-group-flush" style="max-height: 430px; overflow-y: scroll;">
            <li v-for="item of functions" class="list-group-item">
                <a href="#" data-toggle="modal" :data-target="'#func-' + item.id">
                    {{ item.name }}
                </a>

                <!-- Modal -->
                <div class="modal fade" :id="'func-' + item.id" tabindex="-1" role="dialog" :aria-labelledby="'func-' + item.id">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ item.name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p>{{ item.description }}</p>
                                <p><b>Parâmetros:</b> {{ item.parameters }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "ReducFunctions",

        props: ['language'],

        data() {
            return {
                functions: []
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get('/api/languages/' + this.language.id + '/functions')
                    .then(response => {
                        this.functions = response.data
                    })
                    .catch(error => console.log(error))
            }
        }
    }
</script>

<style scoped>

</style>