<section class="product-page">
	<div class="container">
	<?php $user_id = $this->Session->read('Auth.User.id');
	//echo json_encode($listing);exit;
	 ?>
	<div class="top-bredcumb">
		<div class="col-sm-6 bredcumb">
			<a href="<?= HTTP_ROOT ?>equipment-for-sale">Marketplace</a> <span>></span> <span><?= $listing['Equipment']['keywords'] ?></span>
		</div>
		<div class="col-sm-6 text-right">
		<span class="right-desc text-right"><?= $this->App->timeAgo($listing['Equipment']['created']) ?> |<?= $listing['Equipment']['city'] ?>, <?= $listing['Equipment']['zipcode'] ?></span>
		</div>
		</div>
	
		<div class="clear"> &nbsp; </div>
		<div class="product-inner">
		<?php echo $this->Session->flash(); ?>
			<div class="col-sm-8 ">
				<h2 class="product-title"><?= ucfirst($listing['Equipment']['title']) ?></h2>
				<h3 class="product-price">$<?= $listing['Equipment']['price'] ?></h3>
				<div class="col-sm-6 pd-left">
			        <div id="carousel" class="carousel slide" data-ride="carousel">
			            <div class="carousel-inner">
			            <?php 
			            $i = 0;
			            if($listing['EquipmentImage']):
			            foreach($listing['EquipmentImage'] as $img) { ?>
			                <div class="item <?php if($i == 0) { echo "active"; } ?>"">
			                    <img src="<?= HTTP_ROOT?>img/listingImages/<?= $img['image'] ?>">
			                </div>
			                <?php $i++; } else :?>
			                <div class="item active">
			                    <img src="<?= HTTP_ROOT?>img/coming_soon.jpg">
			                </div> 
			               <?php endif; ?>
			               
			            </div>
			        </div> 
				    <div class="clearfix">
				        <div id="thumbcarousel" class="carousel slide" data-interval="false">
				            <div class="carousel-inner">
				                <div class="item active">
				                 <?php 
						            $j = 0;
				                    if($listing['EquipmentImage']):
						            foreach($listing['EquipmentImage'] as $img) { ?>
						            	  <div data-target="#carousel" data-slide-to="<?= $j ?>" class="thumb">
									<img src="<?= HTTP_ROOT?>img/listingImages/<?= $img['image'] ?>"></div>
						               
				                <?php $j++; } else : ?>
				                   <div data-target="#carousel" data-slide-to="0" class="thumb">
				                    <img src="<?= HTTP_ROOT?>img/coming_soon.jpg"></div>
				                    <?php endif; ?>
				                  
				                </div><!-- /item -->
				               
				            </div><!-- /carousel-inner -->
				        
				        </div> <!-- /thumbcarousel -->
				    </div><!-- /clearfix -->
			    </div> <!-- /col-sm-6 -->
			    
			    <div class="col-sm-6 signle-product-detail">
			        <h3>Product Details</h3>
			        <?php if($listing['Equipment']['brand']) { ?><p><b>Brand: </b> <?= ucfirst($listing['Equipment']['brand']) ?></p> <?php } ?>
			        <?php if($listing['Equipment']['model_num']) { ?><p><b>Model No: </b> <?= $listing['Equipment']['model_num'] ?></p> <?php } ?>
			        <?php if($listing['Equipment']['mnfr_yr']) { ?><p><b>Manufacture Year: </b> <?= $listing['Equipment']['mnfr_yr'] ?></p> <?php } ?>
			        <?php if($listing['Equipment']['condition']) { ?><p><b>Condition: </b> <?= ucfirst($listing['Equipment']['condition']) ?></p> <?php } ?>
			         <?php if($listing['Equipment']['shipping']) { ?><p><b>Shipping: </b> <?= ucfirst($listing['Equipment']['shipping']) ?></p> <?php } ?>
			        <p><b>Description:</b>  <?= nl2br($listing['Equipment']['description']) ?></p>
			
			    </div> <!-- /col-sm-6 -->
			    <div class="commentDiv">
				<div class="comments-section col-md-12" id="commentArea">
					<div class="comment-count">
						Comments <span> <?php echo count($listing['Comment']); ?> </span>
						<input type="hidden" id="total_comments" value="<?php echo count($listing['Comment']) ?>">
					</div>
					<div class="comment-contain" id="comment_section">
					
						<?php /*foreach($listing['Comment'] as $c) {
							$cid = base64_encode(convert_uuencode($c['id']));
							?>
						<div class="comments-sec">
							<figure>
							<?php
							if($c['User']['image'])
							{
								$imgu = HTTP_ROOT."img/UsersImages/".$c['User']['image'];
							}
							else
							{
								$imgu = HTTP_ROOT."images/avatar1.png";
							}
							?>
								<img src="<?php echo $imgu; ?>" class="">
							</figure>
							<div class="right-comments">
								<div class="name">
									<?php echo ucfirst($c['User']['firstname'].' '.$c['User'] ['lastname']); ?>
								</div>
								<?php if($user_id == $c['user_id']) {?>
								<div class="delete"><a href="<?php echo HTTP_ROOT ?>equipments/comment_status/delete/<?php echo $cid; ?>"> <i class="fa fa-trash" aria-hidden="true"></i></a> </div>
								<?php } ?>
								<div class="date-time"> <?php echo $this->App->timeAgo($c['created']); ?></div>
								<div class="comments"> <?php echo $c['message']; ?> </div>							
							</div>												
						</div>
						<?php } */ ?>
						
					</div>
					<div class="loadmore" >
					<a href="javascript:void(0);" id="loadmore"> Load More </a>
					</div>
					<?php echo $this->Form->hidden('equipment_id',['value'=>$listing['Equipment']['id'],'id'=>'equipment_id']) ?>
					<?php if($user_id) {?>
					<div class="comments-forms">
					<p class="success_msg"> </p>
					<p class="error_msg"> </p>
					<?php echo $this->Form->create('comment',array('url'=>array('action'=>'saveComment'),'id'=>'commentform')) ?>
					<?php echo $this->Form->hidden('equipment_id',['value'=>$listing['Equipment']['id'],'id'=>'equipment_id']) ?>
						<div class="form-group full">
							<label> Comment </label>
							<textarea type="text" name="message" id="message" class="text-area form-control" placeholder="Type your Message here.."></textarea>							
						</div>
						
						<div class="form-group">
							<button class="btn submit-btn" type="button" id="comment_submit"> Submit </button>														
						</div>	
						<?php echo $this->Form->end() ?>								
					</div>	
					<?php } ?>							
				</div>
				<?php if(!$user_id) {?>
				<div class="before-login col-md-12">
					<a class="red-btn btn " href="#_" data-toggle="modal" data-target="#myModalin"> Login </a>
					<span> You must Login to post a comment </span>										
				</div>
				<?php } ?>
			</div>
			</div>
			<div class="col-sm-4">
				<div class="outer_form">
					<h3 class="title_form">Inquire about this Listing</h3>
				<form  id="inquiry" class="form-horizontal" method="Post" action="javascript:void(0);">
						<div class="align-center">
						<?php //echo $this->Session->flash(); ?>
						<input type= "hidden" id= "list_id" name = "data[Equipment][listing_id]" value="<?php  echo $listing['Equipment']['id']; ?>">
							<div class="form-group no-marg">
								<input type="text" placeholder="First Name" name="data[InquireListing][name]" class="form-control">
							</div>	
							<div class="form-group no-marg">
								<input type="text" placeholder="Last Name" name="data[InquireListing][last_name]" class="form-control">
							</div>	
							<div class="form-group no-marg">
								<input type="text" placeholder="Phone" name="data[InquireListing][phone]" class="form-control">
							</div>	
							<div class="form-group no-marg">
								<input type="text" placeholder="Email" name="data[InquireListing][email]" class="form-control">
							</div>
							<div class="form-group no-marg">	
								<textarea rows="10" placeholder="Type Your Message Here..." class="form-control" name="data[InquireListing][message]" cols="5" onkeydown="if(event.keyCode == 13) { event.returnValue = false; return false; }"></textarea>
							</div>	
                            <div class="form-group no-marg">
                               	<div id="captchaContainer1" class="g-recaptcha captcha-response">
                               	</div>
                         	</div>
						<div class="form-group no-marg">
						<?php 
						
						if($user_id !== $listing['Equipment']['user_id']) { ?>
							<button id="inquiresubmit" type="submit" class="sub form-control">Submit</button>	
							<?php } ?>
							</div>	
						</div>	
					</form>
			</div>
			<div class="social_cions">
            <?php
            $url = HTTP_ROOT.'equipment-for-sale/'.strtolower($listing['Equipment']['keywords']).'/'.$listing['Equipment']['slug'];
            $ld = "https://www.linkedin.com/shareArticle?mini=true&url=".$url."&title=".$listing['Equipment']['title']."&summary=".$listing['Equipment']['description']."&source=";
            $gplus = "https://plus.google.com/share?url=".$url;
            $fblink = "https://www.facebook.com/sharer/sharer.php?u=".$url;
            $tweet = "https://twitter.com/home?status=".$url;
            ?>
				<a href="<?= $tweet ?>" target="_blank"><img src="<?php echo $this->webroot; ?>img/tw.png"></a>
				<a href="<?= $fblink ?>" target="_blank"><img src="<?php echo $this->webroot; ?>img/fb.png"></a>
				<a href="<?= $gplus ?>" target="_blank"><img src="<?php echo $this->webroot; ?>img/gl.png"></a>
				<a href="<?= $ld ?>" target="_blank"><img src="<?php echo $this->webroot; ?>img/in.png"></a>
			
			</div>
			</div>
		
		</div>
		
		<div class="right-products cutom_m col-md-12">
		<h3 class="title_cutom3">Similar Products</h3>
		<?php foreach($sl as $sl){?>
			<div class="col-md-3 listing_cust">
			<div class="column-box ">
				<figure>
				<a href="<?= HTTP_ROOT?>equipment-for-sale/<?= strtolower(str_replace(' ','-',$sl['Equipment']['keywords'])) ?>/<?= $sl['Equipment']['slug'] ?>">
                <?php if($sl['EquipmentImage']) {?>
					<img src="<?= HTTP_ROOT.'img/listingImages/'.$sl['EquipmentImage'][0]['image'] ?>" />
                    <?php } else { ?>
                        <img src="<?= HTTP_ROOT ?>img/coming_soon-sq.jpg" />
                    <?php } ?>
					</a>
				</figure>
				<div class="desc">
					<h4 class="title"><?= ucfirst($sl['Equipment']['title']) ?> </h4>
					<span class="cost"> $<?= $sl['Equipment']['price'] ?> </span>
					<span class="dest"> <?= $this->App->timeAgo($sl['Equipment']['created']) ?> | <?= $sl['Equipment']['city'] ?></span>
				</div>
			</div>
			</div>
			<?php } ?>
			
		
		
		</div>
	</div>
	<div class="modal fade sign-up" id="done" tabindex="-1" role="dialog" aria-labelledby="done">
    <div class="modal-dialog modal-md modal-marg1" role="document">
        <div class="modal-content border">
            <div class="modal-header news-head-pad">
			    <div class="news-logo">
			      	<img src="<?php echo HTTP_ROOT. 'img/news-logo.png'?>" class="img-responsive" alt="Clineeds">
			      		<a href="javascript:void(0);" data-dismiss="modal" class="news-close-btn-set">x</a>
			    </div>
			</div>
                <div class="modal-header heading">
                    <!-- <a class="modal-clos-btn" data-dismiss="modal" href="javascript:void(0);">X</a> -->
                    <h4 style="text-align: center">Your message has been sent!<br>
                   
                </div>
                <div class="modal-body text-set">
                <form  action="<?php echo HTTP_ROOT.'blog/' ?>">
                    <div class="login-div">
                        <div class="signup-but1 marg-top" >  
							
					        <button type="button" style="margin-right:20px;" class="btn btn-primary news-but inquire-btn-set2" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</section>
