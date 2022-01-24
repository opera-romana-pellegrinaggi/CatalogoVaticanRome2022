<?php

$dir    = './it';
$files1 = array_diff(scandir($dir), ['..','.']);

$translationJson = new stdClass();

foreach( $files1 as $file ) {
    $name = explode( '.', $file )[0];
    $translationJson->{$name} = new stdClass();
    $jsonArray = json_decode( file_get_contents( "$dir/$file" ), true );
    $currentStoryId = "";
    foreach( $jsonArray as $entry ) {
        if( $entry["storyId"] !== $currentStoryId ) {
            $currentStoryId = $entry["storyId"];
            $translationJson->{$name}->{$currentStoryId} = [];
            $translationJson->{$name}->{$currentStoryId}[$entry["sourceText"]] = $entry["text"];
        } else {
            $translationJson->{$name}->{$currentStoryId}[$entry["sourceText"]] = $entry["text"];
        }
    }
}

print_r( json_encode( $translationJson ) );
die();
?>
