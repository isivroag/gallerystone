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
        <input type="hidden" id="tipousuario" name="tipousuario" value="<?php echo $_SESSION['s_rol']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar nav-compact nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <?php if ($_SESSION['s_rol'] != '4' && $_SESSION['s_rol'] != '5') { ?>
          <!--ABRE CATALOGOS-->
          <li class="nav-item  has-treeview <?php echo ($pagina == 'concepto' || $pagina == 'tipo' || $pagina == 'subtipo' || $pagina == 'item' || $pagina == 'formato'
                                              || $pagina == 'insumo' || $pagina == 'color' || $pagina == 'acabado' || $pagina == 'umedida' || $pagina == 'servicio' || $pagina == 'especificacion') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link  <?php echo ($pagina == 'concepto' || $pagina == 'tipo' || $pagina == 'subtipo' || $pagina == 'item' || $pagina == 'formato'
                                            || $pagina == 'insumo' || $pagina == 'color' || $pagina == 'acabado' || $pagina == 'umedida' || $pagina == 'servicio' || $pagina == 'especificacion') ? "active" : ""; ?>">
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

              <li class="nav-item">
                <a href="cntaespecificacion.php" class="nav-link <?php echo ($pagina == 'especificacion') ? "active seleccionado" : ""; ?> ">
                  <i class="fa-solid fa-note-sticky  nav-icon"></i>
                  <p>Especificaciones</p>
                </a>
              </li>
            </ul>

          </li>
          <!--CIERRA CATALOGOS-->

          <!--ABRE CRM-->
          <li class="nav-item has-treeview <?php echo ($pagina == 'prospectos' || $pagina == 'citap' || $pagina == 'presupuesto' || $pagina == 'supendidos' ||
                                              $pagina == 'presupuestoobra'  || $pagina == 'presupuestosum' || $pagina == 'rptpresupuesto' || $pagina == 'rptpresupuestoobr'
                                              || $pagina == 'vendedores' || $pagina == 'seguimiento') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link <?php echo ($pagina == 'prospectos' || $pagina == 'citap' || $pagina == 'presupuesto'  || $pagina == 'supendidos'
                                          || $pagina == 'presupuestoobra' || $pagina == 'presupuestosum' || $pagina == 'rptpresupuesto' || $pagina == 'rptpresupuestoobr'
                                          || $pagina == 'vendedores' || $pagina == 'seguimiento') ? "active" : ""; ?>">
              <i class="nav-icon fas fa-grip-horizontal "></i>
              <p>
                CRM
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
                <a href="cntavendedor.php" class="nav-link <?php echo ($pagina == 'vendedores') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Vendedores</p>
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
                  <p>Presupuestos Proyectos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntapresupuestoobra.php" class="nav-link <?php echo ($pagina == 'presupuestoobra') ? "active seleccionado" : ""; ?> ">
                  <i class="material-icons nav-icon">handyman</i>
                  <p>Presupuestos Obras</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cntapresupuestosum.php" class="nav-link <?php echo ($pagina == 'presupuestosum') ? "active seleccionado" : ""; ?> ">
                  <i class="fa-solid fa-dolly nav-icon"></i>
                  <p>Presupuestos Suministro</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="rptpresupuestos.php" class="nav-link <?php echo ($pagina == 'rptpresupuesto') ? "active seleccionado" : ""; ?> ">
                  <i class="fas fa-search-plus nav-icon"></i>
                  <p>Consulta Pres. Poyecto</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="rptpresupuestoobra.php" class="nav-link <?php echo ($pagina == 'rptpresupuestoobr') ? "active seleccionado" : ""; ?> ">
                  <i class="fas fa-search-plus nav-icon"></i>
                  <p>Consulta Pres. Obra</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="rptsuspendidos.php" class="nav-link <?php echo ($pagina == 'supendidos') ? "active seleccionado" : ""; ?> ">
                  <i class="fas fa-business-time nav-icon"></i>
                  <p>Pres. Suspendidos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="seguimiento.php" class="nav-link <?php echo ($pagina == 'seguimiento') ? "active seleccionado" : ""; ?> ">
                  <i class="fas fa-phone-square nav-icon"></i>
                  <p>Seguimiento</p>
                </a>
              </li>


            </ul>
          </li>
          <!--CIERRA CRM-->


          <?php if ($_SESSION['s_rol'] != '1' && $_SESSION['s_rol'] != '6') { ?>
            <!--ABRE INGRESOS-->
            <li class="nav-item has-treeview <?php echo ($pagina == 'cliente' || $pagina == 'venta' || $pagina == 'cntaventaobr' || $pagina == "buscadorpres" || $pagina == "cntaliberaciones"
                                                || $pagina == 'ventaobra' || $pagina == 'cobranza' || $pagina == 'cobranzaobra' || $pagina == 'citav' || $pagina == 'cntaventa' || $pagina == 'preorden') ? "menu-open" : ""; ?>">


              <a href="#" class="nav-link <?php echo ($pagina == 'cliente' || $pagina == 'venta' || $pagina == 'cntaventaobr' || $pagina == "buscadorpres" || $pagina == "cntaliberaciones"
                                            || $pagina == 'ventaobra' || $pagina == 'cobranza' || $pagina == 'cobranzaobra' || $pagina == 'citav' || $pagina == 'cntaventa' || $pagina == 'preorden') ? "active" : ""; ?>">
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
                  <a href="buscadorpres.php" class="nav-link <?php echo ($pagina == 'buscadorpres') ? "active seleccionado" : ""; ?>  ">
                    <i class="fa-solid fa-magnifying-glass nav-icon"></i>
                    <p>Buscador Presupuestos</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntacliente.php" class="nav-link <?php echo ($pagina == 'cliente') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-address-card nav-icon"></i>
                    <p>Clientes</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntaventa.php" class="nav-link <?php echo ($pagina == 'venta') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-cash-register nav-icon"></i>
                    <p>Vtas-Cob Proyectos</p>
                  </a>
                </li>



                <li class="nav-item">
                  <a href="cntaventaobra.php" class="nav-link <?php echo ($pagina == 'ventaobra') ? "active seleccionado" : ""; ?>  ">
                    <i class="material-icons nav-icon">handyman</i>
                    <p>Vtas-Cob Obras</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="rptventa.php" class="nav-link <?php echo ($pagina == 'cntaventa') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-search-plus nav-icon"></i>
                    <p>Consulta de Proyectos</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="rptventaobr.php" class="nav-link <?php echo ($pagina == 'cntaventaobr') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-search-plus nav-icon"></i>
                    <p>Consulta de Obras</p>
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
                    <p>Pagos Proyectos</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntapagoscxcobr.php" class="nav-link <?php echo ($pagina == 'cobranzaobra') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-file-invoice-dollar nav-icon"></i>
                    <p>Pagos Obra</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="cntapreorden.php" class="nav-link <?php echo ($pagina == 'preorden') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-pencil-ruler nav-icon"></i>
                    <p>Preordenes de Servicio</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntaliberaciones.php" class="nav-link <?php echo ($pagina == 'liberaciones') ? "active seleccionado" : ""; ?>  ">
                    <i class="fa-solid fa-clipboard-check nav-icon"></i>
                    <p>Liberaciones</p>
                  </a>
                </li>

              </ul>
            </li>
            <!-- CIERRA INGRESOS-->
            <!--ABRE EGRESOS-->
            <li class="nav-item has-treeview <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp' || $pagina == 'cuentaegr' || $pagina == 'prescto') ? "menu-open" : ""; ?>">


              <a href="#" class="nav-link <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp' || $pagina == 'cuentaegr' || $pagina == 'prescto') ? "active" : ""; ?>">
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
                  <a href="cntacuentaegr.php" class="nav-link <?php echo ($pagina == 'cuentaegr') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-book nav-icon"></i>
                    <p>Cuentas de Egresos</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntapartida.php" class="nav-link <?php echo ($pagina == 'partida') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-list-alt nav-icon"></i>
                    <p>Partidas</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntaprescto.php" class="nav-link <?php echo ($pagina == 'prescto') ? "active seleccionado" : ""; ?>  ">
                    <i class="fa-solid fa-file-invoice nav-icon"></i>
                    <p>Presupuesto de Egresos</p>
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
            <!-- CIERRA EGRESOS-->
            <!-- ABRE REPORTES-->
            <li class="nav-item has-treeview <?php echo ($pagina == 'resultados' || $pagina == "seguimientopres" || $pagina == "fichas" || $pagina == "resumenventa" || $pagina == "resumenobra" || $pagina == "graficoanual" || $pagina == "pvendidos" || $pagina == "rptdiario") ? "menu-open" : ""; ?>">


              <a href="#" class="nav-link <?php echo ($pagina == 'resultados' || $pagina == "seguimientopres" || $pagina == "fichas" || $pagina == "resumenventa" || $pagina == "resumenobra" || $pagina == "graficoanual" || $pagina == "pvendidos" || $pagina == "rptdiario") ? "active" : ""; ?>">
                <span class="fa-stack">
                  <i class="fas fa-chart-line nav-icon"></i>

                </span>
                <p>
                  Reportes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">


                <li class="nav-item">

                  <a href="rptcorte.php<?php echo '?inicio=' . date("Y-m-d") . '&fin=' . date("Y-m-d") ?>" class="nav-link <?php echo ($pagina == 'rptdiario') ? "active seleccionado" : ""; ?>  ">

                    <i class="fa-solid fa-cash-register nav-icon"></i>
                    <p>Ingresos Diarios</p>
                  </a>
                </li>

                <li class="nav-item">
                  <!--
              <a href="resultados.php<?php echo '?mes=' . date("m") . '&ejercicio=' . date("Y") ?>" class="nav-link <?php echo ($pagina == 'resultados') ? "active seleccionado" : ""; ?>  ">
              -->
                  <a href="rptres.php<?php echo '?mes=' . date("m") . '&ejercicio=' . date("Y") ?>" class="nav-link <?php echo ($pagina == 'resultados') ? "active seleccionado" : ""; ?>  ">

                    <i class="fas fa-file-invoice nav-icon"></i>
                    <p>Resultados</p>
                  </a>
                </li>

                <li class="nav-item">

                  <a href="cntapvendidos.php<?php echo '?mes=' . date("m") . '&ejercicio=' . date("Y") ?>" class="nav-link <?php echo ($pagina == 'pvendidos') ? "active seleccionado" : ""; ?>  ">

                    <i class="fas fa-layer-group nav-icon"></i>
                    <p>Productos Vendidos</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="rptgraficoanual.php" class="nav-link <?php echo ($pagina == 'graficoanual') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-chart-bar nav-icon"></i>
                    <p>Grarfico Anual</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="rptresobra.php<?php echo '?mes=' . date("m") . '&ejercicio=' . date("Y") ?>" class="nav-link <?php echo ($pagina == 'resumenobra') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-hard-hat nav-icon"></i>
                    <p>Obras</p>
                  </a>
                </li>
                <!-- ABRE TOOLS ROOT-->
                <?php if ($_SESSION['s_rol'] == '3') {  ?>
                  <li class="nav-item">
                    <a href="cntaprospres.php" class="nav-link <?php echo ($pagina == 'seguimientopres') ? "active seleccionado" : ""; ?>  ">
                      <i class="fas fa-id-badge nav-icon"></i>
                      <p>Prospectos-Presupuestos</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="seguimientopres.php" class="nav-link <?php echo ($pagina == 'fichas') ? "active seleccionado" : ""; ?>  ">
                      <i class="fas fa-id-badge nav-icon"></i>
                      <p>Fichas de Prospectos</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="rptfiscal.php<?php echo '?mes=' . date("m") . '&ejercicio=' . date("Y") ?>" class="nav-link <?php echo ($pagina == 'resumenventa') ? "active seleccionado" : ""; ?>  ">
                      <i class="fas fa-id-badge nav-icon"></i>
                      <p>Resumen VTA-PAGO</p>
                    </a>
                  </li>
                <?php  }  ?>
                <!-- CIERRA TOOLS ROOT-->
              </ul>
            </li>
            <!-- CIERRA REPORTES-->
            <!--ABRE ADMINISTRACION-->
            <li class="nav-item has-treeview <?php echo ($pagina == 'banco'  || $pagina == 'cntamovb' || $pagina == 'personal' || $pagina == 'flujo' || $pagina == 'cortemat' || $pagina == 'corteins') ? "menu-open" : ""; ?>">


              <a href="#" class="nav-link <?php echo ($pagina == 'banco' || $pagina == 'cntamovb' || $pagina == 'personal' || $pagina == 'flujo' || $pagina == 'cortemat' || $pagina == 'corteins') ? "active" : ""; ?>">
                <span class="fa-stack">
                  <i class=" fas fa-book "></i>

                </span>
                <p>
                  Administración
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="cntapersonal.php" class="nav-link <?php echo ($pagina == 'personal') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-user nav-icon"></i>
                    <p>Personal</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntabanco.php" class="nav-link <?php echo ($pagina == 'banco') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-university nav-icon"></i>
                    <p>Cuentas de Banco</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntamovb.php" class="nav-link <?php echo ($pagina == 'cntamovb') ? "active seleccionado" : ""; ?>  ">
                    <i class="fas fa-search-plus nav-icon"></i>
                    <p>Consulta de Movimientos</p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="cntaflujo.php" class="nav-link <?php echo ($pagina == 'flujo') ? "active seleccionado" : ""; ?>  ">
                    <i class="fa-solid fa-percent nav-icon"></i>
                    <p>Distribución de Ingreso</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntacortemat.php" class="nav-link <?php echo ($pagina == 'cortemat') ? "active seleccionado" : ""; ?>  ">
                    <i class="fa-solid fa-boxes-packing nav-icon"></i>
                    <p>Corte Materiales</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="cntacorteins.php" class="nav-link <?php echo ($pagina == 'corteins') ? "active seleccionado" : ""; ?>  ">
                    <i class="fa-solid fa-boxes-packing nav-icon"></i>
                    <p>Corte Insumos</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php } ?>
        <?php } ?>
        <!-- CIERRA ADMINISTRACION-->



        <!-- ABRE PRODUCCION-->
        <?php if ($_SESSION['s_rol'] != '1') {  ?>

          <li class="nav-item has-treeview <?php echo ($pagina == 'orden' ||  $pagina == 'rptorden' ||  $pagina == 'cntarptorden' || $pagina == 'citamed' || $pagina == 'colocacion'
                                              || $pagina == 'corte' || $pagina == 'ensamble' || $pagina == 'pulido' || $pagina == 'cntaot') ? "menu-open" : ""; ?>">
            <a href="#" class="nav-link <?php echo ($pagina == 'orden' ||  $pagina == 'rptorden' ||  $pagina == 'cntarptorden' || $pagina == 'citamed' || $pagina == 'colocacion'
                                          || $pagina == 'corte' || $pagina == 'ensamble' || $pagina == 'pulido' || $pagina == 'cntaot') ? "active" : ""; ?>">
              <span class="fa-stack">
                <i class=" fas fa-hard-hat"></i>

              </span>
              <p>
                Producción Proyectos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


              <li class="nav-item">
                <a href="citaorden.php" class="nav-link <?php echo ($pagina == 'citamed') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-calendar nav-icon"></i>
                  <p>Calendario de Plantillas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaorden.php" class="nav-link <?php echo ($pagina == 'orden') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-pencil-ruler nav-icon"></i>
                  <p>Ordenes de Proyecto</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntacorte.php" class="nav-link <?php echo ($pagina == 'corte') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-scissors nav-icon"></i>
                  <p>Corte</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="cntaensamble.php" class="nav-link <?php echo ($pagina == 'ensamble') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-puzzle-piece nav-icon"></i>
                  <p>Ensamble</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntapulido.php" class="nav-link <?php echo ($pagina == 'pulido') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-sheet-plastic nav-icon"></i>
                  <p>Pulido</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="cntacolocacion.php" class="nav-link <?php echo ($pagina == 'colocacion') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-sink nav-icon"></i>
                  <p>Colocación</p>
                </a>
              </li>


              <!-- empieza Produccion General-->
              <li class="nav-item">
                <a href="cntaot.php" class="nav-link <?php echo ($pagina == 'cntaot') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-clipboard-list nav-icon"></i>
                  <p>Consulta de OT</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="cntarptorden.php" class="nav-link <?php echo ($pagina == 'cntarptorden') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-tasks nav-icon"></i>
                  <p>Consulta de Orden</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="rptorden.php<?php echo '?mes=' . date("m") . '&ejercicio=' . date("Y") ?>" class="nav-link <?php echo ($pagina == 'rptorden') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-tasks nav-icon"></i>
                  <p>Reporte de Producción ML</p>
                </a>
              </li>

              <!-- Termina Produccion General-->
            </ul>
          </li>
          <!-- CIERRA PRODUCCION-->

        <?php }  ?>


        <li class="nav-item has-treeview <?php echo ($pagina == 'ordenobra') ? "menu-open" : ""; ?>">
          <a href="#" class="nav-link <?php echo ($pagina == 'ordenobra') ? "active" : ""; ?>">
            <span class="fa-stack">
              <i class=" fa-solid fa-building "></i>
            </span>
            <p>Producción Obras
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">








            <!-- empieza Produccion General-->

            <li class="nav-item">
              <a href="cntaordenobra.php" class="nav-link <?php echo ($pagina == 'ordenobra') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-archway nav-icon"></i>
                <p>Ordenes de Obra</p>
              </a>
            </li>





            <!-- Termina Produccion General-->
          </ul>
        </li>
        <!-- CIERRA PRODUCCION-->




        <!-- ABRE INVENTARIO-->
        <?php if ($_SESSION['s_rol'] != '1') { ?>





          <li class="nav-item has-treeview <?php echo ($pagina == 'almacen' || $pagina == 'mat' || $pagina == 'desechable' || $pagina == 'inventario' || $pagina == 'inventariogral' || $pagina == 'insumoop'
                                              || $pagina == 'herramienta' || $pagina == 'medida' || $pagina == 'cntamaterial' || $pagina == 'matpieza' || $pagina == 'estante' || $pagina == 'vale' || $pagina == 'movmat' || $pagina == 'cajah') ? "menu-open" : ""; ?>">
            <a href="#" class="nav-link <?php echo ($pagina == 'almacen' || $pagina == 'mat' || $pagina == 'desechable' || $pagina == 'inventario' || $pagina == 'inventariogral' || $pagina == 'insumoop'
                                          || $pagina == 'herramienta' || $pagina == 'medida' || $pagina == 'cntamaterial' || $pagina == 'matpieza' || $pagina == 'estante' || $pagina == 'vale' || $pagina == 'movmat' || $pagina == 'cajah') ? "active" : ""; ?>">
              <span class="fa-stack">
                <i class=" fas fa-box"></i>

              </span>
              <p>
                Inventario
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="cntamedida.php" class="nav-link <?php echo ($pagina == 'medida') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-ruler-combined nav-icon"></i>
                  <p>Unidad de Medida</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaalmacen.php" class="nav-link <?php echo ($pagina == 'almacen') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-warehouse nav-icon"></i>
                  <p>Almacenes</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaestante.php" class="nav-link <?php echo ($pagina == 'estante') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-luggage-cart nav-icon"></i>
                  <p>Estante</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="cntamat.php" class="nav-link <?php echo ($pagina == 'mat') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-layer-group nav-icon"></i>
                  <p>Materiales</p>
                </a>
              </li>



              <li class="nav-item">
                <a href="rptinventariomat.php" class="nav-link <?php echo ($pagina == 'cntamaterial') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-boxes nav-icon"></i>
                  <p>Consulta Materiales</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="inventariomovmat.php" class="nav-link <?php echo ($pagina == 'movmat') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-table-list nav-icon"></i>
                  <p>Movimientos Materiales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cntamatpieza.php" class="nav-link <?php echo ($pagina == 'matpieza') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-cubes nav-icon"></i>
                  <p>Materiales Piezas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cntainsumoop.php" class="nav-link <?php echo ($pagina == 'insumoop') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-brush nav-icon"></i>
                  <p>Insumos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntadesinsumo.php" class="nav-link <?php echo ($pagina == 'desechable') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-business-time nav-icon"></i>
                  <p>Insumos de Desgaste</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaherramienta.php" class="nav-link <?php echo ($pagina == 'herramienta') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-hammer nav-icon"></i>
                  <p>Herramientas</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="inventario.php" class="nav-link <?php echo ($pagina == 'inventario') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-boxes nav-icon"></i>
                  <p>Rpt Inventario Material</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="inventariogral.php" class="nav-link <?php echo ($pagina == 'inventariogral') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-box nav-icon"></i>
                  <p>Inventario General</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntacajah.php" class="nav-link <?php echo ($pagina == 'cajah') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-toolbox nav-icon"></i>
                  <p>Cajas de Herramienta</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntavale.php" class="nav-link <?php echo ($pagina == 'vale') ? "active seleccionado" : ""; ?>  ">
                  <i class="fa-solid fa-screwdriver-wrench nav-icon"></i>
                  <p>Entrega/Recepción</p>
                </a>
              </li>

            </ul>
          </li>
        <?php }  ?>

        <!-- CIERRA INVENTARIO-->


        <!-- ABRE USUARIOS-->
        <?php if ($_SESSION['s_rol'] == '3') {
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
        <!-- CIERRA USUARIOS-->
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