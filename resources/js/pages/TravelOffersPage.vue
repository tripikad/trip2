<template>
    <div>
        PAGE
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false,
        }
    },
    methods: {
        setLoading: function () {
            this.loading = !this.loading
        },
    },
}
</script>