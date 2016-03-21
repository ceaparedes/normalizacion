<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\MyAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

MyAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome desde la web-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--end font awesome-->
    <!-- serve fonts (open sans) from google -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300" />
    <!-- end font-->
    <meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE;chrome=1">
    <meta charset="ISO-8859-1">
    <meta name="description" content="Sistema Realizado para el Departamento de Normalización y Certificación de la Universidad del Bío-Bío">
    <meta name="author" content="Víctor Cea Paredes">
    <link rel="shortcut icon" href="dist/favicon.ico">
    <?= Html::csrfMetaTags() //no borrar, tag necesario para la eliminación?>


    <title>Normalización y Certificación - Universidad del Bío-Bío</title>
    <?php $this->head() ?>
</head>
<body class="no-skin">
<?php $this->beginBody() ?>

  <!-- #section:basics/navbar.layout -->
  <div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
    <script type="text/javascript">
      try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container ace-save-state navbar-fixed-top">
      <!-- #section:basics/sidebar.mobile.toggle -->
      <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" >
        <span class="sr-only">Toggle sidebar</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <!-- /section:basics/sidebar.mobile.toggle -->
      <div class="navbar-header pull-left">
        <!-- #section:basics/navbar.layout.brand -->
        <a href="#" class="navbar-brand">
          <small style="font-size: 14px;">
            <img style="width:20px;height:20px;" src="dist/escudo.png">
            Universidad Del Bio-Bio
          </small>
        </a>

        <!-- /section:basics/navbar.layout.brand -->

        <!-- #section:basics/navbar.toggle -->

        <!-- /section:basics/navbar.toggle -->
      </div>

      <!-- #section:basics/navbar.dropdown -->
      <div class="navbar-buttons navbar-header pull-right" role="navigation">
        <ul class="nav ace-nav">



          <li class="purple">
            <a href="http://werken.ubiobio.cl/" target="_blank">
              <i class="ace-icon fa fa-book icon-animated-bell"></i>
              <span class="badge badge-important">WERKEN</span>
            </a>

          </li>

          <li class="green">
            <a href="http://mail.alumnos.ubiobio.cl/" target="_blank">
              <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
              <span class="badge badge-success">CORREO</span>
            </a>

          </li>



          <!-- #section:basics/navbar.user_menu -->
          <li class="light-blue">
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
              <img class="nav-user-photo" src="dist/user.jpg" alt="Foto Perfil" />
              <span class="user-info">
                <small>Bienvenid@,</small>
                Marcelo
              </span>

              <i class="ace-icon fa fa-caret-down"></i>
            </a>

            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
              <!--  <li>
                  <a href="#">
                    <i class="ace-icon fa fa-cog"></i>
                    Configuración
                  </a>
                </li>

                <li>
                  <a href="#">
                    <i class="ace-icon fa fa-user"></i>
                    Perfil
                  </a>
                </li> -->

                <?= Nav::widget([
                  'class'=>'user-menu dropdown-menu',
                'items' => [
                  ['label' => ' Perfil','url'=>'#',
                    'linkOptions'=>['class'=>'ace-icon fa fa-user pull-left'],
                  ],

                  Yii::$app->user->isGuest ? (
                  ['label' => 'Acceder', 'url' => ['/site/login'],
                    'linkOptions'=>['i class'=>'ace-icon fa fa-power-off pull-left']]
                  ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    ' Cerrar sesión',
                    ['class' => 'ace-icon fa fa-power-off btn btn-link pull-left']
                )
                . Html::endForm()
                . '</li>'
                )
                ],
                  ])?>

            </ul>
          </li>

          <!-- /section:basics/navbar.user_menu -->
        </ul>
      </div>

      <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
  </div>

  <!-- /section:basics/navbar.layout -->
  <div class="main-container" id="main-container">
    <script type="text/javascript">
      try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <!-- #section:basics/sidebar -->
    <div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed" data-sidebar = "true" data-sidebar-scroll = "true" data-sidebar-hover = "true">
      <script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

