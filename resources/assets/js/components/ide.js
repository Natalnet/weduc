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
            disableNameInput: 0,
            blockly: false,
            mode: 'reduc'
        };
    },

    mounted() {
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
        programExists() {
            return this.program.id !== "";
        },

        targetCanCompile() {
            return this.language.compile_code !== null;
        },

        targetCanSend() {
            return this.language.send_code !== null;
        },

        downloadUrl() {
            return "/program/" + this.program.id + "/send_code"
        }
    },

    methods: {
        setBlocklyMode() {
            this.mode = 'blockly';
            this.setupBlockly();
        },

        setReducMode() {
            this.mode = 'reduc'
        },

        setTargetMode() {
            this.mode = 'target'
        },

        loadLanguage(value) {
            axios.get('/fetchlanguage/'+value)
            .then(response => {
                this.language = response.data
            })
            .catch(error => console.log(error))
        },

        setupBlockly() {
            if (!this.blockly) {
                var workspace = Blockly.inject('blocklyDiv', {
                    toolbox: document.getElementById('toolbox')
                })

                var self = this;

                function myUpdateFunction() {
                    var code = Blockly.Reduc.workspaceToCode(workspace);
                    self.updateCode(code)
                    // $('#thecode').html(code);
                }

                console.log(myUpdateFunction);

                workspace.addChangeListener(myUpdateFunction);

                setTimeout(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 300);

                this.blockly = true
            }
        },

        save() {
            if (this.programExists) {
                this.update();
            } else {
                this.create();
            }
        },

        create() {
            axios.post('/api/programs', {
                target_language: this.language.id,
                name: this.program.name,
                reduc_code: this.program.code,
                custom_code: this.program.customCode
            })
            .then(response => {
                this.$emit('program-created');
                this.$notify({
                    group: 'ide',
                    type: 'success',
                    title: 'Programa salvo com sucesso!',
                    text: 'O seu programa foi salvo com sucesso!'
                });
            })
            .catch(error => {
                var message = error.response.data.errors && error.response.data.errors.name ?
                    error.response.data.errors.name[0] : 'Ocorreu um erro inesperado ao salvar o programa.';
                this.$notify({
                    group: 'ide',
                    type: 'error',
                    title: 'Erro ao salvar programa!',
                    text: message
                });
            })
        },

        update() {
            axios.put('/api/programs/' + this.program.id,{
                name: this.program.name,
                reduc_code: this.program.code
            })
            .then(response => {
                this.$emit('program-created');
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
        },

        compile() {
            this.update();

            axios.get('/api/programs/' + this.program.id + '/compile',{
                code: this.program.code,
                language: this.language.id
            })
            .then(response => {
                if (response.data.success) {
                    this.errors = ''
                    this.program.customCode = response.data.target_code
                    this.$notify({
                        group: 'ide',
                        type: 'success',
                        title: 'Programa compilado com sucesso!',
                        text: 'O seu programa foi compilado com sucesso!'
                    });
                } else {
                    console.log(response.data);
                    this.errors = response.data.errors.reduc_code.message
                }
            })
            .catch(error => {
                console.log(error.response.data);
                this.errors = "Linha " + error.response.data.errors.reduc_code.line + ": " +  error.response.data.errors.reduc_code.message
            })
        },


        compileTarget() {
            if (this.program.id) {
                axios.post('/program/' + this.program.id + '/compile_target')
                    .then(response => {
                        console.log(response)
                        this.errors = ''
                        this.$notify({
                            group: 'ide',
                            type: 'success',
                            title: 'Programa compilado com sucesso!',
                            text: 'O seu programa foi compilado com sucesso na linguagem alvo!'
                        });
                    })
                    .catch(error => {
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

        newProgram() {
            this.program.id = ""
            this.program.name = "NovoPrograma"
            this.program.code = ""
            this.program.customCode = ""
            this.errors = ""
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
