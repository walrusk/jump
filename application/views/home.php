<? if($loggedin): ?>
<section id="create">

	<?=(isset($error) ? $error : "");?>
	
	<a href="#newphoto" id="newphoto_link">Add Photo</a>
	<?=form_open_multipart('jump/newphoto', array('id'=>'newphoto'));?>
	
		<div class="caption field">
			<label for="newphoto_caption">Caption</label>
			<input type="text" name="caption" id="newphoto_caption">
		</div>
		<div class="photodate field">
			<label for="newphoto_photodate">Date</label>
			<input type="text" name="photodate" id="newphoto_photodate" value="Today">
		</div>
		<div class="photoupload field">
			<label for="newphoto_photoupload">Select New Photo</label>
			<input type="file" name="photoupload" id="newphoto_photoupload" size="20">
		</div>
		<div class="submit field">
			<input type="submit" value="upload">
		</div>
		
	</form>
	
</section>
<? endif; ?>
<section id="content">
	
	<? foreach($photos as $photo): ?>
	
		<article class="photo">
			<h2 class="date">
				<? $ts = strtotime($photo['photodate']); ?>
				<?= date('F',$ts); ?> <span><?= date('j',$ts); ?></span>
			</h2>
			<div class="data">
				<img src="<?=base_url('/photos/'.$photo['photopath'])?>" alt="">
				<span class="caption"><?=$photo['caption']?></span>
			</div>
			<div class="permalink"><a href="#">Permalink</a></div>		
		</article>	
	
	<? endforeach; ?>
						
</section>