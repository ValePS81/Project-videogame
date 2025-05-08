function login() {
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
                    window.location.href = "../HTML/Index.html";
                });
            } else {
                Swal.fire({
                    title: "Oops...",
                    text: "Vuelva a intentarlo",
                    icon: "error"
                });
            }
        });
}

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



