<?php $form = new Form($_POST); ?>
<!-- Help Box -->
<div id="helpBox">
	<span id="close">&times;</span>
	<h2 style="text-align: center;">Few helps</h2>
	<ul>
		<li>Choose your filter</li>
		<li>Click on the live or on the canvas at the position where you want see your filter appears</li>
		<li>Take your picture</li>
		<li>Add your filter</li>
		<li>If this one is perfect, save it by clicking on - Save picture -</li>
	</ul>
</div>

<!-- div cam_container -->
<div id="cam_container" style="text-align: center;">
<!-- Help button -->
	<button id="howToUse">Need help ?</button>
<!-- Filters -->
	<div id="filters">
		<?php if (isset($filters)) { echo $filters; } ?>
	</div>
<!-- a) Div visualize -->
	<div id="visualize" style="display: block;">
		<video id="video"></video>
<!-- color filter -->
<!-- https://stackoverflow.com/questions/30408939/how-to-save-image-from-canvas-with-css-filters
https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/filter -->
		<script>function SetFilter(myfilter) {
			   		video.setAttribute("class", myfilter.value);}
		</script>
		 <select class="btn-primary" id="filter_type" onchange="SetFilter(this)">
		 	<option value="" id="filter_none" selected="selected">No Filters</option>
		    <option value="filter_greyscale">Greyscale</option>
		    <option value="filter_blur">Blur</option>
		    <option value="filter_sepia">Sepia</option>
		    <option value="filter_contrast">Contrast</option>
		    <option value="filter_brightness">Brightful</option>
		    <option value="filter_opacity">Transparent</option>
		    <option value="filter_saturate">Saturate</option>
		</select>
<!-- Take Picture -->
			<button id="startbutton" class="btn btn-primary">Take picture</button>
<!-- Add Filter -->
			<button id="addfilter" class="btn btn-primary">Add filter</button>
	</div>
<!-- end of a) div -->

<!-- Video -->

	<div style="text-align: center; display: block;">
		<img src="" id="photo" style="display: none;">
	</div>
	<canvas id="canvas" style="border:1px solid black;"></canvas>
<!-- Save Picture -->
	<div style="margin-bottom: 10px;">
		<button id="save" class="btn btn-primary" style="display: none;">Save picture</button>
	</div>
</div>
<script src="../public/js/cam.js"></script>
