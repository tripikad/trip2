<template>
    <div class="HeaderError" :class="{ [isclasses]: true }">
        <div class="HeaderError__title" v-for="(error, index) in errors">
            {{error}}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        errors: { default: () => [] },
    },
}
</script>
