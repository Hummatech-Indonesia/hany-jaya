@push('custom-script')
    @if(session()->has('success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "{{ session('success') }}"
            })
        })
    </script>
    @endif
@endpush