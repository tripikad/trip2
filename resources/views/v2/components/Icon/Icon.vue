<template>

    <svg
        class="Icon"
        :class="isclasses"
        :style="style"
    >
        <use xlink:href="#{{ icon }}"></use>

    </svg>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            size: { default: 'md' },
            width: { default: 0 },
            height: { default: 0 },
            icon: { default: '' }
        },

        computed: {
            style: function() {
                var sizes = { sm: 14, md: 18, lg: 32, xl: 48 }

                if (this.width && this.height) {
                    return {
                        width: this.width,
                        height: this.height
                    }
                }

                return {
                    width: sizes[this.size],
                    height: sizes[this.size]
                }
            }
        }

    }

</script>