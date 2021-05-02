<template>
    <div class="TravelOfferSubscriptionPlan" :class="isclasses">
        <div class="TravelOfferSubscriptionPlan__title">Sinu pakett</div>
        <div class="TravelOfferSubscriptionPlan__content">
            <div class="TravelOfferSubscriptionPlan__plan">
                <div class="TravelOfferSubscriptionPlan__plan__info">
                    <div class="TravelOfferSubscriptionPlan__plan__info__name">
                        <span>1</span>
                        <span class="TravelOfferSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="TravelOfferSubscriptionPlan__plan__info__price">
                        <span>15€</span>
                    </div>
                </div>
            </div>

            <div class="TravelOfferSubscriptionPlan__plan">
                <div class="TravelOfferSubscriptionPlan__plan__status">
                    <Tag title="aktiivne"
                         isclasses="Tag--green Tag--large"/>
                </div>
                <div class="TravelOfferSubscriptionPlan__plan__info">
                    <div class="TravelOfferSubscriptionPlan__plan__info__name">
                        <span>3</span>
                        <span class="TravelOfferSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="TravelOfferSubscriptionPlan__plan__info__price">
                        <span>35€</span>
                    </div>
                </div>
            </div>

            <div class="TravelOfferSubscriptionPlan__plan">
                <div class="TravelOfferSubscriptionPlan__plan__info">
                    <div class="TravelOfferSubscriptionPlan__plan__info__name">
                        <span>5</span>
                        <span class="TravelOfferSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="TravelOfferSubscriptionPlan__plan__info__price">
                        <span>50€</span>
                    </div>
                </div>
            </div>

            <div class="TravelOfferSubscriptionPlan__plan">
                <div class="TravelOfferSubscriptionPlan__plan__info">
                    <div class="TravelOfferSubscriptionPlan__plan__info__name">
                        <span>10</span>
                        <span class="TravelOfferSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="TravelOfferSubscriptionPlan__plan__info__price">
                        <span>80€</span>
                    </div>
                </div>
            </div>

            <div class="TravelOfferSubscriptionPlan__plan">
                <div class="TravelOfferSubscriptionPlan__plan__info">
                    <div class="TravelOfferSubscriptionPlan__plan__info__name">
                        <span>10+</span>
                        <span class="TravelOfferSubscriptionPlan__plan__info__name__month">/kuus</span>
                    </div>
                    <div class="TravelOfferSubscriptionPlan__plan__info__price">
                        <span>Võta ühendust</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Tag from '../../views/components/Tag/Tag.vue'
export default {
    components: {Tag},
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