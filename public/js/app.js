$(document).ready(function () {
    $('#btn-verificar').click(function(){
        var dato = $('#form').serialize();
        $.ajax({
            method: "POST",
            url: "/add-extras",
            data: dato,
            success: function(r) {
                if (r.status === 0) {
                    Swal.fire({
                        title: r.data,
                        icon: 'error',
                        confirmButtonText: 'Cerrar'
                    });
                } else if (r.status === 1) {
                    Swal.fire({
                        title: r.data,
                        icon: 'success',
                        confirmButtonText: 'Cerrar'
                    });
                } else if (r.status === 2) {
                    Swal.fire({
                        title: r.data,
                        icon: 'info',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    });
});
