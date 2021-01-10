import Vue from 'vue'
import VueCookie from 'vue-cookie'
import axios from 'axios'
import moment from 'moment'
import VueDatePicker from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

// Require CSS files

require.context('./styles', true, /\.css$/)
require.context('./components', true, /\.css$/)
require.context('./layouts', true, /\.css$/)

require.context('../scss', true, /\.scss$/)
require.context('./components', true, /\.scss$/)

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

Vue.use(VueDatePicker);

// Set up cookies

Vue.use(VueCookie)

// Set up event bus

var events = new Vue()
Vue.prototype.$events = events

// Set up global props

const globalProps = JSON.parse(decodeURIComponent(document.querySelector('#globalprops').getAttribute('content')))
Vue.prototype.$globalProps = globalProps

// Set up style variables

Vue.prototype.$styles = require('./styles/styles')

// Set up Axios

Vue.prototype.$http = axios.create({
    headers: {
        'X-CSRF-TOKEN': globalProps.token,
        'X-Requested-With': 'XMLHttpRequest'
    }
})

Vue.prototype.$moment = moment

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
