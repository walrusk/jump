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
			<input type="text" name="photodate" id="newphoto_photodate" value="<?=date('Y-m-d');?>">
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