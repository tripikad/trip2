<template>

    <div>

        <div class="margin-bottom-md">

            <label class="PollOption__label">{{ select_type_trans }}</label>

            <component 
                is="FormRadio"
                :options="options"
                :value="type + '_' + this.name"
                :name="name + '[select_type]'"
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <label class="PollOption__label">{{ answer_options_trans }}</label>

            <div class="FormTextfield margin-bottom-md PollOption__option" v-for="(opt, index) in answer_options">

                <input
                    class="FormTextfield__input"
                    :id="opt.id"
                    :name="name + '[]'"
                    type="text"
                    :placeholder="option_trans + ' ' + (index + 1)"
                    v-model="opt.value"
                    v-on:input="$emit('input', answer_options)"
                >

                <a v-if="answer_options.length > 2" v-on:click="deleteField(index)" class="PollOption__delete">

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
                v-on:click.native="addField"
                is="Button"
                isclasses="Button--narrow"
                :title="add_option_trans"
                route="javascript:;"
            >
            </component>

        </div>

    </div>

</template>

<script>

    import Button from '../Button/Button.vue'
    import Icon from '../Icon/Icon.vue'
    import FormRadio from '../FormRadio/FormRadio.vue'

	export default {

        props : {
            name : {default : ''},
            type : {default : ''},
            option_trans : {default: 'Option'},
            select_type_trans : {default: 'Select type'},
            select_one_trans : {default: 'Select one'},
            select_multiple_trans : {default: 'Select multiple'},
            answer_options_trans : {default: 'Answer options'},
            add_option_trans : {default: 'Add option'},
            answer_options_json : {default : '[]'}
        },
        
        components : {
            Button,
            Icon,
            FormRadio
        },
        
        data : function() {
            return {
                answer_options : [],
                options: [
                    {'id' : 'radio_' + this.name, 'name': this.select_one_trans},
                    {'id' : 'checkbox_' + this.name, 'name': this.select_multiple_trans}
                ]
            };
        },
        
        methods: {
            addField: function () {
                this.cnt++;
                this.answer_options.push(
                    {
                        'value' : ''
                    }
                );
                this.$emit('input', this.answer_options)
            },
            
            deleteField: function(id, event){
                var new_arr = [];
                for(var i = 0; i < this.answer_options.length; i++){
                    var elem = this.answer_options[i];
                    if(i != id) {
                        new_arr.push(elem);
                    }
                }
                
                this.answer_options = new_arr;
            },

            populateFields: function(){
                var options = JSON.parse(this.answer_options_json);
                this.answer_options = options;
            }
        },

        mounted() {
            if (this.answer_options_json == '[]') {
                this.addField();
                this.addField();
            } else {
                this.populateFields();
            }
        },

        watch : {
            answer_options_json : function(new_answer_options_json){
                this.populateFields();
            }
        }
    }
    
</script>