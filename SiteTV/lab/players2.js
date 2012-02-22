var videos = new Array({
	id : 'xmehe4',
	type : 'dm',
	name : 'Starcraft 2'
}, {
	id : 'xlyv7m',
	type : 'dm',
	name : 'Minecraft'
}, {
	id : 'xmgtv9',
	type : 'dm',
	name : 'Star Wars the Old Republic'
}, {
	id : 'xj7bck',
	type : 'dm',
	name : 'LOL'
}, {
	id : 'xms57k',
	type : 'dm',
	name : 'DOTA 2'
}, {
	id : 'xgjpeu',
	type : 'dm',
	name : 'GameCreds TV'
}, {
	id : 'xmzxcn',
	type : 'dm',
	name : 'eOSL'
}, {
	id : 'xhiibz',
	type : 'dm',
	name : 'aaa1 TV'
}, {
	id : 'xhlc15',
	type : 'dm',
	name : 'aaa2 TV'
}, {
	id : 'xhlc3t',
	type : 'dm',
	name : 'aaa3 TV'
}, {
	id : 'xhlc52',
	type : 'dm',
	name : 'aaa4 TV'
}, {
	id : 'momanus',
	type : 'jtv',
	name : 'Moman'
}, {
	id : 'adelscott',
	type : 'jtv',
	name : 'Adel'
}, {
	id : 'mstephano',
	type : 'jtv',
	name : 'Stephano'
}, {
	id : 'milleniumtv',
	type : 'jtv',
	name : 'Millenium tv'
}, {
	id : 'teamkigyar',
	type : 'ls',
	name : 'Teamkigyar'
}, {
	id : 'at0mium',
	type : 'jtv',
	name : 'at0mium'
}, {
	id : 'elarcis',
	type : 'jtv',
	name : 'Elarcis'
}, {
	id : 'mojang',
	type : 'jtv',
	name : 'Mojang'
});

var videosOffline = new Array();
var count = 0;
var nbChaines = 0;
var nbHub = 0;
var nbAll = 0;
var dmState = 0;

function ready() {
	count = count + 1;
	// $('#loader').html(count);
	if (count >= videos.length) {
		$('#loader').removeClass('loading');
		displayNbChaines();
	}
}

function addLi(i) {
	if (videos[i].type == 'dm' || videos[i].type == 'ls') {
		chaines = document.getElementById('chaines');
	} else {
		chaines = document.getElementById('jtv');
	}
	newli = document.createElement('li');
	chaines.appendChild(newli);

	newa = document.createElement('a');
	newli.appendChild(newa);
	newa.setAttribute('href', 'javascript:void(0);');
	newa.setAttribute('onclick', 'play(' + i + ')');

	newpaq = document.createElement('div');
	newa.appendChild(newpaq);
	$(newpaq).css("margin", "5px");

	$(
			'<i/>',
			{
				style : 'display: inline-block;' + 'width: 18px;'
						+ 'height: 16px;' + 'background: url(favicon-'
						+ videos[i].type + '.ico) no-repeat center center;'
			}).appendTo(newpaq);

	newDesc = document.createElement('span');
	newpaq.appendChild(newDesc);
	newDesc.id = "desc" + i;
	$(newDesc).addClass("fill");
	$(newDesc).text('chargement ...');
}

function init() {

	loadVideos("mill", "https://api.dailymotion.com/user/Millenium_TV/videos",
			'Dernière vidéos Millenium', 10, 1);
	loadVideos("gameblog", "https://api.dailymotion.com/user/Gameblog/videos",
			'Dernière vidéos Gameblog', 10, 1);
	loadVideos(
			"LotC",
			"https://api.dailymotion.com/playlist/x1vtlt_Millenium_TV_minecraft-the-lord-of-the-cubes/videos",
			'Lord of the Cubes', 10, 1);
	loadVideos("another",
			"https://api.dailymotion.com/playlist/x1vmyd_dybex_another/videos",
			'Mangas : "Another"', 10, 1);

	$('#loader').addClass('loading');
	for ( var i = 0; i < videos.length; i++) {
		addLi(i);
		request(i);
	}

}

var timer;
function toggleAutoRefresh() {
	if (timer == null) {
		var time = 60000;
		refreshDesc();
		timer = setInterval("refreshDesc()", time);
	} else {
		clearInterval(timer);
		timer = null;
	}
}

