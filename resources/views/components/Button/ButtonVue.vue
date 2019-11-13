<template>
    <a :href="route" :target="external ? '_blank' : ''">
        <div class="Button" :class="isclasses">
            <div v-if="icon" class="Button__icon">
                <!-- component('Icon')->is('white')->with('icon', $icon) !!} -->
            </div>

            <div class="Button__title">{{ title }}</div>
        </div>
    </a>
</template>

<script>
export default {
    props: {
        isclasses: { default: '', type: String },
        route: { default: '', type: String },
        external: {
            default: false,
            type: [Boolean, String]
        },
        icon: { default: '', type: String },
        title: { default: '', type: String }
    }
}
</script>
