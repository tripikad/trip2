<template>
    <div>
        <div class="FormButtons" :class="isclasses">
            <div
                v-for="(item,i) in items"
                :key="i"
                class="FormButtons__button"
                :class="i == activeIndex ? 'FormButtons__button--active' : ''"
                @click="activeIndex = i"
            >{{ item }}</div>
        </div>
        <input v-model="activeIndex" v-show="false" type="text" :name="name" />
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        name: { default: '' },
        items: { default: [] }
    },
    data: () => ({
        activeIndex: 0
    })
}
</script>
