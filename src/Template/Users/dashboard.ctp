<div id="main">
    <div class="visible-md visible-xs visible-sm mobile-menu">
        <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
    </div>
    <section class="section bgw clearfix dashboard-master">
        <div class="col-md-12">
            <div class="tab-first menu-center">
                <!-- <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home1" aria-controls="home1" role="tab" data-toggle="tab">Overview</a></li>
                    <li role="presentation"><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab">Learners</a></li>
                    <li role="presentation"><a href="#courses" aria-controls="courses" role="tab" data-toggle="tab">Courses</a></li>
                    <li role="presentation"><a href="#settings1" aria-controls="settings1" role="tab" data-toggle="tab">E-Commerce</a></li>
                    </ul> -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home1">
                        <div class="tab-padding clearfix">
                            <div class="container-fluid">
                                <nav class="portfolio-filter clearfix text-center">
                                    <!-- <ul>
                                        <li><a class="btn btn-default" href="#" data-filter=".cat3">Profile</a></li>
                                        <li><a class="btn btn-default" href="#" data-filter=".cat1">Online Courses</a></li> 
                                        <li><a class="btn btn-default" href="#" data-filter=".cat2">Instructor Led Courses</a></li>
                                        </ul> -->
                                </nav>
                                <div id="fourcol" class="portfolio row overview">
                                    <div class="pitem item-w1 item-h1 cat3">
                                        <div class="profile-sec shop-item course-v2">
                                            <div class="shop-desc">
                                                <h4> My Profile</h4>
                                                <div class="content-widget" style="max-height:100%;">
                                                    <h2 class="name"> <?= ucfirst($u['fullname']) ?> </h2>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <figure>
                                                                <?php if($u['avatar']) {
                                                                    echo $this->Html->image(AVATAR.$u['avatar'],['id'=>'avatar_img']);
                                                                    
                                                                    } else { ?>
                                                                <img src="<?= BASEURL?>images/default_user.png" alt="" id="avatar_img"/>
                                                                <?php } ?>
                                                            </figure>
                                                        </div>
                                                        <ul class="profile-details col-sm-8">
                                                            <li><strong> Username : </strong> <br/> <span><?= $u['username'] ?></span> <br/> <br/></li>
                                                        </ul>
                                                        <a class="button button--wayra btn-block text-left" id="edit_profile_view" >Edit Profile<i class="fa fa-users pull-right" aria-hidden="true"></i> </a>
                                                        <div class="editform manager" >
                                                            <?= $this->Form->create($u,['type'=>'file','id'=>'edit_profile ']) ?>
                                                            <div class="form-group">
                                                            <?= $this->Form->input('fname',['label'=>'First Name','class'=>'form-control','required'=>true]) ?>
                                                            </div>
                                                            <div class="form-group">
                                                            <?= $this->Form->input('lname',['label'=>'Last Name','class'=>'form-control','required'=>true]) ?>
                                                            </div>
                                                            <div class="form-group">
                                                            <?= $this->Form->input('country_id',['label'=>'Country','class'=>'form-control','options'=>$this->Common->getCountry(),'required'=>true]) ?>
                                                            </div>
                                                            <div class="form-group">
                                                            <?= $this->Form->input('state_id',['label'=>'State','class'=>'form-control','required'=>true,'options'=>$this->Common->getStates($u['country_id'])]) ?>
                                                            </div>
                                                            <div class="form-group">
                                                            <?= $this->Form->input('city_id',['label'=>'City','class'=>'form-control','required'=>true,'options'=>$this->Common->getCities($u['state_id'])]) ?>
                                                            </div>
                                                            <div class="form-group">
                                                            <?= $this->Form->input('street',['label'=>'Street','class'=>'form-control','required'=>true]) ?>
                                                            </div>
                                                            <div class="form-group">
                                                            <?= $this->Form->file('avatar',['label'=>'Avatar','id'=>'avatar']) ?>
                                                            </div>
                                                            <div class="form-group">
                                                            <?= $this->Form->button('update',['type'=>'submit','id'=>'submit_profile','class'=>'btn btn-default']) ?>
                                                            </div>
                                                            <?= $this->Form->end() ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end content-widget -->                                 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pitem item-w1 item-h1 cat1 col-md-6">
                                        <div class="profile-sec shop-item course-v2">
                                            <div class="shop-desc">
                                                <h4> My Messages</h4>
                                                <div class="content-widget">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>User</th>
                                                                <th>Message</th>
                                                                <th>Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                foreach($messages as $msg) {
                                                                    $time = $msg->modified;
                                                                  //   $timestamp = new Time($msg->modified);
                                                                  //   $time = $timestamp->timeAgoInWords([
                                                                  //     'accuracy' => ['month' => 'month'],
                                                                  //     'end' => '1 year'
                                                                  // ]);
                                                                ?> 
                                                                <tr>
                                                                    <td><?= ucfirst($msg->sender->fname).' '.$msg->sender->lname ?></td>
                                                                    <td><?= $this->Text->truncate($msg->message,15) ?></td>
                                                                    <td><?= $time->format('d-m-Y, H:i A') ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end content-widget -->                                 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pitem item-w1 item-h1 cat2">
                                        <div class="profile-sec shop-item course-v2">
                                            <div class="shop-desc">
                                                <h4> My Recent Courses </h4>
                                                <div class="content-widget">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Course</th>
                                                                <th> Type </th>
                                                                <th> No. of Users</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($recentCourses as $rc) { ?>
                                                            <tr>
                                                                <td>
                                                                    <?= ucfirst($rc['title']) ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($rc['type']==1) { echo "Online"; } else { echo "Instructor Led";}?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->Common->get_enrolled_users($rc['id']) ?>
                                                                </td>
                                                            </tr>
                                                            <?php }  ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end content-widget -->                                 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end container -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </section>
    <!-- end section -->
</div>
</div><!-- end main -->
<!-- PORTFOLIO -->
<script src="<?= BASEURL?>js/isotope.js"></script>
<script src="<?= BASEURL?>js/imagesloaded.pkgd.js"></script>
<script src="<?= BASEURL?>js/masonry-home-01.js"></script>  
<?= $this->Html->script('../admin/js/common.js') ?>
<script type="text/javascript">
    $(document).ready(function(){
      $('#edit_profile_view').click(function(){
        $('.editform').toggle('slow');
      }); 
      function readURL(input) {
    
      if (input.files && input.files[0]) {
        var reader = new FileReader();
    
        reader.onload = function(e) {
          $('#avatar_img').attr('src', e.target.result);
        }
    
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    $("#avatar").change(function() {
      readURL(this);
    });
    
    });
</script>

