<template>

    <div class="FormCheckbox" :class="isclasses">

        <input
            :id="name"
            :name="name"
            type="checkbox"
            :checked="val"
            class="FormCheckbox__checkbox"
            v-on:input="$emit('input', $event.target.value)"
        >

        <label :for="name" class="FormCheckbox__label">{{ title }}</label>

    </div>

</template>

<script>

    export default {
        
        props : {
            isclasses : {default : ''},
            name : {default : ''},
            title : {default : ''},
            val : {default : false}
        }
    
    }

</script>