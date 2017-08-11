<template>
    <div>
        <div class="margin-bottom-md">
            <label class="FormTextfield__label">Valiku tüüp</label>
        
            <component 
                is="FormRadio"
                :options="options"
                :value="options[0].id"
                name="select_type"
            >
            </component>
        </div>
        
        <div class="margin-bottom-md">
            <label class="FormTextfield__label">Vastuse valikud</label>
                
            <div class="FormTextfield margin-bottom-md PollFields__option" v-for="opt in answer_options">

                <input
                    class="FormTextfield__input"
                    :id="opt.id"
                    :name="opt.id"
                    type="text"
                    :placeholder="opt.placeholder"
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
        
        <div class="margin-bottom-md">
            <component
                v-on:click.native="addField"
                is="Button"
                isclasses="Button--narrow"
                title="Lisa valik"
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
            option_trans : {default: ''}
        },
        
        components : { Button, Icon, FormRadio },
        
        data : function() {
            return {
                'answer_options': [],
                'cnt' : 0,
                options: [
                    {'id' : 'select_one', 'name': 'Vali üks'},
                    {'id' : 'select_multiple', 'name': 'Vali mitu'}
                ]
            };
        },
        
        methods: {
            addField: function () {
                this.cnt++;
                this.answer_options.push(
                    {
                        'id' : 'ans_opt_' + this.cnt, 
                        'placeholder' : this.option_trans + ' ' + (this.answer_options.length + 1)
                    }
                );
            },
            
            deleteField: function(id, event){
                var new_arr = [];
                var j = 0;
                for(var i = 0; i < this.answer_options.length; i++){
                    var elem = this.answer_options[i];
                    if(elem.id != id) {
                        elem.placeholder = this.option_trans + ' ' + ++j;
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