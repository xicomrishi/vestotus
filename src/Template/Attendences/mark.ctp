<div id="sidebar1" class="col-md-9 col-sm-12">
    <div class="widget clearfix">
        <div class="member-profile">
            <div class="big-title">
                <h2 class="related-title">
                    <span>Attendence</span>
                </h2>
            </div>
            <!-- end big-title -->
            <div class="edit-profile loginform">
                <?= $this->Form->create('attendence',['class'=>'','id'=>'dsds'])  ?>
                <table class="attendencetable">
                    <tr>
                        <th>S.no. </th>
                        <th> User </th>
                        <th> Present </th>
                        <th> Absent </th>
                    </tr>
                    <?php 
                        $i = 1;
                        $pusers = explode(',',$presentlist['users']);
                        foreach($getusers as $user) { ?>
                            <input type="hidden" name="attendence[<?= $i ?>][user_id]" value = "<?= $user['user_id'] ?>">
                            <tr>
                                <td> <?= $i ?> </td>
                                <td> <?= ucfirst($user['user']['fullname']) ?></td>
                                <td> <input type="radio" <?php if(in_array($user['user_id'],$pusers)) { echo "checked='checked'"; } ?> name="attendence[<?= $i ?>][status]" value = "present" >  </td>
                                <td> <input type="radio" <?php if(!in_array($user['user_id'],$pusers)) { echo "checked='checked'"; } ?> name="attendence[<?= $i ?>][status]" value = "absent"></td>
                            </tr>
                    <?php  $i++;} ?>
                </table>
                <div class="mt-20">
	                <button type="submit" class="btn btn-primary">Update</button>
	                <button type="button" class="btn btn-secondary" onclick="window.location.href = '<?= BASEURL?>instructors/courses'; ">Back</button>
	            </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- end edit profile -->
        </div>
        <!-- end team-member -->
    </div>
</div>