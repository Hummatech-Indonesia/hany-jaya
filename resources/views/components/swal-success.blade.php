@push('custom-script')
    @if(session()->has('success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                toast: true,
                icon: "success",
                title: "{{ session('success') }}",
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            })
        })
    </script>
    @endif
@endpush