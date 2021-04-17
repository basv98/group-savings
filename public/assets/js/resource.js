$(document).ready(function () {
    plugins();
})

function mensajeExitoso(msj) {
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: msj,
        showConfirmButton: false,
        timer: 2000
    })
}

function mensajeError(msj) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: msj,
        footer: 'Contacta a sistemas'
    })
}

function plugins() {
    $(".miles").on({
        "focus": function (event) {
            $(event.target).select();
        },
        "keyup": function (event) {
            $(event.target).val(function (index, value) {
                return value.replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
    });
}

function numberFormat(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
  }