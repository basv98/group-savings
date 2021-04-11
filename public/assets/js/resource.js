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