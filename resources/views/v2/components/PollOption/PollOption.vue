<template>

    <div>

        <div class="margin-bottom-md">

            <label class="FormTextfield__label">{{ select_type_trans }}</label>

            <component 
                is="FormRadio"
                :options="options"
                :value="options[0].id"
                :name="name + '_select_type'"
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <label class="FormTextfield__label">{{ answer_options_trans }}</label>

            <div class="FormTextfield margin-bottom-md PollFields__option" v-for="(opt, index) in answer_options">

                <input
                    class="FormTextfield__input"
                    :id="opt.id"
                    :name="opt.id"
                    type="text"
                    :placeholder="option_trans + ' ' + (index + 1)"
                    v-model="opt.value"
                >

                <a v-if="answer_options.length > 2" v-on:click="deleteField(opt.id)" class="PollFields__delete">

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

        <component
            is="FormHidden"
            :name="name + '_cnt'"
            :value="cnt"
        >
        </component>

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
    import FormHidden from '../FormHidden/FormHidden.vue'

	export default {

        props : {
            name : {default : ''},
            option_trans : {default: 'Option'},
            select_type_trans : {default: 'Select type'},
            select_one_trans : {default: 'Select one'},
            select_multiple_trans : {default: 'Select multiple'},
            answer_options_trans : {default: 'Answer options'},
            add_option_trans : {default: 'Add option'}
        },
        
        components : {
            Button,
            Icon,
            FormRadio,
            FormHidden
        },
        
        data : function() {
            return {
                'answer_options': [],
                'cnt' : 0,
                options: [
                    {'id' : 'select_one', 'name': this.select_one_trans},
                    {'id' : 'select_multiple', 'name': this.select_multiple_trans}
                ]
            };
        },
        
        methods: {
            addField: function () {
                this.cnt++;
                this.answer_options.push(
                    {
                        'value' : '',
                        'id' : this.name + '_' + this.cnt
                    }
                );
            },
            
            deleteField: function(id, event){
                var new_arr = [];
                for(var i = 0; i < this.answer_options.length; i++){
                    var elem = this.answer_options[i];
                    if(elem.id != id) {
                        new_arr.push(elem);
                    }
                }
                
                this.answer_options = new_arr;
            }
        },

        mounted() {
            this.addField();
            this.addField();
        }
    }
    
</script>