<?php

require __DIR__ . '/vendor/autoload.php';

function die_code($message, $code=500) {
	http_response_code($code);
	die($message);
}
function is_url($url) {
	if (filter_var($url, FILTER_VALIDATE_URL) === false) {
		return false;
	}
	$parsed = parse_url($url);
	if (!$parsed || !in_array($parsed['scheme'], ['http', 'https'])) {
		return false;
	}
	return true;
}

if (!ini_get('allow_url_fopen')) {
	die_code("Can't fetch remote feeds");
}

$feed_url = $_GET['feed'] ?? false;
if (!$feed_url) {
	die_code("No feed provided");
}

if (!is_url($feed_url)) {
	die_code("Not a valid URL");
}

$feedIo = \FeedIo\Factory::create()->getFeedIo();
$result = $feedIo->read($feed_url);

foreach ($result->getFeed() as $item) {
	$categories = [];
	foreach ($item->getCategories() as $category) {
		$label = $category->getLabel() ?: $category->getTerm();
		if ($label[0] != '#') {
			$label = '#' . $label;
		}
		$categories[] = $label;
	}
	if ($categories) {
		$item->setDescription($item->getDescription() . "\n<p>" . implode(', ', $categories) . "</p>");
	}
}

echo $feedIo->toAtom($result->getFeed());
