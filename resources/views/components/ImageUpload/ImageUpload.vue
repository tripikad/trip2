<template>
    <div class="ImageUpload dropzone" ref="dropzone" :class="isclasses"></div>
</template>

<script>
import Dropzone from 'dropzone'

Dropzone.autoDiscover = false

export default {
    props: {
        isclasses: { default: '' },
        name: { default: 'image' },
        reload: { default: false },
        url: { default: '' },
        autoUpload: { default: true },
    },

    mounted() {
        const _this = this;

        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: this.url,
            autoProcessQueue: this.autoUpload,
            paramName: this.name,
            maxFileSize: this.$globalProps.maxfilesize,
            acceptedFiles: '.jpeg,.jpg,.png',
            addRemoveLinks: true,
            maxFiles: 1,
            headers: {
                'X-CSRF-TOKEN': this.$globalProps.token
            },
            dictDefaultMessage: this.$globalProps.imageUploadTitle
        });

        this.dropzone.on('complete', function(file) {
            if (_this.autoUpload !== false) {
                this.removeFile(file)
            }
        });

        this.dropzone.on('success', function(file, response) {
            _this.$events.$emit('imageupload.success', file)
            if (_this.reload === true) {
                window.location.reload(true)
            }
        });

        this.dropzone.on('removedfile', function(file) {
            _this.$events.$emit('imageupload.remove_file', file)
        });

        this.dropzone.on('thumbnail', function(file, dataUrl) {
            if (_this.autoUpload === false) {
                this.emit('success', file)
                this.emit('complete', file)
            }
        });
    }
}
</script>
