<template>
    <div class="FormTextEditor" :class="{ 'FormTextEditor--error': isError, [isclasses]: true }">
        <div class="FormTextfield__header">
            <label :for="name" class="FormTextfield__label">{{ title }}</label>
        </div>

        <vue-editor
            v-model="content"
            :id="name"
            @input="$emit('input', $event)"
            spellcheck="false"
            :placeholder="placeholder"/>

        <input type="hidden" :name=name :value="content"/>
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        name: { default: '' },
        title: { default: '' },
        value: { default: '' },
        errors: { default: () => [] },
        disabled: { default: false },
        placeholder: { default: '' },
    },
    data: function () {
        return {
            content: this.value
        }
    },
    computed: {
        isError() {
            return this.errors.includes(this.name)
        }
    }
};
</script>