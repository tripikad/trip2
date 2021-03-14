<template>
    <div class="Tag" :class="isclasses">
        <a v-if="route" :href="route">
            <div class="Tag__title" v-html="title" />
        </a>
        <div v-if="!route" class="Tag__title">{{ title }}</div>
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        title: { default: '' },
        route: { default: '' }
    }
}
</script>