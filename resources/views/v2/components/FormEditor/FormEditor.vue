<template>

    <div class="FormTextarea" :class="isclasses">

        <label :for="name" class="FormTextarea__label">{{ title }}</label>

        <textarea
            readonly
            class="FormTextarea__textarea"
            :id="name"
            :name="name"
            :rows="rows"
            :cols="cols"
            v-model="currentValue"
            :placeholder="placeholder"
            @focus="$events.$emit('editor.show')"
        ></textarea>

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            name: { default: '' },
            title: { default: '' },
            value: { default: '' },
            rows: { default: 8 },
            cols: { default: 50 },
            placeholder: { default: '' }
        },

        data: () => ({
            currentValue: ''
        }),

        mounted() {
            this.currentValue = this.value
            this.$events.$on('editor.update', value => {
                this.currentValue = value
            })
        }

    }

</script>
