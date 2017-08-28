<template>

    <div>

        <div class="margin-bottom-md" v-for="(field, index) in fields">

            <component
                is="FormHidden"
                :name="'quiz_question[' + index + '][type]'"
                :value="field.type"
            >
            </component>

            <div class="margin-bottom-md QuizFields__question">

                <component
                    is="Title"
                    :title="question_trans + ' ' + (index + 1)"
                    isclasses="Title--small"
                >
                </component>

                <a v-on:click="deleteField(index)" class="QuizFields__delete">

                    <component
                        is="Icon"
                        isclasses="white"
                        icon="icon-close"
                        size="lg"
                    >
                    </component>

                </a>

            </div>

            <div class="margin-bottom-md">

                <component
                    :is="field.type"
                    :name="'quiz_question[' + index + '][question]'"
                    v-model="field.question"
                >
                </component>

            </div>

            <component
                v-if="field.type == 'options'"
                is="PollOption"
                :name="'quiz_question[' + index + '][options]'"
                :question_trans="question_trans"
                :option_trans="option_trans"
                :picture_trans="picture_trans"
                :select_type_trans="select_type_trans"
                :select_one_trans="select_one_trans"
                :select_multiple_trans="select_multiple_trans"
                :answer_options_trans="answer_options_trans"
                :add_option_trans="add_option_trans"
                :type="field.poll_opt_type"
                :answer_options_json="field.poll_opt_val"
                v-on:input="field.poll_opt_val = JSON.stringify($event)"
            >
            </component>

            <div class="margin-bottom-md">

                <component
                    is="FormTextfield"
                    :name="'quiz_question[' + index + '][answer]'"
                    :title="'Vastus ' + (index + 1)"
                    v-model="field.answer"
                >
                </component>

            </div>

            <div class="margin-bottom-md col-2" v-if="field.image_small && field.image_large">

                <component
                    is="PhotoCard"
                    :small="field.image_small"
                    :large="field.image_large"
                >
                </component>

                <component
                    is="FormHidden"
                    :name="'old_quiz_photo_' + index"
                    :value="field.image_id"
                >
                </component>

            </div>

            <div class="margin-bottom-md">

                <label class="FormTextfield__label">{{ picture_trans }}</label>

                <component
                    is="FormUpload"
                    :name="'quiz_photo_' + index"
                >
                </component>

            </div>

            <br>
        </div>

        <div class="margin-bottom-md">

            <component
                v-on:click.native="addField('options')"
                is="Button"
                isclasses="Button--narrow"
                title="Valikud"
                route="javascript:;"
            >
            </component>

            <component
                v-on:click.native="addField('textareafield')"
                is="Button"
                isclasses="Button--narrow"
                title="Teksti väli"
                route="javascript:;"
            >
            </component>

        </div>

    </div>

</template>

<script>
    import Button from '../Button/Button.vue'
    import FormTextarea from '../FormTextarea/FormTextarea.vue'
    import FormTextfield from '../FormTextfield/FormTextfield.vue'
    import PhotoCard from '../PhotoCard/PhotoCard.vue'
    import PollOption from '../PollOption/PollOption.vue'
    import Title from '../Title/Title.vue'
    import FormUpload from '../FormUpload/FormUpload.vue'
    import Icon from '../Icon/Icon.vue'
    import FormHidden from '../FormHidden/FormHidden.vue'

	export default {
        
        props : {
            fields_json : {default : '[]'},
            question_trans : {default: 'Question'},
            option_trans : {default : 'Option'},
            picture_trans : {default : 'Photo'},
            select_type_trans : {default: 'Select type'},
            select_one_trans : {default: 'Select one'},
            select_multiple_trans : {default: 'Select multiple'},
            answer_options_trans : {default: 'Answer options'},
            add_option_trans : {default: 'Add option'}
        },

        components : {
            Button,
            PhotoCard,
            PollOption,
            FormTextfield,
            Title,
            FormUpload,
            Icon,
            FormHidden,
            'options' : FormTextfield,
            'textareafield' : FormTextarea
        },

        data : function() {
            return {
                fields : []
            };
        },

        methods: {
            addField: function (type) {
                this.cnt++;
                this.fields.push(
                    {
                        'type' : type
                    }
                );
            },

            deleteField: function(id) {
                var new_arr = [];
                for(var i = 0; i < this.fields.length; i++){
                    var elem = this.fields[i];
                    if(i != id) {
                        new_arr.push(elem);
                    }
                }

                this.fields = new_arr;
            }
        },

        mounted() {
            var fields = JSON.parse(this.fields_json);
            for (var i = 0; i < fields.length; i++) {
                var field = fields[i];
                var type = field.type == 'text' ? 'textareafield' : 'options';

                var quiz_field = {
                    'type' : type,
                    'answer' : field.options.answer,
                    'question' : field.options.question,
                    'poll_opt_type' : field.type,
                    'poll_opt_val' : JSON.stringify(field.options.options),
                };

                if (field.image_small != undefined && field.image_large != undefined) {
                    quiz_field.image_small = field.image_small;
                    quiz_field.image_large = field.image_large;
                    quiz_field.image_id = field.image_id;
                } else {
                    quiz_field.image_small = false;
                    quiz_field.image_large = false;
                    quiz_field.image_id = false;
                }

                this.fields.push(quiz_field);
            }
        }
	}
</script>