import Vue from 'vue'
import VueResource from 'vue-resource'

import Arc from './components/Arc/Arc.vue'

const globalProps = JSON.parse(decodeURIComponent(
    document.querySelector('#globalprops').getAttribute('content')
))

Vue.use(VueResource)
Vue.http.headers.common['X-CSRF-TOKEN'] = globalProps.token

new Vue({
    el: 'body',

    components: {
        Arc,
    },

    events: {
},

    ready() {
    }

})
