<!-- SIDEBAR 2 -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-bg-class="bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
        <img id="logoSideBar" src="img/Logo-Portal.png" alt="" srcset="">
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 ps ps--active-y">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="<?= Helpers\generateUrl("Access","Access","HomeView");?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Inicio</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Panel de control</span>
        </li>

        <?php if ($_SESSION['RolUser'] == '1'): ?>
        <li class="menu-item" style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-user-detail'></i>
                <div data-i18n="Layouts">Clientes</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Clients","Clients","ViewClientPortal");?>" class="menu-link">
                        <div data-i18n="Without menu">Ver clientes portal</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>


        <!-- COMPANY -->
        <?php if ($_SESSION['RolUser'] == '2' AND $_SESSION['StatusUser'] == '1'): ?>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-store"></i>
                <div data-i18n="Misc">WooCommerce</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Api","Api","Consult");?>" class="menu-link">
                        <div data-i18n="Error">Consultar</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Api","Api","ViewCreateArticle");?>" class="menu-link">
                        <div data-i18n="Error">Crear</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user-check"></i>
                <div data-i18n="Misc">Autorizaciones de registro</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Clients","Clients","sendEmailClientsOfClients");?>"
                        class="menu-link">
                        <div data-i18n="Error">Enviar registro</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Inbox","Inbox","viewInbox");?>" class="menu-link">
                        <div data-i18n="Error">Ver</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="Misc">Clientes</div>
            </a>
            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Company","Company","consultCompanies");?>" class="menu-link">
                        <div data-i18n="Error">Ver
                            clientes</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Clients","Clients","CreateSellers");?>" class="menu-link">
                        <div data-i18n="Error">Crear
                            vendedores</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-dollar-circle"></i>
                <div data-i18n="Misc">Cotizaciones</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Quote","Quote","quotesCompanies");?>" class="menu-link">
                        <div data-i18n="Error">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-truck"></i>
                <div data-i18n="Misc">Pedidos</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Order","Order","ordersCompanies");?>" class="menu-link">
                        <div data-i18n="Error">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-list-check"></i>
                <div data-i18n="Misc">Listas de precios</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Groups","Groups","viewCreateGroups");?>" class="menu-link">
                        <div data-i18n="Error">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-building-house"></i>
                <div data-i18n="Misc">Bodegas</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Warehouse","Warehouse","ViewCreateWarehouse");?>"
                        class="menu-link">
                        <div data-i18n="Error">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="Misc">Inventario</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Stock","Stock","ViewCreateStock");?>" class="menu-link">
                        <div data-i18n="Error">Crear artículo</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Articles","Articles","consult");?>" class="menu-link">
                        <div data-i18n="Error">Ver artículos</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Category","Category","consultCateogries");?>" class="menu-link">
                        <div data-i18n="Error">Crear categorías</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-file"></i>
                <div data-i18n="Authentications">Import/Export</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Data","Data","ImportView");?>" class="menu-link">
                        <div data-i18n="Basic">Ver Import</div>
                    </a>
                    <a href="<?= Helpers\generateUrl("Data","Data","ExportView");?>" class="menu-link">
                        <div data-i18n="Basic">Ver Export</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>


        <?php if ($_SESSION['RolUser'] == '3' AND $_SESSION['StatusUser'] =='1' || $_SESSION['RolUser'] == '4' AND $_SESSION['StatusUser'] =='1'): ?>
        <!-- module -->
        <li class="menu-item" style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-dollar-circle'></i>
                <div data-i18n="Layouts">Cotizaciones</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Quote","Quote","ViewCreateQuote");?>" class="menu-link">
                        <div data-i18n="Without menu">Crear</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Quote","Quote","ViewQuotes");?>" class="menu-link">
                        <div data-i18n="Without menu">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- module -->
        <li class="menu-item" style="">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-truck'></i>
                <div data-i18n="Layouts">Pedidos</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Order","Order","ViewCreateOrder");?>" class="menu-link">
                        <div data-i18n="Without menu">Crear</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Order","Order","ViewOrders");?>" class="menu-link">
                        <div data-i18n="Without menu">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>
        <!-- ROL ADMIN INACTIVO -->
        <?php if ($_SESSION['RolUser'] == '3' AND $_SESSION['StatusUser'] == '3' ): ?>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-paste"></i>
                <div data-i18n="Authentications">Documentación</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Company","Company","UpdateDocumentsClientsImporteds");?>"
                        class="menu-link">
                        <div data-i18n="Basic">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <!-- ROL CLIENT PORTAL INACTIVO -->
        <?php if ($_SESSION['RolUser'] == '2' AND $_SESSION['StatusUser'] == '2' ): ?>
        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-paste"></i>
                <div data-i18n="Authentications">Registro</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Company","Company","RegisterUpdateView");?>" class="menu-link">
                        <div data-i18n="Basic">Ver</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <!-- module -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-paste"></i>
                <div data-i18n="Authentications">Reportes</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="<?= Helpers\generateUrl("Reports","Reports","ViewCreateReports");?>" class="menu-link">
                        <div data-i18n="Basic">Ver</div>
                    </a>
                </li>
            </ul>
        </li>

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 4px; height: 466px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 243px;"></div>
        </div>
    </ul>
</aside>