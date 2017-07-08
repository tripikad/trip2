<template>

    <div class="FrontpageAjaxSearchRow" :class="isclasses">

        <div v-if="index != 'attributes'" class="FrontpageAjaxSearchRow__item">
            <div class="FrontpageAjaxSearchRow__title">

                {{ result.title }}

            </div>
        </div>
        <a v-else class="FrontpageAjaxSearchRow__footer" :href="result.route">
            {{ result.total }} Tulemust kokku
        </a>

    </div>

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
