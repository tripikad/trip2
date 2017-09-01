<template>

    <div class="Badge" :class="isclasses">

        <div class="Badge__title">

            {{ title }}

        </div>

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            title: { default: '' }
        },

    }

</script>
