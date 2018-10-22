<template>
    <textarea :name="name" ref="theTextarea"></textarea>
</template>

<style src="codemirror/lib/codemirror.css" />

<script>
    import CodeMirror from 'codemirror'
    export default {
        props: ['name', 'value'],

        data: () => ({
            codemirror: null,
            localValue: null
        }),

        mounted() {
            const config = {
                ...{
                    tabSize: 4,
                    indentWithTabs: true,
                    lineWrapping: true,
                    lineNumbers: true,
                    theme: 'dracula',
                },
            }

            this.codemirror = CodeMirror.fromTextArea(this.$refs.theTextarea, config)

            this.doc.on('change', (cm, changeObj) => {
                this.localValue = cm.getValue()
            })

            this.doc.setValue(this.value)
        },

        computed: {
            doc() {
                return this.codemirror.getDoc()
            },
        },
    }
</script>

<style scoped>
    .CodeMirror {
        min-height: 50px;
        font: 14px/1.5 Menlo, Consolas, Monaco, 'Andale Mono', monospace;
        box-sizing: border-box;
        height: auto;
        margin: auto;
        position: relative;
        z-index: 0;
    }
    .CodeMirror-wrap {
        padding: 0.5rem;
    }
    .CodeMirror-scroll {
        height: auto;
        overflow: visible;
        box-sizing: border-box;
    }
</style>