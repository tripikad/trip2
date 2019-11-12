import Vue from 'vue'
import VueCookie from 'vue-cookie'
import axios from 'axios'

// Require CSS files

require.context('./styles', true, /\.css$/)
require.context('./components', true, /\.css$/)
require.context('./layouts', true, /\.css$/)

// Require SVG files

require.context('./svg', true, /\.svg$/)

// Require Vue files
// See https://vuejs.org/v2/guide/components-registration.html

const requireComponent = require.context('./components', true, /\.vue$/)

requireComponent.keys().forEach(filePath => {
    const componentConfig = requireComponent(filePath)
    // Get the filename from full file path and strip the .vue extension
    const componentName = filePath.match(/[-_\w]+[.][\w]+$/i)[0].split('.')[0]
    Vue.component(componentName, componentConfig.default || componentConfig)
})

// Set up cookies

Vue.use(VueCookie)

// Set up event bus

var events = new Vue()
Vue.prototype.$events = events

// Set up global props

const globalProps = JSON.parse(
    decodeURIComponent(
        document.querySelector('#globalprops').getAttribute('content')
    )
)
Vue.prototype.$globalProps = globalProps

// Set up style variables

Vue.prototype.$styleVars = require('./styles/variables.json')

// Set up Axios

Vue.prototype.$http = axios.create({
    headers: {
        'X-CSRF-TOKEN': globalProps.token,
        'X-Requested-With': 'XMLHttpRequest'
    }
})

// Create a Vue instance

new Vue({
    el: '#app',

    mounted() {
        if (this.$globalProps.info) {
            this.$events.$emit('alert', {
                title: globalProps.info
            })
        }
    }
})
