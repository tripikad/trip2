<template>

    <div>
        <div class="margin-bottom-md">

            <label class="PollOption__label">{{ label }}</label>

            <div class="FormTextfield margin-bottom-md PollOption__option" v-for="(opt, index) in inputs">

                <input
                        class="FormTextfield__input"
                        :name="name + '[]'"
                        type="text"
                        :placeholder="option_placeholder + ' ' + (index + 1)"
                        v-model="opt.value"
                        :disabled="disabled"
                >

                <a v-if="inputs.length > 2 && !disabled" v-on:click="deleteField(index)" class="PollOption__delete">

                    <component
                            is="Icon"
                            isclasses="white"
                            icon="icon-close"
                            size="lg"
                    >
                    </component>

                </a>

            </div>

        </div>

        <div class="margin-bottom-md">

            <component
                    v-if="!disabled"
                    v-on:click.native="addField"
                    is="Button"
                    isclasses="Button--narrow"
                    :title="add_option_label"
                    route="javascript:;"
            >
            </component>

        </div>

    </div>

</template>

<script>
    import Button from '../Button/ButtonVue.vue'
    import Icon from '../Icon/Icon.vue'
    export default {
        props : {
            name : {default : ''},
            label: {default : ''},
            add_option_label: {default : 'Add option'},
            option_placeholder: {default : 'Option'},
            options : {default : []},
            disabled: {default : false},
        },

        components : {
            Button,
            Icon
        },

        data : function() {
            return {
                cnt: 0,
                inputs : []
            };
        },

        methods: {
            addField: function () {
                this.cnt++;
                this.inputs.push({
                    value: ''
                });
            },

            deleteField: function(index) {
                this.$delete(this.inputs, index);
            },
            populateFields: function(){
                this.inputs = this.options.map(opt => {
                    return {value: opt};
                });
            }
        },
        mounted() {
            if (this.options && this.options.length) {
                this.populateFields();
            } else {
                this.addField();
                this.addField();
            }
        }
    }

</script>