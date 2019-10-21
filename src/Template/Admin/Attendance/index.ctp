<?php $this->assign('title',"Learner Attendance") ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>

<div class="">
    <div class="row">
        <div class="x_panel">
            <div class="row col-md-12">
                <div class="x_title">
                    <h2>Filter Learner Attendance<small></small></h2>
                    <div class="clearfix"></div>
                </div>
                <?= $this->Form->create('filters',['type'=>'get']) ?>
                <div class="col-md-12 date-picker">
                   <div class="form-group col-md-3">
                        <?= $this->Form->input('filter_course_id',['value' => @$search['filter_course_id'], 'options'=>$courses, 'class'=>'form-control', 'label'=>false, 'empty'=>'Select course' ]) ?>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="filter_learner_id" class='form-control'>
                            <option value="">Select learner</option>
                            <?php foreach($learners as $learner) { ?>
                                <option value="<?= $learner['id'] ?>"
                                    <?= ($learner['id'] == @$search['filter_learner_id']) ? 'selected' : '' ?>
                                    ><?= ucfirst($learner['fname']).' '.$learner['lname'].' ('.$learner['username'].')' ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="filter_status" class='form-control'>
                            <option value="">Select attendance</option>
                            <option value="present" <?= ('present' == @$search['filter_status']) ? 'selected' : '' ?> >Present</option>
                            <option value="absent" <?= ('absent' == @$search['filter_status']) ? 'selected' : '' ?> >Absent</option>
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-3 date" id="datetimepicker1">
                        <input type="text" class="form-control" placeholder="Start Date" name="start_date">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div class="form-group col-md-3 date" id="datetimepicker2">
                        <input type="text" class="form-control" placeholder="End Date" name="end_date">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" placeholder="Search Title..." name="search_text">
                    </div> -->
                    <div class="form-group col-md-3">
                        <input type="submit" value="Search" class="btn  btn-primary" name="">
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Learner Attendance<small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                        <thead>
                            <tr>
                                <th>Course Name </th>
                                <th>Learner Name </th>
                                <th>Learner Username </th>
                                <th>Course Type </th>
                                <th>Course Chapter/Session</th>
                                <th>Attendance Marker </th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($list)>0) { 
                                foreach ($list as $list) {
                                        //pr($list);exit;
                                ?>
                            <tr>
                                <td>
                                    <?= ucfirst($list['course']['title']) ?>
                                </td>
                                <td><?= ucfirst($list['student']['fname']).' '.$list['student']['lname'] ?></td>
                                <td> <?= $list['student']['username'] ?></td>
                                <td> <?= ($list['course']['type'] == 1) ? 'Online':'Instructor Led' ?></td>
                                <td> <?= ($list['course']['type'] == 1) ? ucfirst($list['course_chapter']['title']) : ucfirst($list['session']['title']) ?></td>
                                <td> <?= ($list['instructor_id'] == null) ? 'Student':'Instructor' ?></td>
                                <td> <?= ucfirst($list['status']) ?></td>
                                <td> <?= $list['created']->format('d M, Y H:i a') ?></td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="5"> No Records Found! </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?= $this->element('paginator') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
