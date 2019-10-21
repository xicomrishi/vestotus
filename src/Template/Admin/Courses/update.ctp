<?php $this->assign('title',"Manage Courses");
    $controller=new App\Controller\AppController();
    $departments=$controller->departments();
    //echo '<pre/>'; print_r(@$course); echo '</pre>';
?>
<div class="vestotus-updates">
    <!-- <div class="page-title">
        <div class="title_left">
            <h3>Manage Courses</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row"> -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Course Details <small> </small></h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul> -->
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="tab-first">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a tab="tab1" class="<?= @$class ?>"  <?php //if($formtype == 'edit') { ?> onClick="javascript:$('#back1').trigger('click');" href="#general" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="true" <?php //} ?>><i class="fa fa-graduation-cap"></i> General</a></li>
                            <li role="presentation" class="class-syllabus"><a id="tab2" <?php //if($formtype == 'edit') { ?> href="#syllabus" aria-controls="syllabus" onClick="javascript:$('#back2').trigger('click');" role="tab" data-toggle="tab" aria-expanded="true" <?php //} ?>><i class="fa fa-university" ></i> Syllabus </a></li>
                            <li role="presentation" class="class-availability"><a id="tab3" <?php //if($formtype == 'edit') { ?> href="#availability" onClick="javascript:$('#back3').trigger('click');" aria-controls="availability" role="tab" data-toggle="tab" aria-expanded="true" <?php //} ?>><i class="fa fa-home"></i> Availability</a></li>
                            <li role="presentation" class="class-competetion"><a id="tab4" <?php //if($formtype == 'edit') { ?> href="#competetion" onClick="showtab('competetion')" aria-controls="competetion" role="tab" data-toggle="tab" aria-expanded="true" <?php //} ?>><i class="fa fa-check-circle-o" aria-hidden="true"></i> Completion </a></li>
                            <li role="presentation" class="class-messages"><a id="tab5" <?php //if($formtype == 'edit') { ?> href="#messages" onClick="showtab('messages')" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="true" <?php //} ?>><i class="fa fa-envelope" aria-hidden="true"></i> Messages</a></li>
                            <li role="presentation" class="class-resources1"><a id="tab6" <?php //if($formtype == 'edit') { ?> href="#resources1" onClick="showtab('resources1')" aria-controls="resources1" role="tab" data-toggle="tab" aria-expanded="true" <?php //} ?>><i class="fa fa-cog" aria-hidden="true"></i> Resources </a></li>
                            <li role="presentation" class="class-complete"><a id="tab7" <?php if($formtype == 'edit') { ?> href="#complete"  role="tab" data-toggle="tab" aria-expanded="true" <?php } ?>><i class="fa fa-cog" aria-hidden="true"></i> Complete </a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="general">
                                <?= $this->Form->create(@$course,['role'=>'form','id'=>'olcourse','novalidate'=>true]) ?>
                                <?php $this->Form->templates($form_templates['frontForm']); ?>
                                <?= $this->Form->hidden('type',['value'=>1]) ?>
                                <?= $this->Form->hidden('tab_name',['value'=>'1'])?>
                                <div class="tab-padding clearfix">
                                    <div class="loginform general-form">
                                        <div class="form-group">
                                            <?= $this->Form->input('title',['class'=>'form-control','placeholder'=>'Title','Label'=>'Title']) ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <?= $this->Form->textarea('description',['class'=>'form-control','placeholder'=>'Description','Label'=>'Description']) ?>
                                        </div>
                                        <!--<div class="form-group">
                                            <label>Is Active </label>
                                            <input type="checkbox" name="status" <?php if($course['status']==2){ echo "checked='checked'"; } ?>  id="active" class="switch" value="1">
                                            <label for="active" class="checkbox-switch"> </label>
                                            
                                            </div> -->
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label>Thumbnail</label>
                                                    <?= $this->Form->file('thumbnail',['class'=>'btn btn-default']) ?>
                                                    <?php if($course['thumbnail']) { ?>
                                                    <img class="thumbs-img" src="<?= BASEURL.'uploads/courses/thumb/'.$course['thumbnail']?>" width="100"> 
                                                    <?php } ?>
                                                    <img src="">
                                                    <p class="help-block">Recommended size 250x200 jpg or png</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <label>Image</label>
                                                    <?= $this->Form->file('image',['class'=>'btn btn-default']) ?>
                                                    <?php if($course['image']) { ?>
                                                    <img class="thumbs-img" src="<?= BASEURL.'uploads/courses/'.$course['image']?>" width="100"> 
                                                    <?php } ?>
                                                    <p class="help-block">Recommended size 2400x759 jpg or png</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?= $this->Form->input('tag_id',['options'=>$tags,'value'=>explode(',',$course['tag_id']),'multiple'=>true,'empty'=>false,'class'=>'form-control','placeholder'=>'Tags']) ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <?= $this->Form->textarea('notes',['class'=>'form-control','placeholder'=>'Notes']) ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Course type</label>
                                            <?= $this->Form->input('online_course_type',['class'=>'form-control','placeholder'=>'Online test type', 'options'=> [ '1' => 'Online course', '2' => 'Competence course'] ]) ?>
                                        </div>
                                        <?= $this->Form->button('Save',['class'=>'btn btn-primary btn-square','id'=>'nextsyllabus']) ?>
                                    </div>
                                    <!-- end edit profile -->
                                </div>
                                <?= $this->Form->end() ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="syllabus">
                                <?= $this->Form->create(@$course,['role'=>'form','id'=>'olcourse2','novalidate'=>true]) ?>
                                <?php $this->Form->templates($form_templates['frontForm']); ?>
                                <?= $this->Form->hidden('tab_name',['value'=>'2'])?>
                                <div class="tab-padding clearfix">
                                    <div class="top-sec form-group">
                                        <label>Must Complete </label>
                                        <div class="border-box">
                                            <div class="form-group">
                                                <input type="radio" name="must_complete" <?php if($course['must_complete'] == 1 ) { echo 'checked="checked"'; } ?> class="radio-hide" value="1" id="all-lesson">
                                                <label for="all-lesson" class="square-radio"></label>
                                                <span class="label">All lessons, in any order</span>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" <?php if($course['must_complete'] == 2 ) { echo 'checked="checked"'; } ?> name="must_complete" class="radio-hide" value="2" id="all-chapter">
                                                <label for="all-chapter" class="square-radio"></label>
                                                <span class="label">All lessons, in order by chapter </span>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio" name="must_complete" <?php if($course['must_complete'] == 3 ) { echo 'checked="checked"'; } ?> class="radio-hide" value="3" id="exam-only">
                                                <label for="exam-only" class="square-radio"></label>
                                                <span class="label">Exam only </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bottom-form">
                                        <label> Outline </label>
                                        <div class="border-box">
                                            <h3> Lessons<!-- Chapters -->   </h3>
                                            <div class="form-sec">
                                                <?= $this->Html->link('Save Reorder','javascript:void(0);',['class'=>'btn btn-primary'],['onclick'=>'saveorderchapters();']) ?>
                                                <table class="table table-bordered" id="chapterstbl">
                                                    <tbody class="connectedSortable">
                                                        <?php if($course['course_chapters']) { 
                                                            $i = 1;
                                                            foreach($course['course_chapters'] as $chapters)
                                                            {?>
                                                        <tr id="tr_<?= $chapters['id'] ?>" <?php if($chapters['type']=="assessment") { ?> class="assesmenttr"<?php } ?> >
                                                            <td>
                                                                <a href="#"><?= ucwords($chapters['title']) ?></a>
                                                            </td>
                                                            <td class="actions">
                                                                <a href="javascript:void(0);" class="delete delete_chapter" onClick="edit_chapter(<?= $chapters['id'] ?>,'<?= $chapters['type'] ?>')"> <i class="fa fa-edit" aria-hidden="true"></i> </a>
                                                                <a href="javascript:void(0);" class="delete delete_chapter" onClick="delete_chapter(<?= $chapters['id'] ?>)"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                            $i++;
                                                            }
                                                            }
                                                            ?>
                                                    </tbody>
                                                </table>
                                                <button class="addlrobj button button--wayra add-learning-objects" type="button" data-toggle="modal" data-target="#myModal">Add Lesson <!--  Learning Object --> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $this->Form->button('Back',['type'=>'button','class'=>'btn btn-primary btn-square previous_button','id'=>'back1']) ?>
                                    &nbsp; 
                                    <?= $this->Form->button('Save',['type'=>'button','class'=>'btn btn-primary btn-square','id'=>'nextavailability']) ?>
                                </div>
                                <?= $this->Form->end() ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="availability">
                                <div class="tab-padding clearfix">
                                    <div class="loginform available-form">
                                        <?= $this->Form->create(@$course,['role'=>'form','id'=>'olcourse3','novalidate'=>true]) ?>
                                        <?php $this->Form->templates($form_templates['frontForm']); ?>
                                        <?= $this->Form->hidden('tab_name',['value'=>'3'])?>
                                        <div class="form-group">
                                            <label>Enable E-Commerce </label>
                                            <input id="enable_ecommerce" class="switch" <?php if($course['enable_ecommerce'] == 1) { echo "checked='checked'"; } ?> type="checkbox" value="1"  name="enable_ecommerce">
                                            <label for="enable_ecommerce" class="checkbox-switch"> </label>
                                            <div class="inner-section" id="ecommerce_innersection" <?php if($course['enable_ecommerce'] == 1) { echo "style='display:block'"; } ?>>
                                                <div class="form-group">
                                                    <label>Allow Public Purchase </label>
                                                    <input id="public_purchase" class="switch" <?php if($course['public_purchase'] == 1) { echo "checked='checked'"; } ?> type="checkbox" value="1" name="public_purchase">
                                                    <label for="public_purchase" class="checkbox-switch"> </label>
                                                    <div class="form-group value-sec">
                                                        <label>Default Price</label>
                                                        <div class="number-sec">
                                                            <span class="pre-value"> CAD </span>
                                                            <?= $this->Form->input('purchase_price',['label'=>false,'class'=>'form-control value-set','type'=>'number']) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="form-group inner-box">
                                                    <label>Variable Price Groups </label>
                                                    <input class="form-control" placeholder="The course has no variable price group" type="text">
                                                    <button class="button button--wayra" data-toggle="modal" data-target="#myModal">Add Variable Price Groups <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                                    </div>-->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Allow Automatic Enrollment </label>
                                            <input id="automatic_enrollment" <?php if($course['automatic_enrollment'] == 1) { echo "checked='checked'"; } ?> value="1" class="switch" type="checkbox" name="automatic_enrollment">
                                            <label for="automatic_enrollment" class="checkbox-switch"> </label>
                                            <div class="inner-section enrollment" id="enrollment_inner" <?php if($course['automatic_enrollment'] == 1) { echo "style='display:block;'"; } ?>>
                                                <div class="form-group">
                                                    <label>Automatic Enrollment Rule </label>
                                                </div>
                                                <ul class="all_rules" style="list-style:none;">
                                                    <li id="rulediv_0"> </li>
                                                    <?php if($course['enroll_rules']) {
                                                        $i = 1;
                                                        foreach($course['enroll_rules'] as $rule)
                                                        {
                                                        ?>
                                                    <li id="rulediv_<?= $rule['id'] ?>">
                                                        <div class="form-group inner-box" >
                                                            <?php
                                                                $fields = [
                                                                      'firstname'=>'First Name','lastname'=>'Last Name','fullname'=>'Full Name',
                                                                      'username'=>'Username','department'=>'Department','group'=>'Group','location'=>'Location','email'=>'Email Address'
                                                                      
                                                                     ];
                                                                $rules = [
                                                                      'starts'=>'Starts With','contains'=>'Contains','equals'=>'Equals',
                                                                      'ends'=>'Ends With'
                                                                    ];
                                                                
                                                                ?>
                                                            <?= $this->Form->input('EnrollRules.fields[]',['class'=>'form-control','default'=>$rule['fieldname'],'label'=>false,'empty'=>false,'options'=>$fields]) ?>
                                                            <?= $this->Form->input('EnrollRules.rules[]',['default'=>$rule['rule'],'class'=>'form-control','label'=>false,'empty'=>false,'options'=>$rules]) ?>
                                                            <?= $this->Form->input('EnrollRules.value[]',['value'=>$rule['ruleval'],'class'=>'form-control','label'=>false,'placeholder'=>'Value']) ?>
                                                            <a href="javascript:void(0);"  class="delete_rule_db delete-btn" onclick="del_li_db(<?= $rule['id'] ?>);"> <i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                                                        </div>
                                                    </li>
                                                    <?php   $i++;}} else { ?>
                                                    <li id="rulediv_1">
                                                        <div class="form-group inner-box" >
                                                            <?php
                                                                $fields = [
                                                                      'firstname'=>'First Name','lastname'=>'Last Name','fullname'=>'Full Name',
                                                                      'username'=>'Username','department'=>'Department','group'=>'Group','location'=>'Location','email'=>'Email Address'
                                                                      
                                                                     ];
                                                                $rules = [
                                                                      'starts'=>'Starts With','contains'=>'Contains','equals'=>'Equals',
                                                                      'ends'=>'Ends With'
                                                                    ];
                                                                
                                                                ?>
                                                            <?= $this->Form->input('EnrollRules.fields[]',['class'=>'form-control','label'=>false,'empty'=>false,'options'=>$fields]) ?>
                                                            <?= $this->Form->input('EnrollRules.rules[]',['class'=>'form-control','label'=>false,'empty'=>false,'options'=>$rules]) ?>
                                                            <?= $this->Form->input('EnrollRules.value[]',['class'=>'form-control','label'=>false,'placeholder'=>'Value']) ?>
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <button class="button button--wayra col-md-12 add-learning-objects addrule" id="add_rule" type="button">Add Rule <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </div>
                                        </div>
                                        <div class="vestotus-apprval">
                                            <div class="form-group">
                                                <label>Approval </label>
                                                <div class="border-box">
                                                    <div class="form-group">
                                                        <input type="radio" checked="checked" name="approval" id="approval-1" class="radio-hide" value="none">
                                                        <label for="approval-1" class="square-radio"></label>
                                                        <span class="label"> None </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="radio" name="approval" <?php if($course['approval'] == 'Course Author') {  echo "checked='checked'"; } ?> id="approval-2" class="radio-hide" class="Course Author" value="Course Author">
                                                        <label for="approval-2" class="square-radio"></label>
                                                        <span class="label">Course Author </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="radio" name="approval" <?php if($course['approval'] == 'Supervisor') {  echo "checked='checked'"; } ?> id="approval-3" class="radio-hide" class="Supervisor" value="Supervisor">
                                                        <label for="approval-3" class="square-radio"></label>
                                                        <span class="label">Supervisor </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="radio" name="approval" id="approval-4" <?php if($course['approval'] == 'Administrator') {  echo "checked='checked'"; } ?> class="radio-hide" class="Administrator" value="Administrator">
                                                        <label for="approval-4" class="square-radio"></label>
                                                        <span class="label">Administrator </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="radio" name="approval" id="approval-5" <?php if($course['approval'] == 'Other') {  echo "checked='checked'"; } ?> class="radio-hide" class="Other" value="Other">
                                                        <label for="approval-5" class="square-radio"></label>
                                                        <span class="label">Other </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?= $this->Form->button('Back',['type'=>'button','class'=>'btn btn-primary btn-square previous_button','id'=>'back2']) ?>
                                        &nbsp;
                                        <button type="submit" class="btn btn-primary ">Save</button>
                                        <?= $this->Form->end()?>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="competetion">
                                <?= $this->Form->create(@$course,['role'=>'form','id'=>'olcourse4','novalidate'=>true]) ?>
                                <?php $this->Form->templates($form_templates['frontForm']); ?>
                                <?= $this->Form->hidden('tab_name',['value'=>'4'])?>
                                <div class="tab-padding clearfix">
                                    <div class="loginform col-md-12 col-sm-12">
                                        <div class="panel-group first-accordion withicon" id="accordion1">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title" style="color:#555;">
                                                        <span class="inner-space">
                                                        <input type="checkbox" name="receive_certificate" <?php if($course['receive_certificate']==1) { echo "checked='checked'"; } ?> id="receive_certificate" value="1" >
                                                        Learners receive a certificate upon completion
                                                        </span>
                                                    </h4>
                                                </div>
                                                <div id="collapse11" class="panel-collapse <?php if($course['receive_certificate']==1) { echo "expand"; }else { echo "collapse"; } ?>">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label>Certificate Url</label>
                                                            <input type="file" name="certification_url" accept=".pdf" class="btn btn-default">
                                                            <?php if($course['certification_url']!=='') { echo $this->Html->link($course['certification_url'],'uploads/course/certificates/'.$course['certification_url'],['download'=>'certificate.pdf']); } ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Notes</label>
                                                            <?= $this->Form->teaxtarea('certification_notes',['class'=>'form-control','placeholder'=>'Notes','label'=>false]) ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Expiry</label>
                                                            <div class="border-box">
                                                                <div class="form-group">
                                                                    <input type="radio" name="certification_expiry" checked="checked" class="radio-hide" value="no-expiry" id="exp-1">
                                                                    <label for="exp-1" class="square-radio"></label>
                                                                    <span class="label"> No Expiry </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="radio" name="certification_expiry" <?php if($course['certification_expiry']=='from-enroll'){ ?>checked="checked" <?php } ?> class="radio-hide" value="from-enroll" id="exp-2">
                                                                    <label for="exp-2" class="square-radio"></label>
                                                                    <span class="label"> Time from enroll </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="radio" name="certification_expiry" <?php if($course['certification_expiry']=='date'){ ?>checked="checked" <?php } ?> class="radio-hide" value="date" id="exp-3">
                                                                    <label for="exp-3" class="square-radio"></label>
                                                                    <span class="label"> Date </span>
                                                                </div>
                                                            </div>
                                                            <!-- <a href="#" class="btn btn-primary btn-square">Preview Certificate </a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Allow Re Enrollment </label>
                                            <input id="allow_reenrollment" <?php if($course['allow_reenrollment']==1){ ?>checked="checked" <?php } ?> name="allow_reenrollment" value='1' class="switch" type="checkbox">
                                            <label for="allow_reenrollment" class="checkbox-switch"> </label>
                                            <div class="inner-section re-enrollment" id="reenrollment_inner">
                                                <div class="form-group">
                                                    <label>Choose when a learner can re-enroll </label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="radio" checked="checked" <?php if($course['learner_reenroll']==1){ ?>checked="checked" <?php } ?> name="learner_reenroll" value="any_time">
                                                    <label>Any time after completion </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Allow Failure </label>
                                            <input id="allow_failure" class="switch" name="allow_failure" type="checkbox" <?php if($course['allow_failure']==1){ ?>checked="checked" <?php } ?> value="1">
                                            <label for="allow_failure" class="checkbox-switch"> </label>
                                        </div>
                                        <!--<div class="form-group">
                                            <label>Competencies </label>
                                            <?= $this->Form->input('competencies',['value'=>explode(',',$course['competencies']),'multiple'=>true,'label'=>false,'options'=>['test1','test2','test3'],'empty'=>false,'class'=>'form-control']) ?>
                                            
                                            
                                            </div>-->
                                        <?= $this->Form->button('Back',['type'=>'button','class'=>'btn btn-primary btn-square previous_button','id'=>'back3']) ?>
                                        &nbsp;
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <?= $this->Form->end() ?>
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="messages">
                                <?= $this->Form->create(@$course,['role'=>'form','id'=>'olcourse5','novalidate'=>true]) ?>
                                <?php $this->Form->templates($form_templates['frontForm']); ?>
                                <?= $this->Form->hidden('tab_name',['value'=>'5'])?>
                                <div class="tab-padding clearfix">
                                    <div class="loginform col-md-12 col-sm-12 messages-form">
                                        <div class="form-group">
                                            <label>Send email notification </label>
                                            <input id="email_notify" class="switch" <?php if($course['email_notification']==1){ ?> checked="checked" <?php } ?> name="email_notification" value="1" type="checkbox">
                                            <label for="email_notify" class="checkbox-switch"> </label>
                                            <div class="inner-section re-enrollment" id="notificationinner" <?php if($course['email_notification']==1){ ?> style="display:block;" <?php } ?>>
                                                <div class="form-group">
                                                    <label>Send enrollment email </label>
                                                    <input id="enrollment_email" class="switch" <?php if($course['enrollment_email']==1){ ?> checked="checked" <?php } ?> name="enrollment_email" value="1" type="checkbox">
                                                    <label for="enrollment_email" class="checkbox-switch"> </label>
                                                    <div class="inner-section re-enrollment" id="enrollment_email_inner" <?php if($course['enrollment_email']==1) { ?> style="display:block;" <?php } ?>>
                                                        <div class="form-group">
                                                            <label>Custom Email </label>
                                                            <input id="enrollment_email_custom" class="switch" <?php if($course['enrollment_email_custom']==1){ ?> checked="checked" <?php } ?> name="enrollment_email_custom" value="1" type="checkbox">
                                                            <label for="enrollment_email_custom" class="checkbox-switch"> </label>
                                                            <div class="inner-section re-enrollment"  id="enrollment_email_custom_inner" <?php if($course['enrollment_email_custom']==1){ ?> style="display:block;" <?php } ?>>
                                                                <?php foreach($course['course_notifications'] as $notify) {
                                                                    if($notify['slug']=='enroll'):
                                                                    $course['enrollment_subject'] = $notify['subject'];
                                                                    $course['enrollment_body'] = $notify['content'];
                                                                    endif; } ?>
                                                                <div class="form-group">
                                                                    <?= $this->Form->input('enrollment_subject',['label'=>'Subject','class'=>'form-control']) ?>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?= $this->Form->textarea('enrollment_body',['label'=>'Body','class'=>'form-control']) ?>
                                                                </div>
                                                                <div class="form-group" class="tags_view">
                                                                    {FirstName}, {LastName}, {Email}, {Phone}, {Username}, {LMSLink}, {Department}, {CourseName}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Send completion email </label>
                                                    <input id="completion_email" class="switch" <?php if($course['completion_email']==1){ ?> checked="checked" <?php } ?> name="completion_email" value="1" type="checkbox">
                                                    <label for="completion_email" class="checkbox-switch"> </label>
                                                    <div class="inner-section re-enrollment" id="completion_email_inner" <?php if($course['completion_email']==1){ ?> style="display:block;" <?php } ?>>
                                                        <div class="form-group">
                                                            <label>Custom Email </label>
                                                            <input id="completion_email_custom" <?php if($course['completion_email_custom']==1){ ?> checked="checked" <?php } ?> class="switch" name="completion_email_custom" value="1" type="checkbox">
                                                            <label for="completion_email_custom" class="checkbox-switch"> </label>
                                                            <div class="inner-section re-enrollment" id="completion_email_custom_inner" <?php if($course['completion_email_custom']==1){ ?> style="display:block;" <?php } ?>>
                                                                <?php foreach($course['course_notifications'] as $notify) {
                                                                    if($notify['slug']=='completion'):
                                                                      $course['completion_subject'] = $notify['subject'];
                                                                    $course['completion_body'] = $notify['content'];
                                                                     endif; } ?>
                                                                <div class="form-group">
                                                                    <?= $this->Form->input('completion_subject',['label'=>'Subject','class'=>'form-control']) ?>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?= $this->Form->textarea('completion_body',['label'=>'Body','class'=>'form-control']) ?>
                                                                </div>
                                                                <div class="form-group" class="tags_view">
                                                                    {FirstName}, {LastName}, {Email}, {Phone}, {Username}, {LMSLink}, {Department}, {CourseName}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?= $this->Form->button('Back',['type'=>'button','class'=>'btn btn-primary btn-square previous_button','id'=>'back4']) ?>
                                &nbsp; 
                                <button type="submit" class="btn btn-primary btn-square">Save Changes</button>
                                <?= $this->Form->end() ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="resources1">
                                <?= $this->Form->create(@$course,['role'=>'form','id'=>'olcourse6','novalidate'=>true]) ?>
                                <?php $this->Form->templates($form_templates['frontForm']); ?>
                                <?= $this->Form->hidden('tab_name',['value'=>'6'])?>
                                <div class="tab-padding clearfix">
                                    <div class="loginform general-form">
                                        <div class="form-group inner-box">
                                            <label>Resources </label>
                                            <br>
                                            <br>
                                            <div class="rsdiv">
                                                <?php
                                                    // pr($course['course_resources']); die;
                                                    if(is_array(@$course['course_resources'])){
                                                        foreach($course['course_resources'] as $resources) { 
                                                    ?>
                                                    <div class="resourcesdiv" id="resourcediv_<?= $resources['id']?>">
                                                        <a href="javascript:void(0);" id="<?= $resources['id'] ?>" class="delete_resource delete-btn" onclick="del_resource(<?= $resources['id']?>,'1')"><i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                                                        <div class="form-group">
                                                            <label>Name </label>
                                                            <p><?= $resources['name'] ?> </p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>File </label>
                                                            <?= $this->Html->link($resources['files'],'/uploads/courses/resources/'.$resources['files'],['target'=>'_blank']) ?>
                                                        </div>
                                                    </div>
                                                <?php } } ?>
                                            </div>
                                            <div class="form-group">
                                                <?= $this->Form->input('resource_name',['class'=>'form-control','placeholder'=>'Resource Name','label'=>'Name']) ?>
                                            </div>
                                            <div class="form-group">
                                                <label>File </label>
                                                <?= $this->Form->file('resource_file',['class'=>'btn btn-default','accept'=>'.pdf','label'=>'File']) ?>
                                            </div>
                                            <div class="clearfix">
                                                <?= $this->Form->submit('Save',['class'=>'button button--wayra add-learning-objects']) ?>
                                            </div>
                                        </div>
                                        <!--
                                            <button type="button" class="button button--wayra" id="add_resource">Add Resources <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            <br> -->
                                        <?= $this->Form->button('Back',['type'=>'button','class'=>'btn btn-primary btn-square previous_button','id'=>'back5']) ?>
                                        &nbsp;
                                        <?= $this->Html->link('Continue','javascript:void(0);',['class'=>'btn btn-primary btn-square','id'=>'laststepcontinue']) ?>
                                    </div>
                                </div>
                                <?= $this->Form->end() ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="complete" >
                                <?= $this->Form->create(@$course,['role'=>'form','id'=>'olcourse7','novalidate'=>true]) ?>
                                <?php $this->Form->templates($form_templates['frontForm']); ?>
                                <?= $this->Form->hidden('tab_name',['value'=>'7'])?>
                                <div class="tab-padding clearfix">
                                    <div class="loginform col-md-12 col-sm-12 no-pd">
                                        <p> Lorem ipsum dolor sit amet, alii exerci antiopam at mei, omittam placerat in sea. </p>
                                        <?= $this->Form->button('Click here to save course',['type'=>'button','class'=>'button button--wayra add-learning-objects','onclick'=>'finalstep(1)']) ?>
                                        <br/><br/><br/><br/>
                                    </div>
                                </div>
                                <?= $this->Form->button('Back',['type'=>'button','class'=>'btn btn-primary btn-square previous_button','id'=>'back6']) ?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    <!-- </div>
    <div class="clear"> </div> -->
</div>
</div>
</div>
</div>
</div>
<?= $this->element('modal_chapter') ?>  
<?= $this->Html->script('../admin/js/onlinecourse.js') ?>
<?= $this->Html->css('style_custom') ?>