<div class="dataTables_paginate paging_simple_numbers" id="datatable-checkbox_paginate">

	
	<?php if($this->Paginator->counter("{{pages}}") > 1)
	{?>
			<ul class="pagination">
				<?=  $this->Paginator->first('« First') ?>
				<?=  $this->Paginator->prev('Previous',['class'=>'previous','null','null']) ?>
				<?=  $this->Paginator->numbers() ?>
				<?=  $this->Paginator->next('Next',['class'=>'next',['sorting'=>'disabled'],null]) ?>
				<?=  $this->Paginator->last('Last »') ?>
			</ul>
			<?php } ?>
			</div>
			<?php echo $this->Paginator->counter(
		'<span class="total-results-count">{{count}}</span> Records Total'
		);
		?>