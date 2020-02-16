<template>
    <div>
        <div class="FormButtons" :class="isclasses">
            <div
                v-for="(item, i) in items"
                :key="i"
                class="FormButtons__button"
                :class="(item.hasOwnProperty('id') ? item.id : i) == activeIndex ? 'FormButtons__button--active' : ''"
                @click="
                    activeIndex = item.hasOwnProperty('id') ? item.id : i
                    $emit('input', activeIndex)
                "
                v-html="item.hasOwnProperty('name') ? item.name : item"
            ></div>
        </div>
        <input v-model="activeIndex" v-show="false" type="text" :name="name" />
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        name: { default: '' },
        items: { default: [] },
        value: { default: 0 }
    },
    data: () => ({
        activeIndex: 0
    }),
    mounted() {
        this.$watch('value', value => (this.activeIndex = value), { immediate: true })
    }
}
</script>
