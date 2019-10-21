<div id="loader">
  <div class="loader-container">
    <img src="<?= BASEURL?>images/load.gif" alt="" class="loader-site spinner">
  </div>
</div>
<!-- END PRELOADER -->
<!-- START SITE -->
<div id="wrapper">
  <div class="logo-wrapper logo-center">
    <button class="menu-button" id="open-button">
      <span> </span>
      <span> </span>
      <span> </span>
      <div class="nav-arrow">
        <div class="at"></div>
        <div class="ab"></div>
      </div>
    </button>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 text-center">
        <div class="site-logo">
          <!-- <a class="navbar-brand" href="<?= BASEURL?>"> <img src="<?= BASEURL?>images/logo-gry.png" class="header-logo"> </a> -->
          <?php
          // $a = $this->getUserCompanyInfo(@$activeuser->company_id);

          // $a = $this->Auth->user('company_id')->company;
          // pr($a); ?>
          <a class="navbar-brand logo-dash" href="<?= BASEURL?>"><?= $activeuser->company_name ?> </a>
        </div>
      </div><!-- end col -->
    </div><!-- end row -->
  </div><!-- end container -->
  <div class="col-md-3 right-buttons">
    <?php if(@$activeuser) 
    { 
      echo $this->Html->link('Logout',['controller'=>'Users','action'=>'logout'],['class'=>'btn btn-lg']);
    }
    else
    {
      echo $this->Html->link('Sign Up',['controller'=>'Users','action'=>'signup'],['class'=>'btn btn-lg']);
      echo "&nbsp;";
      echo $this->Html->link('Login ',['controller'=>'Users','action'=>'login'],['class'=>'btn btn-lg']);
    }
    ?>
  </div>
 </div>
        <!-- end logo-wrapper -->
