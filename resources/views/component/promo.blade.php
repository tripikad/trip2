{{--

title: Promo / Ad

code: |

    @include('component.promo', [
        'modifiers' => '',
        'route' => '',
        'image' => '',
    ])

modifiers:

- m-sidebar-large
- m-sidebar-small
- m-footer
- m-body

--}}


@if (isset($promo) && $promo)
<div id='{{ config("promo.$promo.id2") }}' style='width:{{ config("promo.$promo.width") }}px; height:{{ config("promo.$promo.height") }}px;'>
    <script type='text/javascript'>
    window.onload = function(e){ 
        googletag.cmd.push(function() { googletag.display('{{ config("promo.$promo.id2") }}'); });
    }
    </script>
</div>
@endif

