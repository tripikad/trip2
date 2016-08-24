<template>

    <div
        v-el:dropzone
        class="ImageUpload dropzone"
        :class="isclasses"
    >
    </div>

</template>

<script>

    import Dropzone from 'dropzone'

    export default {

        props: {
            msgdefault: { default: '' },
            msgfallback:  { default: '' },
            txtfallback: { default: '' },
            msgfiles: { default: '' },
            msgsize: { default: '' },
            msgremove: { default: '' }
        },

        ready: function() {
            const globalProps = JSON.parse(decodeURIComponent(
                document.querySelector('#globalprops').getAttribute('content')
            ))

            Dropzone.autoDiscover = false

            new Dropzone(this.$els.dropzone, {
                url: '/v2/image/store',
                paramName: 'image',
                maxFileSize: globalProps.maxfilesize,
                uploadMultiple: false,
                acceptedFiles: 'image/*',
                maxFiles: 1,
                dictDefaultMessage: this.msgdefault,
                dictFallbackMessage: this.msgfallback,
                dictFallbackText: this.txtfallback,
                dictMaxFilesExceeded: this.msgfiles,
                dictFileTooBig: this.msgsize,
                dictRemoveFile: this.msgremove,
                headers: {'X-CSRF-TOKEN': globalProps.token},
                success: function(file, res) {
                    this.$dispatch('showAlert', res.image + ' uploaded')
                }.bind(this)

            }).on('complete', function(file) {
                this.removeFile(file)
            })
        }

    }

</script>
