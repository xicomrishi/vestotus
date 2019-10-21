          <?php
          if(!empty($messages))
          {
              foreach($messages as $message)
              {
                  if($message['sender_id']==$userid)
                  {
                      $avatar = ADMIN_AVATAR;
                      echo '<div class="msg_container">
                                <img src="'.$avatar.'" alt="Avatar">
                                <p>'.$message['message'].'</p>
                                <span class="time-right">'.$message['created'].'</span>
                            </div>';
                  }
                  else
                  {
                      $avatar = $this->__getUserImage($message['sender_id']);
                      echo '<div class="msg_container darker">
                                <img src="'.$avatar.'" alt="Avatar" class="right">
                                <p>'.$message['message'].'</p>
                                <span class="time-left">'.$message['created'].'</span>
                            </div>';
                  }
              }
          }
          else
          {
              echo "Start conversation";
          }
            
          ?>
