<?php
header('Content-Type: application/json');

if (is_numeric($_GET["id"])) {
	$id = intval($_GET["id"]);
} else {
	die();
}

//$url = 'https://www.prusaprinters.org/graphql/';
//$url = 'https://www.printables.com/graphql/';
$url = 'https://api.printables.com/graphql/';

$superQuery = 'query PrintProfile($id: ID!) {
	print(id: $id) {
		id
		slug
		name
		user {
			id
			publicUsername
			avatarFilePath
			slug
			badgesProfileLevel {
				profileLevel
			}
			printsCount
		}
		ratingAvg
		ratingCount
		description
		modified
		firstPublish
		datePublished
		summary
		shareCount
		likesCount
		makesCount
		downloadCount
		displayCount
		filesCount
		collectionsCount
		commentCount
		images {
			filePath
		}
		thingiverseLink
		license {
			id
			name
			abbreviation
			content
			disallowRemixing
		}
	}
}';

$contentJson = json_encode(array('operationName' => 'PrintProfile', 'query' => $superQuery, 'variables' => array('id' => $id)));

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\nAccept-Language: de,en-US\r\n",
        'method'  => 'POST',
        'content' => $contentJson
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
	json_encode(array('data' => null));
} else {
	echo $result;
}

?>
