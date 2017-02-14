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
            route: { default: ''},
            name: { default: ''},
            title: { default: ''},
            reload: { default: ''}
        },

        mounted() {

            new Dropzone(this.$refs.dropzone, {
                url: this.route,
                paramName: this.name,
                maxFileSize: this.$globalProps.maxfilesize,
                acceptedFiles: 'image/*',
                maxFiles: 1,
                headers: {'X-CSRF-TOKEN': this.$globalProps.token},
                dictDefaultMessage: this.title,
                success: (file, res) => {
                    this.$events.$emit('formfiledrop.created')
                    if (this.reload === 'true') {
                        //window.location.reload(true)
                    }
                }
            }).on('complete', function(file) {
                // Need to use longer callback syntax to access Dropzone this
                this.removeFile(file)
            })

        }

    }

</script>
