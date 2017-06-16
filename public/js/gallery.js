var likeButton = document.querySelectorAll(".like"),
	likeMsg = document.querySelectorAll(".countLikes"),
	comButton = document.querySelectorAll(".btn"),
	currImg = document.querySelectorAll(".image"),
	popUp = document.querySelector('#likersBox'),
	userLink = document.querySelectorAll(".userLink"),
	divInside = document.querySelector(".insideBox"),
	close = document.querySelector("#close"),
	i = 0,
	length = likeButton.length;

for (i; i < length; i++) {
	if (document.addEventListener) {
		var xhr = new XMLHttpRequest();

		userLink[i].href = url() + "Userprofile/view/" + userLink[i].innerHTML;
		likeMsg[i].addEventListener("click", getUser);
		likeMsg[i].params = [xhr, likeButton[i]];
		comButton[i].addEventListener("click", comment);
		comButton[i].params = [xhr, currImg[i], comButton[i]];
		likeButton[i].addEventListener("click", function() {
			if (this.src.indexOf("empty") !== -1) {
				like(this, xhr);
			} else {
				unlike(this, xhr);
			}
		});
	}
};

function url(){
	var url =  window.location.href;
	url = url.split("/");
	return(url[0] + '//' + url[2] + '/' + url[3] + '/');
}

