<template>

    <div class="promotion-slider">
        <div class="promotion-counter-container">
            <div class="promotion-line-background">
                <div class="promotion-line-striped"></div>

                <div class="circle-container">
                    <div class="circle">
                        <p>44000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle">
                        <p>45000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle">
                        <p>46000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle">
                        <p>47000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle">
                        <p>48000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle">
                        <p>49000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle">
                        <p>50000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle">
                        <p>51000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-backpack"></use>
                        </svg>
                    </div>
                    <div class="circle last">
                        <p>52000</p>
                        <svg>
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="#icon-tickets"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    export default {
        props: {
            isclasses: { default: '' },
            placeholder: { default: '' },
            route: { default: '' },
        },
        data: () => (
            {
                totalPageLikes: null,
                startValue: 44000,
                endValue: 52000,
                step: 1000,
                values: []
            }
        ),
        methods: {
            getCircleValues: function (event) {
                for (var i = this.startValue; i <= this.endValue; i+=this.step) {
                    this.values.push(i);
                }

                return this.values;
            }
        },
        mounted: function() {

            var self = this;

            window.fbAsyncInit = function() {

                FB.init({
                    appId      : '1675459002689506',
                    xfbml      : true,
                    version    : 'v2.8'
                });

                FB.api(
                    "https://graph.facebook.com/tripeeee?fields=likes,fan_count&summary=true&access_token=EAAXz0jKw5ZBIBAN9zYFYEWo6TaZCOhiDKSzdlzcFqhDit3RiJvpIw3Sx5stxvEauH3c7KoxFfyuBZA0D5NMaqBHdy0yHfWmSWEVDs1hcVm7YvdJKu2TZBvrv9YHWWyIQ0i6JWajAZB25EINfKrJ3ng3ANUxadu6sZD",
                    function (response) {
                        if (response && !response.error) {
                            self.totalPageLikes = response.fan_count;

                            var circles = document.querySelectorAll('.circle-container .circle');
                            Array.prototype.forEach.call(circles, function(element, index) {
                                var circleP = element.querySelector('p');
                                var p = circleP.textContent;
                                if (p <= self.totalPageLikes) {
                                    element.classList.add("bordered");
                                }
                            });

                            var like2go = self.endValue - self.totalPageLikes;
                            var diff = self.endValue - self.startValue;
                            var res = 100 - ((like2go / diff) * 100);
                            var progressBar = document.querySelector('.promotion-line-striped');
                            progressBar.style.width = res+"%";
                        }
                    }
                );
            };

        }
    }

</script>
