<template>

    <div class="PhotoCard" :class="isclasses" v-show="status_value">

        <img class="PhotoCard__photo" :src="small" @click="onClick" />

        <div class="PhotoCard__status Tag" v-show="edit_status" @click="onStatusChange">
            <a href="#"><div class="PhotoCard__status-button"> {{ button_title }} </div></a>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        small: { default: '' },
        large: { default: '' },
        meta: { default: '' },
        auto_show: { default: '' },
        edit_status: { default: false },
        photo_id: { default: null },
        status: { default: 1 },
        button_title: { default: '' }
    },

    data: function() {
        return {
            status_value: this.status
        }
    },

    methods: {
        onClick() {
            if (this.large) {
                this.$events.$emit('photo', {
                    large: this.large,
                    meta: this.meta
                })
            }
        },
        onStatusChange(event) {
            event.preventDefault()
            const new_status = this.status ? 0 : 1
            this.$http
                .post(
                    'content/photo/' +
                        this.photo_id +
                        '/status/' +
                        new_status
                )
                .then(
                    () => {
                        this.status_value = 0
                    },
                    function() {}
                )
        }
    },

    mounted() {
        if (this.auto_show) {
            this.onClick()
        }
    }
}
</script>
