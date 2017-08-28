<?php
//script to get segments of the urls inside a text file
//@author: Mark Lawrence Dilla

$lines = file("competitor_urls_combined.txt", FILE_IGNORE_NEW_LINES); // paas the value of the text to a variable

//output table
echo "<table border='1'>";
echo "<tr><td>DOMAIN</td><td>URL</td><td>PATHS/KEYWORDS</td></tr>";
foreach ($lines as $line) { // loop through each line of the text file
    parse($line);
}
echo "</table>";


//the main function for parsing the URL segments
//disregards/remove query string and file extensions
//TODO: change the return from table data to array
function parse($line) {
    $path = array();
    $line = strtok($line, '?'); //strip query string from URL
    $values = parse_url($line);
    if(array_key_exists('path', $values)) { // if there are path in the URL after the domain
        $path = explode("/", $values['path']);
    }
    $info = pathinfo($line);
    if ($values['host'] == $info['basename']) { // if the URL is homepage
        echo "<tr><td>" . $values['host'] . "</td><td>" . $line . "</td><td></td></tr>";
    } else {
        if (array_key_exists('extension', $info)) {
            for ($i = 0; $i < count($path); $i++) {
                if (strpos($path[$i], ".") === FALSE) {
                    if($path[$i] !== ""){
                        echo "<tr><td>" . $values['host'] . "</td><td>" . $line . "</td><td>" . clean($path[$i]) . "</td></tr>";
                    }
                }
            }
            echo "<tr><td>" . $values['host'] . "</td><td>" . $line . "</td><td>" . clean($info['filename']) . "</td></tr>";
        } else {
            for ($i = 0; $i < count($path); $i++) {
                if($path[$i] !== ""){
                    echo "<tr><td>" . $values['host'] . "</td><td>" . $line . "</td><td>" . clean($path[$i]) . "</td></tr>";
                }
            }
        }
    }
}

//converts '-' and '_' to space and url decodes the value of the parameter
function clean($text){
    $text = str_replace("-", " ", $text);
    $text = str_replace("_", " ", $text);
    return urldecode($text);
}
?>