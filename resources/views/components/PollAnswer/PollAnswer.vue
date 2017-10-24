<template>

    <div ref="answer_div">

        <div class="margin-bottom-md PollAnswer__title">
            {{question}}
        </div>

        <div class="margin-bottom-md PollAnswer__title">
            <component
                is="PhotoCard"
                v-if="image_small && image_large"
                :small="image_small"
                :large="image_large"
            >
            </component>
        </div>
    
        <div v-if="displayed_results.length == 0">

            <div class="margin-bottom-md PollAnswer__radio">

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

            <div class="margin-bottom-md PollAnswer__error" v-if="error">
                {{ error }}
            </div>

            <div class="margin-bottom-md">

                <component
                    v-on:click.native.once="answer"
                    is="Button"
                    :title="answer_trans"
                    route="javascript:;"
                >
                </component>

            </div>

        </div>
        
        <div class="margin-bottom-md" v-else>

            <component
                is="Barchart"
                :items="displayed_results"
                :width="result_width"
                isclasses="Barchart--black Barchart--block"
            >
            </component>

        </div>

        <div class="PollAnswer__count">

            {{ count_trans }}: {{ displayed_count }}

        </div>

    </div>

</template>

<script>

    import Barchart from '../Barchart/Barchart.vue'
    import Button from '../Button/Button.vue'
    import PhotoCard from '../PhotoCard/PhotoCard.vue'

    export default {

        components : {
            Barchart,
            Button,
            PhotoCard
        },

        props : {
            options : {default : ''},
            type : {default : ''},
            answer_trans : {default : ''},
            id : {default : 0},
            select_error : {default : ''},
            save_error : {default : ''},
            image_small : {default : ''},
            image_large : {default : ''},
            results : {default : []},
            count_trans : {default : ''},
            count : {default: ''}
        },
        
        data : function() {
            return {
                answer_options : [],
                question : '',
                checked : [],
                error : '',
                displayed_results : [],
                displayed_count : 0,
                result_width : 0
            };
        },

        methods: {
            answer: function () {
                if (this.checked.length == 0) {
                    this.error = this.select_error;
                    return;
                }
                
                this.$http.post('/poll/answer', {'id' : this.id, 'values' : this.checked})
                    .then(function(res) {
                        this.displayed_count = res.body.count;
                        this.displayed_results = res.body.result;
                    },function (res) {
                        this.error = this.save_error;
                    })
            }
        },

        mounted() {
            this.result_width = this.$refs.answer_div.clientWidth - 12;
            this.displayed_results = this.results;
            this.displayed_count = this.count;
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