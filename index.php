<?php
//error_reporting(E_ALL);//  打印所有报错
error_reporting(0);//关闭所以报错信息
ignore_user_abort(true); // 后台运行，不受前端断开连接影响
set_time_limit(3600); // 脚本最多运行1个小时
ob_end_clean();//清除之前的缓冲内容，这是必需的，如果之前的缓存不为空的话，里面可能有http头或者其它内容，导致后面的内容不能及时的输出

$url = "http://127.0.0.1:6800/jsonrpc"; //aria2服务器ip+端口

$str="https://vod.lyhuicheng.com/20241122/au5jls4w/index.m3u8";//本地m3u8 



$namedata="0";//是否开启调试模式   1 为取消调试模式，非1为开启调试模式

$urldir='';//补全ts文件url连接，不允许存在特殊字符串，可留空
$dir ='91porn/';//ts文件分一个目录


 $urldata= wpost($str);//发送curl请求
 $url1= dataurl($str);//正则出连接头部地址
 $url2= m3u8key($urldata); //完全匹配出key文件地址
 $url3= m3u8url($urldata);  //判断是否有镶嵌m3u8，如果有镶嵌直接输出m3u8地址

//根据日期创建文件夹目录等...
$Y=date("Y");//年

$m=date("m");//月

$d=date("d");//日
//根据url地址+md5生成目录及m3u8名称
$md5 =md5($str);


 
  $tsdir1= "/www/wwwroot/yourname/aria2/nfs/".$Y."/".$m."/".$d."/".$md5;//m3u8文件储存地址

//判断    没有镶嵌m3u8执行此处
if (!$url3) {
    
  $url2= m3u8key($urldata); //完全匹配出key文件地址
 
 
preg_match('/[a-zA-z]+:\/\/[^\s]*/', $url2, $matches22);//判断key是否带http连接

$keyqian= (explode("/",$url2));//切割第一个 / 前面的数据
//如果有连接直接输出key链接
if (!$matches22==false) {
    $newar2[]=$url2;
}

elseif ($keyqian[0]=='..') {
     $newar2[]=urlname($str,2).str_replace("../","",$url2);//数组名称
} 

elseif ($keyqian[0]=='.') {
    $newar2[]=urlname($str,1).str_replace("./","",$url2);//数组名称
}
elseif ($keyqian[0]==='0') {
   $newar2[]=$url1. $url2;
}
elseif (!$keyqian[0]==false) {
   $newar2[]=$url1. $url2;
}

elseif (!$keyqian[0]) {
    if (!$url2) {
        $newar2[]="";
    }else{
    $newar2[]=urlname($url1,99).$url2;
    }
}

/*if(!$url2==false){
if (!$matches22[0]) {
   $newar2[]= ($url1.$url2);//无连接头部拼接头部
}else {
    $newar2[]= ($url2);//有头部key输出地址
}
}*/
    //开始处理m3u8
    //------------------------------------------------------------------------//
    $str2= m3u8txt($urldata,$dir,$url1,$newar2,$urldir,$tsdir1) ;
    

    
}



