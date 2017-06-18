/**************************************** Global constiables ******************************/
(function() {

  const
	  video       	= document.querySelector('#video'),
	  download_btn	= document.querySelector('#download_btn'),
	  cover       	= document.querySelector('#cover'),
	  canvas      	= document.querySelector('.canvas'),
	  ctx 			= canvas.getContext("2d"),
	  colour 		= 'deeppink',
	  photo       	= document.querySelector('#photo'),
	  upload      	= document.querySelector('#getval'),
	  startbutton 	= document.querySelector('#startbutton'),
	  saveButton	= document.querySelector('#save'),
	  addFilter 	= document.querySelector('#addfilter'),
	  gS_check		= document.querySelector('#greyScale_checkBox'),
	  how2Use		= document.querySelector('#howToUse'),
	  helpBox		= document.querySelector('#helpBox'),
	  cam_container	= document.querySelector('#cam_container'),
	  close			= document.querySelector('#close'),
	  alert			= document.querySelector('.alert'),
	  gS_checked	= false,
	  width 		= 500,
	  mousePos 		= {
	  	x: 0,
	  	y: 0
	  };

	  canvas.width = width;
	  canvas.height = height;
	  // set the colour

	var height 		= 0,
		mousedown	= false,
		streaming	= false;


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
			const vendorURL = window.URL || window.webkitURL;
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

/* display help on click and blur background, excluding menu items */
	upload.addEventListener('change',previewFile);

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
		messageAnimation(alert, "Your picture has been saved");
	});

/* download function */
	download_btn.addEventListener('click', function() {

		downloadCanvas(this, 'canvas', 'myPicture.png');
	}, false);

/* take picture function */
	startbutton.addEventListener('click', function(ev){
		takePicture();
		ev.preventDefault();

	}, false);

/* add filter function */
	addFilter.addEventListener('click', function(){
		if (document.querySelector('input[name="filter"]:checked')) {
			const base_image = new Image(),
			filter = document.querySelector('input[name="filter"]:checked').value;

			base_image.src = '../public/resources/filter/' + filter;
			base_image.onload = function(){
				canvas.getContext('2d').drawImage(base_image, mousePos.x, mousePos.y, 100, 100);
			}
		}
		else
		{
			const alert = document.createElement('div'),
				container = document.getElementById('cam_container');

			alert.className = 'alert alert-danger';
			container.insertBefore(alert, container.firstChild);
			alert.appendChild(document.createTextNode("Chose a filter before adding one !"));
		}
	});


	/* draw functions listeners */
	// get the mouse position on the canvas (some browser trickery involved)
	canvas.addEventListener( 'mousemove', function( event ) {
	  if (event.offsetX ) {
	    mouseX = event.offsetX;
	    mouseY = event.offsetY;
	  }
	  else {
	    mouseX = event.pageX - event.target.offsetLeft;
	    mouseY = event.pageY - event.target.offsetTop;
	  }
	  // call the draw function
	  draw();
	}, false );

	canvas.addEventListener( 'mousedown', function( event ) {
	    mousedown = true;
	}, false );
	canvas.addEventListener( 'mouseup', function( event ) {
	    mousedown = false;
	}, false );


/*************************************** Functions ********************************/

/* not usefull anymore since using css below
	function greyScale() {
		const imgPixels = canvas.getContext('2d').getImageData(0, 0, width, height);
		for(const y = 0; y < imgPixels.height; y++){
			for(const x = 0; x < imgPixels.width; x++){
				const i = (y * 4) * imgPixels.width + x * 4;
				const avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg;
				imgPixels.data[i + 1] = avg;
				imgPixels.data[i + 2] = avg;
			}
		}
		canvas.getContext('2d').putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
	}
*/

	function messageAnimation(mymsg, msg) {

		alert.style.display = 'inline';
		alert.innerHTML = msg;
		mymsg.classList.add("fadein");
		setTimeout(function () {
			mymsg.classList.remove("fadein");
			mymsg.classList.add("fadeout");
		}, 1000);
		/* 2sd to fadeout and fadeout during 600ms (css for save-success) = 2600 */
		setTimeout(function () {
			//alert.remove();
			alert.style.display = 'none';
		}, 1600);
	}

/* Function activated when clicking on picture button and applying css */
	function takePicture() {
		const currentClass = document.getElementById('video').className;
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
		const data = canvas.toDataURL('image/png');
		const alertMessage_ok = document.getElementsByClassName('alert alert-success'),
			alertMessage_fail = document.getElementsByClassName('alert alert-danger'),
			container = document.getElementById('cam_container');
		if (alertMessage_ok.length != 0)
			container.removeChild(container.childNodes[0]);
		if (alertMessage_fail.length != 0)
			container.removeChild(container.childNodes[0]);
		saveButton.style.display = 'inline';
		download_btn.style.display = 'inline';
		flash();
	}

/* drawing functions */
	function draw() {
		ctx.fillStyle = colour;
		if (mousedown) {
			// start a path and paint a circle of 20 pixels at the mouse position
			ctx.beginPath();
			ctx.arc( mouseX, mouseY, 4 , 0, Math.PI*2, true );
			ctx.closePath();
			ctx.fill();
		}
	}

	function downloadCanvas(link, canvasId, filename) {
    	link.href = document.getElementById(canvasId).toDataURL('image/jpeg', 0.9);
    	link.download = filename;
	}

/* preview file mannually dragged */
	// for eg const obj = { id: 1};
	// const { id } = obj;
	// destructuring for handles error of undefined.
	function previewFile({ target: { files } }) {
		const img = new Image();
		const _URL = window.URL || window.webkitURL;
		const file = files[0];

		img.onload = () => {
		}
		img.onerror = () => {
			alert('Wrong Type');
		}
		if (file)
		{
			img.src = _URL.createObjectURL(file);
			photo.src = img.src;
		}
		saveButton.style.display = 'inline';
		download_btn.style.display = 'inline';
	}

/* Function to flash screen*/
	function flash(e){
  	  	const myimg = document.getElementsByTagName('body')[0];
  	  //		const video_img = document.querySelectorAll("#video img");
  	  	myimg.classList.add('flash');
  	  	setTimeout(function () {
  	  	myimg.classList.remove('flash');}, 300);
	}

/* Function to save picture */
	function savePicture()	{
	const head = /^data:image\/(png|jpeg);base64,/,
		xhr = new XMLHttpRequest(),
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
