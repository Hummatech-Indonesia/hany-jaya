@push('custom-script')
    @if(session()->has('error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                toast: true,
                icon: "error",
                title: "{{ session('error') }}",
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            })
        })
    </script>
    @endif
@endpush