//判断有镶嵌m3u8执行此处
if (!$url3==false) { 
$isMatched = preg_match('/[a-zA-z]+:\/\/[^\s]*/', $url3, $matches);

//判断镶嵌的m3u8是否有头部地址，没有头部片拼接出完整m3u8地址
if(!$matches[0]){
    ////////////////////////////////////////////////
$url31= (explode("/",$url3));//切割第一个 / 前面的数据

//这里为处理镶嵌m3u8头部链接信息
if ($url31[0]=='..') {
     $urldata1=wpost(urlname($url1,2).str_replace("../","",$url3));//数组名称
  //   echo urlname($url1,2).str_replace("../","",$url3);
 // echo $urldata1=( urlname($url1,2).str_replace("../","",$url3));//数组名称
} 

elseif ($url31[0]=='.') {
      $urldata1=wpost(urlname($url1,1).str_replace("./","",$url3));//数组名称
     // echo urlname($url1,1).str_replace("./","",$url3);
  // echo $urldata1=(urlname($url1,1).str_replace("./","",$url3));//数组名称
}

elseif (!$url31[0]==false) {
   $urldata1=wpost($url1. $url3);
   
  // echo $url1. $url3;
  //echo $urldata1=($url1.$url3);
}
elseif ($url31[0]==='0') {
   $urldata1=wpost($url1. $url3);
   
  // echo $url1. $url3;
  //echo $urldata1=($url1.$url3);
}

elseif (!$url31[0]) {
    if (!$url3) {
        $urldata1='';
    }else{
          $urldata1=wpost(urlname($url1,99).$url3);
          //判断镶嵌m3u8是否可以访问，不能访问直接输出域名
        /*    $urldata2=head200(urlname($url1,99).$url3);
        if ($urldata2=='200') {
              $urldata1=wpost(urlname($url1,99).$url3);
             // echo urlname($url1,99).$url3;
          }else{
              $urldata1=wpost(urlname($url1,1).$url3);
             //  echo urlname($url1,1).$url3;
              
          }
        */

    }
}

 //  $urldata1=wpost($url1.$url3) ;
  // $url4= dataurl($url1.$url3);//正则出连接头部地址
  
  //正则出连接头部地址
   $url41= (explode("/",$url3));//切割第一个 / 前面的数据

if ($url41[0]=='..') {
     $url4=dataurl(urlname($url1,2).str_replace("../","",$url3));//数组名称
  //   echo urlname($url1,2).str_replace("../","",$url3);
} 

elseif ($url41[0]=='.') {
      $url4=dataurl(urlname($url1,1).str_replace("./","",$url3));//数组名称
    //  echo urlname($url1,1).str_replace("./","",$url3);
}
elseif ($url41[0]==='0') {
       $url4=dataurl($url1. $url3);
    //  echo urlname($url1,1).str_replace("./","",$url3);
}
elseif (!$url41[0]==false) {
   $url4=dataurl($url1. $url3);
  // echo $url1. $url3;
   
}

elseif (!$url41[0]) {
    if (!$url3) {
        $url4='';
    }else{
          $url4=dataurl(urlname($url1,99).$url3);
         /* $url45=head200(urlname($url1,99).$url3);
          if ($url45=='200') {
              $url4=dataurl(urlname($url1,99).$url3);
          }else {
              $url4=dataurl(urlname($url1,1).$url3);
          }
          
        */

    }
}   
  // echo $url4;
   
    $url2= m3u8key($urldata1); //完全匹配出key文件地址
    preg_match('|[a-zA-z]+://[^\s]*|', $url2, $matches1);//正则出连接头部地址


$keyqian= (explode("/",$url2));//切割第一个 / 前面的数据
//如果有连接直接输出key链接
//这里为处理key
if (!$matches1[0]==false) {
    $newar2[]=$url2;
}

elseif ($keyqian[0]=='..') {
     $newar2[]=urlname($url4,2).str_replace("../","",$url2);//数组名称
} 

elseif ($keyqian[0]=='.') {
    $newar2[]=urlname($url4,1).str_replace("./","",$url2);//数组名称
}

elseif ($keyqian[0]==='0') {
    $newar2[]=$url4.$url2;
}

elseif (!$keyqian[0]==false) {
   $newar2[]=$url4.$url2;
}

elseif (!$keyqian[0]) {
    if (!$url2) {
        $newar2[]="";
    }else{
    $newar2[]=urlname($url4,99).$url2;
    }
}


/*if (!$matches1[0]) {
    
    $newar2[]=($url1.$url2);//无连接头部拼接头部

}else{
     $newar2[]=($key_url);//有头部地址直接输出

}
*/

     //开始处理m3u8
    //-----------------------------------------------------------//
     $str2=m3u8txt($urldata1,$dir,$url4,$newar2,$urldir,$tsdir1) ;





    
}



//判断镶嵌的m3u8是否有头部地址，有头部地址直接输出
if(!$matches[0]==false){ 
     $urldata2= wpost($url3);
     $url2= m3u8key($urldata2); //完全匹配出key文件地址
     $url1=dataurl($url3);//正则出连接头部地址

preg_match('|[a-zA-z]+://[^\s]*|', $url2, $matches2);
$keyqian= (explode("/",$url2));//切割第一个 / 前面的数据


//如果有连接直接输出key链接

if (!$matches22==false) {
    $newar2[]=$url2;
}

elseif ($keyqian[0]=='..') {
     $newar2[]=urlname($url1,2).str_replace("../","",$url2);//数组名称
} 

elseif ($keyqian[0]=='.') {
    $newar2[]=urlname($url1,1).str_replace("./","",$url4.$url2);//数组名称
}
elseif ($keyqian[0]==='0') {
    $newar2[]=$url1.$url2;
}
elseif (!$keyqian[0]==false) {
   $newar2[]=$url1.$url2;
}

elseif (!$keyqian[0]) {
    if (!$url2) {
        $newar2[]="";
    }else{
    $newar2[]=urlname($url1,99).$url2;
    }
}

/*
//如果有连接直接输出key链接
if (!$matches22==false) {
    $newar2[]=$url2;
}

elseif ($keyqian[0]=='..') {
     $newar2[]=urlname($str,2).str_replace("../","",$url2);//数组名称
} 

elseif ($keyqian[0]=='.') {
    $newar2[]=urlname($str,1).str_replace("./","",$url2);//数组名称
}

elseif (!$keyqian[0]==false) {
   $newar2[]=$url1. $url2;
}

elseif (!$keyqian[0]) {
    if (!$url2) {
        $newar2[]="";
    }else{
    $newar2[]=urlname($url1,3).$url2;
    }
}*/

/*
if (!$matches2[0]) {
    $newar2[]= dataurl ($url3).$url2  ;//无连接头部拼接头部
     
}else{
    $newar2[]=($key_url) ;//有头部地址直接输出
}
*/
     //开始处理m3u8
    //-----------------------------------------------------------------------------------------//
  $str2= m3u8txt($urldata2,$dir,$url1,$newar2,$urldir,$tsdir1) ;




    
}
}

