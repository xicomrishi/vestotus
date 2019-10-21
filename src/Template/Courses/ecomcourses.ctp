<?php use Cake\I18n\Time; ?>
<div class="page-title bgg">
    <div class="container clearfix">
        <div class="title-area pull-left">
            <h2>E-Commerce Courses <small></small></h2>
        </div><!-- /.pull-right -->
        <div class="pull-right hidden-xs">
            <div class="bread">
                <ol class="breadcrumb">
                    <li><a href="<?= BASEURL ?>users/dashboard">Home</a></li>
                    <li class="active">E-Commerce</li>
                </ol>
            </div><!-- end bread -->
        </div><!-- /.pull-right -->
    </div>
</div><!-- end page-title -->
<section class="section bgw">
    <div class="container">
        <div class="row course-grid">
        <?php foreach($ecom as $ecom){ ?>
            <div class="col-md-4 col-sm-12 col-xs-12 wow fadeIn">
                <div class="shop-item course-v2">
                    <div class="post-media entry">
                        <!-- <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div> -->
                        <?php if($ecom['thumbnail']){ 
                            $img = FILE_COURSE_THUMB.$ecom['thumbnail'];
                        } else{
                            $img = FILE_COURSE_THUMB_DEFAULT;
                        } ?>
                        <img src="<?= $img ?>" alt="" class="img-responsive" style="height:300px; width:100% !important">

                        <div class="magnifier" >
                            <div class="shop-bottom clearfix" >
                                <?php $page = ($ecom['type'] == 1) ? 'view':'viewIled'; ?>
                                <a href="<?= BASEURL ?>courses/addtocart/<?= $ecom['id'] ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="<?= BASEURL.'courses/'.$page.'/'.$this->Common->myencode($ecom['id']).'?buy=enable' ?>" title=""><i class="fa fa-search"></i></a> 
                                <!--   $this->Html->link('<i class="fa fa-shopping-cart"></i>',['action'=>'single',$this->Common->myencode($ecom['id'])],['escape'=>false]) 
                                $this->Html->link('<i class="fa fa-search"></i>',['action'=>'single',$this->Common->myencode($ecom['id'])],['escape'=>false])  -->

                            </div><!-- end shop-bottom -->

                            <div class="large-post-meta">
                                <span class="avatar">
                                <?php if($ecom['user']['avatar']){ echo $this->Html->image(AVATAR.$ecom['user']['avatar'],['height'=>20]);} ?> <?= $ecom['user']['fname'].' '.$ecom['user']['lname'] ?>
                                </span>
                                <small>&#124;</small>
                                <span><i class="fa fa-clock-o"></i> <?php 
                                $time = new Time($ecom->created->format('Y-m-d h:i:s'));
                                $t = $time->timeAgoInWords(
									    ['format' => 'MMM d, YYY', 'end' => '+1 year']
									);
                                $tex = explode(',',$t);
                                echo $tex[0];
								 ?></span>
                                <small class="hidden-xs">&#124;</small>
                                <span class="hidden-xs"><i class="fa fa-graduation-cap"></i> 
                                    <!--  $this->Common->get_enrolled_users($ecom['id']) -->
                                <?= (int)$ecom['enrollments']['0']['total'] ?>
                                Students</span>
                            </div><!-- end meta -->
                        </div><!-- end magnifier -->
                    </div><!-- end post-media -->
                    <div class="shop-desc">
                        <h3>
                            <a href="<?= BASEURL.'courses/'.$page.'/'.$this->Common->myencode($ecom['id']).'?buy=enable' ?>" title=""><?= $ecom['title'] ?></a> 
                            <!-- <a href="<?= BASEURL.'courses/single/'.$ecom['type'].'/'.$this->Common->myencode($ecom['id']) ?>" title=""><?= $ecom['title'] ?></a> -->
                            <div class="pull-right">
                                <small>CAD <?php  if($p = $this->get_course_price($ecom['id'] , $this->request->session()->read('Auth.User.id'))) { echo $p; } else { echo $ecom['purchase_price']; } ?></small>
                            </div>
                        </h3>
                        
                        <?php /*<div class="shop-price clearfix">
                            <div class="pull-right">
                                <small>CAD <?php  if($p = $this->get_course_price($ecom['id'] , $this->request->session()->read('Auth.User.id'))) { echo $p; } else { echo $ecom['purchase_price']; } ?></small>
                            </div>
                        </div>      
                        <h3><a href="<?= BASEURL.'courses/view/'.$this->Common->myencode($ecom['id']) ?>" title=""><?= $ecom['title'] ?></a></h3> */ ?>
                    </div>
                </div><!-- end shop-item -->
            </div><!-- end carousel-item -->
            <?php } ?>
            
        </div><!-- end row -->

        <nav class="clearfix text-center">
            <?= $this->element('paginationnew') ?>
            <!-- <ul class="pagination">
                <li><a class="active" href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">...</a></li>
                <li><a href="#">5</a></li>
                <li>
                <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
            </ul> -->
        </nav>

    </div><!-- end container -->
</section>