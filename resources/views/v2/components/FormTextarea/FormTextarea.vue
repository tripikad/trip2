<template>

    <div class="FormTextarea" :class="isclasses">

        <label v-if="title != ''" :for="name" class="FormTextarea__label">{{ title }}</label>

        <textarea
            class="FormTextarea__textarea"
            :id="name"
            :name="name"
            :rows="rows"
            :cols="cols"
            :placeholder="placeholder"
            :disabled="disabled"
        >{{ value }}</textarea>

    </div>

</template>

<script>

	export default {
        
        props : {
            name : {default: ''},
            title : {default: ''},
            isclasses : {default: ''},
            value : {default: ''},
            placeholder : {default: ''},
            disabled : {default: false},
            rows : 8,
            cols : 50
        }
	}

</script>