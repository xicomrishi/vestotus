<?= $this->assign('title','Manage Finance Admin Users') ?>
       <?= $this->element('company_header') ?>
       <section id="inner-content">
<div id="tabs">
                  <ul>
                    
                    <li><a href="#tabs-customers">Manage Finance admin</a></li>
                   <!-- <li><a href="#tabs-dashboard">Company info</a></li> -->
                  </ul>
                  
                      <!-- <div id="tabs-dashboard" >

                         <section id="leads-table-wrap">
                       <?= $this->Form->create($company,['default'=>false]) ?>
                      <div class="leads-table">
                          <div class="lead-tablehead">
                                <div class="contact-field">Field</div>
                                <div class="contact-value">Value</div>
                            </div>
                            <div class="lead-tabledata">
                                <div class="contact-row1">Company Name</div>
                                <div class="contact-row2">
                                <?= $this->Form->input('company_name',['label'=>false]) ?>
                               </div>
                            </div>
                            <div class="lead-tabledata">
                                <div class="contact-row1">Email</div>
                                <div class="contact-row2"><?= $this->Form->input('email',['label'=>false]) ?></div>
                            </div>
                            <div class="lead-tabledata">
                                <div class="contact-row1">Telephone</div>
                                <div class="contact-row2"><?= $this->Form->input('telephone',['label'=>false]) ?></div>
                            </div>
                            <div class="lead-tabledata">
                                <div class="contact-row1">Address</div>
                                <div class="contact-row2"><?= $this->Form->input('address',['label'=>false]) ?></div>
                            </div>
                            <div class="lead-tabledata">
                                <div class="contact-row1"></div>
                                <div class="contact-row2"><?= $this->Form->submit() ?></div>
                            </div>
                          
                        </div>
                       
                        
            <input type="button" value="Edit" class="btn btn-block tab-btn btn-success" onclick="company.util.EditorFor(this)" data-id="1021" data-url="/Admin/Company/EditorForCompany" data-customer-edit-tab-type="ContactInfo" data-mode-type="Edit">
        
    
                    </section>
                      </div> -->
                      <div class="add-finance-admin">
			<div class="toggle-content pp_inline">
				<form method="post" accept-charset="utf-8" inputdefaults=" " action="/digitura/admin/users/admin_finance/28">
					<div style="display:none;">
						<input name="_method" value="PUT" type="hidden">
					</div>
					<div class="toggles-container">
						<div class="toggle-wrap">
							<div class="toggle-title clicked">
								Finance Admin
								
								<a href="#_" class="expand"> <i class="fa fa-plus"></i> </a>
							</div>
							<div class="toggle-content">
								<div class="fm-fild">
									Full Name
									<div class="spacer-10"></div>
									<div class="input text required">
										<input name="fullname" required="required" maxlength="50" id="fullname" type="text">
									</div>
									<div class="spacer-10"></div>
								</div>
								<div class="fm-fild">
									Email
									<div class="spacer-10"></div>
									<div class="input email required">
										<input name="email" required="required" maxlength="50" id="email" type="email">
									</div>
									<div class="spacer-10"></div>
								</div>
								<div class="fm-fild">
									Select Company
									<div class="spacer-10"></div>
									<div class="input select required">
										<select name="company_id" readonly="readonly" required="required" id="company-id">
											<option value="">-- Select --</option><option value="8" selected="selected">Xicom Technologies</option><option value="11">Company 01</option><option value="13">123</option>
										</select>
									</div>
									<div class="spacer-10"></div>
								</div>

								<div class="fm-fild">
									Department
									<div class="spacer-10"></div>
									<div class="input select required">
										<select name="department" required="required" id="department">
											<option value="">Select Department</option><option selected="selected">Finance</option>
										</select>
									</div>
									<div class="spacer-10"></div>
								</div>

								<div class="fm-fild">
									&nbsp;<div class="spacer-10"></div>
									<div class="submit">
										<input class="btn simple-button margin-bttn" value="Submit" type="submit">
									</div>
									<button type="button" id="" class="simple-button cancel-btn margin-bttn">
										Cancel
									</button>
									<div class="spacer-10"></div>
								</div>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
                      
                      <div class="clear"> </div>
                      
                      
                      <div id="tabs-customers">
    
                 <section id="leads-table-wrap">
               <!--     <div class="my-tog">
                        
                        <a href="javascript:void(0);" onclick="customer.util.addEditCustomer(this, 'NewUser-form-container')" data-url="/admin/admin_finance/" class="plus-btn"><i class="fa fa-plus"></i></a>
                    </div>
  <div class="toggle-content" id="NewUser-form-container">
                        </div>-->


                            	<div class="leads-table">
                            		<div class="lead-tablehead">
                                <div class="checkbox"><input type="checkbox" /></div>
                                		<div class="table-cell">Name</div>
                                     	<div class="table-cell">Email</div>
                                     	<div class="table-cell">Company </div>
                                      <div class="table-cell">Department</div>
                                     	<div class="table-cell">Created</div>
                                        <div class="table-cell">Status</div>
                                        <div class="table-cell">Action</div>
                              		</div>
                              		<?php if(count($list)>0) { foreach($list as $list) {//print '<pre>';print_r($list);exit; ?>
                                	<div class="lead-tabledata">
                                   <div class="checkbox"><input type="checkbox" /></div>
                                    	<div class="table-cell"><?= $list['user']['fullname'] ?></div>
                                     	<div class="table-cell"><?= $list['user']['email'] ?></div>
                                     	<div class="table-cell"><?= $list['company']['company_name'] ?></div>
                                      <div class="table-cell"><?= $list['department'] ?></div>
                                        <div class="table-cell"><?= $list['user']['created']->nice() ?></div>
                                        <div class="table-cell"><?php if($list['user']['status']=='1') { echo "Active"; } else { echo "In-Active"; } ?></div>
                                        <div class="table-cell"><?= $this->Html->link($this->Html->image(BASEURL.'admin/images/leadcontactreferral.png'),['action'=>'admin_finance',$list['user_id']],['escape'=>false]) ?>
                                        	<?= $this->Html->link($this->Html->image(BASEURL.'admin/images/trash.png'),['action'=>'finance_delete',$list['user_id']],['confirm'=>'Do You want to delete this User ?','escape'=>false]) ?>

                                        </div>
                                	</div>
                                	<?php }} else { echo 'No Data';} ?>
                              </div>  	
                        	</section>

                        	 <?= $this->element('paginator') ?>
               
                   </div>
                   </div>
                   </section>
                   <script type="text/javascript">
                    jQuery(function() {
                        jQuery( "#tabs" ).tabs();
                    });
                  </script>