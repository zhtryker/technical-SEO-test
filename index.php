<?php
//backend code goes here
//create desc
include 'techseo.class.php';



$url = 'http://www.connectcentral-ringcentralevents.com/robots.txt';

//$element = new techseo($url);

//echo "TITLE: " . $element->getHTMLTitle();


//var_dump(is_file($url));










function getHeaderResponseUsingCurl($url, $followredirects = true) {
    // returns int responsecode, or false (if url does not exist or connection timeout occurs)
    // NOTE: could potentially take up to 0-30 seconds , blocking further code execution (more or less depending on connection, target site, and local timeout settings))
    // if $followredirects == false: return the FIRST known httpcode (ignore redirects)
    // if $followredirects == true : return the LAST  known httpcode (when redirected)
    if (!$url || !is_string($url)) {
        return false;
    }
    $ch = @curl_init($url);
    if ($ch === false) {
        return false;
    }
    @curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    @curl_setopt($ch, CURLOPT_NOBODY, true);    // dont need body
    @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    // catch output (do NOT print!)
    if ($followredirects) {
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        @curl_setopt($ch, CURLOPT_MAXREDIRS, 10);  // fairly random number, but could prevent unwanted endless redirects with followlocation=true
    } else {
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    }
//      @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5);   // fairly random number (seconds)... but could prevent waiting forever to get a result
//      @curl_setopt($ch, CURLOPT_TIMEOUT        ,6);   // fairly random number (seconds)... but could prevent waiting forever to get a result
    @curl_setopt($ch, CURLOPT_USERAGENT      ,"Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1");   // pretend we're a regular browser
    @curl_exec($ch);
    if (@curl_errno($ch)) {   // should be 0
        @curl_close($ch);
        return false;
    }
    $code = @curl_getinfo($ch); // note: php.net documentation shows this returns a string, but really it returns an int
    @curl_close($ch);
    return $code;
}
//$url = "https://sjc01-qa-dispatcher.ringcentral.com/office/features/call-flip/overview.html";
//
//echo "<pre/>";
//if(!getHeaderResponseUsingCurl($url, FALSE)){
//    echo 'Not Accessible';
//} else {
//    print_r(getHeaderResponseUsingCurl($url, FALSE));
//}
?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>JIRA ticket Tech SEO reviewer</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<style type="text/css">
		.hidden {
			display: none;
		}
		.current {
			display: block;
		}
	</style>
</head>
<body>
<div class="container">
	<h1>Tech SEO Page Reviewer</h1>
        <form name="search" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="form-inline" >
            <div class="form-group">
                <label class="sr-only" for="url">URL</label>
                <input type="text" class="form-control"
                       id="url" placeholder="Example: https://sjc01-qa-dispatcher.ringcentral.com/" name="url" value="<?php if (isset($_POST['url'])) { echo $_POST['url']; } ?>" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="hover focus"
                       data-content="Enter the URL to be reviewed" style="width: 700px;">
            </div>
            <input type="submit" value="Go" class="btn btn-default">
        </form>
	<hr>
	<?php if (isset($_POST['url'])) { ?>
        <h2>Result for URL : <?php echo $_POST['url']; ?></h2>
	<?php echo $_POST['url']; } 
	
	?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">

$(function () {
    $('[data-toggle="popover"]').popover();
});

</script>
</body>
</html>