			
			<div class="top-banner" style="text-align:center">
				
				<img src="<?= BASEURL?>images/main-banner.jpg" width="100%" height="200px"/>
				<span class="green-strip"></span>
				<h2>HELP AND <strong>SUPPORT</strong></h2>
				<div class="search-sec">
				<?= $this->Form->create('faq',['type'=>'get']) ?>
				<input type="text" class="search-bar" value="<?= $searchtext ?>" name="search_faq" placeholder="Having trouble? Search here." />
				<input type="submit" value="Search" class="search-button" />
				<?= $this->Form->end() ?>
				</div>
			</div>
			<div class="content-section">
				<div class="container">

				<?php 
				if($faq){
				foreach($faq as $faq) { ?>
					<h4> <?= $faq['title'] ?> </h4>
					<p> <?= $faq['content'] ?></p>

					<?php } } else { echo "<p>Faq not found ! </p>";} ?>
				</div>
			</div>
			