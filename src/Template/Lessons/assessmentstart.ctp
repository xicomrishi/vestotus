<?php echo $this->Form->create('quiz',['class'=>'','id'=>'quizform']) ?>
<?= $this->Form->hidden('lesson_id',['value'=>$lesson['lesson_id']]) ?>
<?= $this->Form->hidden('course_id',['value'=>$lesson['course_id']]) ?>
<?= $this->Form->hidden('id',['value'=>$lesson['id']]) ?>
						
    <div class="widget custom-widget clearfix">
        <div class="customwidget text-left w40">
            <h3 class="widget-title">Quiz - Question <?= $lessono[$lesson['id']] ?></h3>
            <h4><?= ucfirst($lesson['question']) ?></h4>
            <?php 
                $options = json_decode($lesson['options']);
            ?>
            <form>
                <div class="radio">
                    <?php 
                    $i = 0;
                    foreach($options as $opt) {
                        $cont = '';
                        if($checkans)
                        {
                            if($checkans['answerbyuser']==$opt)
                            {
                                $cont = "checked='checked'"; 
                            }
                        }
                     ?>
                        <div class="radiodiv">
                            <input name="answer" value="<?= $opt ?>" id="c<?= $i ?>" type="radio" <?= $cont ?>  class="styled answers">
                            <label for="c<?= $i ?>">
                               <?= ucfirst($opt) ?>
                            </label>
                        </div>
                        <?php $i++; } ?>
                </div>
                <div class="row">
                <?php if($prev) : ?>
                    <div class="col-md-6">
                        <a href="javascript:void(0);" onclick="gotoprev('<?= $prev?>');" class="btn btn-primary btn-block">Prev Question</a>
                    </div>
                    <?php endif; ?>
                    <?php if($next) : ?>
                    <div class="col-md-6">
                        <a href="javascript:void(0);" onclick="gotonext('<?= $next?>');" class="btn btn-primary btn-block">Save and Continue </a>
                    </div>
                <?php endif; ?>
                <?php if(!$next): ?>
                  <div class="col-md-6">
                        <a href="javascript:void(0);" onclick="testsubmit('<?= $testid ?>');" class="btn btn-primary btn-block">Submit Test</a>
                    </div>  

                <?php endif; ?>
                </div><!-- end row -->
            </form>     
        </div><!-- end newsletter -->
    </div><!-- end widget -->
<?= $this->Form->end()?>