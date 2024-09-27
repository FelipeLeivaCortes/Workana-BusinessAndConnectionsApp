<form id="formNewOrder" action="<?= Helpers\generateUrl("Order", "Order", "pdfOrder", [], "ajax"); ?>" method="POST" enctype="multipart/form-data">
    <div class="container">
        <h1 class="tracking-in-expand">Pedido <i class="fa-solid fa-pen-to-square"></i></h1>

        <!-- <div class="ml-auto col-md-3 p-4">
            <button id="addFieldsForm" type="button"
                data-url="<?= Helpers\generateUrl("Order", "Order", "ViewModalAddFields", [], "ajax"); ?>"
                class="btn btn-outline-primary">Agregar campos</button>
        </div> -->
        <hr>
        <div class="row d-flex">

            <div class="col-md-6 ">
                <h3 class="tracking-in-expand">Información del cliente <i class="fa-solid fa-user"></i></h3>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <label for="" class="form form-control"><?= $_SESSION['nameUser'] . " " . $_SESSION['LastNameUser'] ?></label>
                    <input type="hidden" value="<?= $_SESSION['nameUser'] . " " . $_SESSION['LastNameUser'] ?>" id="name" name="name">
                </div>
                <label for="">Empresa:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-building"></i></span>
                    <label for="" class="form form-control"><?= $_SESSION['CompanyName'] ?></label>

                    <input type="hidden" value="<?= $_SESSION['CompanyName'] ?>" aria-label="Username" name="company" aria-describedby="basic-addon1">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <div class="input-group mb-3">
                        <label for="" class="form form-control"><?= $_SESSION['EmailUser'] ?></label>
                        <input type="hidden" value="<?= $_SESSION['EmailUser'] ?>" name="email" aria-describedby="basic-addon2">
                    </div>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
                        <label for="" class="form form-control"><?= $_SESSION['PhoneUser'] ?></label>
                        <input type="hidden" value="<?= $_SESSION['PhoneUser'] ?>" class="form-control" name="phone" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="tracking-in-expand">Información de pago <i class="fa-solid fa-money-bill"></i></h3>
                <div class="form-group">
                    <label for="metodo_pago">Método de pago:</label>
                    <select class="form-select form-field" id="payment_method" name="payment_method">
                        <option selected disabled> Seleccione una opcion</option>
                        <?php
                        foreach ($methods as $method) {
                            $payment_method_id = $method[0]['payment_method_id'];
                            $name = $method[0]['name'];
                            echo "<option value='$payment_method_id'>$name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="direccion"></label>

                    <div class="input-group">
                        <span class="input-group-text">Dirección de envío:</span>
                        <textarea class="form-control form-field" aria-label="With textarea" name="address_shipping"><?= $orderAddress ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="comentarios">Comentarios:</label>
                    <textarea class="form-control" id="comentarios" name="comments" rows="3"></textarea>
                </div>

            </div>
            <div id="FormFields" class="col-md-12 row d-flex">

            </div>
        </div>
        <hr>




        <h3 class="tracking-in-expand">Articulos <i class="fa-solid fa-cart-shopping"></i></h3>
        <div class="text-right p-4">
            <button type="button" data-url="<?= Helpers\generateUrl("Order", "Order", "CreateOrder", [], "ajax"); ?>" class="btn btn-outline-primary" id="agregar_producto">Agregar productos</button>
        </div>
        <div class="table-responsive">

            <table class="table DataTable table-sm slide-in-top table-hover  table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Articulo</th>
                        <th>Categoria</th>
                        <th>Cantidad</th>
                        <th>Precio unit</th>
                        <th>Descuento</th>
                        <th>Precio tras el descuento</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="contArticlesOrder">
                    <!-- ADD ARTICLES FOR AJAX  -->
                </tbody>
            </table>
        </div>

        <hr>


        <h3 class="tracking-in-expand">Resumen<i class="fa-solid fa-pen-to-square"></i></h3>
        <div class="container ">
            <div class="col-md-12 p-2 d-flex">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="metodo_pago">Codigo de vendedor:</label>
                        <?php if (!empty($seller)) { ?>
                            <input type="hidden" name="s_id" value="<?= $seller[0]['s_id']; ?>">
                            <label class="form form-control" for=""><?= $seller[0]['s_code']; ?></label>
                        <?php } else { ?>
                            <label class="form form-control">No se ha asignado un vendedor</label>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago">Nombre vendedor:</label>
                        <?php if (!empty($seller)) { ?>
                            <label for="" class="form form-control"><?= $seller[0]['s_name']; ?></label>
                        <?php } else { ?>
                            <label class="form form-control">No se ha asignado un vendedor</label>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-6 p-2">
                    <label for="">Subtotal:</label>
                    <label for="" class="form form-control" id="subtotalOrder">NAN</label>
                    <input type="hidden" name="subtotalOrderInput" id="subtotalOrderInput">
                    <label for="">Descuento Total:</label>
                    <label for="" class="form-control" id="discountOrder">0</label>
                    <input class="form-control" type="hidden" name="discountOrderInput" id="discountOrderInput">
                    <label for="">Impuestos:</label>
                    <label for="" class="form form-control" id="taxesOrder">NAN</label>
                    <input type="hidden" name="taxesOrderInput" id="taxesOrderInput">
                    <label for="">Gastos Adicionales:</label>
                    <input class="form-control" type="number" name="additionalCostsOrderInput" id="additionalCostsOrderInput" value="0" readonly>
                    <label for="">Total:</label>
                    <label for="" class="form form-control" id="totalOrder">NAN</label>
                    <input type="hidden" name="totalOrderInput" id="totalOrderInput">
                    <input type="hidden" id="totalOrderInputCurrent">

                </div>

            </div>



        </div>
        <div class="text-right">


            <button type="submit" class="btn btn-outline-success">Generar pedido</button>

        </div>
</form>