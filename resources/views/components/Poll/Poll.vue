<template>

    <div class="margin-bottom-md margin-top-lg Poll__container" v-if="poll">

        <div class="Poll__title">
            {{poll.question}}
        </div>

        <div class="Poll__content" :class="[this.submitting ? 'Poll__submitting' : '']">

            <div v-if="!results.length">
                <div class="Poll__option" v-for="opt in poll.poll_options">

                    <input
                        type="radio"
                        class="Poll__input"
                        name="poll_answer"
                        :id="`poll_option_${opt.id}`"
                        :value="opt.id"
                        v-model="checked"
                        :disabled="submitting"
                        v-on:change="answer"
                    />

                    <label
                        class="Poll__label"
                        :for="`poll_option_${opt.id}`"
                    >
                        {{ opt.name }}
                    </label>

                </div>
            </div>

            <div v-else>
                <Barchart :items="results"/>

                <div class="Poll__count">
                    Vastanuid: {{ poll.answered }}
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import Barchart from '../Barchart/Barchart.vue'
    export default {
        components : {
            Barchart
        },
        props : {
            front_page : {default : false},
            id : {default : null},
            read_only : {default : false} //todo: not implemented
        },

        data : function() {
            return {
                poll: null,
                results: [],
                checked : null,
                submitting: false
            };
        },
        methods: {
            answer: function () {

                if (this.checked) {
                    this.submitting = true;

                    this.$http.post('/api/poll/' + this.poll.id + '/answer', {'value' : this.checked})
                        .then(res => {
                            this.poll = res.data.poll;
                            this.results = res.data.results;
                            this.submitting = false;

                        })
                        .catch(error => {
                            this.poll = null;
                        });
                }
            }
        },
        created() {
            let url = '/api/poll/front_page';
            if (this.id) {
                url = '/api/poll/' + this.id;
            }

            this.$http.get(url)
                .then(res => {
                    this.poll = res.data.poll;
                    if (res.data.results) {
                        this.results = res.data.results;
                    }
                })
                .catch(error => {
                    this.poll = null;
                });
        }
    }
</script>