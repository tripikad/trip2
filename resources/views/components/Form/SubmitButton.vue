<template>
    <button class="FormSubmitButton" :class="isclasses" type="submit">
        {{title}}
    </button>
</template>

<script>

export default {
    props: {
        isclasses: { default: '' },
        title: {
            required: true,
            type: String,
        },
    }
};
</script>
