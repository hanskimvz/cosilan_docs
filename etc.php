<?PHP
include ("dbconnect.php");

$sq = "select * from help_docs";
$rs = mysqli_query($connect, $sq);
$arr_rs = array(
    "cosilan"=>array(
        "name"=>"cosilan",
        "display" =>"Cosilan(平台软件)",
        "active" =>1,
        "contents"=>array()
    ), 
    "vca"=>array(
        "name"=>"vca", 
        "display" =>"VCA(智能分析)",
        "active" =>1,
        "contents"=>array()
    ),
    "support"=>array(
        "name"=>"support", 
        "display" =>"技术支持",
        "active" =>1,
        "contents"=>array()
    ), 
    "product"=>array(
        "name"=>"product", 
        "display" =>"产品",
        "active" =>1,
        "contents"=>array()
    ),     
);
while ($assoc = mysqli_fetch_assoc($rs)){
    $fname = strtolower($assoc['filename']);
    if (!strncmp($fname,'cosilan', strlen("cosilan"))) {
        $class= "cosilan";
    }
    else if (!strncmp($fname,'ts_',3)) {
        $class= "support";
    }
    else if (!strncmp($fname,'vca',3)) {
        $class= "vca";
    }
    else if (!strncmp($fname,'product',7)) {
        $class= "product";
    }
    else {
        continue;
    }    
    array_push($arr_rs[$class]["contents"], 
        array(
            "name"=>"",
            "display" =>$assoc['title'],
            "filename"=>$assoc['filename'], 
            "active" => 1,
        )
    );
}
$jsonstr = json_encode($arr_rs, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
print_r($jsonstr);

?>