var player;
function onYouTubeIframeAPIReady() {
	player = new YT.Player('muteYouTubeVideoPlayer', {
		//videoId: idVideo, // YouTube Video ID
		width: 215,               // Player width (in px)
		height: 150,              // Player height (in px)
		playerVars: {
			autoplay: 1,        // Auto-play the video on load
			controls: 1,        // Pause/play buttons in player
			showinfo: 1,        // The video title
			modestbranding: 0,  // The Youtube Logo
			loop: 1,            // Run the video in a loop
			fs: 1,              // Full screen button
			cc_load_policy: 0, // Closed captions
			iv_load_policy: 3,  // Hide the Video Annotations
			autohide: 1         // Video controls when playing
		},
		events: {
			'onReady': onPlayerReady
		}
	});
}

function onPlayerReady() {
	 player.mute();
	 var videoid = $('#muteYouTubeVideoPlayer').attr("data-id");
	 player.loadVideoById(videoid);
}
