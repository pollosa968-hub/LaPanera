document.getElementById('formulario-registro').addEventListener('submit', function(event) {
    // Detener el envío del formulario para validar primero
    event.preventDefault();
    
    limpiarErrores();
    
    let valido = validarFormulario();
    
    if (valido) {
        this.submit();
    }
});

function limpiarErrores() {
    let errores = document.querySelectorAll('.error-message');
    errores.forEach(error => {
        error.textContent = '';
    });
}

function validarFormulario() {
    let valido = true;
    
    const nombre = document.getElementById('nombre').value.trim();
    if (nombre === '') {
        document.getElementById('error-nombre').textContent = 'El nombre es requerido';
        valido = false;
    }
    
    const email = document.getElementById('email').value.trim();
    if (email === '') {
        document.getElementById('error-email').textContent = 'El email es requerido';
        valido = false;
    } else if (!validarEmail(email)) {
        document.getElementById('error-email').textContent = 'Ingrese un email válido';
        valido = false;
    }
    
    const password = document.getElementById('password').value;
    if (password.length < 6) {
        document.getElementById('error-password').textContent = 'La contraseña debe tener al menos 6 caracteres';
        valido = false;
    }
    
    const confirm_password = document.getElementById('confirm_password').value;
    if (password !== confirm_password) {
        document.getElementById('error-confirm_password').textContent = 'Las contraseñas no coinciden';
        valido = false;
    }
    
    return valido;
}

function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}