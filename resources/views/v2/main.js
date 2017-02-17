import Vue from 'vue'
import VueResource from 'vue-resource'
import VueCookie from 'vue-cookie'

import Alert from './components/Alert/Alert.vue'
import Arc from './components/Arc/Arc.vue'
import Editor from './components/Editor/Editor.vue'
import Flag from './components/Flag/Flag.vue'
import FormButtonProcess from './components/FormButtonProcess/FormButtonProcess.vue'
import FormEditor from './components/FormEditor/FormEditor.vue'
import FormImageId from './components/FormImageId/FormImageId.vue'
import FormSelect from './components/FormSelect/FormSelect.vue'
import FormSelectMultiple from './components/FormSelectMultiple/FormSelectMultiple.vue'
import FrontpageDestinationSearch from './components/FrontpageDestinationSearch/FrontpageDestinationSearch.vue'
import FrontpageSearch from './components/FrontpageSearch/FrontpageSearch.vue'
import Icon from './components/Icon/Icon.vue'
import IconLoader from './components/IconLoader/IconLoader.vue'
import ImagePicker from './components/ImagePicker/ImagePicker.vue'
import ImageUpload from './components/ImageUpload/ImageUpload.vue'
import NavbarDesktop from './components/NavbarDesktop/NavbarDesktop.vue'
import NavbarMobile from './components/NavbarMobile/NavbarMobile.vue'
import NavbarSearch from './components/NavbarSearch/NavbarSearch.vue'
import PhotoCard from './components/PhotoCard/PhotoCard.vue'
import PhotoFullscreen from './components/PhotoFullscreen/PhotoFullscreen.vue'
import PromoBar from './components/PromoBar/PromoBar.vue'
import UserImage from './components/UserImage/UserImage.vue'

Vue.use(VueResource)
Vue.use(VueCookie);

var events = new Vue()
Vue.prototype.$events = events

const globalProps = JSON.parse(decodeURIComponent(
    document.querySelector('#globalprops').getAttribute('content')
))
Vue.prototype.$globalProps = globalProps
Vue.http.headers.common['X-CSRF-TOKEN'] = globalProps.token

new Vue({
    el: '#app',

    components: {
        Alert,
        Arc,
        Editor,
        Flag,
        FormButtonProcess,
        FormEditor,
        FormImageId,
        FormSelect,
        FormSelectMultiple,
        FrontpageDestinationSearch,
        FrontpageSearch,
        Icon,
        IconLoader,
        ImagePicker,
        ImageUpload,
        NavbarDesktop,
        NavbarMobile,
        NavbarSearch,
        PhotoCard,
        PhotoFullscreen,
        PromoBar,
        UserImage,
    },

    mounted() {
        if (globalProps.info) {
            this.$events.$emit('alert', {title: globalProps.info})
        }

    }

})
