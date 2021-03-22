<template>
    <div class="FormDatepicker" :class="{ 'FormDatepicker--error': errors.length, [isclasses]: true }">
        <label :for="name" class="FormDatepicker__label" v-if="title">{{ title }}</label>

        <VueDatePicker
            v-model="date"
            :name="name"
            :placeholder="placeholder"
            format="DD.MM.YYYY"
            :clearable="true"
            :noHeader="true"
            :locale="locale"
            :disabled="disabled"
            :minDate="this.disablePastDates ? new Date(new Date().setDate(new Date().getDate()-1)) : null"
            :onChange="this.$emit('input', this.date)"
        />

    </div>
</template>

<script>
    import locale from './locale/et';
    export default {
        props: {
            isclasses: { default: '' },
            name: { default: '' },
            title: { default: '' },
            value: { default: null },
            placeholder: { default: '' },
            errors: { type: Array, default: () => [] },
            disabled: { default: false },
            disablePastDates: { default: false }
        },

        data: function () {
            return {
                date: null,
                locale,
            }
        },
        computed: {
            /*isError() {
                return this.errors.includes(this.name)
            },*/
            formattedDate() {
                if (this.value) {
                    if (this.$moment(this.value, 'YYYY-MM-DD', true).isValid()) {
                        return this.value;
                    } else if (this.$moment(this.value, 'DD.MM.YYYY', true).isValid()) {
                        return this.$moment(this.value, 'DD.MM.YYYY').format('YYYY-MM-DD')
                    }
                }

                return null
            }
        },
        created: function () {
            this.date = this.formattedDate;
        }
    }
</script>
