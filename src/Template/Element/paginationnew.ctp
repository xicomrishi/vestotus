<nav aria-label="Page navigation" class="pull-right pagination-wb">
  <ul class="pagination">
  <?php if($this->Paginator->counter("{{pages}}") > 1)
      {?>
        <?=  $this->Paginator->first(' <span aria-hidden="true">&laquo;</span>',['escape'=>false]) ?>
    
   <?=  $this->Paginator->numbers() ?>
   <?=  $this->Paginator->next('<span aria-hidden="true">&raquo;</span>',['escape'=>false,'class'=>'next',['sorting'=>'disabled'],null]) ?>
  
    <?php } ?>
  </ul>
</nav>

