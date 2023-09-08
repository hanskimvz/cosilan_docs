<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">
	<link rel="shortcut icon" href="/favicon.ico">
	<title>BI help</title>
	<link rel="stylesheet" href="/css/app.css">
</head>
<?PHP

session_start();

$tableBody = "";
if (isset($_GET['file'])) {
	// include "view_markdown.php";
	print '	<style>
    h2{
        text-align: center;
        background: #EFEFEF;
        padding: 8px 6px;
    }
    table {border-collapse: collapse; border: 0; box-shadow: 1px 2px 3px #eee;}
    th {border: 1px solid #aaa; font-size: 100%; vertical-align: baseline; padding: 3px 6px;}
    td {border: 1px solid #aaa; font-size: 100%; vertical-align: baseline; padding: 3px 6px;}
	</style>';
    $fname = '/home/www/help_docs/docs/'.$_GET['file'];
    // print $fname;
	if (file_exists($fname)) {
		$ext = pathinfo($fname, PATHINFO_EXTENSION);
		print $ext;
		$body = file_get_contents($fname);
		$body = str_replace("images/", "docs/images/", $body);
		if ($ext == 'md') { // markdown
			require_once("./parsedown/Parsedown.php");
			$Parsedown = new Parsedown();
			$tableBody = $Parsedown->text($body);
		}
		else if ($ext == 'html' || $ext == 'htm'){
			$tableBody = $body;
		}
		else if ($ext == 'doc' || $ext == 'docs'){
			$tableBody = $body;
		}

	}
}

function simpleBodyText($str,$search){
	$str = strip_tags($str);
	$st = strpos($str, $search);
	if ($st) {
		$st =-10;
	}
	if ($st<0){
		$st = 0;
	}
	$ed = $st+500;
	return mb_substr($str, $st, $ed);
}

if(isset($_GET['search'])) {
	include ("dbconnect.php");
	// $sq = "select pk, code, title, body, regdate, last_modified, flag from document.paragraph where title like '%".trim($_GET['search'])."%' or body like '%".trim($_GET['search'])."%' ";
	$sq = "select filename, last_modified, title, body from help_docs where title like '%".trim($_GET['search'])."%' or body like '%".trim($_GET['search'])."%' ";
	// print $sq;
	$rs = mysqli_query($connect, $sq);
	while ($assoc = mysqli_fetch_assoc($rs)){
		$assoc['title'] = '<a href="help.php?file='.$assoc['filename'].'" target="view_doc">'.$assoc['title'].'</a>';
		$tableBody .= '<tr>
			<td><p>'.$assoc['title'].' ---- '.date("Y-m-d", strtotime($assoc['last_modified'])).'</br>
			'.simpleBodyText($assoc['body'], trim($_GET['search'])).'</p></td>
			</tr>';
	}
	if (!$tableBody){
		$tableBody = "No Record, Phlease Try Other Keywords!";
	}
	$tableBody = '<table class="table table-sm table-striped">
		<tbody>'.$tableBody.'</tbody></table>';
}

if (!$tableBody) {
	$tableBody = '<table class="table table-striped"><tbody>Try Keyword for Search</tbody></table>';

}

$json_body = file_get_contents("menu.json");
$menus = json_decode($json_body, True);

$sideMenu = '';
print "<pre>";
foreach($menus as $menu) {
    if (!$menu['active']) {
        continue;
    }
    // print_r ($menu);
	$sideMenu .= '<li class="sidebar-item">
		<a href="#'.$menu['name'].'" data-toggle="collapse" class="sidebar-link collapsed"><span class="align-middle">'.$menu['display'].'</span></a>
		<ul id="'.$menu['name'].'" class="sidebar-dropdown list-unstyled collapse">';

    foreach ($menu['contents'] as $submenu){
        if (!$submenu['active']) {
            continue;
        }
        $sideMenu .= '<li id="'.$submenu['name'].'" class="sidebar-item"><a class="sidebar-link" href="/help/help.php?file='.$submenu['filename'].'"><span class="align-middle">'.$submenu['display'].'</span></a></li>';
		if ($_GET['file'] == $submenu['filename']) {
			$name_tag = $submenu['name'];
		}

    }
	$sideMenu .='
		</ul>
	</li>';
}
print "</pre>";
$sideMenu = '<nav class="sidebar sidebar-sticky">
	<div class="sidebar-content ">
		<a class="sidebar-brand" href="/help/help.php"><span class="align-middle ml-2">HELP PAGE</span></a> 
		<ul class="sidebar-nav">'.$sideMenu.'</ul>
	</div>
</nav>';



$header = <<<EOBLCOK
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">
    <title id='title'>Help Page</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
EOBLCOK;

$searchForm = <<<EOBLOCK
<form method="GET" class="form-inline d-none d-sm-inline-block" ENCTYPE="multipart/form-data">
<input type="text" class="form-control form-control-no-border"  placeholder="Search" name="search" value="$_GET[search]" size="100">
<button type="submit" class="btn btn-warning" >查找</button>
</form>
EOBLOCK;

$contents_body = <<<EOBLOCK
<html lang="en">
$header
<body>
	<div class="wrapper">	
		<div class="main" id="main_page">
			<nav class="navbar sidebar-sticky navbar-expand navbar-light bg-white">
				<i class="hamburger align-self-center"></i>
				$searchForm				
			</nav>
			<main class="content">
				<div class="container-fluid p-0" >
					<div class="row">
					$tableBody
					</div>
				</div>
			</main>
		</div>
	</div>
</body>
<script src="/js/app.js"></script>
</html>
EOBLOCK;

?>

<body>
	<div class="wrapper">
		<?=$sideMenu?>
		<div class="main" id="main_page">
			<nav class="navbar sidebar-sticky navbar-expand navbar-light bg-white">
				<a class="sidebar-toggle d-flex mr-2"><i class="hamburger align-self-center"></i></a>
				<?=$searchForm ?>
			</nav>
			<main class="content">
				<div class="container-fluid p-0" >
					<?=$tableBody?>
				</div>
			</main>			
		</div>	
	</div>
</body>


<script src="/js/app.js"></script>
<script>
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        // vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


var a = '';
var b = '';	

a = document.getElementById("<?=$name_tag?>");
console.log(a);

if (a) {
	a.classList.add("active");
}

if (b) {
	b.classList.add("show");
}
</script>

</html>