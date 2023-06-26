<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir ticket</title>
    <script src="./ConectorJavaScript.js"></script>
</head>

<body>

</body>
<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const urlSearchParams = new URLSearchParams(window.location.search);
        const id = urlSearchParams.get("id");
        const respuestaRaw = await fetch("./obtener_detalles_ticket.php?id=" + id);
        const detallesTicket = await respuestaRaw.json();

        // Empezar a usar el plugin
        const conector = new ConectorPluginV3();
        conector
            .EscribirTexto("Ticket de venta\n")
            .EscribirTexto("Fecha: " + detallesTicket.fecha)
            .Feed(1);
        for (const producto of detallesTicket.productos) {
            conector.EscribirTexto(producto.nombre + " precio: " + producto.precio);
            conector.Feed(1);
        }
        const respuesta = await conector.imprimirEn(detallesTicket.nombreImpresora);
        if (!respuesta) {
            alert("Error al imprimir ticket: " + respuesta);
        } else {
            window.location.href = "./index.php";
        }
    });
</script>

</html>