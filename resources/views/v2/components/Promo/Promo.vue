<template>

    <div
        class="Promo"
        :class="isclasses"
        :style="{paddingBottom: ratio + '%'}">
        
        <iframe
            class="Promo__iframe"
            src="/photos/social.jpg"
            frameborder='0'
        ></iframe>
    
    </div>

</template>

<script>

    const globalProps = JSON.parse(decodeURIComponent(
        document.querySelector('#globalprops').getAttribute('content')
    ))

    export default {

        props: {
            isclasses: { default: '' },
            promo: { default: 'sidebar_small' }
        },

        computed: {
            ratio: function() {
                return (globalProps.promo[this.promo].height /
                    globalProps.promo[this.promo].width) * 100
            }
        }

    }

</script>
