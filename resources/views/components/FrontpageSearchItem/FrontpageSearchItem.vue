<template>

    <a :href="result.route" class="FrontpageSearchItem" :class="isclasses">
        {{ result.title }}
         <span :class="'FrontpageSearchItem__badge FrontpageSearchItem__badge--' + (result.badge_color ? result.badge_color : 'orange')" v-if="result.badge">
            {{result.badge}}
         </span>
    </a>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            result: { default: [] },
            index: { default: '' }
        }

    }

</script>
