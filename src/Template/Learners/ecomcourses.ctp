<?php use Cake\I18n\Time; ?>
<div class="col-md-9 col-sm-12 page-left-sidebar catalog" id="sidebar">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>E-Commerce Courses </span>
                </h2>
            </div>
            <div class="row course-grid">
            <?php foreach($ecom as $ecom){ ?>
                <div class="col-md-4 col-sm-12 col-xs-12 wow fadeIn">
                    <div class="shop-item course-v2">
                        <div class="post-media entry">
                            <!-- <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div> -->
                            <!-- old image-  if($ecom['thumbnail']){ ?>
                            <img src="<?= FILE_COURSE_THUMB.$ecom['thumbnail'] ?>" alt="" class="img-responsive" style="height:300px;">
                             } ?> -->

                            <?php if($ecom['thumbnail']){ 
                                $img = FILE_COURSE_THUMB.$ecom['thumbnail'];
                            } else{
                                $img = FILE_COURSE_THUMB_DEFAULT;
                            } ?>
                            <img src="<?= $img ?>" alt="" class="img-responsive" style="height:250px;"> <!-- 300px -->

                            <div class="magnifier">
                                <div class="shop-bottom clearfix">
                                    <?php $page = ($ecom['type'] == 1) ? 'view':'viewIled'; ?>
                                    <a href="<?= BASEURL ?>courses/addtocart/<?= $ecom['id'] ?>"><i class="fa fa-shopping-cart"></i></a>
                                    <a href="<?= BASEURL.'courses/'.$page.'/'.$this->Common->myencode($ecom['id']).'?buy=enable' ?>" title=""><i class="fa fa-search"></i></a> 

                                    <!-- $this->Html->link('<i class="fa fa-shopping-cart"></i>',['controller'=>'courses','action'=>'single',$this->Common->myencode($ecom['id'])],['escape'=>false]) ?>
                                    $this->Html->link('<i class="fa fa-search"></i>',['controller'=>'courses','action'=>'single',$this->Common->myencode($ecom['id'])],['escape'=>false]) ?> -->                                    
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
                                    <span class="hidden-xs"><i class="fa fa-graduation-cap"></i> <?= $this->Common->get_enrolled_users($ecom['id']) ?> Students</span>
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

                            <!-- <div class="shop-price clearfix">
                                <div class="pull-right">
                                    <small>CAD <?= $ecom['purchase_price'] ?></small>
                                </div>
                            </div>
                            <h3><a href="<?= BASEURL.'courses/'.$page.'/'.$this->Common->myencode($ecom['id']).'?buy=enable' ?>" title=""><?= $ecom['title'] ?></a></h3> --> 
                        </div>
                    </div><!-- end shop-item -->
                </div><!-- end carousel-item -->
                <?php } ?>
            </div><!-- end row -->
        </div>
    </div>
</div>