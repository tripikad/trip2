<template>
    <div class="VPSubscriptionPlan" :class="isclasses">
        <div class="VPSubscriptionPlan__title">Sinu pakett</div>
        <div class="VPSubscriptionPlan__content">
            <div class="VPSubscriptionPlan__plan">
                <div class="VPSubscriptionPlan__plan__info">
                    <div class="VPSubscriptionPlan__plan__info__name">
                        <span>1</span>
                        <span class="VPSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="VPSubscriptionPlan__plan__info__price">
                        <span>15€</span>
                    </div>
                </div>
            </div>

            <div class="VPSubscriptionPlan__plan">
                <div class="VPSubscriptionPlan__plan__status">
                    <div class="StatusTag StatusTag--active">
                        <div class="StatusTag__title">
                            Aktiivne
                        </div>
                    </div>
                </div>
                <div class="VPSubscriptionPlan__plan__info">
                    <div class="VPSubscriptionPlan__plan__info__name">
                        <span>3</span>
                        <span class="VPSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="VPSubscriptionPlan__plan__info__price">
                        <span>35€</span>
                    </div>
                </div>
            </div>

            <div class="VPSubscriptionPlan__plan">
                <div class="VPSubscriptionPlan__plan__info">
                    <div class="VPSubscriptionPlan__plan__info__name">
                        <span>5</span>
                        <span class="VPSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="VPSubscriptionPlan__plan__info__price">
                        <span>50€</span>
                    </div>
                </div>
            </div>

            <div class="VPSubscriptionPlan__plan">
                <div class="VPSubscriptionPlan__plan__info">
                    <div class="VPSubscriptionPlan__plan__info__name">
                        <span>10</span>
                        <span class="VPSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="VPSubscriptionPlan__plan__info__price">
                        <span>80€</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        isclasses: {default: ''},
        plans: {default: () => []},
        activePlan: {default: null},
        disabled: {default: false},
        submitRoute: null
    },
    data: function () {
        return {
            selectedPlan: {},
            submitting: false,
            success: false,
            errors: [],
        }
    },
    methods: {
        handleSubmit() {
            if (!this.submitting) {
                this.submitting = true;
                this.success = false;
                this.errors = {};
                this.$http.post(this.submitRoute, this.fields).then(response => {
                    this.fields = {};
                    this.success = true;
                    this.submitting = false;
                }).catch(error => {
                    this.submitting = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.keys
                        const errorTitle = error.response.data.errors.join('<br>')
                        this.$events.$emit('alert', {
                            title: errorTitle,
                            isType: 'error'
                        })
                    }
                });
            }
        },
    }
};
</script>