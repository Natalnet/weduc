import Vue from 'vue'
import Toasted from 'vue-toasted'
import router from '@/router'
import axios from '@/util/axios'
import PortalVue from 'portal-vue'
import Loading from '@/components/Loading'
import AsyncComputed from 'vue-async-computed'

Vue.use(PortalVue)
Vue.use(AsyncComputed)

Vue.use(Toasted, {
    router,
    theme: 'bubble',
    position: 'bottom-right',
    duration: 6000,
})

export default class Atom {
    constructor(config) {
        this.bus = new Vue()
        this.bootingCallbacks = []
        this.config = config
    }

    /**
     * Register a callback to be called before Atom starts. This is used to bootstrap
     * addons, tools, custom fields, or anything else Atom needs
     */
    booting(callback) {
        this.bootingCallbacks.push(callback)
    }

    /**
     * Execute all of the booting callbacks.
     */
    boot() {
        this.bootingCallbacks.forEach(callback => callback(Vue, router))

        this.bootingCallbacks = []
    }

    /**
     * Start the Atom app by calling each of the tool's callbacks and then creating
     * the underlying Vue instance.
     */
    liftOff() {
        let _this = this

        this.boot()

        this.app = new Vue({
            el: '#app',
            router,
            components: { Loading },
            mounted: function() {
                this.$loading = this.$refs.loading

                _this.$on('error', message => {
                    this.$toasted.show(message, { type: 'error' })
                })
            },
        })
    }

    /**
     * Return an axios instance configured to make requests to Atom's API
     * and handle certain response codes.
     */
    request(options) {
        if (options !== undefined) {
            return axios(options)
        }

        return axios
    }

    /**
     * Register a listener on Atom's built-in event bus
     */
    $on(...args) {
        this.bus.$on(...args)
    }

    /**
     * Register a one-time listener on the event bus
     */
    $once(...args) {
        this.bus.$once(...args)
    }

    /**
     * Unregister an listener on the event bus
     */
    $off(...args) {
        this.bus.$off(...args)
    }

    /**
     * Emit an event on the event bus
     */
    $emit(...args) {
        this.bus.$emit(...args)
    }
}