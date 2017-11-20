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
                :answer_options_json="JSON.stringify(field.poll_opt_val)"
                v-on:input="field.poll_opt_val = $event; $forceUpdate();"
                v-on:poll_type="field.poll_type = $event; $forceUpdate();"
            >
            </component>

            <div v-if="answer_enabled">

                <div class="margin-bottom-md QuizFields__label">
                    {{ answer_trans }} {{ (index + 1) }}
                </div>

                <div class="margin-bottom-md" v-if="field.type == 'textareafield'">

                    <component
                        is="FormTextfield"
                        :name="'quiz_question[' + index + '][answer]'"
                        v-model="field.answer"
                    >
                    </component>

                </div>

                <div class="margin-bottom-md"
                    v-if="field.type == 'options' && field.poll_type == 'checkbox'"
                    v-for="opt in parseOptionsForCheckbox(field)"
                >
                    <component
                        is="FormCheckbox"
                        :name="'quiz_question[' + index + '][answer][' + opt + ']'"
                        :title="opt"
                        :val="field.answer.includes(opt)"
                        v-model="field.answer_opts[opt]"
                    >
                    </component>
                </div>

                <div class="margin-bottom-md"
                    v-if="field.type == 'options' && field.poll_type == 'radio'"
                >
                    <component
                        is="FormRadio"
                        :name="'quiz_question[' + index + '][answer]'"
                        :options="parseOptionsForRadio(field)"
                        :value="field.answer[0]"
                        v-on:change="field.answer[0] = $event"
                    >
                    </component>
                </div>

            </div>

            <div class="margin-bottom-md">

                <label class="QuizFields__label">{{ picture_trans }}</label>

            </div>

            <div class="margin-bottom-md col-2 QuizFields__picture" v-if="field.image_small && field.image_large">

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

                <a v-on:click="deletePicture(field)">

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
                :title="option_button_trans"
                route="javascript:;"
            >
            </component>

            <component
                v-on:click.native="addField('textareafield')"
                is="Button"
                isclasses="Button--narrow"
                :title="textfield_button_trans"
                route="javascript:;"
            >
            </component>

        </div>

        <div class="margin-bottom-md" v-if="answer_enabled">

            <component
                is="FormCheckbox"
                name="quiz_show_answers"
                :title="show_answers_trans"
                :val="show_answers"
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
    import FormCheckbox from '../FormCheckbox/FormCheckbox.vue'
    import FormRadio from '../FormRadio/FormRadio.vue'

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
            add_option_trans : {default: 'Add option'},
            answer_trans : {default: 'Answer'},
            option_button_trans : {default: 'Options'},
            textfield_button_trans : {default: 'Text field'},
            answer_enabled : {default: false},
            show_answers_trans : {default: 'Show answers to users'}
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
            FormCheckbox,
            FormRadio,
            'options' : FormTextfield,
            'textareafield' : FormTextarea
        },

        data : function() {
            return {
                fields : [],
                show_answers : false
            };
        },

        methods: {
            addField: function (type) {
                this.cnt++;
                this.fields.push(
                    {
                        'type' : type,
                        'answer_opts' : {},
                        'answer' : []
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
            },

            parseOptionsForCheckbox: function(options) {
                var new_opts = [];
                options = options.poll_opt_val

                if (options == undefined) {
                    return new_opts;
                }

                for (var i = 0; i < options.length; i++) {
                    if (options[i]['value'] != "") {
                        new_opts.push(options[i]['value']);
                    }
                }

                return new_opts;
            },

            parseOptionsForRadio: function(options) {
                var new_opts = [];
                options = options.poll_opt_val

                if (options == undefined) {
                    return new_opts;
                }

                for (var i = 0; i < options.length; i++) {
                    if (options[i]['value'] != "") {
                        new_opts.push({'id' : options[i]['value'], 'name': options[i]['value']});
                    }
                }

                return new_opts;
            },

            deletePicture: function(field) {
                field.image_small = '';
                field.image_large = '';
            }
        },

        mounted() {
            var fields = JSON.parse(this.fields_json);
            for (var i = 0; i < fields.length; i++) {
                var field = fields[i];
                var type = field.type == 'text' ? 'textareafield' : 'options';

                this.show_answers = field.options.show_answers;

                var poll_opt_val = [];
                if (field.options.options != undefined) {
                    for(var j = 0; j < field.options.options.length; j++) {
                        poll_opt_val.push({'value' : field.options.options[j]});
                    }
                }

                if(!(field.options.answer instanceof Array)) {
                    field.options.answer = [field.options.answer];
                }

                var quiz_field = {
                    'type' : type,
                    'answer' : field.options.answer.map(function (val) { return val+'' }),
                    'question' : field.options.question,
                    'poll_opt_type' : field.type,
                    'poll_type' : field.type,
                    'poll_opt_val' : poll_opt_val,
                    'answer_opts' : {}
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