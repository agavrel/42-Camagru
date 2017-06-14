<?php
	$form = new Form();
?>
<div class="gallery-container">
	<div id="likersBox">
		<span id="close">&times;</span>
		<span><b>Likes</b></span><br>
		<div class="insideBox">	</div>
	</div>

	<div id="gallery_container">
		<h2>Gallery</h2><br>
		<?php ControllerUsergallery::five_imgs(0, $form); ?>
	</div>
	<script type="text/javascript" src="../public/js/gallery.js"></script>
</div>