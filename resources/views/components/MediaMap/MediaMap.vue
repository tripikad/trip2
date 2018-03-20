<template>

    <div class="MediaMap" :class="isclasses">

        <h1>Map on siin</h1>
        <svg
                class="MediaMap_svg"
                :class="isclasses"
        >

            <use :xlink:href="'#tripee_logo'"></use>

        </svg>

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            width: 100,
            height: 100
        },

        methods: {

        },

        mounted() {

        }

    }

</script>
