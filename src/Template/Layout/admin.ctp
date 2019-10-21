<?php
    /**
     * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
     * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     *
     * Licensed under The MIT License
     * For full copyright and license information, please see the LICENSE.txt
     * Redistributions of files must retain the above copyright notice.
     *
     * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     * @link          http://cakephp.org CakePHP(tm) Project
     * @since         0.10.0
     * @license       http://www.opensource.org/licenses/mit-license.php MIT License
     */
    
    $cakeDescription = 'Vestotus Admin - ';
    ?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <!--Vertical slider-->
        <?= $this->Html->css('../admin/vendors/bootstrap/dist/css/bootstrap.min.css') ?>
        <?= $this->Html->css('../admin/vendors/font-awesome/css/font-awesome.min.css') ?>
        <?= $this->Html->css('../admin/vendors/nprogress/nprogress.css') ?>
        <?= $this->Html->css('../admin/vendors/iCheck/skins/flat/green.css') ?>
        <?= $this->Html->css('../admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') ?>
        <?= $this->Html->css('../admin/vendors/jqvmap/dist/jqvmap.min.css') ?>
        <?= $this->Html->css('../admin/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>
        <?= $this->Html->css('../admin/build/css/custom.min.css') ?>
        <?= $this->Html->script('../admin/vendors/jquery/dist/jquery.min.js') ?>
        <?= $this->Html->css('../admin/style.css') ?>
        <?= $this->Html->script('../admin/vendors/bootstrap/dist/js/bootstrap.min.js') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?><script>
            var siteUrl='<?= $this->request->webroot; ?>'
        </script>
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?= $this->element('adminmenu') ?>
                <div class="right_col" role="main">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
    </body>
    <?= $this->Html->script('../admin/vendors/fastclick/lib/fastclick.js') ?>
    <?= $this->Html->script('../admin/vendors/nprogress/nprogress.js') ?>
    <?= $this->Html->script('../admin/vendors/gauge.js/dist/gauge.min.js') ?>
    <?= $this->Html->script('../admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>
    <?= $this->Html->script('../admin/vendors/skycons/skycons.js') ?>
    <?= $this->Html->script('../admin/vendors/moment/min/moment.min.js') ?>
    <?= $this->Html->script('../admin/vendors/bootstrap-daterangepicker/daterangepicker.js') ?>
    <?= $this->Html->script('../admin/build/js/custom.min.js') ?>
</html>