<template>

    <div class="FrontpageSearch" :class="isclasses">

        <div class="FrontpageSearch__search">
            <input type="text" autocomplete="off" :placeholder="placeholder" class="FrontpageSearch__input"
                v-model="query"
                @keyup="keymonitor"
                @blur="blurMonitor">

            <div class="FrontpageSearch__icon" @click="redirect">
                <component :is="Icon" icon="icon-search" size="lg"></component>
            </div>

            <div class="FrontpageSearch__loading" v-show="loading"></div>
        </div>

        <div class="FrontpageSearch__results" v-if="showResultContainer" @mousedown="blurMonitorPrevent">
            <component v-for="(result, index) in results" :is="SearchRow" :result="result" :key="index" :index="index"></component>
        </div>

    </div>

</template>

<script>
import Icon from '../Icon/Icon.vue'
import SearchRow from '../FrontpageSearchRow/FrontpageSearchRow.vue'

export default {
    props: {
        isclasses: { default: '' },
        options: { default: [] },
        placeholder: { default: '' },
        route: { default: '' }
    },
    components: { Icon, SearchRow },
    data: () => ({
        results: [],
        query: '',
        loading: false,
        lastRequest: null,
        enterPressed: false,
        lastKeyword: '',
        searchTimeout: null,
        showResultContainer: true
    }),
    methods: {
        keymonitor: function(event) {
            if (event.key == 'Enter') {
                this.redirect()
            } else if (this.query != this.lastKeyword) {
                this.search()
            }
        },
        blurMonitor: function() {
            this.showResultContainer = false
        },
        blurMonitorPrevent: function(event) {
            event.preventDefault()
        },
        redirect: function() {
            this.loading = true
            this.enterPressed = true
            window.location = '/search?q=' + this.query
            return false
        },
        search: function() {
            this.showResultContainer = true
            this.loading = true
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout)
                this.searchTimeout = null
            }

            this.searchTimeout = setTimeout(() => {
                this.performSearch()
            }, 150)
        },
        performSearch: function() {
            if (
                this.query &&
                this.query != '' &&
                String(this.query).length > 2 &&
                !this.enterPressed
            ) {
                if (this.query != this.lastKeyword) {
                    this.$http
                        .get(
                            '/search/ajaxsearch/?q=' +
                                this.query +
                                '&_t=' +
                                Date.now(),
                            {
                                before: function(xhr) {
                                    if (this.lastRequest) {
                                        this.lastRequest.abort()
                                    }

                                    this.lastRequest = xhr
                                }
                            }
                        )
                        .then(
                            res => {
                                this.results = res.data
                                this.loading = false
                            },
                            function() {
                                this.results = []
                                this.loading = false
                            }
                        )
                }
                this.lastKeyword = this.query
            } else {
                if (this.lastRequest) {
                    this.lastRequest.abort()
                }

                this.results = []
                this.loading = false
                this.lastKeyword = ''
            }
        }
    }
}
</script>
