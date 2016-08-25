import Vue from 'vue'
import VueResource from 'vue-resource'

import Alert from './components/Alert/Alert.vue'
import Arc from './components/Arc/Arc.vue'
import HeaderSearch from './components/HeaderSearch/HeaderSearch.vue'
import Icon from './components/Icon/Icon.vue'
import IconLoader from './components/IconLoader/IconLoader.vue'
import Editor from './components/Editor/Editor.vue'
import Flag from './components/Flag/Flag.vue'
import Navbar from './components/Navbar/Navbar.vue'
import NavbarMobile from './components/NavbarMobile/NavbarMobile.vue'
import Map from './components/Map/Map.vue'
import Promo from './components/Promo/Promo.vue'
import ImageUpload from './components/ImageUpload/ImageUpload.vue'
import FormSelect from './components/FormSelect/FormSelect.vue'
import Gallery from './components/Gallery/Gallery.vue'

const globalProps = JSON.parse(decodeURIComponent(
    document.querySelector('#globalprops').getAttribute('content')
))

Vue.use(VueResource)
Vue.http.headers.common['X-CSRF-TOKEN'] = globalProps.token

new Vue({
    el: 'body',

    components: {
        Alert,
        Arc,
        HeaderSearch,
        Icon,
        IconLoader,
        Editor,
        Flag,
        Navbar,
        NavbarMobile,
        Map,
        Promo,
        ImageUpload,
        FormSelect,
        Gallery,
    },

    events: {
        showAlert: function(alert) {
            this.$broadcast('showAlert', alert)
        }
    },

    ready() {
        this.$http.get(globalProps.alertRoute).then(function(res) {
            if (res.data.info) {
                this.$emit('showAlert', res.data.info)
            }
        })
    }

})
