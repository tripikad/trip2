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
            :question_trans="question_trans"
            :option_trans="option_trans"
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
            question_trans : {default : 'Question'},
            option_trans : {default : 'Option'}
        },
        
        components : {
            'poll' : PollFields,
            'quiz' : QuizFields
        },
        
        data : function() {
            return {
                options: [
                    {'id' : 'poll', 'name' : 'Küsitlus'},
                    {'id' : 'quiz', 'name' : 'Viktoriin'}
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