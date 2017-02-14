<template>

    <div
        class="FormFileDrop dropzone"
        ref="dropzone"
        :class="isclasses"
    >
    </div>

</template>

<script>

    import Dropzone from 'dropzone'

    Dropzone.autoDiscover = false

    export default {

        props: {
        },

        mounted() {

            new Dropzone(this.$refs.dropzone, {
                url: '/admin/image',
                paramName: 'image',
                maxFileSize: 15,
                acceptedFiles: 'image/*',
                maxFiles: 1,
                headers: {'X-CSRF-TOKEN': globalProps.token},
                success: (file, res) => {
                    this.$events.$emit('formfiledrop.created')
                    this.$events.$emit('alert', res.image + ' uploaded')
                }

            })
        }

    }

</script>
