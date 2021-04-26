<template>
    <div class="FormCheckbox" :class="{ 'FormTextfield--error': errors.length, [isclasses]: true }">
        <input
            v-model="valueModel"
            :name="name"
            :id="name"
            type="checkbox"
            class="FormCheckbox__checkbox"
        >

        <label :for="name" class="FormCheckbox__label">{{title}}</label>
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        title: { default: ''},
        name: {
            required: true,
            type: String,
        },
        value: { default: ''},
        errors: { type: Array, default: () => [] }
    },
    data: function () {
        return {
            valueModel: this.value
        }
    },
};
</script>