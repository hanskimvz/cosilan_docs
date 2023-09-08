<?PHP
include ("dbconnect.php");
/*
CREATE TABLE `help_docs` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255),
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regdate` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `tmp` enum('y','n') default 'y',
  PRIMARY KEY (`pk`)
);
*/

function getBody($fname){
    $arr = array('title'=>'', 'body'=>'');
    $fp = fopen($fname, 'r');
    
    $arr['body']= fread($fp, filesize($fname));
    
    $lines= explode("\n", $arr['body']);
    foreach($lines as $line) {
        $line = trim($line);
        if (substr($line,0,1) == '#') {
            $arr['title'] = trim(str_replace("#","",$line));
            break;
        }
    }

    fclose($fp);
    return $arr;
}

$sq = "update help_docs set tmp='n'";
$rs = mysqli_query($connect, $sq);

$dir    = './docs/';
$handle = opendir($dir);
while (false !== ($entry = readdir($handle))) {
    if ($entry == "." || $entry == ".." || is_dir($dir.$entry)) {
        continue;
    }
    $mtime = date("Y-m-d H:i:s", filemtime($dir.$entry) +3600*9);
    $sq = "select last_modified from help_docs where filename='".$entry."' ";
    $rs = mysqli_query($connect, $sq);
    if ($rs->num_rows) {
        $row = mysqli_fetch_row($rs);
        if ($row[0] == $mtime) {
            $sq = "update help_docs set  tmp='y' where filename='".$entry."' "; 
        }
        else {
            $arr = getBody($dir.$entry);
            $sq = "update help_docs set  title='".addslashes($arr['title'])."', body='".addslashes($arr['body'])."', last_modified='".$mtime."', tmp='y' where filename='".$entry."' "; 
            print "<br />".$entry."== modified";
        }
    }
    else {
        $arr = getBody($dir.$entry);
        $sq = "insert into help_docs(filename, title, body, regdate, last_modified, tmp) values('".$entry."', '".addslashes($arr['title'])."',  '".addslashes($arr['body'])."', now(), '".$mtime."', 'y')";
        print "<br />".$entry."== added";
    }
    // print $sq ."\n";
    $rs =  mysqli_query($connect, $sq);
    if ($rs) {
        print " : OK";
    }
    else {
        print $sq." : FAIL";
    }
}

closedir($handle);

$sq = "select pk, filename from help_docs where tmp='n'";
$rs = mysqli_query($connect, $sq);
while ($row = mysqli_fetch_row($rs)){
    $sq = "delete from help_docs where pk=".$row[0];
    print "<br />".$row[1]."==";
    if (mysqli_query($connect, $sq)) {
        print "deleted";
    }
    else {
        print "failed";

    }
}

// print_r($files1);
// foreach($files1 as $fn) {
//     print ($fn);
//     print "\n";

// }



?>