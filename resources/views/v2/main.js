import Vue from 'vue'
import VueResource from 'vue-resource'
import VueCookie from 'vue-cookie'

import Alert from './components/Alert/Alert.vue'
import Arc from './components/Arc/Arc.vue'
import Flag from './components/Flag/Flag.vue'
import FormSelect from './components/FormSelect/FormSelect.vue'
import FrontpageSearch from './components/FrontpageSearch/FrontpageSearch.vue'
import Gallery from './components/Gallery/Gallery.vue'
import Icon from './components/Icon/Icon.vue'
import IconLoader from './components/IconLoader/IconLoader.vue'
import NavbarDesktop from './components/NavbarDesktop/NavbarDesktop.vue'
import NavbarMobile from './components/NavbarMobile/NavbarMobile.vue'
import NavbarSearch from './components/NavbarSearch/NavbarSearch.vue'
import PhotoCard from './components/PhotoCard/PhotoCard.vue'
import PhotoFullscreen from './components/PhotoFullscreen/PhotoFullscreen.vue'
import PromoBar from './components/PromoBar/PromoBar.vue'
import UserImage from './components/UserImage/UserImage.vue'

const globalProps = JSON.parse(decodeURIComponent(
    document.querySelector('#globalprops').getAttribute('content')
))

Vue.use(VueResource)
Vue.http.headers.common['X-CSRF-TOKEN'] = globalProps.token

Vue.use(VueCookie);

var events = new Vue()
Vue.prototype.$events = events

new Vue({
    el: '#app',

    components: {
        Alert,
        Arc,
        Flag,
        FormSelect,
        FrontpageSearch,
        Gallery,
        Icon,
        IconLoader,
        NavbarDesktop,
        NavbarMobile,
        NavbarSearch,
        PhotoCard,
        PhotoFullscreen,
        PromoBar,
        UserImage,
    },

    mounted() {
        this.$http.get(globalProps.alertRoute).then(function(res) {
            if (res.data.info) {
                this.$events.$emit('showAlert', res.data.info)
            }
        })
    }

})
