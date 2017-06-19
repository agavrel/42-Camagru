function messageAnimation(msg, time) {
	const alert			= document.querySelector('.alert');

	alert.style.display = 'inline';
	alert.innerHTML = msg;
	alert.classList.add("fadein");
	setTimeout(function () {
		alert.classList.remove("fadein");
		alert.classList.add("fadeout");
	}, time);
	/* 2sd to fadeout and fadeout during 600ms (css for save-success) = 2600 */
	setTimeout(function () {
		alert.style.display = 'none';
	}, time + 600);
}
