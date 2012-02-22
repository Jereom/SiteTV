function saveModal() {
	type = $('select[name="type"]').val();
	title = $('input[name="title"]').val();
	url = $('input[name="url"]').val();
	var nok = false;
	if (type.indexOf("playlist") >= 0) {

		if (url.indexOf("www.dailymotion.com/") >= 0) {
			url = url.substr(url.indexOf("www.dailymotion.com/") + 20,
					url.length);
		} else {
			nok = true;
		}
		if (!nok) {
			loadVideos(title, "https://api.dailymotion.com/" + url + "/videos",
					title, 10, 1);
		}
	} else {
		// http://www.dailymotion.com/embed/video/xmehe4
		// http://www.livestream.com/teamkigyar

		if (url.indexOf("www.dailymotion.com/embed/video/") >= 0) {
			tp = 'dm';
			url = url.substr(
					url.indexOf("www.dailymotion.com/embed/video/") + 32,
					url.length);

		} else if (url.indexOf("www.livestream.com") >= 0) {
			tp = 'ls';
			url = url
					.substr(url.indexOf("www.livestream.com") + 19, url.length);

		} else {
			nok = true;
		}
		if (url.indexOf("/") >= 0) {
			url = url.substr(0, url.indexOf("/"));
		}

		if (!nok) {
			newStr = {
				id : url,
				type : tp,
				name : title
			};
			i = videos.push(newStr);

			addLi(i - 1);
			request(i - 1);
		}
	}
	$('#addContent').each(function() {
		this.reset();
	});
	if (nok) {
		alert("L'url n'a pas un bon format");
	}
	// $("#messages").text(url);

}