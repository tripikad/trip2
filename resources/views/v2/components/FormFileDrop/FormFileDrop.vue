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
            isclasses: { default: ''},
            name: { default: 'image'},
            reload: { default: ''}
        },

        mounted() {

            new Dropzone(this.$refs.dropzone, {
                url: this.$globalProps.formfiledroproute,
                paramName: this.name,
                maxFileSize: this.$globalProps.maxfilesize,
                acceptedFiles: 'image/*',
                maxFiles: 1,
                headers: {'X-CSRF-TOKEN': this.$globalProps.token},
                dictDefaultMessage: this.$globalProps.formfiledroptitle,
                success: (file, res) => {
                    this.$events.$emit('formfiledrop.created')
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
