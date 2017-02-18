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
            @focus="$events.$emit('imagepicker.show', name)"
        >

        <div v-if="image">
            <img class="FormImageId__image" :src="image" />
        </div>

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
            currentValue: '',
            image: ''
        }),

        mounted() {
            this.currentValue = this.value
            this.$events.$on('imagepicker.insert', payload => {
                if (payload.target === this.name) {
                    this.currentValue = payload.id
                    this.image = payload.large
                }
                this.$events.$emit('imagepicker.hide')
            })
        }

    }

</script>
