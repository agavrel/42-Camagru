(function() {

  var streaming = false,
	  video        = document.querySelector('#video'),
	  cover        = document.querySelector('#cover'),
	  canvas       = document.querySelector('#canvas'),
	  photo        = document.querySelector('#photo'),
	  startbutton  = document.querySelector('#startbutton'),
	  width = 500,
	  height = 0;

  navigator.getMedia = ( navigator.getUserMedia ||
						 navigator.webkitGetUserMedia ||
						 navigator.mozGetUserMedia ||
						 navigator.msGetUserMedia);

  navigator.getMedia(
	{
		video: true,
		audio: false
	},
	function(stream) {
	  if (navigator.mozGetUserMedia) {
		video.mozSrcObject = stream;
	  } else {
		var vendorURL = window.URL || window.webkitURL;
		video.src = vendorURL.createObjectURL(stream);
	  }
	  video.play();
	},
	function(err) {
	  console.log("An error occured! " + err);
	}
	);

	startbutton.addEventListener('click', function(ev){
		takepicture();
	ev.preventDefault();
	}, false);

	video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			/* canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);*/
			streaming = true;
		}
	}, false);

	function takepicture() {
	canvas.width = width;
	canvas.height = height;
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	var data = canvas.toDataURL('image/png');
	photo.setAttribute('src', data);
	savePicture();
	}

	function putPreview(imgPath)
	{
		var imgPreview = document.querySelectorAll('.img_preview'),
			parentDiv = document.getElementById('side_container'),
			newImg = document.createElement('img');

		if (imgPreview.length == 3)
		{
			parentDiv.removeChild(imgPreview[2]);
			imgPreview.length -= 1;
		}
		newImg.src = imgPath;
		newImg.className = 'img_preview';
		parentDiv.insertBefore(newImg, imgPreview[0]);
	}

	function savePicture()
	{
		var head = /^data:image\/(png|jpeg);base64,/,
			data = '',
			filter = document.querySelector('input[name="filter"]:checked').value,
			xhr = new XMLHttpRequest(),
			ret = null;	

		data = canvas.toDataURL('image/jpeg', 0.9).replace(head, '');
		xhr.open('POST', url() + 'Userindexphp/save', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('contents=' + data + '&filter=' + filter);
		xhr.onload = function ()
		{
			if (xhr.readyState === xhr.DONE)
			{
				if (xhr.status === 200 || xhr.status == 0)
				{
					var string = xhr.responseText.substring(0, xhr.responseText.indexOf("}") + 1);
					var jsonImg = JSON.parse(string);
					var imagePath = '../' + jsonImg['image_path'].substring(1, jsonImg['image_path'].indexOf("'", 2));

					base_image = new Image();
					base_image.src = imagePath;
					base_image.onload = function()
					{
						canvas.width = width;
						canvas.height = height;
						canvas.getContext('2d').drawImage(base_image, 0, 0, width, height);
					}
					putPreview(imagePath);
				}
			}
		};
	}

	function url(){
		var url =  window.location.href;
		url = url.split("/");
		return(url[0] + '//' + url[2] + '/' + url[3] + '/');
	}
})();