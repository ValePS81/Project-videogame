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
                window.location.href = "../HTML/Index.html";
            } else {
                alert("Usuario o clave incorrectos");
            }
        });
}