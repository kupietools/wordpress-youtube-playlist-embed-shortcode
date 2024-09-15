#    wordpress-youtube-playlist-embed-shortcode

This is some PHP to embed a YouTube playlist in a Wordpress page or post. The native YouTube embeds don't show the list of videos in the playlist, just the playing video, and you must click a tiny icon to see the list of videos. I didn't like that.

The PHP code should be put in your Wordpress theme's functions.php file or in a custom plugin. You should also enter the provided CSS somewhere to style the output. 

Then you can put a shortcode `[ytplaylist playlist_ID="[PLAYLIST_ID]"` in a post or page. The `PLAYLIST_ID` comes from the embed code provided by YouTube, at this writing it's the `list=` parameter in the src url of the `embed` iframe tag.

As of this initial commit, this is very barebones. It gets the job done, that's it. 

You can see this shortcode in action on pages of [Michael Kupietz Arts+Code](https://michaelkupietz.com) such as [The Best Of Guitarist In Progress — video playlist](https://michaelkupietz.com/best-guitaristinprogress-video-playlist/).

Thanks to https://codepen.io/skyrocker/pen/jONrvwO for the original tip that yielded a javascript version of this technique, linked from the accepted answer at [https://stackoverflow.com/questions/57459015/how-to-embed-a-youtube-playlist-with-a-sidebar](https://stackoverflow.com/questions/57459015/how-to-embed-a-youtube-playlist-with-a-sidebar).
