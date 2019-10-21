 <div id="sidebar2" class="col-md-3 col-sm-12 mob30">
                        <div class="widget clearfix">
                            <div class="member-profile">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>Contact</span>
                                    </h2>
                                </div><!-- end big-title -->

    <div class="loginform">
    <?= $this->Form->create('contactform',['class'=>'row','id'=>'cform','url'=>['controller'=>'users','action'=>'contactusform']]) ?>
    <div class="success" style="float: left; width: 100%;padding: 20px;color: green;display:none;"> Your Message has sent to our Administrator. </div>
    <div class="error" style="float: left; width: 100%;padding: 20px;;color: red;display:none;"> </div>
    <?= $this->Form->hidden('user_id',['value'=>$this->request->session()->read('Auth.User.id')]) ?>
            <div class="col-md-12">
            <?= $this->Form->input('name',['label'=>false,'required'=>true,'class'=>'form-control','placeholder'=>'Name']) ?>
            <?= $this->Form->input('email',['readonly'=>true,'label'=>false,'required'=>true,'class'=>'form-control','placeholder'=>'Email','value'=>$this->request->session()->read('Auth.User.email')]) ?>
            <?= $this->Form->input('phone',['label'=>false,'required'=>true,'class'=>'form-control','placeholder'=>'Phone']) ?>
            <?= $this->Form->textarea('comment',['label'=>false,'required'=>true,'class'=>'form-control','placeholder'=>'Your Bio']) ?>
            <?= $this->Form->submit('Contact',['class'=>'button button--wayra btn-block btn-square']) ?>
            
            
            </div>
        </form> 
    </div>
                            </div><!-- end team-member -->
                        </div>
                    </div><!-- end right -->