/*
m3u8为   data   数据(原始ts数据)

m3u81为  data1  数据(保存文件m3u8数据)

key1 为  key    数据(ts文件key数据)
*/
$str1=json_decode($str2,true);

//data ts数据
foreach ($str1['data'] as $key){
   $m3u8[]= ($key."\r\n" );
    //将ts文件转换为数组
    //$key1 = substr($key, 0, strrpos($key, ".ts")).".ts";
    //判断ts文件如果存在#EXT-X-KEY将过滤掉
    if(strstr($key,'#EXT-X-KEY:')==true){
    echo "";
}else {
    $ts_url_json.= Add_to_Json($key,$tsdir1."/".$dir);//将ts文件转换为数组
};
   
};
////////////////////////////////////////////////////////////////////


//data1 原始数据
foreach ($str1['data1'] as $key){
    //判断文件是否存在多余字符
    $str2= (explode("?",$key)); //以 / 切割为数组   
    if (!$str2[1]==false) {
        if(strstr($key,'#EXT-X-KEY:')){
         $get_key = explode('"',$key);//完全匹配key文件地址
         $key_url = $get_key[1];//打印出匹配的key文件地址 
        $str2= (explode("?",$key_url)); //以 / 切割为数组   
          $m3u81[]= str_replace("?".$str2[1],"",$key)."\r\n";
        }
        else{
             $m3u81[]= str_replace("?".$str2[1],"",$key)."\r\n";
        }
    }else{
        $m3u81[]= ($key."\r\n" );
    }

// $m3u81[]= ($key."\r\n" );
};
////////////////////////////////////////////////////////////////////



//key  key文件数据
$key1 = $str1['key']['0'];

