
<section class="product-page">
	<div class="container">
		<!-- <h2 class="top-heading">
			Medical Equipments for Sale
		</h2> -->
		<div class="col-md-12 topsection-equipment" style="color:#606060;padding:0px;">
		<?= $this->element('frontElements/equipment_top_section') ?>
		</div>
		<div class="clear"> &nbsp; </div>
		
		<div class="left-filters col-md-3">
		<?php //echo $category; ?>
		<?php echo $this->Form->create('search_form',array('class'=>'search_form','type'=>'get')) ?>
			

			<input class="search-text" name="keyword" id="keyword" placeholder="Search Marketplace" value="<?= $search['keyword'] ?>">
				<button type="submit" class="search_btn"><img src="<?php echo $this->webroot; ?>img/search.png"></button>
				<?php $user_id = $this->Session->read('Auth.User.id'); if($user_id)  {
					?>
					<a href="<?= HTTP_ROOT ?>signup2" class="sell-somthing">
					<?php 
				} else {   
					?>
					<a href="javascript:void(0);" data-toggle="modal" data-target="#myModalin" id="loginbut" class="sell-somthing" rel="nofollow">
					<?php
				}
					?>
				
				
			Sell Something <span class="plus">+</span></a>
			
			<div class="heads"> Categories </div>
			
			<ul>
			<li>	
				<div class="chkbut1 <?php if($category == '') { echo "btn-color"; } ?>" id="all">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons">  
								<label class="btn active">
									<input type="checkbox" name="category[]" value = "all" class="checkbox1" <?php if(!$search['category']) { echo "checked='checked'"; } ?>>  
								</label>
							</div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">All Listing</span>
						</span>
				</div>
					
					</li>
				<li>	
				<div class="chkbut1 <?php if($category == "Medical") { echo "btn-color"; } ?>" id="Medical">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons">  
								<label class="btn active">
									<input type="checkbox" name="category[]" value = "Medical" class="checkbox1" <?php if(in_array("Medical", $search['category'])) { echo "checked='checked'"; } ?>>  
								</label>
							</div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Medical</span>
						</span>
				</div>
					
					</li>
				<li>
				
				<div class="chkbut1 <?php if($category == "Dental") { echo "btn-color"; } ?>" id="Dental">
						<div class="chkbx-div ">
							<div class="check-box-btn" data-toggle="buttons"> <label class="btn active">   <input type="checkbox" name="category[]" value = "Dental" class="checkbox1" <?php if(in_array("Dental", $search['category'])) { echo "checked='checked'"; } ?>>   </label> </div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Dental</span>
						</span>
				</div></li>
				<li> <div class="chkbut1 <?php if($category == "Chiropractic") { echo "btn-color"; } ?>" id="Chiropractic">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons"> <label class="btn active">   <input type="checkbox" name="category[]" value = "Chiropractic" class="checkbox1" <?php if(in_array("Chiropractic", $search['category'])) { echo "checked='checked'"; } ?>>  </label> </div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Chiropractic</span>
						</span>
				</div></li>
				<li><div class="chkbut1 <?php if($category == "Podiatry") { echo "btn-color"; } ?>" id="Podiatry">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons">  <label class="btn active">   <input type="checkbox" name="category[]" value = "Podiatry" class="checkbox1" <?php if(in_array("Podiatry", $search['category'])) { echo "checked='checked'"; } ?>> </label></div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Podiatry</span>
						</span>
				</div></li>
				<li><div class="chkbut1 <?php if($category == "Laboratory") { echo "btn-color"; } ?>" id="Laboratory">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons">  <label class="btn active">   <input type="checkbox" name="category[]" value = "Laboratory" class="checkbox1" <?php if(in_array("Laboratory", $search['category'])) { echo "checked='checked'"; } ?>>  </label></div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Laboratory</span>
						</span>
				</div></li>
				<li> <div class="chkbut1 <?php if($category == "Optometry") { echo "btn-color"; } ?>" id="Optometry">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons">  <label class="btn active">  <input type="checkbox" name="category[]" value = "Optometry" class="checkbox1" <?php if(in_array("Optometry", $search['category'])) { echo "checked='checked'"; } ?>>  </label></div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Optometry</span>
						</span>
				</div></li>
				<li> <div class="chkbut1 <?php if($category == "Veterinary") { echo "btn-color"; } ?>" id="Veterinary">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons">  <label class="btn active">  <input type="checkbox" name="category[]" value = "Veterinary" class="checkbox1" <?php if(in_array("Veterinary", $search['category'])) { echo "checked='checked'"; } ?>>   </label></div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Veterinary</span>
						</span>
				</div></li>
				<li> <div class="chkbut1 <?php if($category == "Psychotherapy") { echo "btn-color"; } ?>" id="Psychotherapy">
						<div class="chkbx-div">
							<div class="check-box-btn" data-toggle="buttons">  <label class="btn active">  <input type="checkbox" name="category[]" value = "Psychotherapy" class="checkbox1" <?php if(in_array("Psychotherapy", $search['category'])) { echo "checked='checked'"; } ?>> </label></div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Psychotherapy</span>
						</span>
				</div></li>
				<li> <div class="chkbut1 <?php if($category == "Physical Therapy") { echo "btn-color"; } ?>" id="Physical-Therapy">
						<div class="chkbx-div">
						 <label class="btn active"> 
							<div class="check-box-btn" data-toggle="buttons">  <input type="checkbox" name="category[]" value = "Physical Therapy" class="checkbox1" <?php if(in_array("Physical", $search['category'])) { echo "checked='checked'"; } ?>></label></div>
						</div>
						<span class="check-custom-sat">
							<span class="text-sling-cntr">Physical Therapy </span>
						</span>
				</div> </li>
			</ul>
			
			<div class="heads"> Filters </div>
			<div class="filters">
				<div class="radio-btn"> <input class="radio" id="new" value="new" name="condition" <?php if($search['condition'] == "new") { echo "checked='checked'"; } ?> type="radio"> <label for="new"> New </label></div>
				<div class="radio-btn"> <input class="radio" id="used" value="used" name="condition" <?php if($search['condition'] == "used") { echo "checked='checked'"; } ?> type="radio"> <label for="used"> Used</label></div>		
			</div>
			<div class="price pricing">
				<label> Price </label>
				<input type="number" class="form-control" name="price_start" min="1" value="<?= $search['price_start'] ?>"/> <span> - </span>
				<input type="number" class="form-control" name="price_end"  min="1" value="<?= $search['price_end'] ?>"/>
				<p class="error" id="priceerror" style="color:red;">Please enter valid Price Range </p>
			</div>
			<div class="price">
				<label> Zip Code </label>
				<select name="distance" id="distance" class="form-control" style="padding:0px !important;"> 
				<option value="10" <?php if($search['distance'] == 10) { echo "selected='selected'"; } ?>> 10 MI  </option>
				<option value="25" <?php if($search['distance'] == 25) { echo "selected='selected'"; } ?>> 25 MI  </option>
				<option value="50" <?php if($search['distance'] == 50) { echo "selected='selected'"; } ?>> 50 MI  </option>
				<option value="100" <?php if($search['distance'] == 100) { echo "selected='selected'"; } ?>> 100 MI  </option>
				
				

				</select><span> of </span>
				<input type="number" name="zipcode" min="1" value="<?= $search['zipcode'] ?>" class="form-control" style="padding:2px !important;"/>
				<p class="error" id="zipcodeerror" style="color:red;">Please enter valid zip code </p>
			</div>
			
			<div class="form-group">
				<input type="button" class="btn blue-btn applybutt" value="Apply">
				<input type="button" class="btn white-btn" value="Reset" onClick="window.location.href='<?= HTTP_ROOT ?>equipment-for-sale'">
			</div>
			<?php echo $this->Form->end() ?>
		</div>
		
		<div class="right-products col-md-9">
		<?php 
		if($list):
		foreach($list as $sl) {
			
			?>
		<div class="col-md-3 listing_cust">
			<div class="column-box ">
				<figure>
				<?php if($sl['EquipmentImage']) { $bgimg = HTTP_ROOT.'img/listingImages/'.$sl['EquipmentImage'][0]['image']; } else { $bgimg = HTTP_ROOT."img/coming_soon-sq.jpg"; } ?>
					<a href="<?= HTTP_ROOT?>equipment-for-sale/<?= strtolower(str_replace(' ','-',$sl['Equipment']['keywords'])) ?>/<?= $sl['Equipment']['slug'] ?>" style="background-image : url(<?= $bgimg ?>)">
					
					</a>
				</figure>
				<div class="desc" style="min-height:130px;">
					<h4 class="title"><?= ucfirst($sl['Equipment']['title']) ?> </h4>
					<span class="cost"> $<?= $sl['Equipment']['price'] ?></span>
					<span class="dest"> <?= $this->App->timeAgo($sl['Equipment']['created']) ?> | <?= $sl['Equipment']['city'] ?></span>
				</div>
			</div>
			</div>
			<?php } else : ?>
			<div class="notfoundtext">
			 Listing not found!
			</div>
			<?php endif; ?>
			
			<?php 
			$page= $this->Paginator->params();
			if(!$category)
			{
				$options[] = strtolower($category);
			}
			else
			{
				$options = [];
			}
			if($page['count'] > 12) {
				
				$this->Paginator->settings['paramType'] = 'querystring';
				$this->Paginator->options['url'] = [strtolower($category),'?'=>$search];
				//$this->Paginator->options['link'] = '/equipment-for-sale/';
				

				?>
			 <div class="box-header">
			
    <span class="span-top"><?php echo $this->Paginator->counter('{:start} - {:end}'); ?> of <?php echo $total= $page['count'];?> Listings.</span>
    <ul class="pagination">
    
        <?php echo $this->Paginator->prev('« Previous', array_merge(array('escape' => false, 'class' => 'prev'),$options ), null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->numbers(); ?>
        <?php echo $this->Paginator->next('Next »',  array_merge(array('escape' => false, 'class' => 'prev'),$options ), null, array('class' => 'disabled')); ?> 
    </ul>                   
</div>
<?php } ?>
		</div>
	</div>
</section>

<style>
 .text-sling-cntr::before {
    /* symbol for "opening" panels */
    font-family: 'FontAwesome';  /* essential for enabling glyphicon */
    content: "\f00c";    /* adjust as needed, taken from bootstrap.css */
    float: left;        /* adjust as needed */
    color: #fff;         /* adjust as needed */
    position: absolute;
    left: -16px;
}
.text-sling-cntr {
    position: relative;
    text-align: center;
    font-size: 12px;
}
.left-filters ul li {
    display: inline-block;
    width: 100%;
    float: left;
    padding-bottom: 9px;
}
.left-filters ul{padding-left:0;margin-left:0;}
.chkbut1{width:100%;}
#zipcodeerror,#priceerror{display:none;}
</style>

<script>
	$(document).ready(function(){
		$('.applybutt').click(function(){
			var zip = $('input[name=zipcode]').val();
			var pend = $('input[name=price_end]').val();
			var pstart = $('input[name=price_start]').val();
			if((pstart && pstart < 0) || (pend && pend < 1) || (pstart && pend && pstart > pend) )
			{
				$('#priceerror').fadeIn();
			}
			else
			{
			if(zip && zip.length < 4 || zip.length > 6 && zip < 1)
			{
				$('#zipcodeerror').fadeIn();
			}
			else
			{
				$('#zipcodeerror').hide();
				$('.search_form').submit();
			}
		}
		});
		$('.chkbut1').click(function(){
			var getval = $(this).attr('id');
			if(getval == "all")
			{
				window.location.href = "<?= HTTP_ROOT ?>equipment-for-sale";
			}
			else
			{
				window.location.href = "<?= HTTP_ROOT ?>equipment-for-sale/"+getval.toLowerCase();
			}

		});
	});
</script>