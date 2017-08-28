<template>

    <div>

        <div class="FormRadio margin-bottom-md">

            <div class="FormRadio__option" v-for="opt in options">

                <input
                    class="FormRadio__input"
                    type="radio"
                    :id="opt.id"
                    name="poll_type"
                    :value="opt.id"
                    :checked="opt.id == value"
                    @change="changeComponent"
                    v-model="pollType"
                />

                <label
                    class="FormRadio__label"
                    :for="opt.id"
                >
                    {{ opt.name }}
                </label>

            </div>

        </div>

        <component
            :is="pollType"
            :fields_json="fields_json"
            :question_trans="question_trans"
            :option_trans="option_trans"
            :picture_trans="picture_trans"
            :select_type_trans="select_type_trans"
            :select_one_trans="select_one_trans"
            :select_multiple_trans="select_multiple_trans"
            :answer_options_trans="answer_options_trans"
            :add_option_trans="add_option_trans"
        >
        </component>

    </div>

</template>

<script>
    import PollFields from '../PollFields/PollFields.vue'
    import QuizFields from '../QuizFields/QuizFields.vue'

	export default {
        props : {
            value : {default : ''},
            fields_json : {default : '[]'},
            question_trans : {default : 'Question'},
            option_trans : {default : 'Option'},
            poll_trans : {default : 'Poll'},
            quiz_trans : {default : 'Quiz'},
            picture_trans : {default : 'Photo'},
            select_type_trans : {default: 'Select type'},
            select_one_trans : {default: 'Select one'},
            select_multiple_trans : {default: 'Select multiple'},
            answer_options_trans : {default: 'Answer options'},
            add_option_trans : {default: 'Add option'}
        },
        
        components : {
            'poll' : PollFields,
            'quiz' : QuizFields
        },
        
        data : function() {
            return {
                options: [
                    {'id' : 'poll', 'name' : this.poll_trans},
                    {'id' : 'quiz', 'name' : this.quiz_trans}
                ],
                pollType: null
            };
        },
        
        methods: {
            changeComponent: function (event) {
                this.pollType = event.target.id;
            }
        },
		
        mounted() {
            this.pollType = this.value;
        }
	}
</script>