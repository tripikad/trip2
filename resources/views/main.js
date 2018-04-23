// Require CSS files

require.context('./styles', true, /\.css$/)
require.context('./components', true, /\.css$/)
require.context('./layouts', true, /\.css$/)

// Require SVG files

require.context('./svg', true, /\.svg$/)

// Require Vue et al

import Vue from 'vue'
import VueResource from 'vue-resource'
import VueCookie from 'vue-cookie'

Vue.use(VueResource);
Vue.use(VueCookie);

// See https://vuejs.org/v2/guide/components-registration.html

const requireComponent = require.context("./components", true, /\.vue$/);

requireComponent.keys().forEach(filePath => {
  const componentConfig = requireComponent(filePath);
  // Get the filename from full file path and strip the .vue extension
  const componentName = filePath.match(/[-_\w]+[.][\w]+$/i)[0].split(".")[0];
  Vue.component(componentName, componentConfig.default || componentConfig);
});

var events = new Vue()
Vue.prototype.$events = events

const globalProps = JSON.parse(decodeURIComponent(
    document.querySelector('#globalprops').getAttribute('content')
))
Vue.prototype.$globalProps = globalProps
Vue.http.headers.common['X-CSRF-TOKEN'] = globalProps.token

new Vue({
    el: '#app',

    mounted() {
        if (globalProps.info) {
            this.$events.$emit('alert', {title: globalProps.info})
        }

    }

})
