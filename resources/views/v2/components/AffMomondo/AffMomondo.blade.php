<div
    id="mmd-flight-widget"
    style="width: 100%; display: inline-block; min-height: 215px;"
>
</div>

@push('scripts')

<script>
    
    (function initWidget(options)
    {
        var settings = options.settings;
        var airports = options.airports;
        var encoding = '';
        onFlightWidgetLoaded = function (f)
        {
            f('mmd-flight-widget', {
                searchForms: [{
                    type: 1,
                    searchURL: 'http://[DOMAIN]/flightsearch/[QUERY]' + (!!settings.source ? '&source=' + settings.source : '') +"&utm_source=tripee&utm_medium=affiliate&utm_campaign=widget",
                    openNewWindow: settings.openNewWindow,
                    currency: "EUR",
                    segments: [
                        {
                            airports: [
                                { code: airports.origin || '' },
                                { code: airports.destination || '' }
                            ]
                        },
                        {
                            airports: [
                                { code: airports.destination || '' },
                                { code: airports.origin || '' }
                            ]
                        }
                    ]
                }]
            });
        };
        var scr = document.createElement('script');
        scr['src'] = 'http://' + settings.domain + '/widget/searchform/v1.1/?encoding=' + encoding + '&dimensions=generic&types=1&callback=onFlightWidgetLoaded';
        var tag = document.getElementsByTagName('head');
        if (tag &&
                tag.length)
        {
            tag = tag[0];
            tag.appendChild(scr);
        }
    })(
            {
                airports: {
                    origin: '',
                    destination: ''
                },
                settings: {
                    openNewWindow: true,
                    domain: 'www.momondo.ee',
                    source: ''
                }
            }
    );

</script>

@endpush