//echo json_encode($str1) ;//打印全部数据json

 $ts_json= "[". substr($ts_url_json, 0, -1)."]";//删除尾部一位字符，加括号转为json数据
 
    // echo  postCurl($url,$ts_json); //发送数据到Aria2
    
    
    //判断是否开启调试模式
if ($namedata=='1') {
    //判断m3u8文件是否存在，不存在就下载保存，有文件就结束运行
if (!file_exists($tsdir1."/index.m3u8")) {
    // 文件不存在开始下载并保存m3u8文件。
     
   if(!dir_exists($tsdir1)){//判断目录文件是否存在
       mkdir($tsdir1,0777,true);//不存在就创建目录
         }
    //有key的先判断key可用性，可用开始发送到aria2进行下载。不可用判断ts文件状态码
    if (!$key1==false) {
    if(head200($key1)=="200"){
        //先下载key文件
       $keydir=wpost($key1);//请求key文件
       $path_parts = pathinfo($key1);//获取key文件名称
     //  $path_parts['basename']; // prints "file.txt"
     $index = strpos($path_parts['basename'],"?");//查询key名称是否带
    $res = substr($path_parts['basename'],0,$index);//将查询的字符串传入切割
     if (!dir_exists($tsdir1."/".$dir)) {
        mkdir($tsdir1."/".$dir,0777,true);//不存在就创建目录
    if (!$res==false) {//如果存在多余字符 ? ，过滤后保存下载
          if(strstr($path_parts['basename'],'.key')==false){//查询key后缀不等于key，保存到md5目录
       file_put_contents($tsdir1."/".$res, $keydir);//保存key文件为本地
        }else {
      //否者保存保存到ts目录
       file_put_contents($tsdir."/".$dir.$res, $keydir);//保存key文件为本地
}
     }else {//不存在 ? 字符 就直接执行下面操作
                   if(strstr($path_parts['basename'],'.key')==false){//查询key后缀不等于key，保存到md5目录
       file_put_contents($tsdir1."/".$path_parts['basename'], $keydir);//保存key文件为本地
        }else {
      //否者保存保存到ts目录
       file_put_contents($tsdir1."/".$dir.$path_parts['basename'], $keydir);//保存key文件为本地
}
     }

;
       
     }
      
       //保存key1文件
      //  这里开始发送到aria2
      echo '发送curl请求';
      file_put_contents("$tsdir1"."/"."index.m3u8", $m3u81);    //保存处理的m3u8文件
      echo "<hr>"."m3u8地址：$$$tsdir1"."/"."index.m3u8$$<hr>";
        postCurl($url,$ts_json); //发送数据到Aria2
    }else{//key值不等于200，结束运行
        echo'key值状态码判断失败，可能网址解析拼接出错。结束运行。';
        exit();
    }

}
//如果没有key值，打印一个ts文件进行判断状态码。
    if (!$key1) {//没有key
   if (!$m3u8[0]==false) {
       if (head200($str1["data"]["1"])=="200") {
        echo '没有key，但是ts文件可以访问。开始直接下载ts文件<hr>';
        file_put_contents("$tsdir1"."/"."index.m3u8", $m3u81);    //保存处理的m3u8文件
        echo "<hr>"."m3u8地址：$$$tsdir1"."/"."index.m3u8$$<hr>";
          postCurl($url,$ts_json); //发送数据到Aria2
       }else{
           echo "key值为空，并且ts状态码也判断失败，结束运行";
           exit();
       }
   }
}
  
}
//如果存在就跳出任务
else  {
   echo '文件存在结束运行<hr>';
   echo "m3u8文件地址 : $$$tsdir1"."/index.m3u8$$";
   exit();
}
}else{
    echo json_encode($str1) ;//打印全部数据json
    
}





