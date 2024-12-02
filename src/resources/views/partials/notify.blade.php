@if (session()->has('notify'))
    @foreach (session('notify') as $message)
        <script>
            "use strict";
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["{{$message[0]}}"]("{{$message[1]}}");
        </script>
    @endforeach
@endif

@if ($errors->any())
    @php
        $errors = $errors->unique();
    @endphp

    @foreach ($errors as $message)
        <script>
            "use strict";
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.error("{{$message}}");
        </script>
    @endforeach
@endif

<script>
    "use strict";
    function notify(status, message) {
        toastr[status](message);
    }
</script>
