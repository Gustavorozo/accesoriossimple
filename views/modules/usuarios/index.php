<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\DepartamentosController;
use App\Controllers\MunicipiosController;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Usuario";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Crear <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Crear un Nuevo <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Crear</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensaje de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información del <?= $nameModel ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="create.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- form start -->
                                <form class="form-horizontal" enctype="multipart/form-data" method="post" id="frmCreate<?= $nameModel ?>"
                                      name="frmCreate<?= $nameModel ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=create">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group row">
                                                <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="Nombre" name="Nombre"
                                                           placeholder="Ingrese su Nombre" value="<?= $frmSession['Nombre'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Correo" class="col-sm-2 col-form-label">Correo</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="Correo"
                                                           name="Correo" placeholder="Ingrese su Correo"
                                                           value="<?= $frmSession['Correo'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Cedula" class="col-sm-2 col-form-label">Cedula</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" minlength="6" class="form-control"
                                                           id="Cedula" name="Cedula" placeholder="Ingrese su Cedula"
                                                           value="<?= $frmSession['Cedula'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Telefono" class="col-sm-2 col-form-label">Telefono</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" minlength="6" class="form-control"
                                                           id="Telefono" name="Telefono" placeholder="Ingrese su Telefono"
                                                           value="<?= $frmSession['Telefono'] ?? '' ?>">
                                                </div>
                                            </div>
                                            <?php if ($_SESSION['UserInSession']['rol'] == 'Administrativo'){ ?>
                                                <div class="form-group row">
                                                    <label for="user" class="col-sm-2 col-form-label">Usuario</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="user" name="user"
                                                               placeholder="Ingrese su Usuario" value="<?= $frmSession['user'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su Usuario">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                                                    <div class="col-sm-10">
                                                        <select required id="rol" name="rol" class="custom-select">
                                                            <option <?= (!empty($frmSession['rol']) && $frmSession['rol'] == "Administrativo") ? "selected" : ""; ?> value="Administrador">Administrador</option>
                                                            <option <?= (!empty($frmSession['rol']) && $frmSession['rol'] == "Empleado") ? "selected" : ""; ?> value="Empleado">Empleado</option>
                                                            <option <?= (!empty($frmSession['rol']) && $frmSession['rol'] == "Cliente") ? "selected" : ""; ?> value="Cliente">Cliente</option>
                                                            <option <?= (!empty($frmSession['rol']) && $frmSession['rol'] == "Proveedor") ? "selected" : ""; ?> value="Proveedor">Proveedor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="info-box">
                                                <div class="imageupload panel panel-primary">
                                                    <div class="panel-heading clearfix">
                                                        <h5 class="panel-title pull-left">Foto de Perfil</h5>
                                                    </div>
                                                    <div class="file-tab panel-body">
                                                        <label class="btn btn-default btn-file">
                                                            <span>Seleccionar</span>
                                                            <!-- The file is stored here. -->
                                                            <input type="file" id="foto" name="foto">
                                                        </label>
                                                        <button type="button" class="btn btn-default">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <button type="submit" class="btn btn-info">Enviar</button>
                                    <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                    <!-- /.card-footer -->
                                </form>
                            </div>
                            <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
</body>
</html>

