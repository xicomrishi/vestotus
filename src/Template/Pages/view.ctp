			<div class="top-banner" style="text-align:center">
				
				<?php if($page['banner'])
				{
					$banner = BASEURL.'uploads/'.$page['banner'];
				}
				else
				{
					$banner = BASEURL.'images/main-banner.jpg';
				}
				?>
				<img src="<?= $banner ?>" width="100%" height="200px"/>
				<span class="green-strip"></span>
				<h2><?= $page['title'] ?></h2>
			</div>
			<div class="content-section">
				<div class="container">
				<?= $page['content'] ?>
				</div>
			</div>
			