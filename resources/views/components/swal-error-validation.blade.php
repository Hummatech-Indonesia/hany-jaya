@push('custom-script')
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                let error_message = ''
                @foreach ($errors->all() as $error)
                    error_message+= `{{ $error }} <br />`
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input',
                    html: `${error_message}`
                })
            @endif
        })
    </script>
@endpush