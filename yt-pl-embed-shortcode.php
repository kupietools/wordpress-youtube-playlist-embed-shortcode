
function ytplaylist_shortcode($atts) {
    $atts = shortcode_atts(array(
        'playlist_id' => ''
    ), $atts, 'ytplaylist');

    $playlistID = $atts['playlist_id'];

    if (empty($playlistID)) {
        return '<p>Please provide a valid YouTube playlist ID.</p>';
    }

    $apiKey = 'YOUR_API_KEY';
    $apiUrl = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=50&playlistId=' . $playlistID . '&key=' . $apiKey;

    $response = wp_remote_get($apiUrl);

    if (is_wp_error($response)) {
        return '<p>Error fetching playlist data.</p>';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['items'])) {
        return '<p>No playlist items found.</p>';
    }

    $playlistItems = $data['items'];

    static $instance = 0;
    $instance++;

    $output = '<div class="ytplaylist-container ytplaylist-container-' . $instance . '">';
    $output .= '<iframe frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="1" src="https://www.youtube.com/embed?listType=playlist&list=' . $playlistID . '&index=0"></iframe>';
    $output .= '<div><div class="ytlist_playlist">';

    foreach ($playlistItems as $index => $item) {
        $videoId = $item['snippet']['resourceId']['videoId'];
        $videoTitle = $item['snippet']['title'];
        $thumbnailUrl = 'https://i.ytimg.com/vi/' . $videoId . '/mqdefault.jpg';
        $videoUrl = 'https://www.youtube.com/watch?v=' . $videoId . '&list=' . $playlistID . '&index=' . ($index + 1);

        $output .= '<div class="ytlist_outeritem" data-video-id="' . $videoId . '" data-video-index="' . ($index + 1) . '">';
        $output .= '<div class="ytlist_playlist-item" style="background: url(' . $thumbnailUrl . ') no-repeat center; background-size: contain;"></div>';
        $output .= '<span class="ytlist_vid_name">' . $videoTitle . '<br><span>(<a href="' . $videoUrl . '">watch on YouTube</a>)</span></span>';
        $output .= '</div>';
    }

    $output .= '</div></div></div>';

    $output .= '<script>';
    $output .= 'document.addEventListener("DOMContentLoaded", function() {';
    $output .= '  var container = document.querySelector(".ytplaylist-container-' . $instance . '");';
    $output .= '  var iframe = container.querySelector("iframe");';
    $output .= '  var outerItems = container.querySelectorAll(".ytlist_outeritem");';
    $output .= '  outerItems.forEach(function(item) {';
    $output .= '    item.addEventListener("click", function() {';
    $output .= '      var videoIndex = this.getAttribute("data-video-index");';
    $output .= '      iframe.src = "https://www.youtube.com/embed?listType=playlist&list=' . $playlistID . '&autoplay=1&index=" + videoIndex;';
    $output .= '    });';
    $output .= '  });';
    $output .= '});';
    $output .= '</script>';

    return $output;
}

add_shortcode('ytplaylist', 'ytplaylist_shortcode');
