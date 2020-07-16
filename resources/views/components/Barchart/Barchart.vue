<template>
    <div class="Barchart" :class="isclasses">
        <div class="Barchart__item" v-for="item in items">
            <div class="Barchart__title">{{ item.title }}</div>

            <div class="Barchart__bar">
                <div class="Barchart__line" :style="{ width: item.value + '%' }">
                    <span class="Barchart__percent">{{ item.value }} %</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        items: { default: [] }
    }
}
</script>
