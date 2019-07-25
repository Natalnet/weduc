export default {
  props: {
    attribute: { required: true },
    value: { required: true },
    label: { type: String }
  },

  mounted() {
    // Register a global event for setting the field's value
    Atom.$on(this.attribute + '-value', value => {
      this.fieldValue = value
    })
  },

  destroyed() {
    Atom.$off(this.attribute + '-value')
  },

  computed: {
    fieldValue: {
      get() {
        return this.value
      },
      set(value) {
        this.$emit('input', value)
      }
    }
  },
}