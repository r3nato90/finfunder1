@if($hoory->status == \App\Enums\Status::ACTIVE)
    <script>
        "use strict";
        window.hoorySettings = {"position":"right","type":"standard","launcherTitle":"Chat with us"};
        (function(d,t) {
            const BASE_URL = "https://app.hoory.com";
            const g = d.createElement(t), s = d.getElementsByTagName(t)[0];
            g.src=BASE_URL+"/packs/js/sdk.js";
            g.defer = true;
            g.async = true;
            s.parentNode.insertBefore(g,s);
            g.onload=function(){
                window.hoorySDK.run({
                    websiteToken: {{getArrayValue($hoory?->short_key, 'api_key')}},
                    baseUrl: BASE_URL
                })
            }
        })(document,"script");
    </script>
@endif