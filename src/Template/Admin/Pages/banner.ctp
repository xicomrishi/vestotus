
<?php $this->assign('title','Manage Banner') ?>
<div class="breadcrumbs">
             <a href="#">Admin</a> <span>&rtrif;</span>
              <a href="<?= BASEURL?>pages/banner">Manage Banner</a> 
            </div>
        	<section id="inner-content">
            	<div class="section-titlebar">
                	<h2 class="section-title"> Manage Banner</h2>
                </div>
<div class="toggle-wrap">
    <div class="clear"></div>
    <div class="toggle-content pp_inline edited-sec">
<?= $this->Form->create($setting,['type' =>'file','inputDefaults' => ['div' => false],'novalidate'=>'novalidate']); ?>
<?php
if($setting['banners'])
{
$imgs = explode(',',$setting['banners']);
}
else
{
	$imgs = [];
}
?>
<div class="toggles-container">
                	<div class="toggle-wrap">
                	 <div class="toggle-title">Banner Management</div>
                	   <div class="toggle-content">
						<div class="fm-fild1">
						Title
						 <div class="spacer-10"></div>
						 <div class="bnr">
						 <?php 
						 $ttlfiles = 5-count($imgs);
						 for($i=1;$i < $ttlfiles+1;$i++)
						 {
						 ?>
						<?= $this->Form->file('file[]',['type'=>'file','label'=>false,'id'=>'banner_'.$i,'class'=>'banner_upload']) ?>
						<?php } ?>
						
						</div>
						<div class="spacer-10"> </div>
						</div>

						
						<div class="fm-fild1">
						<ul class="files">
						<?php if($imgs)
						{
							
							foreach($imgs as $img)
							{
								?>
								<li>
								
									<?= $this->Html->image('../uploads/'.$img,['width'=>700,'height'=>200])?>
									<a href="<?= BASEURL?>admin/pages/del_banner/<?= $img; ?>" >Delete
								</a>
								</li>

								<?php
							}
						}
						?>
						</ul>
						 </div>

						
						 
						<div class="spacer-10"> </div>
						
						<div class="fm-fild1">
						
							<?= $this->Form->submit('Save',['escape'=>false,'div'=>false,'class'=>'btn simple-button margin-bttn']) ?>
							
						<div class="spacer-10"> </div>
						</div>
						</div></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.banner_upload').change(function(){
			var getid = $(this).attr('id');
			getid = getid.split('_');
			getid = getid[1];
			var reader = new FileReader();
			var ext = $(this).val().split('.').pop();
          	ext = ext.toLowerCase();
          	if(ext=='jpg' || ext=='jpeg'	 || ext=='png' || ext=='gif')
          	{
          		reader.onload = function (e) {
          			$('#banner_'+getid).hide();
          			var newid = parseInt(getid)+ parseInt('1');
          			$('#banner_'+newid).show();
          			
          			
		        	var img = '<li id="li_'+getid+'"><img src="'+e.target.result+'" width="700" height="200"> <a href="javascript:void(0);" class="del_image" id="'+getid+'">Delete </a> </li>';
		        	$('ul.files').append(img);
		        }
				reader.readAsDataURL(this.files[0]);
		    	}
		    	else
		    	{
		    		alert('please choose valid image.');
		    		$(this).val('');
		    	}
		        });

			$('ul.files').on('click','.del_image',function(){
			
			var getid = $(this).attr('id');
			$('li#li_'+getid).remove();
			$('.banner_upload').hide();
			$('#banner_'+getid).val('');
			$('#banner_'+getid).show();
		        });


	});
</script>
	<style type="text/css">
		#banner_2,#banner_3,#banner_4,#banner_5
		{
			display: none;
		}
		.files
		{
			list-style: none;
		}
		.files li
		{
			padding:10px;
		}
		.files li img
		{
			border: 1px solid #ccc;
		}
	</style>
						
						

		