function displayNbChaines() {
	elt = $('#nbChaines');
	if (nbChaines > 0) {
		elt.show();
		elt.html(nbChaines);
	} else {
		elt.hide();
	}

	elt2 = $('#nbHub');
	if (nbHub > 0) {
		elt2.show();
		elt2.html(nbHub);
	} else {
		elt2.hide();
	}

	elt3 = $('#nbAll');
	nbAll = nbChaines + nbHub;
	if (nbAll > 0) {
		elt3.show();
		elt3.html(nbAll);
	} else {
		elt3.hide();
	}

}
function setDesc(i) {
	desc = document.getElementById("desc" + i);

	if (videos[i].type == 'dm') {
		descrition = videos[i].title;
	} else
	// if(videos[i].type == 'jtv')
	{
		descrition = videos[i].name;
	}
	if (videos[i].count) {
		descrition = descrition + ' (' + videos[i].count + ')';
	}
	$(desc).text('');
	if (videos[i].mode == 'live') {

		if (videos[i].onair) {
			status = $('<span/>', {
				class : 'label label-success icon-live',
				html : 'Live'
			});

			$(desc).css("font-weight", "bold");

			if (videos[i].type == 'jtv') {
				nbHub = nbHub + 1;
			} else {
				nbChaines = nbChaines + 1;
			}

		} else {
			status = $('<span/>', {
				class : 'label icon-live',
				html : 'Off'
			});
			$(desc).css("font-weight", "none");
		}

	} else {
		$(desc).css("border", "6px solid #FFF");
	}
	$('<span/>', {
		class : 'fill',
		html : descrition
	}).appendTo(desc);

	if (status) {
		status.appendTo(desc);
	}
}

var currentPlayer;
var videotoload;

function initLSPlayer(videoId) {
	params = {
		AllowScriptAccess : 'always',
		AllowFullScreen : "true"
	};
	flashvars = {
		channel : videoId
	};
	var atts = {
		id : "live"
	};
	swfobject.embedSWF(
			"http://cdn.livestream.com/chromelessPlayer/v20/playerapi.swf",
			"live", "930", "500", "9.0.0", "expressInstall.swf", flashvars,
			params, atts);
}
function livestreamPlayerCallback(event) {
	if (event == 'ready') {
		lsplayer = document.getElementById("live");
		currentPlayer = lsplayer;
		// if (lsplayer.isLive()) {
		lsplayer.startPlayback(0);
		// }
		lsplayer.showFullscreenButton(true);
		lsplayer.showPlayButton(true);
		lsplayer.showPauseButton(true);
		lsplayer.showMuteButton(true);
		lsplayer.showThumbnail(true);
		// $('#tvtitle').html(
		// lsplayer.getChannelDescription() + ' ('
		// + lsplayer.getViewerCount() + ')');
	}
}

function initDMPlayer(videoId) {
	var params = {
		allowScriptAccess : "always",
		allowFullScreen : "true"
	};
	var atts = {
		id : "live"
	};
	swfobject.embedSWF("http://www.dailymotion.com/swf/" + videoId
			+ "&enableApi=1&playerapiid=dmplayer", "live", "930", "500", "9",
			null, null, params, atts);
}
function onDailymotionPlayerReady(playerId) {
	if (playerId == 'dmplayer') {

		dmplayer = document.getElementById("live");
		dmplayer.unMute();

		dmplayer.addEventListener("onStateChange", "ondmplayerStateChange");
		status = document.getElementById("status");

		dmplayer.playVideo();
		currentPlayer = dmplayer;
	}
}

function initJTVPlayer(videoId) {
	var params = {
		allowScriptAccess : "always",
		allowFullScreen : "true",
		allowNetworking : "all",
		flashvars : "hostname=fr.twitch.tv&amp;channel=" + videoId + "&amp;auto_play=true&amp;start_volume=25"
	};
	var atts = {
		id : "live"
	};
	var flashvars = "hostname=fr.twitch.tv&amp;channel=" + videoId
	+ "&amp;auto_play=true&amp;start_volume=25";
	
	swfobject.embedSWF("http://fr.twitch.tv/widgets/live_embed_player.swf?"
			+ videoId, "live", "930", "500", "9", null, flashvars, params, atts);
}

function loadVideos(id, url, title, lim, page) {
	videosElt = document.getElementById('videos');

	$.ajax({
		url : url,
		async : false,
		data : {
			limit : lim,
			page : page
		},
		cache : false,
		dataType : 'json',
		success : function(ret) {

			var vids = ret.list;

			if (page < 2) {
				var div5 = document.createElement('div');
				div5.setAttribute('class', 'span4');
				videosElt.appendChild(div5);

				h3 = document.createElement('h2');
				$(h3).html(title);
				div5.appendChild(h3);

				ul = document.createElement('ul');
				ul.setAttribute('id', id);
				div5.appendChild(ul);
			} else {
				ul = document.getElementById(id);
			}
			for ( var i = 0; i < vids.length; i++) {
				var newli = document.createElement('li');
				ul.appendChild(newli);

				vid = vids[i];
				vid.mode = 'vod';
				vid.type = 'dm';
				videosOffline.push(vid);

				var newa = document.createElement('a');
				newa.setAttribute('href', 'javascript:void(0);');
				newa.setAttribute('onclick', 'playOff('
						+ (videosOffline.length - 1) + ')');

				$(newa).html(vid.title);

				newli.appendChild(newa);

				newli.appendChild(document.createElement('br'));

			}
			if (ret.has_more && page < 2) {
				// <ul class="pager">
				// <li><a href="#">Previous</a></li>
				// <li><a href="#">Next</a></li>
				// </ul>
				// </div>
				ulpager = document.createElement('ul');
				ulpager.setAttribute('class', 'pager');
				ulpager.setAttribute('id', 'ulpager' + id);
				div5.appendChild(ulpager);

				var newli = document.createElement('li');
				ulpager.appendChild(newli);
				var newa = document.createElement('a');
				newa.setAttribute('id', 'ulpagera' + id);
				newa.setAttribute('href', 'javascript:void(0);');
				newa
						.setAttribute('onclick', 'loadVideos("' + id + '","'
								+ url + '", "' + title + '", ' + lim + ','
								+ (page + 1) + ')');
				$(newa).html("Plus ...");
				newli.appendChild(newa);

			} else if (ret.has_more) {
				$('#ulpagera' + id).attr(
						"onclick",
						'loadVideos("' + id + '","' + url + '", "' + title
								+ '", ' + lim + ',' + (page + 1) + ')');
			} else {
				$('#ulpager' + id).remove();
			}
		}
	});
}

