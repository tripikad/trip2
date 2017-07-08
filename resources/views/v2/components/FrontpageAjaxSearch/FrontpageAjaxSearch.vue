<template>

    <div class="FrontpageAjaxSearch" :class="isclasses">

        <div class="FrontpageAjaxSearch__search">
            <input type="text" autocomplete="off" :placeholder="placeholder" class="FrontpageAjaxSearch__input"
                v-model="query"
                v-on:keyup="keymonitor">

            <div class="FrontpageAjaxSearch__icon" @click="redirect">
                <component is="Icon" icon="icon-search" size="lg"></component>
            </div>

            <div class="FrontpageAjaxSearch__loading" v-show="loading"></div>
        </div>

        <div class="FrontpageAjaxSearch__results">
            <component v-for="(result, index) in results" is="SearchRow" :result="result" :index="index"></component>
        </div>

    </div>

</template>

<script>
    import Icon from '../Icon/Icon.vue'
    import SearchRow from '../FrontpageAjaxSearchRow/FrontpageAjaxSearchRow.vue'

    export default {
        props: {
            isclasses: { default: '' },
            options: { default: [] },
            placeholder: { default: '' },
            route: { default: '' },
        },
        components: { Icon, SearchRow },
        data: () => (
            {
                results: [],
                query: '',
                loading: false,
                lastRequest: null,
                enterPressed: false,
                lastKeyword: '',
                searchTimeout: null,
            }
        ),
        methods: {
            keymonitor: function(event) {
                if (event.key == 'Enter') {
                    this.redirect();
                } else if (['F1', 'F2', 'F3', 'F4', 'F5',
                            'F6', 'F7', 'F8', 'F9', 'F10',
                            'F11', 'F12', 'Shift', 'Alt',
                            'Meta', 'Control'].indexOf(event.key) === -1) {
                    this.search();
                }
            },
            redirect: function() {
                this.loading = true
                this.enterPressed = true
                window.location = '/search?q=' + this.query
                return false
            },
            search: function() {
                this.loading = true
                if (this.searchTimeout) {
                    clearTimeout(this.searchTimeout)
                    this.searchTimeout = null
                }

                this.searchTimeout = setTimeout(() => { this.performSearch() }, 150);
            },
            performSearch: function() {
                if (this.query && this.query != '' && String(this.query).length > 2 && ! this.enterPressed) {
                    if (this.query != this.lastKeyword) {
                        this.$http
                            .get('/search/ajaxsearch/?q=' + this.query, {
                                before: function (xhr) {
                                    if (this.lastRequest) {
                                        this.lastRequest.abort()
                                    }

                                    this.lastRequest = xhr
                                }
                            }).then(
                                (res) => {
                                    this.results = res.data
                                    this.loading = false
                                }, function(error) {
                                    this.results = []
                                    this.loading = false
                                }
                            )
                    }
                    this.lastKeyword = this.query;
                } else {
                    if (this.lastRequest) {
                        this.lastRequest.abort()
                    }

                    this.results = []
                    this.loading = false
                }
            }
        }
    }

</script>
