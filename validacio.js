function validarLogin() {
    const correo = document.getElementById("correoLogin").value;
    const password = document.getElementById("passwordLogin").value;

    // Simulación de autenticación
    if (correo === "empresa@ejemplo.com" && password === "empresa123") {
        window.location.href = "privado_empresa.html";
    } else if (correo === "cliente@ejemplo.com" && password === "cliente123") {
        window.location.href = "privado_usuario.html";
    } else {
        document.getElementById("mensajeLogin").innerText = "Credenciales incorrectas, intenta de nuevo.";
    }
}
