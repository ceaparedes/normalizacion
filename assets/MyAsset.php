<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/chosen.css',
        'css/ace.min.css',
        'css/ace-part2.css',
        'css/ace-skins.min.css',
        'css/ace-ie.css',



    ];
    public $js = [
      'js/main.js',
      'js/ace-extra.min.js',
      'js/respond.min.js',
      'js/bootstrap.js',
      'js/excanvas.js',
      'js/ace.js',
      'js/ace-elements.js',



      'js/ace/ace.ajax-content.js',
      'js/ace/ace.auto-container.js',
      'js/ace/ace.autohide-sidebar.js',
      'js/ace/ace.auto-padding.js',
      'js/ace/elements.onpage-help.js',
      'js/ace/ace.settings.js',
      'js/ace/ace.sidebar.js',
      'js/ace/ace.submenu-1.js',
      'js/ace/ace.submenu-2.js',
      'js/ace/elements.scroller.js',
      'js/ace/elements.spinner.js',
      'js/ace/ace.settings-rtl.js',
      'js/ace/elements.treeview.js',
      'js/ace/ace.sidebar-scroll-1.js',
      'js/ace/ace.submenu-hover.js',
      'js/ace/elements.wizard.js',
      'js/ace/ace.onpage-help.js',

      'js/rainbow.js',
      'js/language/generic.js',
      'js/language/html.js',
      'js/language/css.js',
      'js/language/javascript.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
