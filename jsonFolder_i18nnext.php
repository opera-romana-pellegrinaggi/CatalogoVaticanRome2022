<?php

$dir    = './it';

$files1 = array_diff(scandir($dir), ['..','.','translation.json']);

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

//print_r( json_encode( $translationJson ) );
if( false !== file_put_contents( "{$dir}/translation.json", json_encode( $translationJson, JSON_PRETTY_PRINT ) ) ) {
    echo "Successfully saved JSON to file it/translation.json" . PHP_EOL;
};
die();
?>
