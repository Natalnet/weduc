Vue.component('ide', {
    props: ['languages'],

    data() {
        return {
            errors: '',
            language: '',
            program: {
                id: "",
                name: "NovoPrograma",
                code: "",
                customCode: ""
            },
            disableNameInput: 0
        };
    },

    mounted() {
        console.log('Component mounted.')
        this.$swal({
            title: 'Selecione uma linguagem para programar',
            input: 'select',
            inputOptions: this.languages,
            inputValidator: value => {
                return new Promise((resolve, reject) => {
                    if (value) {
                        this.loadLanguage(value)
                        resolve()
                    } else {
                        reject('Você precisa selecionar uma opção!')
                    }
                })
            },
            inputClass: 'form-control',
            inputPlaceholder: 'Selecione',
            allowOutsideClick: false,
            allowEscapeKey: false,
        })
    },

    computed: {
        downloadUrl() {
            return "/program/" + this.program.id + "/send_code"
        }
    },

    methods: {
        loadLanguage(value) {
            axios.get('/fetchlanguage/'+value)
            .then(response => {
                console.log(response.data)
                this.language = response.data
            })
            .catch(error => console.log(error))
        },

        onCompile() {
            axios.post('/compilar',{
                code: this.program.code,
                language: this.language.id
            })
            .then(response => {
                this.errors = ''
                console.log(response.data.translatedCode)
                this.program.customCode = response.data.translatedCode
                this.$notify({
                    group: 'ide',
                    type: 'success',
                    title: 'Programa compilado com sucesso!',
                    text: 'O seu programa foi compilado com sucesso!'
                });
            })
            .catch(error => {
                console.log(error.response.data)
                this.errors = error.response.data.message
            })
        },


        compileTarget() {
            if (this.program.id) {
                axios.post('/program/' + this.program.id + '/compile_target')
                    .then(response => {
                        this.errors = ''
                        this.$notify({
                            group: 'ide',
                            type: 'success',
                            title: 'Programa compilado com sucesso!',
                            text: 'O seu programa foi compilado com sucesso na linguagem alvo!'
                        });
                    })
                    .catch(error => {
                        console.log(error.response.data)
                        this.errors = error.response.data.message
                    })
            } else {
                this.$notify({
                    group: 'ide',
                    type: 'error',
                    title: 'Erro ao compilar o programa!',
                    text: 'Para compilar o programa na linguagem alvo é necessário salvá-lo primeiro.'
                });
            }
        },

        updateCode (newCode) {
            if (this.program.code !== newCode) {
                this.program.code = newCode
            }
        },

        updateCustomCode (newCode) {
            if (this.program.customCode !== newCode) {
                this.program.customCode = newCode
            }
        },

        loadProgram (program) {
            this.program.id = program.id
            this.program.name = program.name
            this.program.code = program.reduc_code
            this.program.customCode = program.custom_code
            this.disableNameInput = 1
        },

        save() {
            if (this.program.id) {
                axios.put('/program/'+this.program.id,{
                    code: this.program.code,
                    custom_code: this.program.customCode
                })
                .then(response => {
                    this.$notify({
                        group: 'ide',
                        type: 'success',
                        title: 'Programa salvo com sucesso!',
                        text: 'O seu programa foi salvo com sucesso!'
                    });
                })
                .catch(error => {
                    this.$notify({
                        group: 'ide',
                        type: 'error',
                        title: 'Erro ao salvar programa!',
                        text: 'Ocorreu um erro inesperado ao salvar o programa.'
                    });
                })
            } else if (this.isNameAvailable(this.program.name)) {
                axios.post('/program',{
                    language: this.language.id,
                    name: this.program.name,
                    code: this.program.code,
                    custom_code: this.program.customCode
                })
                .then(response => {
                    this.$notify({
                        group: 'ide',
                        type: 'success',
                        title: 'Programa salvo com sucesso!',
                        text: 'O seu programa foi salvo com sucesso!'
                    });
                    this.disableNameInput = 1
                })
                .catch(error => {
                    this.$notify({
                        group: 'ide',
                        type: 'error',
                        title: 'Erro ao salvar programa!',
                        text: 'Ocorreu um erro inesperado ao salvar o programa.'
                    });
                })
            } else {
                this.$notify({
                    group: 'ide',
                    type: 'error',
                    title: 'Erro ao salvar programa!',
                    text: 'O nome do programa já está em uso.'
                });
            }
        },

        isNameAvailable(name) {
            for (program of this.language.programs){
                if (name == program.name) {
                    return false
                }
            }
            return true
        },

        newProgram() {
            this.program.id = ""
            this.program.name = "NovoPrograma"
            this.program.code = ""
            this.program.customCode = ""
            this.disableNameInput = 0
            this.$notify({
                group: 'ide',
                type: 'success',
                title: 'Novo programa criado!',
                text: 'O seu programa foi criado com sucesso!'
            });
        }
    }
});
