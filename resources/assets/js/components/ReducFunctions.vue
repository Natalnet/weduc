<template>
    <div class="card">
        <div class="card-header">
            <b>Funções R-Educ</b>
        </div>

        <!-- List group -->
        <ul class="list-group list-group-flush" style="max-height: 430px; overflow-y: scroll;">
            <li v-for="item of functions" class="list-group-item">
                <a href="#" data-toggle="modal" :data-target="'#func-' + item.id" @click="modals[item.id] = true">
                    {{ item.name }}
                </a>
            </li>
        </ul>


        <div v-for="item of functions" class="modal fade" :id="'func-' + item.id" tabindex="-1" role="dialog" :aria-labelledby="'func-' + item.id" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ item.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
    </div>
</template>

<script>
    export default {
        name: "ReducFunctions",

        props: ['language'],

        data() {
            return {
                functions: [],
                modals: {}
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
                        for (var item of this.functions) {
                            this.modals[item.id] = false
                        }
                    })
                    .catch(error => console.log(error))
            }
        }
    }
</script>

<style scoped>

</style>