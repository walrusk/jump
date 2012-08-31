<section id="content">
	
	<? // each day in the content
	  foreach($days as $datestring => $day): ?>
		<div class="day contains-<?=count($day)?>-photo" id="day_<?=$datestring?>">
			<h2 class="date">
				<? $ts = strtotime($datestring); ?>
				<?= date('F',$ts); ?> <span><?= date('j',$ts); ?></span>
			</h2>
			
			<?  // each photo in the content
				foreach($day as $photo): ?>
					<article class="photo" id="index_<?=$photo['index']?>">
						<img src="<?=base_url('/photos/'.$photo['photopath'])?>" alt="">
						<div class="caption"><span><?=$photo['caption']?></span></div>
					</article>
			<? 	endforeach; ?>
			
			<span class="albumlink"><a href="#">Album</a></span>
		</div>
	<? endforeach; ?>
						
</section>