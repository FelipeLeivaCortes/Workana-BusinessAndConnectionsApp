<div class="container">
    <h2>Asignar vendedor a cliente</h2>
    <div class="table-responsive">

        <div class="p-4">
            <button type="button" data-id="<?=$s_id?>"
                data-url="<?=Helpers\generateUrl("Clients","Clients","addCompanyToSeller",[],"ajax")?>"
                class="btn btn-outline-primary" id="addCompanyToSeller">
                Agregar empresa
            </button>
        </div>
        <table class="table DataTable table-hover slide-in-top  table-stripe">
            <thead>
                <tr>
                    <th scope="col">Nombre empresa</th>
                    <th scope="col">Email</th>
                    <th scope="col">Numero de telefono</th>
                    <th scope="col">Acciones</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="theadClientsOfSeller">
                <?php
                foreach ($companies as $c) {
                    echo '<tr>
                        <td>'.$c['c_name'].'</td>
                        <td>'.$c['u_email'].'</td>
                        <td>'.$c['u_phone'].'</td>
                        <td class="text-center">
                            <button id="deleteSellerOfCompany" data-url="'.Helpers\generateUrl("Clients","Clients","DeleteSellerOfCompany",["c_id"=>$c['c_id'],"s_id"=>$c['s_id']],"ajax").'" class="btn btn-outline-danger"><i class="fa-regular fa-circle-xmark"></i></button>
                        </td>
                    </tr>';
                }
			?>
            </tbody>
        </table>

    </div>
</div>