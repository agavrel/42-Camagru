/**************************************** Global variables ******************************/
(function() {

  var streaming = false,
	  video       	= document.querySelector('#video'),
	  cover       	= document.querySelector('#cover'),
	  canvas      	= document.querySelector('#canvas'),
	  photo       	= document.querySelector('#photo'),
	  startbutton 	= document.querySelector('#startbutton'),
	  saveButton	= document.querySelector('#save'),
	  addFilter 	= document.querySelector('#addfilter'),
	  gS_check		= document.querySelector('#greyScale_checkBox'),
	  how2Use		= document.querySelector('#howToUse'),
	  helpBox		= document.querySelector('#helpBox'),
	  cam_container	= document.querySelector('#cam_container'),
	  close			= document.querySelector('#close'),
	  gS_checked	= false,
	  width 		= 500,
	  height 		= 0,
	  mousePos 		= {
	  	x: 0,
	  	y: 0
	  };


	navigator.getMedia = (navigator.getUserMedia ||
						navigator.webkitGetUserMedia ||
						navigator.mozGetUserMedia ||
						navigator.msGetUserMedia);

	navigator.getMedia(
	{	video: true,
		audio: false },
	function(stream) {
		if (navigator.mozGetUserMedia) {
			video.mozSrcObject = stream;}
		else {
			var vendorURL = window.URL || window.webkitURL;
			video.src = vendorURL.createObjectURL(stream); }
		video.play(); },
	function(err) {
		console.log("An error occured! " + err); }
	);

/***************************************** Event listeners ******************************/

/* display help on click and blur background, excluding menu items */
	how2Use.addEventListener('click', function() {
		helpBox.style.display = "inline-block";
		cam_container.setAttribute('class', 'filter_blur');
	})

/* close help if click on close button... */
	close.addEventListener('click', function(){
		helpBox.style.display = "none";
		cam_container.setAttribute("class", "");
	})
/* ...or somewhere else on the page */
	window.onclick = function(event) {
		if (event.target != helpBox && event.target != how2Use)
		{
			helpBox.style.display = "none";
			cam_container.setAttribute("class", "");
		}
	}

/* filter position function */
	video.addEventListener('click', function(e) {
		mousePos.x = e.offsetX - 50;
		mousePos.y = e.offsetY - 50;
	})

	canvas.addEventListener('click', function(e) {
		mousePos.x = e.offsetX - 50;
		mousePos.y = e.offsetY - 50;
	})

/* stream webcam function */
	video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);

/* save picture function */
	save.addEventListener('click', function(){
		savePicture();
		saveButton.style.display = 'none';

		photo.style.display = 'none';
		var alert = document.createElement('div'),
			container = document.getElementById('cam_container');
		alert.className = 'alert alert-success';
		container.insertBefore(alert, container.firstChild);
		alert.appendChild(document.createTextNode("Your picture has been saved"));
	});

/* take picture function */
	startbutton.addEventListener('click', function(ev){
		takePicture();
		var video_img = document.getElementById('video');
		var myimg = video_img.getElementsByTagName('img')[0];
		var mysrc = myimg.src;
//		var video_img = document.querySelectorAll("#video img");
		myimg.classList.add('flash');
		setTimeout(function () {
			myimg.classList.remove('flash');}, 900);
		ev.preventDefault();
	}, false);

/* add filter function */
	addFilter.addEventListener('click', function(){
		if (document.querySelector('input[name="filter"]:checked')) {
			var base_image = new Image(),
			filter = document.querySelector('input[name="filter"]:checked').value;

			base_image.src = '../public/resources/filter/' + filter;
			base_image.onload = function(){
				canvas.getContext('2d').drawImage(base_image, mousePos.x, mousePos.y, 100, 100);
			}
		}
		else
		{
			var alert = document.createElement('div'),
				container = document.getElementById('cam_container');

			alert.className = 'alert alert-danger';
			container.insertBefore(alert, container.firstChild);
			alert.appendChild(document.createTextNode("Chose a filter before adding one !"));
		}
	});

/*************************************** Functions ********************************/

/* not usefull anymore since using css below
	function greyScale() {
		var imgPixels = canvas.getContext('2d').getImageData(0, 0, width, height);
		for(var y = 0; y < imgPixels.height; y++){
			for(var x = 0; x < imgPixels.width; x++){
				var i = (y * 4) * imgPixels.width + x * 4;
				var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg;
				imgPixels.data[i + 1] = avg;
				imgPixels.data[i + 2] = avg;
			}
		}
		canvas.getContext('2d').putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
	}
*/

/* Function activated when clicking on picture button and applying css */
	function takePicture() {
		var ctx = canvas.getContext("2d");
		var currentClass = document.getElementById('video').className;
		canvas.width = width;
		canvas.height = height;
		switch(currentClass) {
		    case "filter_sepia":
		        ctx.filter = "sepia(1)";
		        break;
		    case "filter_greyscale":
		        ctx.filter = "grayscale(100%)";
		        break;
			case "filter_saturate":
		        ctx.filter = "saturate(8)";
		        break;
			case "filter_opacity":
		        ctx.filter = "opacity(.2)";
		        break;
			case "filter_brightness":
		        ctx.filter = "brightness(3)";
		        break;
			case "filter_contrast":
		        ctx.filter = "contrast(4)";
		        break;
			case "filter_blur":
		        ctx.filter = "blur(5px)";
		        break;
		    default:
		        ctx.filter = "";
		}
		ctx.drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
		saveButton.style.display = 'inline';
		var alertMessage_ok = document.getElementsByClassName('alert alert-success'),
			alertMessage_fail = document.getElementsByClassName('alert alert-danger'),
			container = document.getElementById('cam_container');
		if (alertMessage_ok.length != 0)
			container.removeChild(container.childNodes[0]);
		if (alertMessage_fail.length != 0)
			container.removeChild(container.childNodes[0]);
	}

/* Function to flash screen*/
	function flash(e){
	  $('.flash')
	   .show()  //show the hidden div
	   .animate({opacity: 0.5}, 300)
	   .fadeOut(300)
	   .css({'opacity': 1});
	}

/* Function to save picture */
	function savePicture()	{
	var head = /^data:image\/(png|jpeg);base64,/,
		data = '',
		xhr = new XMLHttpRequest();

		data = canvas.toDataURL('image/jpeg', 0.9).replace(head, '');
		xhr.open('POST', url() + 'Userindex/save', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('contents=' + data);
	}

	function url(){
		var url =  window.location.href;
		url = url.split("/");
		return(url[0] + '//' + url[2] + '/' + url[3] + '/');
	}

})();
