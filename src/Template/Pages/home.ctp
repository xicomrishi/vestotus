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

$cakeDescription = 'Stop Website -';
$this->layout = false;
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
<?= $this->Html->css('stop/jquery.fullPage.css') ?>
<?= $this->Html->css('stop/examples.css') ?>
<?= $this->Html->css('stop/component.css') ?>
<?= $this->Html->css('stop/menu_elastic.css') ?>
<?= $this->Html->script('stop/modernizr.custom.js') ?>
<?= $this->Html->script('stop/jquery.min.js') ?>
<?= $this->Html->script('stop/jquery-ui.min.js') ?>
<?= $this->Html->script('stop/scrolloverflow.js') ?>
<?= $this->Html->script('stop/jquery.fullPage.js') ?>
<?= $this->Html->script('stop/examples.js') ?>
<?= $this->Html->script('stop/snap.svg-min.js') ?>

    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?= $this->Html->css('stop/font-awesome.min.css') ?>
<?= $this->Html->css('stop/style.css') ?>
<?= $this->Html->css('stop/animate.css') ?>
<?= $this->Html->css('stop/responsive.css') ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#fullpage').fullpage({
            anchors: ['Home', 'About-us', 'Services' , 'Contact-us'],
            sectionsColor: ['transparent', 'transparent', 'transparent' , 'rgba(0, 0, 0, 0.4)'],
            navigation: true,
            navigationPosition: 'right',
            navigationTooltips: ['Home', 'About-us', 'Services', 'Contact-us']
        });
    });
