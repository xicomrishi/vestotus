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
        <link rel="apple-touch-icon" href="<?= BASEURL?>images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="57x57" href="<?= BASEURL?>images/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= BASEURL?>images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= BASEURL?>images/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= BASEURL?>images/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= BASEURL?>images/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= BASEURL?>images/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= BASEURL?>images/apple-touch-icon-152x152.png">
        <!--Vertical slider-->
        <?= $this->Html->css('settings') ?>
        <?= $this->Html->css('layers.css') ?>
        <?= $this->Html->css('navigation.css') ?>
        <?= $this->Html->css('bootstrap.css') ?>
        <?= $this->Html->css('style.css') ?>
        <?= $this->Html->css('custom.css') ?>
        <?= $this->Html->css('style_custom.css') ?>
        <?= $this->Html->css('menu_elastic.css') ?>
        <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css') ?>
        <?= $this->Html->script('snap.svg-min.js') ?>
        <?= $this->Html->script('jquery.min.js') ?>    
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
        <script>
            var siteUrl='<?= $this->request->webroot; ?>'
        </script>
    </head>
    <body class="leftside">
        <?= $this->element('header') ?>
        <?= $this->element('nav-bar') ?>
        <section class="section litpadtop bgw">
            <?= $this->element('top-page') ?>
            <div class="container">
                <div class="row">
                    <?= $this->element('left-side') ?>
                    <div class="dashbrd-alrt">
                        <?= $this->Flash->render() ?>
                    </div>
                    <?= $this->fetch('content') ?>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <div class="clear"> </div>
        <?php if($this->request->action=='home') { ?>
        <hr class="red-line" />
        <?php } ?>
        <?= $this->element('foot') ?>
    </body>
    <?= $this->Html->script('bootstrap.js') ?>
    <?= $this->Html->script('plugins.js') ?>
    <?= $this->Html->script('jquery.themepunch.tools.min.js') ?>
    <?= $this->Html->script('jquery.themepunch.revolution.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.actions.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.carousel.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.kenburn.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.layeranimation.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.migration.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.navigation.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.parallax.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.slideanims.min.js') ?>
    <?= $this->Html->script('extensions/revolution.extension.video.min.js') ?>
    <script type="text/javascript">
        (function($) {
        "use strict";
        var tpj=jQuery;             
        var revapi98;
            tpj(document).ready(function() {
                if(tpj("#rev_slider_98_2").revolution == undefined){
                    revslider_showDoubleJqueryError("#rev_slider_98_2");
                    }else{
                    revapi98 = tpj("#rev_slider_98_2").show().revolution({
                    sliderType:"hero",
                    jsFileLocation:"/js/",
                    sliderLayout:"fullwidth",
                    dottedOverlay:"none",
                    delay:9000,
                    navigation: {
                    },
                    responsiveLevels:[1240,1024,778,480],
                    gridwidth:[1240,1024,778,480],
                    gridheight:[850,610,560,560],
                    lazyType:"none",
                    parallax: {
                    type:"mouse",
                    origo:"slidercenter",
                    speed:2000,
                    levels:[2,3,4,5,6,7,12,16,10,50],
                    },
                    shadow:0,
                    spinner:"off",
                    autoHeight:"off",
                    disableProgressBar:"on",
                    hideThumbsOnMobile:"off",
                    hideSliderAtLimit:0,
                    hideCaptionAtLimit:0,
                    hideAllCaptionAtLilmit:0,
                    debugMode:false,
                    fallbacks: {
                    simplifyAll:"off",
                    disableFocusListener:false,
                    }
                });
            }
        }); /*ready*/
        })(jQuery);
    </script>   
    <script type="text/javascript">
        (function($) {
        "use strict";
            $('.menu-button').click(function() {
            $('.row-offcanvas').addClass('active');
            });  
        })(jQuery);
    </script>
    <script type="text/javascript">
        (function($) {
        "use strict";
            $('.close-button').click(function() {
            $('.row-offcanvas').removeClass('active');
            });  
        })(jQuery);
    </script>
    <?= $this->Html->script('classie.js') ?>
    <?= $this->Html->script('main3.js') ?>
    <?= $this->Html->script('common.js') ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function(){
            var date_input=$('.date');
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            date_input.datepicker({
                format: 'd M, yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            })
        })
    </script>
    </body>
</html>