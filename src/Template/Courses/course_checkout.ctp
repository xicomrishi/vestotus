<div class="page-title bgg">
    <div class="container clearfix">
        <div class="title-area pull-left">
            <h2>Checkout <small>Please complete your order to join our community</small></h2>
        </div>
        <!-- /.pull-right -->
        <div class="pull-right hidden-xs">
            <div class="bread">
                <ol class="breadcrumb">
                    <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
                    <li><a href="<?= BASEURL ?>courses/ecomcourses">E-Commerce Courses</a></li>
                </ol>
            </div>
            <!-- end bread -->
        </div>
        <!-- /.pull-right -->
    </div>
</div>
<!-- end page-title -->
<section class="section bgw">
    <div class="container">
        <div class="cart-body">
            <?= $this->Form->create('checkout',['class'=>'form-horizontal row','id'=>'checkoutform']) ?>
            <div class="col-lg-10 col-md-offset-1 col-md-12">
                <!--REVIEW ORDER-->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Review Order
                    </div>
                    <div class="panel-body">
                        <?php 
                            $t = 0;
                            foreach($courses as $c) {
                                
                                if($p = $this->get_course_price($c['id'] , $this->request->session()->read('Auth.User.id'))) {  
                                    $price = $p ; 
                                } else { 
                                    $price = $c['purchase_price']; 
                                } 
                                $t = $t + ($price * $getsession[$c->id]) ;
                            ?>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">
                                <?php $page = ($c['type'] == 1) ? 'view':'viewIled'; ?>
                                <a href="<?= BASEURL.'courses/'.$page.'/'.$this->Common->myencode($c['id']).'?buy=enable' ?>" title=""> 

                                <!-- <a href="<?= BASEURL ?>courses/single/<?= $this->Common->myencode($c
                                    ['id']) ?>"> -->
                                    
                                    <?php if($c['thumbnail']){ 
                                        $img = FILE_COURSE_THUMB.$c['thumbnail'];
                                    } else{
                                        $img = FILE_COURSE_THUMB_DEFAULT;
                                    } ?>
                                    <img src="<?= $img ?>" alt="" class="img-responsive">

                                </a>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="col-xs-12">
                                    <h4><?= ucfirst($c->title) ?></h4>
                                </div>
                                <div class="col-xs-12"><small><span><?= $c->notes ?></span></small></div>
                            </div>
                            <div class="col-sm-1 col-xs-2">
                                <?php if($this->request->session()->read('Auth.User.role') == 2) { $type =  'number'; } else { $type = 'hidden' ; }  ?>
                                <h6><?= $this->Form->input('quantity',['type'=>$type,'class'=>'form-control quantity','value'=>$getsession[$c->id],'min'=>1,'label'=>false,'style'=>'width:80px;','data-price'=>$price,'data-id'=>$c->id]) ?></h6>
                            </div>
                            <div class="col-sm-2 col-xs-2 text-right">
                                <h6><span>$</span><span class="itemprice" data-price="<?= $c->purchase_price ?>" id="price_<?= $c->id ?>"><?= $getsession[$c->id] * $price ?></span></h6>
                            </div>
                            <div class="col-sm-2 col-xs-2 text-right">
                                <a href="<?= BASEURL?>courses/removecart/<?= $this->Common->myencode($c->id) ?>"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <hr />
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>Order Total</label>
                                <span>$</span> <span class="total_amount"><?= $t ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--REVIEW ORDER END-->
                <?php $u = $this->request->session()->read('Auth.User') ?>
                <!--SHIPPING METHOD-->
                <div class="panel panel-info contact_form">
                    <div class="panel-heading">Shipping Address</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-6 col-xs-12">
                                <label>First Name:</label>
                                <input type="text" name="fname" value="<?= $this->request->session()->read('Auth.User.fname') ?>" class="form-control"  required="required" />
                            </div>
                            <!-- <div class="span1"></div> -->
                            <div class="col-md-6 col-xs-12">
                                <label>Last Name:</label>
                                <input type="text" name="lname" class="form-control" value="<?= $this->request->session()->read('Auth.User.lname') ?>"  required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-xs-12">
                                <label>Phone Number:</label>
                                <input type="text" name="phone"  class="form-control" value="<?= $this->request->session()->read('Auth.User.phone') ?>"  required="required"/>
                            </div>
                            <!-- <div class="span1"></div> -->
                            <div class="col-md-6 col-xs-12">
                                <label>Email:</label>
                                <input type="text" name="email" value="<?= $this->request->session()->read('Auth.User.email') ?>" readonly="readonly" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12"><label>Address:</label></div>
                            <div class="col-md-6">
                                <input type="text" name="address" class="form-control" value="<?= $this->request->session()->read('Auth.User.street') ?>  "  required="required"/>
                            </div>
                            <div class="col-md-6">
                                <input type="text" placeholder="Postal Code" name="zip" class="form-control" value="<?= $u['zip'] ?>"  required="required"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!--SHIPPING METHOD END-->
                <!--CREDIT CART PAYMENT-->
                <div class="panel panel-info contact_form">
                    <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Secure Payment</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-6"><label>Card Type:</label></div>
                            <div class="col-md-6">
                                <select name="orderby" class="form-control" required="required">
                                    <option value="Visa">Visa</option>
                                    <option value="MasterCard">MasterCard</option>
                                    <option value="American Express">American Express</option>
                                    <option value="Discover">Discover</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6"><label>Credit Card Number:</label></div>
                            <div class="col-md-6"><input type="text" class="number form-control" name="card_number" value="" required="required" maxlength="16" minlength="16"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6"><label>Credit Holder Name:</label></div>
                            <div class="col-md-6"><input type="text" required="required"  class="form-control" name="card_name" value="" /></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6"><label>Select Month:</label></div>
                            <div class="col-md-6">
                                <select name="exp_month"  required="required" class="form-control">
                                    <?php 
                                        for($m = 1 ;$m < 13 ;$m++){?>
                                    <option value="<?= $m ?>"><?= $m ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6"><label>Select Year:</label></div>
                            <div class="col-md-6">
                                <select name="exp_year" required="required"  class="form-control">
                                    <?php for($i = date('Y'); $i < date('Y') + 20 ; $i++) {?>
                                    <option value="<?= $i ?>"><?= $i ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6"><label>Cvv:</label></div>
                            <div class="col-md-6"><input type="number" required="required"  class="form-control" name="cvv" maxlength="3" minlength="3" /></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <p>Pay secure using your credit card.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-methods">
                                    <ul class="list-inline text-left">
                                        <li><a href="#"><img src="<?= BASEURL ?>uploads/payment_01.png" alt=""></a></li>
                                        <li><a href="#"><img src="<?= BASEURL ?>uploads/payment_02.png" alt=""></a></li>
                                        <li><a href="#"><img src="<?= BASEURL ?>uploads/payment_03.png" alt=""></a></li>
                                        <li><a href="#"><img src="<?= BASEURL ?>uploads/payment_04.png" alt=""></a></li>
                                        <li><a href="#"><img src="<?= BASEURL ?>uploads/payment_05.png" alt=""></a></li>
                                        <li><a href="#"><img src="<?= BASEURL ?>uploads/payment_06.png" alt=""></a></li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <button type="submit" class="btn btn-primary">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--CREDIT CART PAYMENT END-->
            </div>
            </form>
        </div>
    </div>
    <!-- end container -->
</section>
<!-- end section -->
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js') ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#checkoutform').validate();
    
        $(document).ready(function(){
            $('.quantity').change(function(){
                var qty = $(this).val();
                var price = $(this).attr('data-price');
                var id = $(this).attr('data-id');
                var p = parseInt(qty) * parseFloat(price);
                $('#price_'+id).html(p.toFixed(2));
                calculate_total_price();
                var data = {"id":id , "quantity" : qty}
                $.post("<?= BASEURL ?>courses/updatecart/",data,function(response){
                    console.log(response);
                });
            });
        });
    });
    
    function calculate_total_price()
    {
        var ttlprice = 0;
        $('.itemprice').each(function(){
            var price = $(this).html();
            ttlprice = parseFloat(ttlprice) + parseFloat(price);
        
        });
        $('.total_amount').html(ttlprice);
        
    
    }
</script>