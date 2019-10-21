<?= $this->Html->css('message'); ?> 


<div class="message-area">
     <div class="left-section">
         <a class="user-role" href="javascript:void(0)"><h2 class="contact-heading">Managers <i class="fa fa-angle-down"></i></h2></a>
         <?php if(!empty($managers)){ ?>
         <ul class="contact-list">
             <?php foreach($managers as $mgr){ ?>
             <li id="<?= $mgr['id']; ?>" class="<?= $mgr['role']; ?>"><a href="javascript:void(0)"><?= $mgr['fname'].' '.$mgr['lname']; ?></a></li>
             <?php } ?>
         </ul>
         <?php } ?>
         
         
            <a class="user-role" href="javascript:void(0)"><h2 class="contact-heading">Instructors <i class="fa fa-angle-down"></i></h2></a>
         <?php if(!empty($instructors)){ ?>
            <ul style="display:none" class="contact-list" style="">
             <?php foreach($instructors as $mgr){ ?>
            <li id="<?= $mgr['id']; ?>" class="<?= $mgr['role']; ?>"><a href="javascript:void(0)"><?= $mgr['fname'].' '.$mgr['lname']; ?></a></li>
             <?php } ?>
         </ul>
         <?php } ?>
         
        <a class="user-role" href="javascript:void(0)"><h2 class="contact-heading">Learners <i class="fa fa-angle-down"></i></h2></a>
        <?php if(!empty($learners)){ ?>
         <ul style="display:none"  class="contact-list">
             <?php foreach($learners as $mgr){ ?>
             <li id="<?= $mgr['id']; ?>" class="<?= $mgr['role']; ?>"><a href="javascript:void(0)"><?= $mgr['fname'].' '.$mgr['lname']; ?></a></li>
             <?php } ?>
         </ul>
         <?php } ?>
         
     </div>
     <div class="right-section">
        <div class="message-row" style="">
          <div class="msg_container">
            <img src="/w3images/bandmember.jpg" alt="Avatar">
            <p>Hello. How are you today?</p>
            <span class="time-right">11:00</span>
          </div>

          <div class="msg_container darker">
            <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right">
            <p>Hey! I'm fine. Thanks for asking!</p>
            <span class="time-left">11:01</span>
          </div>

          <div class="msg_container">
            <img src="/w3images/bandmember.jpg" alt="Avatar">
            <p>Sweet! So, what do you wanna do today?</p>
            <span class="time-right">11:02</span>
          </div>

          <div class="msg_container darker">
            <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right">
            <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
            <span class="time-left">11:05</span>
          </div> 
        </div>
        <div class="send-msg">
              <?= $this->Form->create('Message', array('url' => '/messages/add','id'=>'MessageAddForm')); ?>
            <input name="message" class="form-control input-msg" type="text" placeholder="Enter Your Message" id="Messagebox">
           <?php echo  $this->Form->hidden('receiver_id', array("value" => "")); ?>
           <input class="btn btn-primary sent-btn" value="Send" type="submit">
              <?= $this->Form->end(); ?>
        </div>

     </div>
    
   
 </div>
<?= $this->Html->script('chat'); ?> 
