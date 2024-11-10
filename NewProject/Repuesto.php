<?php include "includes/header.php"; ?> 

    <main class="compra-repuestos-container">
        <section class="form-container">
            <h2>Spare Parts Purchase Form</h2>
            <form id="compra-repuestos-form">
                <label for="nombre-repuesto">Spare Part Name:</label>
                <input type="text" id="nombre-repuesto" name="nombre-repuesto" required placeholder="Enter the spare part name">

                <label for="precio">Price:</label>
                <input type="number" id="precio" name="precio" required placeholder="Enter the price" step="0.01">

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required placeholder="Enter the quantity in stock">

                <label for="proveedor">Supplier:</label>
                <input type="text" id="proveedor" name="proveedor" required placeholder="Enter the supplier's name">

                <button type="submit">
                    <i></i> Make Purchase
                </button>
            </form>
        </section>
    </main>
</body>
</html>
