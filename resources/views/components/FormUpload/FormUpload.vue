<template>

    <div class="FormUpload" :class="isclasses">

        <input type="file" :name="name" />
        
    </div>
    
</template>

<script>

	export default {

        props : {
            isclasses : {default: ''},
            name : {default: ''}
        },

    }

</script>