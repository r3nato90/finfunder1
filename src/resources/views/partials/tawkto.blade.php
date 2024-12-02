@if($tawkto?->status == \App\Enums\Status::ACTIVE->value)
    <script>
        "use strict";
        const Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function(){
            const s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/{{getArrayValue($tawkto?->short_key, 'api_key')}}';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
@endif



