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

import Alert from './components/Alert/Alert.vue'
import Arc from './components/Arc/Arc.vue'
import Button from './components/Button/Button.vue'
import Barchart from './components/Barchart/Barchart.vue'
import Editor from './components/Editor/Editor.vue'
import EditorSmall from './components/EditorSmall/EditorSmall.vue'
import Dotmap from './components/Dotmap/Dotmap.vue'
import Flag from './components/Flag/Flag.vue'
import FormButtonProcess from './components/FormButtonProcess/FormButtonProcess.vue'
import FormCheckbox from './components/FormCheckbox/FormCheckbox.vue'
import FormEditor from './components/FormEditor/FormEditor.vue'
import FormHidden from './components/FormHidden/FormHidden.vue'
import FormImageId from './components/FormImageId/FormImageId.vue'
import FormSelect from './components/FormSelect/FormSelect.vue'
import FormSelectMultiple from './components/FormSelectMultiple/FormSelectMultiple.vue'
import FormRadio from './components/FormRadio/FormRadio.vue'
import FormTextarea from './components/FormTextarea/FormTextarea.vue'
import FormTextfield from './components/FormTextfield/FormTextfield.vue'
import FormUpload from './components/FormUpload/FormUpload.vue'
import FrontpageDestinationSearch from './components/FrontpageDestinationSearch/FrontpageDestinationSearch.vue'
import FrontpageSearch from './components/FrontpageSearch/FrontpageSearch.vue'
import FrontpageSearchRow from './components/FrontpageSearchRow/FrontpageSearchRow.vue'
import FrontpageSearchItem from './components/FrontpageSearchItem/FrontpageSearchItem.vue'
import TravelmateStart from './components/TravelmateStart/TravelmateStart.vue'
import NewsletterComposer from './components/NewsletterComposer/NewsletterComposer.vue'
import Icon from './components/Icon/Icon.vue'
import IconLoader from './components/IconLoader/IconLoader.vue'
import ImagePicker from './components/ImagePicker/ImagePicker.vue'
import ImageUpload from './components/ImageUpload/ImageUpload.vue'
import Linechart from './components/Linechart/Linechart.vue'
import NavbarDesktop from './components/NavbarDesktop/NavbarDesktop.vue'
import NavbarMobile from './components/NavbarMobile/NavbarMobile.vue'
import NavbarSearch from './components/NavbarSearch/NavbarSearch.vue'
import PhotoCard from './components/PhotoCard/PhotoCard.vue'
import PhotoFullscreen from './components/PhotoFullscreen/PhotoFullscreen.vue'
import PollAddFields from './components/PollAddFields/PollAddFields.vue'
import PollAnswer from './components/PollAnswer/PollAnswer.vue'
import PollFields from './components/PollFields/PollFields.vue'
import PollOption from './components/PollOption/PollOption.vue'
import QuizFields from './components/QuizFields/QuizFields.vue'
import PromoBar from './components/PromoBar/PromoBar.vue'
import Title from './components/Title/Title.vue'
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
        Button,
        Barchart,
        Editor,
        EditorSmall,
        Dotmap,
        Flag,
        FormButtonProcess,
        FormCheckbox,
        FormEditor,
        FormHidden,
        FormImageId,
        FormRadio,
        FormSelect,
        FormSelectMultiple,
        FormTextarea,
        FormTextfield,
        FormUpload,
        FrontpageDestinationSearch,
        FrontpageSearch,
        FrontpageSearchRow,
        FrontpageSearchItem,
        Icon,
        IconLoader,
        ImagePicker,
        ImageUpload,
        Linechart,
        NavbarDesktop,
        NavbarMobile,
        NavbarSearch,
        PhotoCard,
        PhotoFullscreen,
        PollAddFields,
        PollAnswer,
        PollFields,
        PollOption,
        QuizFields,
        PromoBar,
        UserImage,
        Title,
        TravelmateStart,
        NewsletterComposer
    },

    mounted() {
        if (globalProps.info) {
            this.$events.$emit('alert', {title: globalProps.info})
        }

    }

})
