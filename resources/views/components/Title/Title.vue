<template>

    <div class="Title" :class="isclasses">

        <a :href="route" v-if="route != ''">

            <h2 class="Title__title">

            {{ title }}

            </h2>

        </a>

        <h2 class="Title__title" v-else>

        {{ title }}

        </h2>

    </div>

</template>

<script>

	export default {

        props : {
            route : {default: ''},
            title : {default: ''},
            isclasses : {default: ''}
        }

	}

</script>