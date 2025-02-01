{{-- Success Message --}}
@if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#d4edda',
            color: '#155724'
        });
    </script>
@endif

{{-- Error Message --}}
@if(session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#f8d7da',
            color: '#721c24'
        });
    </script>
@endif

{{-- Deleted Message --}}
@if(session('deleted'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'warning',
            title: "{{ session('deleted') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#f8d7da',
            color: '#721c24'
        });
    </script>
@endif

{{-- Delete Confirmation Modal --}}
<script>
    function showDeleteModal(form) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>