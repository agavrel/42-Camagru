var image = document.querySelectorAll(".images"),
	btn_cross = document.querySelectorAll(".cross"),
	i = 0,
	length = image.length;

for (i; i < length; i++) {
	if (document.addEventListener) {

		image[i].addEventListener("mouseover", function(){
			this.nextSibling.nextSibling.style.display = "inherit";
		});
		image[i].addEventListener("mouseout", function(){
			this.nextSibling.nextSibling.style.display = "none";
		});
		btn_cross[i].addEventListener("mouseover", function(){
			this.style.display = "inherit";
		});
		btn_cross[i].addEventListener("mouseout", function(){
			this.style.display = "none";
		});
		btn_cross[i].addEventListener("click", deletePhoto);

	}
	else {
		image[i].attachEvent("mousein", function(){});
		image[i].attachEvent("mouseout", function(){});
		btn_cross[i].attachEvent("mouseover", function(){});
		btn_cross[i].attachEvent("mouseout", function(){});
		btn_cross[i].attachEvent("click", function(){});
	}
};

function deletePhoto(){
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url() + 'Userprofile/delete', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var currImg = this.previousSibling.previousSibling.src.split("/");
	currImg = "public/copies/" + currImg[currImg.length - 1];
	xhr.send('img_path=' + currImg);
	/*
	*	Supprimer directement l'image au lieu d'un display none
	 */
	this.parentNode.style.display = "none";
	this.style.display = "none";
}

function url(){
	var url =  window.location.href;
	url = url.split("/");
	return(url[0] + '//' + url[2] + '/' + url[3] + '/');
}