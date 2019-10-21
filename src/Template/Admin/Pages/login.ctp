<?= $this->layout = false; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
          <?= $this->Flash->render() ?>
            <?= $this->Form->create('login') ?>
              <h1>Login Form</h1>
              <div>
               <?= $this->Form->input('email',['label'=>false,'class'=>'form-control','placeholder'=>'Username','required'=>'true']) ?>
               
              </div>
              <div>
               <?= $this->Form->input('password',['label'=>false,'class'=>'form-control','placeholder'=>'Username','required'=>'true']) ?>
                
              </div>
              <div>
              <?= $this->Form->submit('Log in',['class'=>'btn btn-default submit']) ?>
                
               <!-- <a class="reset_pass" href="#">Lost your password?</a> -->
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                
                <div>
                  <h1></h1>
                  <p>©2016 All Rights Reserved. </p>
                </div>
              </div>
           <?= $this->Form->end() ?>
          </section>
        </div>


      </div>
    </div>
  </body>
</html>