//函数判断是否有镶嵌m3u8
function m3u8url($str){
 if (strpos($str,'.m3u8')) {
      
  preg_match('/[^\s]*m3u8/', $str, $matches);//匹配镶嵌m3u8
  
  // preg_match('/\/\/[^\s]*/', $str, $matches);//匹配镶嵌m3u8是否有头部
   if (!$matches[0]==false) {//判断m3u8匹配是否失败
       // code...
         preg_match('/[a-zA-z]+:\/\/[^\s]*/', $matches[0], $matches1);//匹配镶嵌http信息
         if (!$matches1[0]) {
            preg_match('/\/\/[^\s]*/', $matches[0], $matches2);//匹配镶嵌http信息
            if (!$matches2[0]==false) {
                return $url='http:'.$matches[0];
            }else {
               return $url=$matches[0];
            }

           // return $url='http:'.$matches[0];
         }
         if (!$matches1[0]==false) {
             return $matches1[0];
         }
   }else {
       return '镶嵌m3u8匹配失败!';
   }

/* if (!$matches[0]==false) {
      return $url=$matches[0];
  }*/

   
  
} 
};

//函数完全匹配出key文件地址
//函数完全匹配出key文件地址
function m3u8key($str){
        //完全匹配出key文件地址
 preg_match("/\n#EXT-X-KEY:[^\n]*/",$str,$result);//正则出key文件
if (!$result[0]==false) {
    $get_key = explode('"',$result[0]);//完全匹配key文件地址
    $key_url = $get_key[1];//打印出匹配的key文件地址
preg_match("/[a-zA-z]+:\/\/[^\s]*/",$key_url,$result2);//匹配key是否有http头部地址


//如果key存在连接直接输出
if (!$result2[0]==false) {
    return $result2[0];//如果key存在连接直接输出
}
//如果key有连接但是无头部，添加http输出
if (!$result2[0]) {
    preg_match("/\/\/[^\s]*/",$key_url,$result3);//匹配key是否有http头部地址
    if (!$result3[0]) {
       if (!$key_url==false) {
           return $key_url;
       }
    }
    if (!$result3[0]==false) {
       return "http:".$key_url; //如果key有连接但是无头部，添加http输出
    }
}
};
};

