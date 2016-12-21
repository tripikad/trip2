<template>

    <div
        class="UserImage"
        :class="isclasses"
        :style="{
            width: size + 'px',
            height: size + 'px'
        }"
    >
        
        <a :href="route">

        <img
            class="UserImage__image"
            :src="image"
            :style="{
                padding: border / 2 + 'px'
            }"
        />

        <div class="UserImage__arcRank">

            <component
                is="Arc"
                startangle="0"
                :endangle="rank"
                :size="size"
                :border="border"
            ></component>

        </div>

        <div class="UserImage__arcReminder">

            <component
                is="Arc"
                :startangle="rank"
                endangle="360"
                :size="size"
                :border="border"
            ></component>

        </div>

        </a>

    </div>

</template>

<script>

    import Arc from '../Arc/Arc.vue'

    export default {

        components: { Arc },

        props: {
            isclasses: { default: '' },
            route: { default: '' },
            image: { default: '' },
            rank: { default: '0' },
            size: { size: '36' },
            border: { size: '3' }
        }

    }

</script>
