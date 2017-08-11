<template>
    <a :href="route" :target="target">

        <div class="Button" :class="isclasses">

            <div v-if="icon != ''" class="Button__icon">

                <component 
                    is="Icon"
                    isclasses="white"
                    :icon="icon"
                >
                </component>

            </div>

            <div class="Button__title">

                {{ title }}

            </div>

        </div>

    </a>
</template>

<script>
        
	export default {
        
        props : {
            route : {default: ''},
            icon : {default: ''},
            title : {default: ''},
            isclasses : {default: ''},
            target : {default: ''}
        }
	}
    
</script>