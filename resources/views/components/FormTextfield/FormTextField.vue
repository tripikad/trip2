<template>
    <div class="FormTextfield" :class="{ 'FormTextfield--error': errors.length, [isclasses]: true }">
        <div class="FormTextfield__header" v-if="title">
            <label :for="name" class="FormTextfield__label">{{title}}</label>
        </div>
        <div class="FormTextfield__field">
            <input class="FormTextfield__input"
                   :type="type"
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
        type: { default: 'text' },
        errors: { type: Array, default: () => [] }
    },
    data: function () {
        return {
            valueModel: this.value
        }
    },
    computed: {
        /*isError() {
            return this.errors.includes(this.name)
        },*/
    }
};
</script>