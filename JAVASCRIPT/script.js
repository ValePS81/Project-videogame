document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('contraseña');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.setAttribute('name', type === 'password' ? 'eye-off-outline' : 'eye-outline');
    });

    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Detiene el comportamiento por defecto

        const datos = {
            usuario: document.getElementById("usuario").value,
            contraseña: document.getElementById("contraseña").value
        };

        fetch("../PHP/login.php", {
            method: "POST",
            body: JSON.stringify(datos),
            headers: {
                "Content-Type": "application/json"
            }
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "¡Bienvenido!",
                    icon: "success"
                }).then(() => {
                    // Redirigir según el rol
                    if (data.rol === 'admin') {
                        window.location.href = "../PHP/Panel_control.php";
                    } else {
                        window.location.href = "../HTML/Index.html"; // ruta de usuario normal
                    }
                });
            } else {
                Swal.fire({
                    title: "Oops...",
                    text: "Usuario o contraseña incorrectos.",
                    icon: "error"
                });
            }
        });
    });
});

document.querySelector("form").addEventListener("submit", function (e) {
    e.preventDefault(); // Previene el envío por defecto del formulario

    const datos = new FormData(this);

    fetch("../PHP/register.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: "¡Registro Exitoso!",
                icon: "success"
            }).then(() => {
                window.location.href = "../HTML/Index.html";
            });
        } else {
            Swal.fire({
                title: "Error",
                text: "Error al registrar: " + (data.error || "datos inválidos"),
                icon: "error"
            });
        }
    });
});




