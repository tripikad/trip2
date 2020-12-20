<template>
    <div class="FormTextfield" :class="{ 'FormTextField--error': isError }">
        <div class="FormTextField__header">
            <label :for="name" class="FormTextField__label">{{title}}</label>
        </div>
        <div class="FormTextField__field">
            <input class="FormTextField__input"
                   type="text"
                   spellcheck="false"
                   v-model="valueModel"
                   :name="name"
                   :id="name"
                   @input="$emit('input', $event.target.value)"
                   :placeholder="placeholder"/>
        </div>
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
        placeholder: { default: '' },
        errors: { type: Array, default: () => [] }
    },
    data: function () {
        return {
            valueModel: this.value
        }
    },
    computed: {
        isError() {
            return this.errors.includes(this.name)
        },
    }
};
</script>
