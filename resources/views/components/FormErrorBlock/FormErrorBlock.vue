<template>
    <div class="HeaderError" :class="{ [isclasses]: true }" v-if="hasErrors">
        <div class="HeaderError__title" v-for="(error, index) in errorsFromObject">
            {{error}}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        errors: Object,
    },
    computed: {
        hasErrors: function() {
            return Object.keys(this.errors).length
        },
        errorsFromObject: function() {
            let errors = []
            Object.keys(this.errors).map((errorKey, index) => {
                this.errors[errorKey].map((error, key) => {
                    errors.push(error)
                })
            })

            return errors
        }
    }
}
</script>
