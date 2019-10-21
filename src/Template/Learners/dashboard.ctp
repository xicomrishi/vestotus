
                    <div id="sidebar1" class="col-md-6 col-sm-12">
                        <div class="widget clearfix">
                            <div class="member-profile">
                                <div class="big-title">
                                    <h2 class="related-title">
                                        <span>About Me</span>
                                    </h2>
                                </div><!-- end big-title -->

                                <table style="width:100%">
                                    <tr>
                                    <th>Name: </th><td><?= ucfirst($profile['fullname']) ?> </td>
                                    </tr>
                                    <tr>
                                    <th>Address: </th><td><?= $profile['street'] ?> 
                                    <?php if($profile['city_id']) {?>
                                    <?= $this->Common->getCities($profile['state_id'] , $profile['city_id']) ?> <?php } ?>
                                     <?php if($profile['state_id']) {?> ,
                                        <?= $this->Common->getStates($profile['country_id'] , $profile['state_id']) ?><?php } ?>  <?php if($profile['country_id']) {?> ,
                                            <?= $this->Common->getCountry($profile['country_id']) ?> 
                                            <?php } ?></td>
                                    </tr>
                                </table>

                            </div><!-- end team-member -->
                        </div>
                    </div><!-- end right -->

                   <?= $this->element('contact-form') ?>
                   