<?php echo $this->Html->script(
    array(
        'frontend_js/reCaptcha2.min.js')
    );
?>
<script type="text/javascript">
 $(document).ready(function(){
	
     
     
 $("#inquiry").formValidation({
        framework: "bootstrap",
        excluded: [":disabled"],
        icon: {
            valid: "glyphicon glyphicon-ok",
            invalid: "glyphicon glyphicon-remove",
            validating: "glyphicon glyphicon-refresh"
        },
        err: {
            container: "popover"
        },
        addOns: {
            reCaptcha2: {
                element: 'captchaContainer1',
                theme: 'light',
                siteKey: '6LeouwwUAAAAAMB3AkDsCm12sFgLkcL6WOhGNLCa',
                timeout: 120,
                message: 'The captcha is not valid'
            }
        },
        fields: {
            "data[InquireListing][name]": {
                validators: {
                    notEmpty: {
                        message: "This field is required"
                    },
                    stringLength: {
                        min: 3,
                        max: 100,
                        message: "The Name must be more than 2 and less than 100 Characters"
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: "The First name can consist of alphabetical characters and spaces only"
                    }
                }
            },
             "data[InquireListing][last_name]": {
                validators: {
                    notEmpty: {
                        message: "This field is required"
                    },
                    stringLength: {
                        min: 3,
                        max: 100,
                        message: "The Last Name must be more than 2 and less than 100 Characters"
                    },
                    regexp: {
                        regexp: /^[a-z\s]+$/i,
                        message: "The First name can consist of alphabetical characters and spaces only"
                    }
                }
            },
            "data[InquireListing][message]": {
                validators: {
                    notEmpty: {
                        message: "This field is required"
                    },
                    stringLength: {
                        min: 25,
                        message: "The Message must be 25 Characters Long"
                    }
                }
            },
            "data[InquireListing][phone]": {
                validators: {
                    notEmpty: {
                        message: "This field is required"
                    },
                    stringLength: {
                        min: 10,
                        max: 12,
                        message: "The Phone number must be more than 9 and less than 13 digits long"
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: "The Phonenumber can only consist of digits"
                    }
                }
            },
            "data[InquireListing][email]": {
                validators: {
                    notEmpty: {
                        message: "Email is required"
                    },
                    stringLength: {
                        message: "email length must be less than 50 characters",
                        max: function(e, a, s) {
                            return 50 - (e.match(/\r/g) || []).length
                        }
                    },
                    emailAddress: {
                        message: "This email is not a valid email address"
                    },
                    regexp: {
                        regexp: "^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$",
                        message: "The value is not a valid email address"
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        $('#inquiresubmit').text('Processing...');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            data: $('#inquiry').serialize(),
            url: ajax_url + 'equipments/inquire_listing',
            success: function(resp) {
                //console.log(resp);
            	$('#inquiresubmit').text('Message Sent');
                if ($.trim(resp) == "success") {
                    $('#done').modal('show');
                } else {}
            },
        })
    })
$("#done").on("hidden.bs.modal", function() {
        $("#inquiry").data("formValidation").resetForm(!0)
        window.location.reload();
    });
   	

});

$(document).ready(function(){
	getComments();
    $(".comment-count").click(function(){
        $(".comments-sec").toggleClass("show");
    });

   $(document).on('click','#comment_submit',function(){
   		var getmessage = $('#message').val();
   		var equipment_id = $('#equipment_id').val();
   		if(getmessage)
   		{
   			$('#comment_submit').attr('disabled','disabled');
   		$.post('<?php echo HTTP_ROOT ?>equipments/saveComment',{"message":getmessage,"equipment_id":equipment_id},function(response){
   			
   			var result = $.parseJSON(response);
   			if(result.status == 'success')
   			{

   				$('.success_msg').html('Comment submitted successfully for approval to admin.');
   				$('.success_msg').fadeIn();
   				$('.success_msg').delay(1000).fadeOut('slow');
   				$('#message').val('');
   			}
   			else
   			{
   				$('.error_msg').html(result.message);
   			}
   			$('#comment_submit').removeAttr('disabled','disabled');

   		});
   	}
   	else
   	{
   		$('.error_msg').fadeIn();
   		$('.error_msg').html("Please enter Message.");
   		$('.error_msg').delay(1000).fadeOut('slow');
   	}
   });
   $(document).on('click','#loadmore',function(){
   	var lastid = $('.comments-sec:last').attr('id');
   	if(lastid)
   	{
   	var id =  lastid.split('_');
   	id = id[1];
   }
   else
   {
   	var id = 0;
   }
   	getComments(id)
   });
   
   function getComments(last_id =null )
   {
   	var equipment_id = $('#equipment_id').val();

   	$.get("<?php echo HTTP_ROOT ?>equipments/getListingComment/"+equipment_id+"/"+last_id , function(response)
   	{
   		//console.log(response);
   		$('#comment_section').append(response);
   	
	   	var ttl_comment = $('#total_comments').val();
	   	var l = $('.comments-sec').length;
	  	//getlength = parseInt(getlength + 1);
	   	console.log(l+'/'+ttl_comment);
	   	if(l == ttl_comment)
	   	{
	   		$('#loadmore').hide();
	   	}
   	});

   }
});
</script>