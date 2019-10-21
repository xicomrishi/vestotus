<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 nopad">
            <div class="member-cover instructor-sec1">
                <?php if($activeuser['profile_cover']) { ?>
                        <img src="<?=BASEURL?>uploads/user_data/<?=$activeuser['profile_cover']?>" width="1180" height="373">
                <?php } else { ?>
                    <img alt="" src="<?= BASEURL?>uploads/member-cover.jpg" class="img-responsive">
                <?php } ?>
                
                <div class="lightoverlay overlay"></div>
                <div class="authorbox">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="clearfix">
                                <div class="avatar-author">
                                    <a href="#">
                                    <?php if($activeuser['avatar']) { ?>
                                        <img src="<?=BASEURL?>uploads/user_data/<?=$activeuser['avatar']?>" width="80" height="80">
                                        <?php } else { ?>
                                        <img alt="" src="<?= BASEURL?>uploads/team_01.jpg" class="img-responsive">
                                    <?php } ?>
                                    </a>
                                </div>
                                <div class="author-title desc">
                                    <h4><a href="#"><?= $activeuser['fullname'] ?></a></h4>
                                    <p> Instructor </p>
                                    <!-- <a class="authorlink" href="https://showwp.com">https://showwp.com</a> 
                                    <ul class="list-inline social-small">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>-->
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end authorbox -->
            </div><!-- end cover -->
        </div>
    </div><!-- end row -->
</div>


<style>
.instructor-sec.member-cover .authorbox { padding: 0; right: 0; left: auto; bottom: auto; top: -150px;}
</style>