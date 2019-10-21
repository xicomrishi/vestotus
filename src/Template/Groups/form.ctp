 <?php 
 $user = [];
 foreach($users as $u)
 {
  $user[$u['id']] = $u['fullname'];
 }
 ?>
 <div id="main">
            <div class="visible-md visible-xs visible-sm mobile-menu">
                <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
            </div>

            <section class="bgw clearfix course-detail-master">           	
			        
			         <div class="page-title bgg">
			            <div class="container-fluid clearfix">
			                <div class="title-area pull-left">
			                    <h2>Update Group </h2>
			                </div><!-- /.pull-right -->
			                <div class="pull-right hidden-xs">
			                    <div class="bread">
			                        <ol class="breadcrumb">
			                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
			                            <li ><a href="<?= BASEURL?>Groups/">Groups</a></li>
			                            <li class="active">update</li>
			                        </ol>
			                    </div><!-- end bread -->
			                </div><!-- /.pull-right -->
			            </div>
			        </div><!-- end page-title -->
          
			            	<section class="section bgw">
					            <div class="container">
					                <div class="row">
					                    <div class="col-md-12 col-sm-12">
					         
		
                      <div class="custom-form clearfix">
                                                <div class="big-title">
                                                    <h2 class="related-title">
                                                        <span> Group Details </span>
                                                    </h2>
                                                </div><!-- end big-title -->
<div class="loginform learners-form">
<?= $this->Form->create($group,['class'=>'row']) ?>
<?php $this->Form->templates($form_templates['frontForm']); ?>
<div class="col-md-12">
<div class="form-group">
<?= $this->Form->input('name',['label'=>'Group Name','class'=>'form-control','placeholder'=>'Group Name']) ?>
</div>
<div class="form-group">
<?= $this->Form->radio('behaviour',['automatic'=>'Automatic','manual'=>'Manual'],['hidden'=>false,'class'=>'form-control']) ?>
</div>
<div class="clear"> </div>

<div class="form-group manualadd">
<?= $this->Form->input('users',['empty'=>'Select Users','class'=>'form-control','multiple'=>true,'options'=>$user,'required'=>false]) ?>
</div>

<div class="form-group automaticadd"  style="display:none;">
<div class="">

<table class="ruletable">
  <tr id='tr-0'>
    <td>
    <?php 
      $fields = array('fname'=>'First Name','lname'=>'Last Name','username'=>'Username','email'=>'Email','department'=>'Department');
    ?>
    <?= $this->Form->input('fieldname[]',['label'=>false,'empty'=>false,'options'=>$fields,'class'=>'form-control']) ?></td>
    <td><?= $this->Form->input('rulename[]',['label'=>false,'empty'=>false,'class'=>'form-control','options'=>['start_with'=>'Starts With','contains'=>'Contains','equal'=>'Equals','ends_with'=>'Ends With']]) ?>
    </td>
    <td><?= $this->Form->input('fieldval[]',['label'=>false,'class'=>'form-control']) ?>
    </td>
    <td>
    <?= $this->Html->link('<i class="fa fa-trash"></i>','javascript:void(0);',['escape'=>false,'class'=>'deleterow','id'=>'0']) ?>
    </td>
  </tr>
</table>
<?= $this->Html->link('<i class="fa fa-plus"></i>Add Rule','javascript:void(0);',['escape'=>false,'class'=>'add_row']) ?>
</div>
</div>

<div class="clear"> </div>




<?= $this->Form->submit('SEND',['class'=>'button button--wayra btn-block btn-square btn-lg']) ?>

</div>
</form> 
</div>
</div>
                    </div>

</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->


<?= $this->Html->css('../plugins/select2/dist/css/select2.css') ?>

<?= $this->Html->script("../plugins/select2/dist/js/select2.full.js") ?>

<script type="text/javascript">
	$(document).ready(function(){
    $('.deleterow').on('click',function(){
      var getid = $(this).attr('id');
      var trid = 'tr-'+getid;
      console.log(trid);
      $('.ruletable tr#'+trid).remove();
    });
    $('.add_row').on('click',function(){
      var getlast = $('.ruletable tr:last').attr('id');
      getlastid = getlast.split('-');
      id = parseInt(getlastid[1]) + 1;
      console.log(id);
      var content = ' <tr id="tr-'+id+'"><td><select name="fieldname[]" class="form-control" id="fieldname"><option value="fname">First Name</option><option value="lname">Last Name</option><option value="username">Username</option><option value="email">Email</option><option value="department">Department</option></select></td><td><select name="rulename[]" class="form-control" id="rulename"><option value="start_with">Starts With</option><option value="contains">Contains</option><option value="equal">Equals</option><option value="ends_with">Ends With</option></select>    </td><td><input type="text" name="fieldval[]" class="form-control" id="fieldval">    </td><td><a href="javascript:void(0);" class="deleterow" id="'+id+'"><i class="fa fa-trash"></i></a></td></tr>';
      $('.ruletable').append(content);
    });
    $('input[name="behaviour"]').click(function(){
      var getval = $(this).val();
      if(getval=='manual')
      {
        $('.automaticadd').hide();
        $('.manualadd').show();
      }
      else if(getval=='automatic')
      {
        $('.manualadd').hide();
        $('.automaticadd').show();
      }
    }); 
		$("#uddsers").select2({allowClear: true, 'placeholder' : "Select or input a user.",
  minimumInputLength: 0 ,
  ajax: {
    url: "<?= BASEURL?>users/searchbykey/",
    dataType: 'json',
    quietMillis: 200,
    data: function (term, page) {
      return {
        term: term, //search term
        flag: 'selectprogram',
        page: page // page number
      };
    },
    results: function (data) {
      console.log(data);
      return {results: data};
    }
  },
  dropdownCssClass: "bigdrop",
  escapeMarkup: function (m) { return m; }
    
    
  });  
	});
</script>
 