<template>
    <div class="FormTextEditor" :class="{ 'FormTextEditor--error': isError, [isclasses]: true }">
        <div class="FormTextField__header">
            <label :for="name" class="FormTextField__label">{{ title }}</label>
        </div>

        <vue-editor
            v-model="content"
            :id="name"
            @input="$emit('input', $event)"
            spellcheck="false"/>
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
