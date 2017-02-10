<template>

    <div class="FormTextfield" :class="isclasses">

        <label :for="name" class="FormTextfield__label">{{ title }}</label>

        <input
            class="FormTextfield__input"
            :id="name"
            :name="name"
            type="text"
            v-model="currentValue"
            :placeholder="placeholder"
            @focus="$events.$emit('photopicker.show')"
        >

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            name: { default: '' },
            title: { default: '' },
            value: { default: '' },
            placeholder: { default: '' }
        },

        data: () => ({
            currentValue: ''
        }),

        mounted() {
            this.currentValue = this.value
            this.$events.$on('photopicker.insert', id => {
                this.currentValue = id
                this.$events.$emit('photopicker.hide')
            })
        }

    }

</script>
