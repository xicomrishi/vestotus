
<?php $this->assign('title','Website Settings') ?>
<div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Website Settings <small> Update </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= $this->Form->create($setting,['type' =>'file','novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                    <?php $this->Form->templates($form_templates['fullForm']); ?>

                     
                      <!-- <span class="section">Please fill the details below</span> -->

                        <div class="item form-group">
                        
                        
                          
                           <?= $this->Form->input('contact_email',['label'=>'Support Email *','class'=>'form-control col-md-7 col-xs-12']) ?>
                        
                     </div>
                      <div class="item form-group">
                       
                          <?= $this->Form->input('fb_link',['label'=>'Facebook Link *','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>

                      <div class="item form-group">
                       
                          <?= $this->Form->input('twitter_link',['label'=>'Twitter Link *','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>

                      <div class="item form-group">
                     
                          <?= $this->Form->input('insta_link',['label'=>'Instagram Link *','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>

                        <div class="item form-group">
                     
                          <?= $this->Form->input('li_link',['label'=>'Linkedin Link *','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>


                      <div class="item form-group">
                       
                          <?= $this->Form->input('gplus_link',['label'=>'Googleplus Link','class'=>'form-control col-md-7 col-xs-12']) ?>
                        </div>


                      <div class="item form-group">
                      
                          <?= $this->Form->input('youtube_link',['label'=>'Youtube Link','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>

                       <div class="item form-group">
                      
                          <?= $this->Form->input('vimeo',['label'=>'vimeo Link','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>

                       <div class="item form-group">
                      
                          <?= $this->Form->input('skype',['label'=>'Skype Id','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>

                       <div class="item form-group">
                      
                          <?= $this->Form->input('pinterest',['label'=>'Pinterest','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>

                       <div class="item form-group">
                      
                          <?= $this->Form->input('contact_phone',['label'=>'Contact Phone','class'=>'form-control col-md-7 col-xs-12','min'=>0,'minLength'=>'10']) ?>
                       </div>

                       <div class="item form-group">
                      
                          <?= $this->Form->input('contact_address',['label'=>'Contact Address','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>
                       <div class="item form-group">
                      
                          <?= $this->Form->input('lat',['label'=>'Address Latitude','class'=>'form-control col-md-7 col-xs-12']) ?>
                       </div>
                       <div class="item form-group">
                      
                          <?= $this->Form->input('lng',['label'=>'Address Longitude','class'=>'form-control col-md-7 col-xs-12']) ?>
                          <p style="text-align:center;"><i class="fa fa-info-circle" aria-hidden="true"></i>  Below is the link to get Latitude / Longitude <br> <a href="http://www.latlong.net/" target="_blank">http://www.latlong.net/</a> </p>
                       </div>

                     
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                        <?= $this->Form->submit('Update',['escape'=>false,'div'=>false,'class'=>'btn btn btn-success']) ?>
							
						
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

						