//函数正则出 m3u8头部链接
function dataurl($str){
    //正则出 m3u8头部链接
    //正则出 m3u8头部链接
        $str2= (explode("?",$str)); //以 / 切割为数组  
        if (!$str2[1]==false) {
            $isMatched = preg_match('/[^\s]*\//', $str2[0], $matches);
 return($url1= $matches[0]);
        }else {
            $isMatched = preg_match('/[^\s]*\//', $str, $matches);
 return($url1= $matches[0]);
        }
};
//函数获取远程文件的文件名称
function namekey($str){
$path_parts = pathinfo($str);
return $path_parts['basename']; // prints "file.txt"
}
//函数将m3u8分割成两组数据json
// str 为传入的m3u8文件数据，dir为保存的路径需要自己设置，name为ts文件的原始连接，$namekey为key原始地址没地址拼接出
function m3u8txt($str,$dir,$name,$namekey,$urldir,$tsdir1){
    if (!$urldir) {
        $urldir="";
    }if(!$urldir===false){
        $urldir=$urldir;
    }
$realUrlArr = preg_split("/[\r\n]+/s", $str);    //以换行切割成字符串数组
   foreach ($realUrlArr as $key => &$value) {

    //下面为匹配出的全部ts文件连接地址
   /////////////////////////////////////////////////////////  
  if(strpos($value,".ts")){//判断内容是否存在ts文件，有ts文件打印出数组形式
         $isMatched = preg_match('/[a-zA-z]+:\/\/[^\s]*/', $value, $matches); //正则ts是否带连接
   //$key_url1=strstr($value,'/');    //判断key是否存在多余字符
   if(!$matches[0]){ //判断ts文件是否有http连接
   ////////////////////////////////////////////////////////////
    $keyqian= (explode("/",$value));//切割第一个 / 前面的数据
//如果有连接直接输出key链接
if (!$matches[0]==false) {
    $newar[]=$value;
}

elseif ($keyqian[0]=='..') {
     $newar[]=urlname($name,2).str_replace("../","",$value);//数组名称
} 

elseif ($keyqian[0]=='.') {
    $newar[]=urlname($name,1).str_replace('./','',$value);//数组名称
     
}
elseif ($keyqian[0]==='0') {
    $newar[]=$name.$value;
     
}
elseif (!$keyqian[0]==false) {
   $newar[]=$name.$value;
}

elseif (!$keyqian[0]) {
    if (!$value) {
       $newar[]="";
    }else{
    $newar[]=(urlname($name,99).$value);
    //$newar[]=urlname($name,2);
    }
}
}else {
       
       $newar[]=$value; //有连接直接输出
       
   }
   }
   //下面为打印出m3u8文件格式全部数据
   /////////////////////////////////////////////////////////  
if (strpos($value,".ts")) {
       $key_url1=strstr($value,'/');    //判断key是否存在多余字符
   if(!$key_url1==false){
   $result = substr($value,strripos($value,"/")+1);
     $newar1[]=$urldir.$dir.$result;//有 “/”符号 切割以后添加域名
   }
   if (!$key_url1) {
   if(strstr($value,'#EXT-X-KEY:')==true){
    $newar1[]=$value;
}else {
    $newar1[]=$urldir.$dir.$value;//没有“/”符号直接添加域名
}
;
       
   }
}      //下面处理key文库路径
   ////////////////////////////////////////////////////////
elseif (strpos($value,'.key')) {
     $get_key = explode('"',$value);//完全匹配key文件地址

    $key_url = $get_key[1];//打印出匹配的key文件地址

   $key_url1=strstr($key_url,'/');    //判断key是否存在多余字符
if(!$key_url1==false){
	   $result = substr($key_url,strripos($key_url,"/")+1);
	 $result;
}
if(!$key_url1){
	 $key_url;
}
if(!$result){
	$result=$key_url;
}elseif(!$result==false){
	$result;
}
$newar1[]=$get_key[0].'"'.$dir.$result.'"'.$get_key[2];
  }
else {
    $newar1[]=$value;//不是ts数据直接打印
}


     
}//循环尾

    


return $m3u8txt= json_encode($newar= ['data'=>$newar,'data1'=>$newar1,'key'=>$namekey,'tsdir'=>$tsdir1."/".$dir,'msg'=>'数据获取成功']);//以json方式打印采集数据





}
//获取网页状态码
function head200($str){
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $str); //设置URL
//curl_setopt($curl, CURLOPT_REFERER, 'https://www.baidu.com');//模拟来路
curl_setopt($curl, CURLOPT_HEADER, 1); //获取Header
curl_setopt($curl,CURLOPT_NOBODY,true); //Body就不要了吧，我们只是需要Head
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //数据存到成字符串吧，别给我直接输出到屏幕了
curl_setopt($curl, CURLOPT_TIMEOUT,15);//设置请求超时20秒
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);// 跳过证书检查
curl_exec($curl); //开始执行啦～
$httpcode=curl_getinfo($curl,CURLINFO_HTTP_CODE); //我知道HTTPSTAT码哦～
curl_close($curl); //用完记得关掉他
return($httpcode);
}

//函数根据key切割url；
function urlname($str99,$id){
$str=(parse_url($str99)); //分割url、
$str1=$str['path'];//urlpath部分
($str1= (explode("/",$str1))); //以 / 切割为数组

 json_encode(($str2=Array_filter($str1)));//去除数值为空的数据

 ( $n1=count($str1,0));//不计较多维数组，只取最外层数组下一层的长度,结果为2

if ($id=='99') {
    if(!$str['port']==false){
         return  $str["scheme"]."://".$str['host'].":".$str['port'];
    }else{
        return  $str["scheme"]."://".$str['host'];
    }
   
}else {
   $n1= $n1-$id ;
for ($i = 0; $i< $n1; $i++) {
   $data.= $str1[$i]."/";

}
if (!$str['port']==false) {
    return  $str["scheme"]."://".$str['host'].":".$str['port'].$data;
}else {
     return  $str["scheme"]."://".$str['host']. $data;
}
// return  $str["scheme"]."://".$str['host']. $data;
}

};

