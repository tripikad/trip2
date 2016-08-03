import Vue from 'vue'
import VueResource from 'vue-resource'

import Arc from './components/Arc/Arc.vue'
import Icon from './components/Icon/Icon.vue'
import IconLoader from './components/IconLoader/IconLoader.vue'

const globalProps = JSON.parse(decodeURIComponent(
    document.querySelector('#globalprops').getAttribute('content')
))

Vue.use(VueResource)
Vue.http.headers.common['X-CSRF-TOKEN'] = globalProps.token

new Vue({
    el: 'body',

    components: {
        Arc,
        Icon,
        IconLoader
    },

    events: {
    },

    ready() {
    }

})
