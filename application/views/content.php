<section id="content">
	
	<? if(isset($archive) && $archive): ?>
		<span class="back"><?=anchor('','<i class="icon-arrow-left"></i> Back to front page')?></span>
	<? endif; ?>
	
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
						<? if($loggedin): ?>
							<a href="<?=base_url('jump/deletephoto/'.$photo['id'])?>" class="deletephoto">X</a>
						<? endif; ?>
					</article>
			<? 	endforeach; ?>
			
			<span class="albumlink"><a href="#">Album</a></span>
		</div>
	<? endforeach; ?>
	
	<? if(!isset($archive) || !$nomore): ?>
	<span class="archivelink">
		<?=anchor('archive/'.$nextday,'More <i class="icon-arrow-right"></i>')?>
	</span>
	<? endif; ?>
	
</section>