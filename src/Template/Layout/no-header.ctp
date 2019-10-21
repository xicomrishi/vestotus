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

$cakeDescription = 'Vestotus -';
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
    <!-- FAVICONS -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="images/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/apple-touch-icon-152x152.png">

   <!--Vertical slider-->
    <?= $this->Html->css('settings') ?>
    <?= $this->Html->css('layers.css') ?>
    <?= $this->Html->css('navigation.css') ?>
    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('custom.css') ?>
    <?= $this->Html->css('style_custom.css') ?>
    <?= $this->Html->css('menu_elastic.css') ?>

    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body class="login">

	<!-- PRELOADER -->
        <div id="loader">
			<div class="loader-container">
				<img src="<?= BASEURL?>images/load.gif" alt="" class="loader-site spinner">
			</div>
		</div>
	<!-- END PRELOADER -->

    <!-- START SITE -->

    <!-- START SITE -->
    <div id="wrapper">
        <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
        <script>
        var siteUrl='<?php echo BASEURL ; ?>' 
        </script>
    </div><!-- end wrapper -->

    <div class="dmtop">Scroll to Top</div>
    <!-- END SITE -->
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('bootstrap.js') ?>
    <?= $this->Html->script('plugins.js') ?>
    <?= $this->Html->script('myscript') ?>
</body>
</html>