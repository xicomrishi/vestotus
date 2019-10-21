<?= $this->Html->css('message'); ?> 
<div id="main">
	<div class="visible-md visible-xs visible-sm mobile-menu">
		<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
	</div>
	<section class="bgw clearfix course-detail-master">           	
		<div class="page-title bgg">
			<div class="container-fluid clearfix">
				<div class="title-area pull-left">
					<h2>Messages</h2>
				</div><!-- /.pull-right -->
				<div class="pull-right hidden-xs">
					<div class="bread">
						<ol class="breadcrumb">
							<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
							<li class="active">Messages from admin</li>
						</ol>
					</div><!-- end bread -->
				</div><!-- /.pull-right -->
			</div>
		</div><!-- end page-title -->
		<section class="section bgw">
			<div class="container-fluid">
				<div class="row">			                    
					<div id="post-content" class="col-md-12 col-sm-12 single-course">
						<hr class="invis">
						<div class="leaners-table clearfix">
							<div class="big-title">
								<h2 class="related-title">
								<span>Message List</span>
								</h2>

								<div class="message-area">
								     <div class="left-section">
								         <a class="user-role" href="javascript:void(0)"><h2 class="contact-heading">Admin <i class="fa fa-angle-down"></i></h2></a>
								     </div>
								     <div class="right-section">
								        <div class="message-row">
								          	<?= $this->Html->css('message'); ?> 
											<?php
											if(!empty($messages))
											{
											    foreach($messages as $message)
											    {
													
											        if($message['sender_id']==$userid)
											        {
														$avatar = $this->__getUserImage($message['sender_id']);
											            echo '<div class="msg_container">
											                      <img src="'.$avatar.'" alt="Avatar">
											                      <p>'.$message['message'].'</p>
											                      <span class="time-right">'.$message['created'].'</span>
											                  </div>';
											        }
											        else
											        {
														$avatar = ADMIN_AVATAR;
											            echo '<div class="msg_container darker">
											                      <img src="'.$avatar.'" alt="Avatar" class="right">
											                      <p>'.$message['message'].'</p>
											                      <span class="time-left">'.$message['created'].'</span>
											                  </div>';
											        }
											    }
											}
											else
											{
											    echo "Start conversation";
											}
											  
											?>
								        </div>
								        <div class="send-msg">
							              	<?= $this->Form->create('Message', array('url' => '/messages/add','id'=>'MessageAddForm')); ?>
									            <input name="message" class="form-control input-msg" type="text" placeholder="Enter Your Message" id="Messagebox">
									           	<?php echo  $this->Form->hidden('receiver_id', array("value" => 33)); ?>
									           	<input class="btn btn-primary sent-btn" value="Send" type="submit">
							              	<?= $this->Form->end(); ?>
								        </div>
							     	</div>
							 	</div>

							</div><!-- end big-title -->

						</div><!-- end course-table -->			
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section><!-- end section -->
	</section><!-- end section -->
</div><!-- end main -->
<?= $this->Html->script('chatuser'); ?> 