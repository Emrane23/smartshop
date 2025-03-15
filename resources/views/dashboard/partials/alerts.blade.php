<script>
    function alertToastr(message, alertType) {
        
        const toastrOptions = {
            timeOut: 10000,
            closeButton: true,
            progressBar: true
        };


        if (typeof toastr[alertType] === 'function' && alertType != 'error') {
            toastr[alertType](message, toastrOptions);

        } else {
            if (alertType == 'danger') {
                toastr.error(message, 'Error!', toastrOptions);
            } else {
                toastr.warning(message, 'Info', toastrOptions);
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if ($message = session('success'))
            alertToastr('{{ addslashes($message) }}', 'success');
        @endif

        @if ($error = session('info'))
            alertToastr('{{ addslashes($error) }}', 'info');
        @endif

        @if ($error = session('error'))
            alertToastr('{{ addslashes($error) }}', 'error');
        @endif

        @if ($errors->any())
            alertToastr('{{ addslashes($errors->first()) }}', 'error');
        @endif
    });
</script>
