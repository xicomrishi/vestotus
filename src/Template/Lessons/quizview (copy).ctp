<div id="post-content" class="col-md-9 col-sm-12 single-course pull-right">
    <div class="page-title bgg">
        <div class="clearfix">
            <div class="title-area pull-left">
                <h2> <?= ucwords(@$getresult['course']['title']) ?> <small>Quiz</small></h2>
            </div>
            <!-- /.pull-right -->
            <div class="pull-right hidden-xs">
                <div class="bread">
                    <ol class="breadcrumb">
                        <li><a href="<?= BASEURL ?>learners/dashboard">Home</a></li>
                        <li class=""><a href="<?= BASEURL?>courses/view/<?= $this->Common->myencode(@$getresult['course']['id']) ?>"><?= ucwords(@$getresult['course']['title']) ?></a></li>
                        <li class="active">Assessment Result </li>
                    </ol>
                </div>
                <!-- end bread -->
            </div>
            <!-- /.pull-right -->
        </div>
    </div>
    <div id="post-content" class="col-md-12 col-sm-12 single-course">
        <div class="course-single-quiz">
            <?php if(@$getresult['result']=='pass') { ?>
            <span class="pass">
            Congratulation ! You have passed your exam.
            </span>
            <?php } else if(@$getresult['result'] == 'fail') { ?>
            <span class="fail">
            Sorry ! You have not passed your exam.
            </span>
            <?php } ?>    
        </div>
        <!-- end desc -->
        <div class="tablediv quiz-wrapper">
            <h3> Result Report </h3>
            <table class="resulttbl">
                <tr>
                    <th> Question </th>
                </tr>
                <?php foreach($questions as $ques) { ?>
                    <tr>
                        <td><?= $ques['question'] ?> </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2">Pass Percentage :</td>
                    <td class="text-center"><?php echo @$getresult['percent'] ?> % </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<style type="text/css">
    .right_side_checkbox{
        float: right;
    }
</style>
<?= $this->Html->script('myscript.js') ?>