<!-- botones feos-->
      <!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
          <button class="btn btn-success">
            <i class="ace-icon fa fa-signal"></i>
          </button>

          <button class="btn btn-info">
            <i class="ace-icon fa fa-pencil"></i>
          </button>

          <!-- #section:basics/sidebar.layout.shortcuts -->
          <!--<button class="btn btn-warning">
            <i class="ace-icon fa fa-users"></i>
          </button>

          <button class="btn btn-danger">
            <i class="ace-icon fa fa-cogs"></i>
          </button>
          </div>
          <!-- /section:basics/sidebar.layout.shortcuts -->


        <!--<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
          <span class="btn btn-success"></span>

          <span class="btn btn-info"></span>

          <span class="btn btn-warning"></span>

          <span class="btn btn-danger"></span>
        </div>
      </div><!-- /.sidebar-shortcuts -->

      <ul class="nav nav-list" style = "top:0px;">
        <li class="active">
          <a href="index.php">
            <i class="menu-icon fa fa-university"></i>
            <span class="menu-text"> Inicio </span>
          </a>

          <b class="arrow"></b>
        </li>

        <li class="">
          <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-pencil-square-o"></i>
            <span class="menu-text"> Reclamos y Sugerencias</span>

            <b class="arrow fa fa-angle-down"></b>
          </a>

          <b class="arrow"></b>

          <ul class="submenu">
            <li class="">
              <a href="index.php?r=reclamo-sugerencia%2Fcreate">
                <i class="menu-icon fa fa-caret-right"></i>
                Completar Formulario
              </a>
              <b class="arrow"></b>
            </li>

            <!--<li class="">
              <a href="index.php?r=reclamo-sugerencia%2Fcreate">
                <i class="menu-icon fa fa-caret-right"></i>
                Completar Formulario en Blanco
              </a>
              <b class="arrow"></b>
            </li> -->

            <li class="">
              <a href="index.php?r=reclamo-sugerencia">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Reclamos y Sugerencias
              </a>

              <b class="arrow"></b>
            </li>

            <li class="">
              <a href="index.php?r=solucion-reclamo-sugerencia">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Solicutudes Evaluadas
              </a>

              <b class="arrow"></b>
            </li>

            <li class="">
              <a href="index.php?r=derivacion-reclamo-sugerencia">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Solicutudes Derivadas
              </a>

              <b class="arrow"></b>
            </li>

            <li class="">
              <a href="index.php?r=historial-estados">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Historial de Solicitudes
              </a>

              <b class="arrow"></b>
            </li>

          </ul>
        </li>

        <li class="">
          <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-files-o"></i>
            <span class="menu-text"> Documentos </span>

            <b class="arrow fa fa-angle-down"></b>
          </a>

          <b class="arrow"></b>

          <ul class="submenu">
            <li class="">
              <a href="index.php?r=solicitud-documento%2Fcreate">
                <i class="menu-icon fa fa-caret-right"></i>
                Completar Solicitud
              </a>

              <b class="arrow"></b>
            </li>

            <li class="">
              <a href="index.php?r=solicitud-documento">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Solicitudes
              </a>

              <b class="arrow"></b>
            </li>

            <li class="">
              <a href="index.php?r=derivacion-solicitud-documento">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Solicitudes Derivadas
              </a>

              <b class="arrow"></b>
            </li>

            <li class="">
              <a href="index.php?r=borrador-documento">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Borradores de Documentos
              </a>
              <b class="arrow"></b>
            </li>

            <li class="">
              <a href="index.php?r=historial-solicitud">
                <i class="menu-icon fa fa-caret-right"></i>
                Ver Historial de Solicitudes
              </a>

              <b class="arrow"></b>
            </li>


          </ul>
        </li>

        </ul><!-- /.nav-list -->

      <!-- #section:basics/sidebar.layout.minimize -->
      <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
      </div>

      <!-- /section:basics/sidebar.layout.minimize -->
      <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')
          }catch(e){}
      </script>
    </div>

    <!-- /section:basics/sidebar -->
    <div class="main-content">
      <!-- inicio breadcrumbs (el submenu de arriba)-->
      <div class="breadcrumbs" id="breadcrumbs">
					<script type="text/javascript">
						try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
					</script>
          <?= Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
				</div> <!--/ breadcrumbs-->
        <!-- endbreadcrumbs (el submenu de arriba)-->

      <!-- #section:basics/content.breadcrumbs -->

          <div class="page-content-area">
            <div class="page-header"><h1> <?= $this->title ?> </div></h1>
                <div class="row">
                  <div class="col-xs-12"> <!--funciona a medias -->
                    <!-- contenido de la página-->
                    <?= $content ?>
                    <!--/contenido -->
                </div>
              </div>
            </div>
            <!--/page content -->
    </div><!--/page content-->

    <div class="panel-footer">

          <div class="footer-inner">
              <!-- #section:basics/footer -->
              <center>
              <div class="footer-content">
                  <span class="bigger-120">
                      <span class="blue bolder">Universidad  del Bío-Bío</span>
                      Todos los derechos reservados © 2014-2015
                  </span>

                  &nbsp; &nbsp;
                  <span class="action-buttons">
                      <a href="https://twitter.com/ubbchile" target="_blank">
                          <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                      </a>

                      <a href="https://www.facebook.com/ubiobiochile" target="_blank">
                          <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                      </a>

                      <a href="https://www.flickr.com/photos/ubiobio" target="_blank">
                          <i class="ace-icon fa fa-flickr bigger-150"></i>
                      </a>

                      <a href="http://cl.linkedin.com/in/ubiobio" target="_blank">
                          <i class="ace-icon fa fa-linkedin-square blue bigger-150"></i>
                      </a>

                      <a href="https://www.youtube.com/user/udelbiobio" target="_blank">
                          <i class="ace-icon fa fa-youtube red bigger-150"></i>
                      </a>
                  </span>
              </div>
            </center>
              <!-- /section:basics/footer -->
          </div>
    </div>



</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
