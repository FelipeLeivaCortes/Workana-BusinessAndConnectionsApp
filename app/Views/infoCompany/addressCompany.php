<div class="container ">
    <h1 class="tracking-in-expand">Agregar dirección</h1>

    <div class="row slide-in-top">


        <div class="col-md-6">

            <h2>Dirección de facturación</h2>

            <?php foreach ($billingAddress as $key) {
                ?>

            <!-- start -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value=""
                    data-url="<?= Helpers\generateUrl("Company","Company","updateAddressShippingToAddressBilling",[],"ajax")?>"
                    id="changeAddressCheck">
                <label class="form-check-label" for="billing-same-as-shipping">
                    Usar la misma dirección de facturación para envío
                </label>
            </div>
            <form action="<?= Helpers\generateUrl("Company","Company","updateAddressBilling",[],"ajax")?>"
                method="POST">

                <div class="mb-3">
                    <label for="billing-address1" class="form-label">Calle y número</label>
                    <input type="text" name="street" value="<?= $key['c_street']?>" class="form-control addressBilling"
                        id="billing-address1">
                </div>
                <div class="mb-3">
                    <label for="billing-address2" class="form-label">Apartamento</label>
                    <input type="text" name="apartament" class="form-control addressBilling"
                        value="<?= $key['c_apartament']?>" id="billing-address2">
                </div>
                <div class="mb-3">
                    <label for="billing-city" class="form-label">Pais</label>
                    <input type="text" name="country" value="<?= $key['c_country']?>"
                        class="form-control addressBilling" id="billing-city">
                </div>
                <div class="mb-3">
                    <label for="billing-city" class="form-label">Ciudad</label>
                    <input type="text" name="city" class="form-control addressBilling" value="<?= $key['c_city']?>"
                        id="billing-city">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="billing-state" class="form-label">Departamento</label>
                        <input type="text" name="state" class="form-control addressBilling"
                            value="<?= $key['c_state']?>" id="billing-state">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="billing-zip" class="form-label">Código postal</label>
                        <input type="text" name="postalcode" class="form-control addressBilling"
                            value="<?= $key['c_postal_code']?>" id="billing-zip">
                    </div>
                </div>
            </form>
            <!-- end -->

        </div>

        <div class="col-md-6">
            <h2>Dirección de envío</h2>

            <div id="contBillingAddress">
                <form action="<?= Helpers\generateUrl("Company","Company","updateAddressShipping",[],"ajax")?>"
                    method="post">
                    <div class="mb-3">
                        <label for="shipping-address1" class="form-label">Calle y número</label>
                        <input type="text" name="streetShipping" value="<?= $key['c_shippingStreet']?>"
                            class="form-control addressShipping" id="shipping-address1">
                    </div>
                    <div class="mb-3">
                        <label for="shipping-address2" class="form-label">Apartamento.</label>
                        <input type="text" name="apartamentShipping" value="<?= $key['c_shippingApartament']?>"
                            class="form-control addressShipping" id="shipping-address2">
                    </div>
                    <div class="mb-3">
                        <label for="shipping-city" class="form-label">Pais</label>
                        <input type="text" name="countryShipping" value="<?= $key['c_shippingCountry']?>"
                            class="form-control addressShipping" id="shipping-city">
                    </div>
                    <div class="mb-3">
                        <label for="shipping-city" class="form-label">Ciudad</label>
                        <input type="text" name="cityShipping" value="<?= $key['c_shippingCity']?>"
                            class="form-control addressShipping" id="shipping-city">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="shipping-state" class="form-label">Departamento</label>
                            <input type="text" name="stateShipping" value="<?= $key['c_shippingState']?>"
                                class="form-control addressShipping" id="shipping-state">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="shipping-zip" class="form-label">Código postal</label>
                            <input type="text" name="postalcodeShipping" value="<?= $key['c_shippingPostalcode']?>"
                                class="form-control addressShipping" id="shipping-zip">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <?php 
        }
        ?>


</div>