function getUser(evt)
{
	var xhr = evt.target.params[0],
		likeClicked = evt.target.params[1].id;
	xhr.open('POST', url() + 'Usergallery/showLikers', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('image_path=' + likeClicked);
	xhr.onload = function ()
	{
		if ((xhr.readyState === xhr.DONE) && (xhr.status === 200 || xhr.status === 0))
		{
				var string = xhr.responseText.substring(0, xhr.responseText.indexOf('<')).split(',');
				string.splice(string.length - 1, 1);
				if (string.length > 0) {
					string.forEach(function(item) {
						var link = document.createElement("a"),
							br = document.createElement("br");

						link.innerHTML = item;
						link.href = url() + 'Userprofile/view/' + link.innerHTML;
						divInside.appendChild(link);
						divInside.appendChild(br);
					}, string)
					popUp.style.display = "inline-block";
				}
		}
	}
}

close.addEventListener('click', function(){
	popUp.style.display = 'none';
	while (divInside.firstChild) {
   		divInside.removeChild(divInside.firstChild);
	}
})

window.onclick = function(event) {
	if (event.target != popUp)
	{
		popUp.style.display = "none"
		while (divInside.firstChild) {
   		 	divInside.removeChild(divInside.firstChild);
		}
	}

}

function comment(evt)
{
	var xhr = evt.target.params[0],
		currImg = evt.target.params[1],
		button = evt.target.params[2],
		tmp_path = currImg.src.split("/"),
		imgPath = "public/copies/" + tmp_path[tmp_path.length - 1],
		commentHTML = document.createElement('p'),
		com_contain = button.nextSibling.nextSibling.nextSibling,
		commenText = button.previousSibling.lastChild.value;

	if (commenText !== "")
	{
		xhr.open('POST', url() + 'Usergallery/comment', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("comment=" + commenText + "&img_path=" + imgPath);
		xhr.onload = function ()
		{
			if ((xhr.readyState === xhr.DONE) && (xhr.status === 200 || xhr.status == 0))
				{
					var string = xhr.responseText.substring(0, xhr.responseText.indexOf("}") + 1);
					var json = JSON.parse(string);
					var tmp = json['user'] + ': ';
					var user = tmp.bold();

					com_contain.insertBefore(commentHTML, com_contain.firstChild);
					commentHTML.innerHTML = user + commenText;
					button.previousSibling.lastChild.value = "";
				}
		};
	}
}

/* infinite pagination, credit: arlecomte && dzheng */
window.onscroll = function() {
	comButton = document.querySelectorAll(".test");
	var posY = window.pageYOffset,
		winSize = window.innerHeight,
		pageSize = document.documentElement.scrollHeight,
		imgs = document.querySelectorAll('.image'),
		lastImg = imgs[imgs.length - 1];
	if (posY + winSize > pageSize - 50)
	{
		var xhr = new XMLHttpRequest(),
			imgPath = lastImg.src.split("/");

		xhr.open('POST', url() + 'Usergallery/infiniteScroll', true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('img_path=' + "public/copies/" + imgPath[imgPath.length - 1]);

		xhr.onload = function()
		{
			if (xhr.readyState === xhr.DONE)
			{
				if (xhr.status === 200 || xhr.status === 0)
				{
					var string = xhr.responseText.substring(0, xhr.responseText.indexOf("|")),
						json,
						container = document.getElementById('gallery_container'),
						br = document.createElement("br"),
						com_div = document.createElement("div"),
						imgDiv = document.querySelector(".img-thumbnail"),
						cloneDiv = imgDiv.cloneNode(true),
						i = 0;
					if (string.indexOf('null') === 0 || string.indexOf('<!DOCTYPE') === 0)
						return ;
						json = JSON.parse(string);
					cloneDiv.removeChild(cloneDiv.lastChild);

					if (json.image_path)
					{
						//Create div
						cloneDiv.childNodes[1].innerHTML = json.owner;
						cloneDiv.childNodes[2].firstChild.src = '../' + json.image_path;
						if (json.liked === 'yes')
							cloneDiv.childNodes[3].src = '../public/resources/colored_heart.png';
						else
							cloneDiv.childNodes[3].src = '../public/resources/empty_heart.png';
						cloneDiv.childNodes[3].id = json.image_path;
						cloneDiv.childNodes[5].innerHTML = json.countLikes + ' like' + (json.countLikes > 1 ? 's' : '');
						com_div.className = "com_container";
						while (json.comments[i])
						{
							com_div.appendChild(document.createElement('p'));
							com_div.childNodes[i].innerHTML = '<b>' + json.comments[i].login + ': </b>' + ' ' + json.comments[i].img_comment;
							i++;
						}

						//Add event listener
						if (document.addEventListener)
						{
							if (typeof cloneDiv.childNodes[7] !== 'undefined') {
								cloneDiv.childNodes[7].addEventListener("click", comment);
								cloneDiv.childNodes[7].params = [xhr, cloneDiv.childNodes[2].firstChild, cloneDiv.childNodes[7]];
							}
							cloneDiv.childNodes[5].addEventListener("click", getUser);
							cloneDiv.childNodes[5].params = [xhr, cloneDiv.childNodes[3]];
							cloneDiv.childNodes[3].addEventListener("click", function() {
								if (this.src.indexOf("empty") !== -1) {
									like(this, xhr);
								} else {
									unlike(this, xhr);
								}
							});
						}
						//Put div on page
						cloneDiv.appendChild(com_div);
						container.appendChild(cloneDiv);
						container.appendChild(br);
					}
				}
			}
		}
	}
};



function like(likeClicked, xhr)
{
	xhr.open('POST', url() + 'Usergallery/like', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	likeClicked.src = "../public/resources/colored_heart.png";
	var countLikes = parseInt(likeClicked.nextSibling.nextSibling.innerHTML) + 1;
	likeClicked.nextSibling.nextSibling.innerHTML = countLikes + ' like' + (countLikes > 1 ? 's' : '');
	xhr.send('image_path=' + likeClicked.id);

}

function unlike(likeClicked, xhr)
{
	xhr.open('POST', url() + 'Usergallery/unlike', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	likeClicked.src = "../public/resources/empty_heart.png";
	var countLikes = parseInt(likeClicked.nextSibling.nextSibling.innerHTML) - 1;
	likeClicked.nextSibling.nextSibling.innerHTML = countLikes + ' like' + (countLikes > 1 ? 's' : '');
	xhr.send('image_path=' + likeClicked.id);
}

/* share on facebook */
