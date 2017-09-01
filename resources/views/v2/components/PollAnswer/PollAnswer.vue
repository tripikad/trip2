<template>

    <div>

        <div class="margin-bottom-md PollAnswer__title">
            {{question}}
        </div>

        <div class="margin-bottom-md">
            <div class="PollAnswer__radio">

                <div class="PollAnswer__option" v-for="opt in answer_options">

                    <div>

                        <input
                            v-if="type == 'checkbox'"
                            type="checkbox"
                            class="PollAnswer__input"
                            :id="opt.id"
                            name="poll_answer"
                            :value="opt.id"
                            v-model="checked"
                        />
                        
                        <input
                            v-if="type == 'radio'"
                            type="radio"
                            class="PollAnswer__input"
                            :id="opt.id"
                            name="poll_answer"
                            :value="opt.id"
                            v-model="checked"
                        />

                    </div>

                    <label
                        class="PollAnswer__label"
                        :for="opt.id"
                    >
                        {{ opt.name }}
                    </label>

                </div>

            </div>
        </div>

        <div class="margin-bottom-md">

            <component
                v-on:click.native="answer"
                is="Button"
                :title="answer_trans"
                route="javascript:;"
            >
            </component>

        </div>

    </div>

</template>

<script>

    import Alert from '../Alert/Alert.vue'
    import Button from '../Button/Button.vue'

    export default {

        components : {
            Alert,
            Button
        },

        props : {
            options : {default : ''},
            type : {default : ''},
            answer_trans : {default : ''},
            id : {default : 0}
        },
        
        data : function() {
            return {
                answer_options : [],
                question : '',
                checked : []
            };
        },

        methods: {
            answer: function () {
                this.$http.post('/poll/answer', {'id' : this.id, 'values' : this.checked})
                    .then(res => {
                        console.log(res);
                    })
            }
        },

        mounted() {
            this.question = this.options.question;
            var opts = this.options.options;
            for (var i = 0; i < opts.length; i++) {
                this.answer_options.push({
                    'id' : opts[i],
                    'name' : opts[i]
                });
            }
        }
    }

</script>