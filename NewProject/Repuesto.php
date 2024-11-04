<?php include "includes/header.php"; ?> 

    <main class="compra-repuestos-container">
        <section class="form-container">
            <h2>Formulario de Compra de Repuestos</h2>
            <form id="compra-repuestos-form">
                <label for="nombre-repuesto">Nombre del Repuesto:</label>
                <input type="text" id="nombre-repuesto" name="nombre-repuesto" required placeholder="Ingrese el nombre del repuesto">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" required placeholder="Ingrese el precio" step="0.01">

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required placeholder="Ingrese la cantidad en stock">

                <label for="proveedor">Proveedor:</label>
                <input type="text" id="proveedor" name="proveedor" required placeholder="Ingrese el nombre del proveedor">

                <button type="submit">
                    <i></i> Realizar Compra
                </button>
            </form>
        </section>
    </main>
</body>
</html>
