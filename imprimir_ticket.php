<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir ticket</title>
</head>

<body>

</body>
<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const urlSearchParams = new URLSearchParams(window.location.search);
        const id = urlSearchParams.get("id");
        const respuestaRaw = await fetch("./obtener_detalles_ticket.php?id=" + id);
        const detallesTicket = await respuestaRaw.json();
        // Documentación de operaciones:
        // https://parzibyte.me/http-esc-pos-desktop-docs/es/
        const operaciones = [{
                nombre: "EscribirTexto",
                argumentos: ["Ticket de venta\n"],
            },

            {
                nombre: "EscribirTexto",
                argumentos: ["Fecha: " + detallesTicket.fecha],
            },
            {
                nombre: "Feed",
                argumentos: [1],
            },
        ];
        for (const producto of detallesTicket.productos) {
            operaciones.push({
                nombre: "EscribirTexto",
                argumentos: [
                    producto.nombre + " precio: " + producto.precio
                ]
            }, {
                nombre: "Feed",
                argumentos: [
                    1,
                ]
            });
        }
        const cargaUtil = {
            "serial": "",
            "nombreImpresora": detallesTicket.nombreImpresora,
            "operaciones": operaciones,
        };
        const respuestaHttp = await fetch("http://localhost:8000/imprimir", {
            method: "POST",
            body: JSON.stringify(cargaUtil),
        })
        const respuestaComoJson = await respuestaHttp.json();
        if (respuestaComoJson.ok) {
            window.location.href = "./index.php";
        } else {
            // El mensaje de error está en la propiedad message
            alert("Error al imprimir ticket: " + respuestaComoJson.message);
        }
    });
</script>

</html>