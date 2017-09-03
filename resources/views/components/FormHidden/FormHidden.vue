<template>

    <input type="hidden" :name="name" :value="value">

</template>

<script>

	export default {

        props : {
            name : {default : ''},
            value : {default : ''}
        },
    }

</script>