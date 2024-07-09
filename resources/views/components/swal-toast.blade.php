<script>
    function Toaster(type, msg) {
        Swal.fire({
            toast: true,
            icon: type,
            title: msg,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })
    }
</script>