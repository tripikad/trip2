<template>

    <div class="FrontpageSearchRow" :class="isclasses">

        <div v-if="index != 'attributes'" class="FrontpageSearchRow__item">
            <div class="FrontpageSearchRow__title">

                {{ result.title }}

            </div>
        </div>
        <a v-else class="FrontpageSearchRow__footer" :href="result.route">
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
