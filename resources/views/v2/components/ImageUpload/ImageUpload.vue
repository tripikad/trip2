<template>

    <div
        class="ImageUpload dropzone"
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
            isclasses: { default: ''},
            name: { default: 'image'},
            reload: { default: ''}
        },

        mounted() {

            new Dropzone(this.$refs.dropzone, {
                url: this.$globalProps.imageUploadRoute,
                paramName: this.name,
                maxFileSize: this.$globalProps.maxfilesize,
                acceptedFiles: 'image/*',
                maxFiles: 1,
                headers: {'X-CSRF-TOKEN': this.$globalProps.token},
                dictDefaultMessage: this.$globalProps.imageUploadTitle,
                success: (file, res) => {
                    this.$events.$emit('imageupload.created')
                    if (this.reload === 'true') {
                        window.location.reload(true)
                    }
                }
            }).on('complete', function(file) {
                this.removeFile(file)
            })

        }

    }

</script>
