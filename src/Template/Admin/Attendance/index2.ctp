<div class="x_panel">
    <div class="x_title">
        <h2>Attendance (<?php echo Date("d M Y"); ?>)<small></small></h2>
    </div>
    <div class="x_content">
      
        <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                <thead>
                    <tr role="row">
                        <th class="" ><?= $this->Paginator->sort('fullname',__('name <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('manager',__('Manager <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('instructor',__('Instructor <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                        <th class="" ><?= $this->Paginator->sort('attendance',__('Attendance <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                    </tr>
                </thead>

                <tbody>
                <?php
                  foreach($users as $user)
                  {
                      if($user['attendance']=='Present')
                      {
                          $td= '<td style="color:green">'. $user['attendance'] . '</td>';
                      }
                      else
                      {
                          $td= '<td style="color:red">'. $user['attendance'] . '</td>';
                      }
                      echo '<tr>';
                          echo '<td>'. $user['fname'] . ' ' .$user['lname']. '</td>';
                          echo '<td>'. $user['manager']['fname']. ' ' .$user['manager']['lname'].'</td>';
                          echo '<td>'. $user['instructor']['fname']. ' ' .$user['instructor']['lname'].'</td>';
                          echo  $td ;
                      echo '</tr>';
                  }
                ?>
                </tbody>
            </table>
        </div>
        <?= $this->element('paginator') ?>
  </div>
</div>