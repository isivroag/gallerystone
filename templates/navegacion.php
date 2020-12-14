<aside class="main-sidebar sidebar-light-primary elevation-3">
  <!-- Brand Logo -->

  <a href="inicio.php" class="brand-link">

    <img src="img/minilogo.png" alt="Gallery Stone Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold">Gallery Stone</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
      <div class="image">
        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['s_nombre']; ?></a>
        <input type="hidden" id="nameuser" name="nameuser" value="<?php echo $_SESSION['s_nombre']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p >
              Home
            </p>
          </a>
        </li>

        <li class="nav-item  has-treeview <?php echo ($pagina == 'concepto' || $pagina == 'tipo' || $pagina == 'subtipo' || $pagina == 'item' || $pagina == 'formato' || $pagina == 'insumo' || $pagina == 'color' || $pagina == 'acabado' || $pagina == 'umedida' || $pagina == 'servicio') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link  <?php echo ($pagina == 'concepto' || $pagina == 'tipo' || $pagina == 'subtipo' || $pagina == 'item' || $pagina == 'formato' || $pagina == 'insumo' || $pagina == 'color' || $pagina == 'acabado' || $pagina == 'umedida' || $pagina == 'servicio') ? "active" : ""; ?>">
            <i class="nav-icon fas fa-cogs "></i>
            <p>
              Catalogos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>


          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cntaumedida.php" class="nav-link <?php echo ($pagina == 'umedida') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-ruler-combined nav-icon"></i>
                <p>Unidad de Medida</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntainsumo.php" class="nav-link <?php echo ($pagina == 'insumo') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-gem nav-icon"></i>
                <p>Materia Prima</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntacolor.php" class="nav-link <?php echo ($pagina == 'color') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-tint nav-icon"></i>
                <p>Color</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaacabado.php" class="nav-link <?php echo ($pagina == 'acabado') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-vector-square nav-icon"></i>
                <p>Acabado</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaitem.php" class="nav-link <?php echo ($pagina == 'item') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Materiales y Servicios</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaconcepto.php" class="nav-link <?php echo ($pagina == 'concepto') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-toolbox nav-icon"></i>
                <p>Conceptos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cntatipo.php" class="nav-link <?php echo ($pagina == 'tipo') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-list  nav-icon"></i>
                <p>Tipos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntasubtipo.php" class="nav-link <?php echo ($pagina == 'subtipo') ? "active seleccionado" : ""; ?> ">
                <i class="fas fa-stream  nav-icon"></i>
                <p>Subtipos</p>
              </a>
            </li>


          </ul>

        </li>


        <li class="nav-item has-treeview <?php echo ($pagina == 'prospectos' || $pagina == 'citap' || $pagina == 'presupuesto') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'prospectos' || $pagina == 'citap' || $pagina == 'presupuesto') ? "active" : ""; ?>">
            <i class="nav-icon fas fa-grip-horizontal "></i>
            <p>
              Preventa
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cntaprospecto.php" class="nav-link <?php echo ($pagina == 'prospectos') ? "active seleccionado" : ""; ?>  ">
                <i class="far fa-user nav-icon"></i>
                <p>Prospectos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="citaspres.php" class="nav-link <?php echo ($pagina == 'citap') ? "active seleccionado" : ""; ?>  ">
                <i class="far fa-calendar nav-icon"></i>
                <p>Citas Presupuesto</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cntapresupuesto.php" class="nav-link <?php echo ($pagina == 'presupuesto') ? "active seleccionado" : ""; ?> ">
                <i class="fas fa-money-check-alt nav-icon"></i>
                <p>Presupuestos</p>
              </a>
            </li>



          </ul>
        </li>

        <li class="nav-item has-treeview <?php echo ($pagina == 'cliente' || $pagina == 'venta' || $pagina == 'cobranza' || $pagina=='citav') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'cliente' || $pagina == 'venta' || $pagina == 'cobranza' || $pagina=='citav') ? "active" : ""; ?>">
            <span class="fa-stack">
              <i class=" fas fa-dollar-sign "></i>
              <i class=" fas fa-arrow-up "></i>
            </span>
            <p>
              Ingresos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntacliente.php" class="nav-link <?php echo ($pagina == 'cliente') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-address-card nav-icon"></i>
                <p>Clientes</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaventa.php" class="nav-link <?php echo ($pagina == 'venta') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-cash-register nav-icon"></i>
                <p>Ventas y Cobranza</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="citasventa.php" class="nav-link <?php echo ($pagina == 'citav') ? "active seleccionado" : ""; ?>  ">
                <i class="far fa-calendar nav-icon"></i>
                <p>Calendario Instalación</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cntapagoscxc.php" class="nav-link <?php echo ($pagina == 'cobranza') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                <p>Reporte de Pagos</p>
              </a>
            </li>


          </ul>
        </li>


        <li class="nav-item has-treeview <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp') ? "active" : ""; ?>">
          <span class="fa-stack">
              <i class=" fas fa-dollar-sign "></i>
              <i class=" fas fa-arrow-down "></i>
            </span>
            <p>
              Egresos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntapartida.php" class="nav-link <?php echo ($pagina == 'partida') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Partidas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaproveedor.php" class="nav-link <?php echo ($pagina == 'proveedor') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-people-carry nav-icon"></i>
                <p>Proveedores</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntacxp.php" class="nav-link <?php echo ($pagina == 'cxp') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                <p>Cuentas por Pagar</p>
              </a>
            </li>


          </ul>
        </li>





        <?php if ($_SESSION['s_rol'] == '2') {
        ?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php
        }
        ?>

        <hr class="sidebar-divider">
        <li class="nav-item">
          <a class="nav-link" href="bd/logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <p>Salir</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->