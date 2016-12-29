<template>

    <div
        ref="dropzone"
        class="ImageUpload dropzone"
        :class="isclasses"
    >
    </div>

</template>

<script>

    import Dropzone from 'dropzone'

    export default {

        props: {
            dictdefaultmessage: { default: '' },
            dictfallbackmessage: { default: '' },
            dictfallbacktext: { default: '' },
            dictmaxfilesexceeded: { default: '' },
            dictfiletoobig: { default: '' },
            dictremovefile: { default: '' }
        },

        mounted() {
            const globalProps = JSON.parse(decodeURIComponent(
                document.querySelector('#globalprops').getAttribute('content')
            ))

            Dropzone.autoDiscover = false

            new Dropzone(this.$refs.dropzone, {
                url: '/v2/image/store',
                paramName: 'image',
                maxFileSize: globalProps.maxfilesize,
                uploadMultiple: false,
                acceptedFiles: 'image/*',
                maxFiles: 1,
                dictDefaultMessage: this.dictdefaultmessage,
                dictFallbackMessage: this.dictfallbackmessage,
                dictFallbackText: this.dictfallbacktext,
                dictMaxFilesExceeded: this.dictmaxfilesexceeded,
                dictFileTooBig: this.dictfiletoobig,
                dictRemoveFile: this.dictremovefile,
                headers: {'X-CSRF-TOKEN': globalProps.token},
                success: function(file, res) {
                    this.$events.$emit('showAlert', res.image + ' uploaded')
                }.bind(this)

            }).on('complete', function(file) {
                this.removeFile(file)
            })
        }

    }

</script>
