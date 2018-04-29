<template>

    <div class="FrontpageSearchRow" :class="isclasses">

        <div v-if="index != 'attributes'" class="FrontpageSearchRow__category">
            <div class="FrontpageSearchRow__icon">
                <component is="Icon" :icon="result.icon" size="lg"></component>
            </div>
            <div class="FrontpageSearchRow__title">
                {{ result.title }}
            </div>
            <component v-for="(result, index) in result.items" is="SearchItem" :result="result" :key="index" :index="index"></component>
        </div>
        <a v-else-if="index == 'attributes' && result.total > 0" class="FrontpageSearchRow__footer" :href="result.route">
            {{ result.message }} ({{ result.total }})
            <component is="Icon" icon="icon-arrow-right" size="sm"></component>
        </a>
        <div v-else class="FrontpageSearchRow__footer">
            {{ result.message }}
        </div>

    </div>

</template>

<script>
import Icon from '../Icon/Icon.vue'
import SearchItem from '../FrontpageSearchItem/FrontpageSearchItem.vue'

export default {
    props: {
        isclasses: { default: '' },
        result: { default: [] },
        index: { default: '' }
    },
    components: { Icon, SearchItem }
}
</script>
