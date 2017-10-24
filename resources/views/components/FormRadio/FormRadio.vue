<template>

    <div class="FormRadio" :class="isclasses">

        <div class="FormRadio__option" v-for="opt in options">

            <input
                class="FormRadio__input"
                type="radio"
                :id="opt.id"
                :name="name"
                :value="opt.id"
                :checked="opt.id == value"
                v-on:change="$emit('change', $event.target.value)"
            />

            <label
                class="FormRadio__label"
                :for="opt.id"
            >
                {{ opt.name }}
            </label>

        </div>

    </div>

</template>

<script>

	export default {
        
        props : {
            options : {default: []},
            name : {default: ''},
            isclasses : {default: ''},
            value : {default: ''}
        }
	}

</script>