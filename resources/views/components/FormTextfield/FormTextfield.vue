<template>
    <div class="FormTextfield" :class="isclasses">

        <label 
            v-if="title != ''" 
            :for="name" 
            class="FormTextfield__label"
        >
            {{ title }}
        </label>

        <input
            class="FormTextfield__input"
            :id="name"
            :name="name"
            type="text"
            :size="size"
            :value="value"
            :placeholder="placeholder"
            :disabled="disabled"
            v-on:input="$emit('input', $event.target.value)"
        >

    </div>
</template>

<script>
        
	export default {
        
        props : {
            name : {default: ''},
            title : {default: ''},
            isclasses : {default: ''},
            value : {default: ''},
            size : {default: ''},
            placeholder : {default: ''},
            disabled : {default: false}
        }
	}
    
</script>