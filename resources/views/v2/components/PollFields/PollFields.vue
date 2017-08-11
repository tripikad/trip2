<template>
    <div>
        <div class="margin-bottom-md">

            <component
                is="FormTextfield"
                name="poll_question"
                :title="question_trans"
            >
            </component>

        </div>

        <div class="margin-bottom-md">

            <component
                is="PollOption"
                :option_trans="option_trans"
            >
            </component>
        </div>

        <div class="margin-bottom-md">
            <label class="FormTextfield__label">Pilt</label>

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

	export default {
        
        components : { FormTextfield, FormUpload, PollOption},

        props : {
            question_trans : {default: ''},
            option_trans : {default: ''}
        },

        data : function() {
            return {
            };
        },

        mounted() {
        }
	}
</script>