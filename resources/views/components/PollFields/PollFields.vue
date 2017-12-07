<template>

    <div>

        <div class="margin-bottom-md">

            <component
                is="Title"
                :title="question_trans"
                isclasses="Title--small"
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <component
                is="FormTextfield"
                name="poll_question"
                v-model="question"
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <component
                is="PollOption"
                name="poll_fields"
                :type="type"
                :option_trans="option_trans"
                :select_type_trans="select_type_trans"
                :select_one_trans="select_one_trans"
                :select_multiple_trans="select_multiple_trans"
                :answer_options_trans="answer_options_trans"
                :add_option_trans="add_option_trans"
                :answer_options_json="answer_options_json"
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <label class="PollFields__label">{{ picture_trans }}</label>

        </div>

        <div class="margin-bottom-md col-2 PollFields__picture" v-if="image_small && image_large">

            <component
                is="PhotoCard"
                :small="image_small"
                :large="image_large"
            >
            </component>

            <component
                is="FormHidden"
                name="old_image_id"
                :value="image_id"
            >
            </component>

            <a v-on:click="deletePicture()">

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
                name="poll_photo"
            >
            </component>

        </div>

        <component
            is="FormHidden"
            name="poll_field_id"
            :value="field_id"
            v-if="field_id != 0"
        >
        </component>

    </div>

</template>

<script>

    import FormHidden from '../FormHidden/FormHidden.vue'
    import FormTextfield from '../FormTextfield/FormTextfield.vue'
    import FormUpload from '../FormUpload/FormUpload.vue'
    import PhotoCard from '../PhotoCard/PhotoCard.vue'
    import PollOption from '../PollOption/PollOption.vue'
    import Title from '../Title/Title.vue'
    import Icon from '../Icon/Icon.vue'

	export default {

        components : {
            FormHidden,
            FormTextfield,
            FormUpload,
            PhotoCard,
            PollOption,
            Title,
            Icon
        },

        props : {
            fields_json : {default : '[]'},
            question_trans : {default: 'Question'},
            option_trans : {default: 'Option'},
            picture_trans : {default: 'Picture'},
            select_type_trans : {default: 'Select type'},
            select_one_trans : {default: 'Select one'},
            select_multiple_trans : {default: 'Select multiple'},
            answer_options_trans : {default: 'Answer options'},
            add_option_trans : {default: 'Add option'}
        },

        data : function() {
            return {
                question : '',
                type : '',
                answer_options_json : '[]',
                field_id : 0,
                image_small : false,
                image_large : false,
                image_id : 0,
            };
        },

        methods: {
            deletePicture: function () {
                this.image_small = '';
                this.image_large = '';
            }
        },

        mounted() {
            var fields = JSON.parse(this.fields_json);
            if (fields.length == 1) {
                var field = fields[0];
                this.type = field.type;
                this.field_id = field.field_id;
                this.question = field.options.question;

                var answer_options = [];

                if (field.options.options != undefined) {
                    for(var j = 0; j < field.options.options.length; j++) {
                        answer_options.push({'value' : field.options.options[j]});
                    }
                }

                this.answer_options_json = JSON.stringify(answer_options);

                if (field.image_small != undefined && field.image_large != undefined) {
                    this.image_small = field.image_small;
                    this.image_large = field.image_large;
                    this.image_id = field.image_id;
                }
            }
        }
	}
</script>