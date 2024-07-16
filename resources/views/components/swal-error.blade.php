@push('custom-script')
    @if(session()->has('error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "{{ session('error') }}"
            })
        })
    </script>
    @endif
@endpush