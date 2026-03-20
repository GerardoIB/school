<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Gestión de Productos</h2>

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock (Min/Max)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $p): ?>
            <tr>
                <td><?= $p['pk_product'] ?></td>
                <td><?= $p['product'] ?></td>
                <td>$<?= number_format($p['price'], 2) ?></td>
                <td><?= $p['stock_min'] ?> / <?= $p['stock_max'] ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" 
                            onclick="editProduct(<?= htmlspecialchars(json_encode($p)) ?>)" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal">
                        Editar
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= base_url('product/update') ?>" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="pk_product" id="pk_product">
                    
                    <div class="mb-3">
                        <label>Nombre del Producto</label>
                        <input type="text" name="product" id="form_product" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Precio</label>
                        <input type="number" step="0.01" name="price" id="form_price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea name="description" id="form_description" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Stock Mín</label>
                            <input type="number" name="stock_min" id="form_stock_min" class="form-control">
                        </div>
                        <div class="col">
                            <label>Stock Máx</label>
                            <input type="number" name="stock_max" id="form_stock_max" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editProduct(data) {
            document.getElementById('pk_product').value = data.pk_product;
            document.getElementById('form_product').value = data.product;
            document.getElementById('form_price').value = data.price;
            document.getElementById('form_description').value = data.description;
            document.getElementById('form_stock_min').value = data.stock_min;
            document.getElementById('form_stock_max').value = data.stock_max;
        }
    </script>
</body>
</html>