//发送aria2请求    
function postCurl($url,$data){
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_URL,$url);
      curl_setopt($curl,CURLOPT_POST,1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
      if(!empty($data)){
      curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
      }

      curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
      //curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
      $res = curl_exec($curl);
      if(curl_errno($curl)){
          echo 'Error+'.curl_error($curl);
      }
      curl_close($curl);
      return $res;
    }
//把ts地址拼接进aria2的jsonrpc支持的格式
function Add_to_Json($tsurl,$dir){
        $json_str = '
        {
            "jsonrpc": "2.0", 
            "id": 1.0,
            "method": "aria2.addUri",
            "params":[
                "token:b28fcbf42a17c233f18a",
                ["'.$tsurl.'"],
                {"dir":"'.$dir.'"}
            ]
        },';
			return $json_str;
    };   
//判断目录是否存在存在输出1不存在空白
function dir_exists($path){
  //判断目录是否存在
  if(is_dir($path)){
    return true;
  }else{
    return false;
  }
}

 //自定义curl函数
function wpost($url){
    $agentarry=[
    //PC端的UserAgent
    "safari 5.1 – MAC"=>"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
    "safari 5.1 – Windows"=>"Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
    "Firefox 38esr"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
    "IE 11"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
    "IE 9.0"=>"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
    "IE 8.0"=>"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
    "IE 7.0"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
    "IE 6.0"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
    "Firefox 4.0.1 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
    "Firefox 4.0.1 – Windows"=>"Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
    "Opera 11.11 – MAC"=>"Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
    "Opera 11.11 – Windows"=>"Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
    "Chrome 17.0 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
    "傲游（Maxthon）"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
    "腾讯TT"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
    "世界之窗（The World） 2.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
    "世界之窗（The World） 3.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
    "360浏览器"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
    "搜狗浏览器 1.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
    "Avant"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
    "Green Browser"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
    //移动端口
    "safari iOS 4.33 – iPhone"=>"Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
    "safari iOS 4.33 – iPod Touch"=>"Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
    "safari iOS 4.33 – iPad"=>"Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
    "Android N1"=>"Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
    "Android QQ浏览器 For android"=>"MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
    "Android Opera Mobile"=>"Opera/9.80 (Android 2.3.4; Linux; Opera Mobi/build-1107180945; U; en-GB) Presto/2.8.149 Version/11.10",
    "Android Pad Moto Xoom"=>"Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13",
    "BlackBerry"=>"Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+",
    "WebOS HP Touchpad"=>"Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0",
    "UC标准"=>"NOKIA5700/ UCWEB7.0.2.37/28/999",
    "UCOpenwave"=>"Openwave/ UCWEB7.0.2.37/28/999",
    "UC Opera"=>"Mozilla/4.0 (compatible; MSIE 6.0; ) Opera/UCWEB7.0.2.37/28/999",
   // ""=>"",
 
];
//$useragent="Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11";  //要得到类似这样useranget 可以自定义
$useragent=$agentarry[array_rand($agentarry,1)];  //随机浏览器useragent
$ip = rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255) ; // 伪造随机ip
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array("Accept-Language:zh-CN,zh;q=0.8",)); //构造浏览器语言
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip.'','CLIENT-IP:'.$ip.'','Accept-Language:zh-CN,zh;q=0.8')); //构造IP 
    curl_setopt($ch, CURLOPT_USERAGENT, "$useragent"); //构造浏览器信息
    curl_setopt($ch, CURLOPT_REFERER,"https://www.google.com/search");   //构造来路
    curl_setopt($ch, CURLOPT_TIMEOUT,20);//设置请求超时20秒
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 打印  302跳转网站
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);// 跳过证书检查
   // curl_setopt($ch, CURLOPT_POST, 1);
    $html= curl_exec($ch);
    curl_error($ch);
    curl_close($ch);
    return $html;

  };



  
