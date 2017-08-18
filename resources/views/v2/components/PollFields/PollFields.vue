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
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <component
                is="PollOption"
                name="poll_fields"
                :option_trans="option_trans"
                :select_type_trans="select_type_trans"
                :select_one_trans="select_one_trans"
                :select_multiple_trans="select_multiple_trans"
                :answer_options_trans="answer_options_trans"
                :add_option_trans="add_option_trans"
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <label class="FormTextfield__label">{{ picture_trans }}</label>

            <component
                is="FormUpload"
                name="poll_photo"
            >
            </component>

        </div>

    </div>

</template>

<script>

    import FormTextfield from '../FormTextfield/FormTextfield.vue'
    import FormUpload from '../FormUpload/FormUpload.vue'
    import PollOption from '../PollOption/PollOption.vue'
    import Title from '../Title/Title.vue'


	export default {
        
        components : {
            FormTextfield,
            FormUpload,
            PollOption,
            Title
        },

        props : {
            question_trans : {default: 'Question'},
            option_trans : {default: 'Option'},
            picture_trans : {default: 'Picture'},
            select_type_trans : {default: 'Select type'},
            select_one_trans : {default: 'Select one'},
            select_multiple_trans : {default: 'Select multiple'},
            answer_options_trans : {default: 'Answer options'},
            add_option_trans : {default: 'Add option'}
        }
	}
</script>