function ondmplayerStateChange(newState) {
	status.innerHTML = "Main player's new state: " + newState;
}

function refreshDesc() {
	count = 0;
	nbChaines = 0;
	nbHub = 0;
	$('#loader').addClass('loading');
	for ( var i = 0; i < videos.length; i++) {
		request(i);
	}
}

function request(i) {
	if (videos[i].type == 'dm') {
		var onairurl = 'https://api.dailymotion.com/video/' + videos[i].id
				+ '?fields=onair,title,mode';
		$.ajax({
			url : onairurl,
			cache : false,
			dataType : 'json',
			success : function(ret) {
				videos[i].onair = ret.onair;
				videos[i].title = ret.title;
				videos[i].mode = ret.mode;
				ready();
				setDesc(i);
			},
			error : function(ret) {
				videos[i].onair = false;
				ready();
				setDesc(i);
			}
		});
	} else if (videos[i].type == 'jtv') {
		var onairurl2 = 'http://api.justin.tv/api/stream/list.json?jsonp=?';
		$.ajax({
			url : onairurl2,
			cache : false,
			dataType : 'json',
			data : {
				channel : videos[i].id
			},
			success : function(ret) {
				videos[i].onair = ret[0] != '';
				videos[i].count = ret[0].channel_count;
				videos[i].title = ret[0].title;
				videos[i].mode = 'live';
				ready();
				setDesc(i);
			},
			error : function(ret) {
				videos[i].onair = false;
				videos[i].mode = 'live';
				ready();
				setDesc(i);
			}
		});
	} else if (videos[i].type == 'ls') {
		var onairurl3 = 'http://x' + videos[i].id
				+ 'x.api.channel.livestream.com/2.0/livestatus.json';
		// var onairurl3 = 'http://channel.api.livestream.com/1.0/livestatus';
		$.ajax({
			url : onairurl3,
			cache : false,
			// data: { channel: videos[i].id},
			dataType : 'jsonp',
			success : function(ret) {
				videos[i].onair = ret.channel.isLive;
				videos[i].count = ret.channel.currentViewerCount;
				videos[i].title = videos[i].name;
				videos[i].mode = 'live';
				ready();
				setDesc(i);
			},
			error : function(ret) {
				console.error(ret);
				videos[i].onair = false;
				// videos[i].mode = 'live';
				ready();
				setDesc(i);
			}
		});
	}

}

function play(i) {
//	if (videos[i].type == 'jtv') {
//		openVideo(videos[i]);
//	} else {
		playVideo(videos[i]);
//	}
}

function jumpToAnchor(cible) {
	$('html, body').animate({
		scrollTop : $(cible).offset().top
	});
}

function playOff(i) {
	playVideo(videosOffline[i]);
}

function openVideo(video) {
	if (video.type == 'jtv') {
		window.open("http://fr.twitch.tv/" + video.id, '_blank');
	}
}

function playVideo(video) {
	load(video);
	$('#tvtitle').html(video.title);
	jumpToAnchor("#top");
}

function load(video) {
	if (video.type == 'dm') {
		loadOnDM(video.id);
	} else if (video.type == 'ls') {
		loadOnLS(video.id);
	} else {
		initJTVPlayer(video.id);
	}

}
function loadOnDM(videoId) {
	if (currentPlayer && currentPlayer == dmplayer) {
		dmplayer.loadVideoById(videoId);
	} else {
		initDMPlayer(videoId);
	}
}
function loadOnLS(videoId) {
	if (currentPlayer && currentPlayer == lsplayer) {
		lsplayer.load(videoId);
		if (lsplayer.isLive()) {
			lsplayer.startPlayback(0);
		}
	} else {
		videotoload = videoId;
		initLSPlayer(videoId);
	}
}

function stop() {
	// dmplayer.stopVideo();
	// lsplayer.stopPlayback();
	currentPlayer = null;
	$("#live").remove();
	$("#tvtitle").html("Web TV");
	$('<div id="live">').appendTo('.liveContainer');
}
function showModal() {
	$('#connectModal').modal('show');
}