</script>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
   <?= $this->element('stop/menubar') ?>
   <div class="container-fluid absolute-container">
        <div class="container home-slider clearfix">
            <div class="row">
                <div class="col-md-6 logo">
                    <div class="row">
                    <a href="<?= BASEURL?>">
                        <img src="<?= BASEURL ?>images/logo.png" class="img-responsive">
                        </a>
                    </div><!--row-->
                </div><!--col-md-6-->
                
                <div class="col-md-6 buttons">
                    <div class="row">
                        <p><?= $this->Html->link('Sign Up',['controller'=>'users','action'=>'signup']) ?>
                          <?= $this->Html->link('Sign In',['controller'=>'users','action'=>'login']) ?>
                        </p>
                    </div><!--row-->
                </div><!--col-md-6-->
            </div><!--row-->
        </div><!--conatiner-->
    </div><!--container-fluid-->
    <?php 
    
    if($this->request->params['controller']=='Pages' && $this->request->params['action']=='home' ) { ?>
    <video id="bgvid" playsinline autoplay muted loop>
        <source src="<?= BASEURL?>uploads/stop/stop.mp4" type="video/mp4">
    </video>
    <div id="fullpage">
    <?php } else { ?>
        <div class="wrapper">
        <?php } ?>
    <?= $this->Flash->render() ?>
    
       <?php $this->assign('title','Home') ?>
    <div class="section " id="section0"><?php //pr($content); die; ?>
      <h2><?= (isset($content['home_title'])) ? $content['home_title']['content'] : '' ?></h2>    
      <!-- <h3>Keeping your drivers eyes on the road so that you don't have to. </h3> -->     
    </div>

    <div class="section" id="section1">
        <div class="intro">
        <div class="about-us-section top-sec">
          <div class="left-testimonials hide-mobile">
            <h2>Testimonials</h2>
            <div id="slideshow">
            <?php if($content['testimonials']) { 

              foreach($content['testimonials'] as $test)
              {

              ?>
               <div>
               <p><strong><?= $test['name'] ?>:</strong></p>
               <p><?= $test['content'] ?></p>

        
               </div>
               <?php }
            }
            ?>
               
            </div>
          </div><!--left-testimonials-->
          
          <div class="right-about-us">
            <h2><?= @$content['home_about']['title'] ?></h2>
            <p><?= @$content['home_about']['content'] ?></p>
            <a href="<?= BASEURL.@$content['home_about']['readmore'] ?>" class="read-more-btn">Read More</a>
            
        
          </div><!--right-about-us-->   
        
        </div><!--about-us-section-->
        
        
        
      </div>
  
    </div>
    
      
    <div class="section" id="section2">
      <div class="intro">
        <div class="col-md-12 col-xs-12 col-sm1-12 service-section">
          <div class="row">
            <div class="container service-section-container"> 
              <div id="bl-main" class="bl-main">
                <section class="first-block">
                  <div class="bl-box first">
                    <div class="blck-bg one"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/bus.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-about">BUSES</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/bus.png" class="img-responsive" alt="" />
                    </figure>
                    <h2><?= $content['home_busses']['title']?></h2>
                    <p><?= $content['home_busses']['content']?></p>
                   
                    
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                
                <section id="bl-work-section" class="second-block">
                  <div class="bl-box second">
                    <div class="blck-bg two"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/taxi.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-works">TAXIS</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/taxi.png" class="img-responsive" alt="" />
                    </figure>
                    <h2><?= $content['home_taxies']['title']?></h2>
                    <p><?= $content['home_taxies']['content']?></p>
                   
                    
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                <section class="third-block">
                  <div class="bl-box third">
                    <div class="blck-bg three"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/limo.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-about">LImousine</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/limo.png" class="img-responsive" alt="" />
                    </figure>
                     <h2><?= $content['home_limousine']['title']?></h2>
                    <p><?= $content['home_limousine']['content']?></p>
                   
                    
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                
                <section id="bl-work-section" class="forth-block">
                  <div class="bl-box forth">
                    <div class="blck-bg four"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/para.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-works">para transit</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/para.png" class="img-responsive" alt="" />
                    </figure>
                     <h2><?= $content['para_transit']['title']?></h2>
                    <p><?= $content['para_transit']['content']?></p>
                   
                    
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                <section class="fifth-block">
                  <div class="bl-box fifth">
                    <div class="blck-bg five"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/towing.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-about">towing</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/towing.png" class="img-responsive" alt="" />
                    </figure>
                      <h2><?= $content['towing']['title']?></h2>
                    <p><?= $content['towing']['content']?></p>
                   
                    
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                
                <section id="bl-work-section" class="sixth-block">
                  <div class="bl-box sixth">
                    <div class="blck-bg six"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/commercial.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-works">commercial fleet</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/commercial.png" class="img-responsive" alt="" />
                    </figure>
                      <h2><?= $content['commercial_fleet']['title']?></h2>
                    <p><?= $content['commercial_fleet']['content']?></p>
                   
                   
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                <section class="seventh-block">
                  <div class="bl-box seventh">
                    <div class="blck-bg seven"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/municipalities.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-blog">municipalities</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/municipalities.png" class="img-responsive" alt="" />
                    </figure>
                     <h2><?= $content['municipilaties']['title']?></h2>
                    <p><?= $content['municipilaties']['content']?></p>
                   
                    
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                <section class="eighth-block">
                  <div class="bl-box eighth">
                    <div class="blck-bg eight"></div>
                    <figure>
                      <img src="<?= BASEURL ?>images/custom.png" class="img-responsive" alt=""/>
                    </figure>
                    <h2 class="bl-icon bl-icon-contact">custom services</h2>
                  </div>
                  <div class="bl-content">
                    <figure>
                      <img src="<?= BASEURL ?>images/custom.png" class="img-responsive" alt="" />
                    </figure>
                     <h2><?= $content['custom_services']['title']?></h2>
                    <p><?= $content['custom_services']['content']?></p>
                   
                    
                  </div>
                  <span class="bl-icon bl-icon-close"><img src="<?= BASEURL ?>images/cross.png" class="img-responsive"/></span>
                </section>
                
              </div>
            </div><!-- /container -->
          </div><!--row-->
        </div><!--col-md-12-->
      </div>
    </div>
    <div class="section" id="section3">
      <div class="intro form-intro">
        
        <div class="form-div">
          <h2>Looking for more information? </h2>
          <?= $this->element('contact_form') ?>
        </div><!--form-div-->
        
        <?= $this->element('footer') ?>
        
        
        
        
      </div>
    </div>
    
    <?php  if($this->request->params['action']!=='home' ) { 
       echo $this->element('stop/footer'); 
         } ?>
    </div>
   


        <?= $this->Html->script('stop/classie.js') ?>
        <?= $this->Html->script('stop/main3.js') ?>
        <?= $this->Html->script('stop/boxlayout.js') ?>
        
        <script>
            $(function() {
                Boxlayout.init();
            });
        </script>
    <!--FULL SCREEN POPUP-->
    
    
    <!--INC DEC-->
     <script>
  jQuery(document).ready(function(){
    // This button will increment the value
    $('.qtyplus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});

  </script>
  <!--INC DEC-->
  
  <!--fade in fade out-->
  <script>
    $("#slideshow > div:gt(0)").hide();

setInterval(function() { 
  $('#slideshow > div:first')
    .fadeOut(1000)
    .next()
    .fadeIn(1000)
    .end()
    .appendTo('#slideshow');
},  3000);
</script>
</body>
</html>
