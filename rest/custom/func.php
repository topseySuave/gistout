<?php //session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 3/7/2017
 * Time: 4:47 PM
 */

//function __autoload($class)
//{
//    require_once '/../classes/'.$class.'.php';
//}
//
//spl_autoload_register('__autoLoad');

function userBonus(){
    return $userBonus = array(
        "like" => 1,
        "share" => 2,
        "report" => 1,
        "follow" => 1,
        "create quote" => 1,
        "create post" => 2,
        "create gist" => 3,
        "register" => 5,
        "online" => 1,
        "win trophy" => 20
    );
}

$badeColor = array(
    "#C1C0C6",
    "",
    "#CD8032",
    "#BEBEBE",
    "#CC9900",
    "",
    "",
    ""
);

$arr = array(
    "Aluminum",
    "Topaz",
    "Bronze",
    "Silver",
    "Gold",
    "Platinum",
    "Diamond",
    "Adamantium"
);

$badgeImgArr = array(
    '<img src="" alt="badge-'.$arr[0].'" />',
    '<img src="" alt="badge-'.$arr[1].'" />',
    '<img src="" alt="badge-'.$arr[2].'" />',
    '<img src="" alt="badge-'.$arr[3].'" />',
    '<img src="" alt="badge-'.$arr[4].'" />',
    '<img src="" alt="badge-'.$arr[5].'" />',
    '<img src="" alt="badge-'.$arr[6].'" />',
    '<img src="" alt="badge-'.$arr[7].'" />'
);

function badgesArray($point){
    $badge = '';
    if($point <= 10){
        $badge = "Aluminum";
    }elseif($point >= 100 && $point < 500){
        $badge = "Topaz";
    }elseif($point >= 500 && $point < 1000){
        $badge = "Bronze";
    }elseif($point >= 1000 && $point < 2000){
        $badge = "Silver";
    }elseif($point >= 2000 && $point < 5000){
        $badge = "Gold";
    }elseif($point >= 5000 && $point < 10000){
        $badge = "Platinum";
    }elseif($point >= 10000 && $point < 50000){
        $badge = "Diamond";
    }elseif($point >= 50000){
        $badge = "Adamantium";
    }
    return $badge;
}

function getStarProgress($points){
    $prog = [];
    if($points > 5 && $points < 10){
        $prog['stars_count'] = 0.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 7.5;
    }elseif($points >= 11 && $points < 50){
        $prog['stars_count'] = 1;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 7;
    }elseif($points >= 51 && $points < 100){
        $prog['stars_count'] = 1.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 6.5;
    }elseif($points >= 101 && $points < 250){
        $prog['stars_count'] = 2;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 6;
    }elseif($points >= 251 && $points < 500){
        $prog['stars_count'] = 2.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 5.5;
    }elseif($points >= 501 && $points < 750){
        $prog['stars_count'] = 3;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 5;
    }elseif($points >= 751 && $points < 1000){
        $prog['stars_count'] = 3.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 4.5;
    }elseif($points >= 1001 && $points < 1500){
        $prog['stars_count'] = 4;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 4;
    }elseif($points >= 1501 && $points < 2000){
        $prog['stars_count'] = 4.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 3.5;
    }elseif($points >= 2001 && $points < 3500){
        $prog['stars_count'] = 5;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 3;
    }elseif($points >= 3501 && $points < 5000){
        $prog['stars_count'] = 5.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 2.5;
    }elseif($points >= 5000 && $points < 7500){
        $prog['stars_count'] = 6;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 2;
    }elseif($points >= 7501 && $points < 10000){
        $prog['stars_count'] = 6.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 1.5;
    }elseif($points >= 10001 && $points < 30000){
        $prog['stars_count'] = 7;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 1;
    }elseif($points >= 30001 && $points < 50000){
        $prog['stars_count'] = 7.5;
        $prog['stars_fill'] = 'star_half';
        $prog['stars_remaining'] = 0.5;
    }elseif($points > 50000){
        $prog['stars_count'] = 8;
        $prog['stars_fill'] = 'star';
        $prog['stars_remaining'] = 0;
    }
    return $prog;
}

function getBadge($badge){
    global $badgeArr;
    global $arr;
    for($i = 0;$i < count($badgeArr); $i++){
        if($badge === $arr[$i]){
            return $badgeArr[$i];
        }
    }
}

function ageCalculator($date)
{
    //full age calulator
    $bday = new DateTime($date);//dd.mm.yyyy
    $today = new DateTime(); // Current date
    $diff = $today->diff($bday);
    printf('%d years, %d month, %d days', $diff->y, $diff->m, $diff->d);
}

function age($birthday){
//    $year_diff = explode('-', $birthday);
    list($year, $month, $day) = explode("-", $birthday);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 && $month_diff==0){$year_diff--;}
    if ($day_diff < 0 && $month_diff < 0){$year_diff--;}
    return $year_diff;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function appendMaterialBoxImgContent($content, $path){
    return $content . '<div class="_2imgprvwhldr"><img class="materialboxed" src="'.$path.'"></div>';
}

function sanitizeContent($c){
    return htmlspecialchars_decode(stripslashes(convertHashTag(convertMentions(nl2br(link_it($c))))));
}

function misc(){
    require_once '../classes/Session.php';
    $s = new Session();
    $salt = 'gIsTDa4CkouT';
    $token = sha1($salt . sha1($_SESSION['id'] . $salt));
    $key = sha1(uniqid(rand()));
    $expire = time() + 60 * 60 * 24 * 30 * 12;
    setcookie('_gist', "$token:$key", $expire);
    //Insert the session data to the user table for auto login access
    $addSession = $s->addNew($_SESSION['id'], $key, $token, $expire);
    return $addSession;
}

function checkCookie()
{
    if(isset($_COOKIE['_gist']) && $_COOKIE['_gist'] === true && !isset($_SESSION['signed_in']) && $_SESSION['signed_in'] !== true){
        redirect('autologin');
    }
}

function redirect($location){
    header('location:/'.$location);
}

function keywords($str){
    $arr =  explode(' ', $str);
    $keywArr = array();
    //print all the value which are in the array
    foreach($arr as $v){
        print $v.', ';
    }
    print 'gistout, discuss, international, forum, naija, nigeria';
}

function randColor()
{
    $color = array('brown', 'burlywood', 'cornflowerblue', 'cadetblue', 'chocolate', 'darkseagreen', 'dimgrey', 'peru', 'sienna');
    $length_of_color = sizeof($color) - 1;
    $rand = rand(0, $length_of_color);
    return $color[$rand];
}

function randomString($length)
{
    $allChar = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $allChar = str_shuffle($allChar);
    $randomKey = substr($allChar,0,$length);
    return $randomKey;
}

function randomKey()
{
    $rand = rand(1000000, 99999999);
    $rand = str_replace('-', '', $rand);
    return $rand;
}

function hashPassword($pass)
{
    $user_input =  '12+gIsTD4kOuT#æ345';
//    $pass = urlencode($pass);
//    $pass_crypt = crypt($pass);
    $hashedPass = md5(sha1(md5($pass)));
    $pass_crypt = crypt($hashedPass, $user_input);
    return $pass_crypt;
}

function hashString($str)
{
    $salt =  '12+gIsTD4kOuT#æ345';
    $hash = sha1(md5(sha1(crypt($str.time(), $salt))));
    return $hash;
}

function convertHashTag($str)
{
    $regex = "/#+([a-zA-Z0-9_]+)/";
    $str = preg_replace($regex, '<a style="color: cornflowerblue !important;" href="tag/$1">$0</a>', $str);
//    print $1;
    return ($str);
}

function convertMentions($str)
{
    $regex = "/@+([a-zA-Z0-9_]+)/";
    $str = preg_replace($regex, '<a style="color: cornflowerblue !important;" href="profile/$1">$0</a>', $str);
    return ($str);
}

function mention($str)
{
    $men = "@";
    $arr = explode(" ", $str);
    $arrc = count($arr);
    $i = 0;
    while($i < $arrc){
        if(substr($arr[$i], 0, 1) === $men){
            $par = $arr[$i];
        }
        $i++;
    }
    if(!empty($par))
        return true;
    else
        return false;
}

function processMention($recevr, $sender, $gistid, $postId, $type, $specs){
    require_once '/rest/classes/notification.php';
    $noti = new Notification();
    $addNoti = $noti->addNew($recevr, $sender, $gistid, $postId, $type, $specs);
    if($addNoti)
        return true;
    else
        return false;
}

function hashTag($str, $postID, $specs)
{
    $htag = "#";
    $arr = explode(" ", $str);
    $arrc = count($arr);
    $i = 0;
    while($i < $arrc){
        if(substr($arr[$i], 0, 1) === $htag)
        {
            $par = $arr[$i];
            $par = preg_replace("#[^0-9a-z_]#i", "", $par);
            //$arr[$i] = "<a class='blue' href='tag?gtag=$par'>".$arr[$i]."</a>";
            $processedTag = processHashTag($par, $postID, $specs);
        }
        $i++;
    }
    $str = implode(" ", $arr);
    return $str;
}


function processHashTag($tag, $postID, $specs)
{
    require_once '/rest/classes/trending-hashtag.php';
    require_once '/rest/classes/hashtag-posts.php';

    $trendingHashTag = new TrendingHashtags();
    $hashTagPost = new HashtagPosts();

    //trending hashtag check for exitance...
    $hashTagcheck = json_decode($trendingHashTag->getByhashtag($tag));
    if(sizeof($hashTagcheck->trending_hashtag) > 0):
        $addedPreviousCount = $hashTagcheck->trending_hashtag[0]->recent_count + 1;
        $updateByRecentCount = $trendingHashTag->updateByRecentCount($hashTagcheck->trending_hashtag[0]->id, $addedPreviousCount);
        $hashtagId = $hashTagcheck->trending_hashtag[0]->id;
    else:
        $addNewTrending = $trendingHashTag->addNew($tag);
        $hashtagId = $addNewTrending;
    endif;

    $addhashTagPost = $hashTagPost->addNew($hashtagId, $postID, $specs);
    if($addhashTagPost == true):
        return true;
    else:
        return false;
    endif;
}

function link_it($text)
{
    $text= preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a id='linkify".randomString(8)."' style='color: cornflowerblue !important;' href=\"$3\" target=\"_blank\">$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([\w]*?)((www)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a id='linkify".randomString(8)."' style='color: cornflowerblue !important;' href=\"http://$3\" target=\"_blank\">$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a id='linkify".randomString(8)."' style='color: cornflowerblue !important;' href=\"ftp://$3\" target=\"_blank\">$3</a>", $text);
    $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a id='linkify".randomString(8)."' style='color: cornflowerblue !important;' href=\"mailto:$2@$3\" target=\"_blank\">$2@$3</a>", $text);
    return($text);
}

function autolink($str, $attributes = array()) {
    $str = str_replace("http://www","www",$str);
    $str = str_replace("https://www","www",$str);

    $attrs = '';
    foreach ($attributes as $attribute => $value) {
        $attrs .= " {$attribute}=\"{$value}\"";
    }
    $str = ' ' . $str;
    $str = preg_replace('`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i','$1<a id="linkify'.randomString(8).'" style="color: cornflowerblue !important;" href="$2"'.$attrs.' target="_blank">$2</a>',$str);
    $str = preg_replace('`([^"=\'>])((www).[^\s<]+[^\s<\.)])`i','$1<a id="linkify'.randomString(8).'" style="color: cornflowerblue !important;" href="http://$2"'.$attrs.' target="_blank">$2</a>',$str);
    $str = substr($str, 1);
    return $str;
}

function auto_link_twitter ($text)
{
    // properly formatted URLs
    $urls = "/(((http[s]?:\/\/)|(www\.))?(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
    $text = preg_replace($urls, " <a href='$1'>$1</a>", $text);

    // URLs without protocols
    $text = preg_replace("/href=\"www/", "href=\"http://www", $text);

    // Twitter usernames
    $twitter = "/@([A-Za-z0-9_]+)/is";
    $text = preg_replace ($twitter, " <a href='http://twitter.com/$1'>@$1</a>", $text);

    // Twitter hashtags
    $hashtag = "/#([A-Aa-z0-9_-]+)/is";
    $text = preg_replace ($hashtag, " <a href='http://hashtags.org/$1'>#$1</a>", $text);
    return $text;
}

function countFormat($n, $point='.', $sep=',') {
    if ($n < 0) {
        return 0;
    }
    if ($n < 10000) {
        return number_format($n, 0, $point, $sep);
    }
    $d = $n < 1000000 ? 1000 : 1000000;
    $f = round($n / $d, 1);
    return number_format($f, $f - intval($f) ? 1 : 0, $point, $sep) . ($d == 1000 ? 'k' : 'M');
}

//function time_ago($tm,$rcs = 0)
//{
//    $cur_tm = time();
//    $dif = $cur_tm-$tm;
//    $pds = array('second','minute','hour','day','week','month','year','decade');
//    $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
//    for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
//
//    $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
//    if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
//    return $x;
//}

function timeago($date) {
    $timestamp = strtotime($date);
    $strTime = array("sec", "min", "hr", "day", "mon", "y");
    $length = array("60","60","24","30","12","10");
    $currentTime = time();
    if($currentTime >= $timestamp) {
        $diff = time() - $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        if($diff >= 2){
            return $diff . " " . $strTime[$i] . "s ago ";
        }else{
            return $diff . " " . $strTime[$i] . " ago ";
        }
    }
}

function thumbUpImgIcon(){
    return 'docs/img/thumb-up.png';
}

function viewImgIcon(){
    return 'docs/img/png/1f441.png';
}

function postImgIcon(){
    return 'docs/img/png/1f4c4.png';
}

function ago($time)
{
    $time = strtotime($time);

    $periods = array("s", "m", "h", "d", "w", "mon", "y", "dec");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();

    $difference = $now - $time;
    $tense = "ago";

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j] .= "";
    }
    if ("$difference $periods[$j]" == '1 s' || "$difference $periods[$j]" == '0 s') {
        return "just now";
    } else {

    }
}

function compress($source_url, $destination_url, $quality)
{
    $info = getimagesize($source_url);
    $image = null;
    if($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);
    elseif($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source_url);
    elseif($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);

    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}

function randomImage($num)
{
    $dir = 'images/user_images/';
    // Open a directory, and read its contents
    $img_file = $dir.$num.'.jpg';
    return $img_file;
}

function defaultImage($name = '')
{
    $randomAvatarUrl = 'https://api.adorable.io/avatars/';
    $pixel = '450/';
    $img_file = $name . '@adorable.png';
    $randomAvatar = $randomAvatarUrl . $pixel . $img_file;
//    $num = rand(1, 6);
//    $img = 'docs/img/avatar/img'.$num.'.jpg';
//    $arr = array($img_file, $img);
//    $rand_img = rand(0, 1);
    return $randomAvatar;
}

function watermark_image($oldimage_name, $new_image_name, $thumb_path)
{
    list($owidth,$oheight) = getimagesize($oldimage_name);
    $scale_ratio = 2;
    if($owidth > 600)
    {
        $width = $owidth / $scale_ratio;
        $height = $oheight / $scale_ratio;
    }
    elseif($owidth < 100)
    {
        $width = $owidth * $scale_ratio;
        $height = $oheight * $scale_ratio;
    }
    else
    {
        $width = $owidth;
        $height = $oheight;
    }

    $im = imagecreatetruecolor($width, $height);
    $img_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
    $watermark = imagecreatefrompng($thumb_path);
    list($w_width, $w_height) = getimagesize($thumb_path);
    $pos_x = $width - $w_width;
    $pos_y = $height - $w_height;
    imagecopy($im, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
    imagejpeg($im, $new_image_name, 100);
    imagedestroy($im);
    unlink($oldimage_name);
    return true;
}

function img_resize($target, $newcopy, $ext)
{
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = 3;
    if($w_orig > 600)
    {
        $w = $w_orig / $scale_ratio;
        $h = $h_orig / $scale_ratio;
    }
    elseif($w_orig < 100)
    {
        $w = $w_orig * $scale_ratio;
        $h = $h_orig * $scale_ratio;
    }
    else
    {
        $w = $w_orig;
        $h = $h_orig;
    }

    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif")
    {
        $img = imagecreatefromgif($target);
    }
    else if($ext == "png")
    {
        $img = imagecreatefrompng($target);
    }
    else
    {
        $img = imagecreatefromjpeg($target);
    }

    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);

    if ($ext == "gif")
    {
        imagegif($tci, $newcopy);
    }
    else if($ext == "png")
    {
        imagepng($tci, $newcopy);
    }
    else
    {
        imagejpeg($tci, $newcopy, 84);
    }

    // ---------- Start Universal Image Resizing Function --------
    // $target_file = "uploads/".$fileName;
    // $resized_file = "uploads/resized_".$fileName;
    // $wmax = 500;
    // $hmax = 500;
    // ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
    // ----------- End Universal Image Resizing Function ----------

}

function img_thumb($target, $newcopy, $w, $h, $ext)
{
    list($w_orig, $h_orig) = getimagesize($target);
    $src_x = ($w_orig / 2) - ($w / 2);
    $src_y = ($h_orig / 2) - ($h / 2);
    $ext = strtolower($ext);
    $img = "";
    if ($ext == "gif")
    {
        $img = imagecreatefromgif($target);
    }
    else if($ext == "png")
    {
        $img = imagecreatefrompng($target);
    }
    else
    {
        $img = imagecreatefromjpeg($target);
    }

    $tci = imagecreatetruecolor($w, $h);
    imagecopyresampled($tci, $img, 0, 0, $src_x, $src_y, $w, $h, $w, $h);

    if ($ext == "gif")
    {
        imagegif($tci, $newcopy);
    }
    else if($ext == "png")
    {
        imagepng($tci, $newcopy);
    }
    else
    {
        imagejpeg($tci, $newcopy, 84);
    }
}

function img_watermark($target, $wtrmrk_file, $newcopy)
{
    $watermark = imagecreatefrompng($wtrmrk_file);
    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);
    $img = imagecreatefromjpeg($target);
    $img_w = imagesx($img);
    $img_h = imagesy($img);
    $wtrmrk_w = imagesx($watermark);
    $wtrmrk_h = imagesy($watermark);
    $dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // For centering the watermark on any image
    $dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // For centering the watermark on any image
    imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
    imagejpeg($img, $newcopy, 100);
    imagedestroy($img);
    imagedestroy($watermark);
}

function mcopyImg($img, $path){
    $date = date('m/d/h');
    $dirName = $path . $date;
    if(!file_exists($dirName)){
        $dir = mkdir($dirName, 0644, true);
        if($dir){
            if(copy($path . $img, $dirName . '/' . $img)){
                return '<img src="' . $dirName . '/' . $img . '" alt="" style="width: 200px;"/><br> successful: ' . $dirName . '/' . $img;
            }else{
                return 'probs moving file 1';
            }
        }else{
            return 'Nope...!!!!!!';
        }
    }else{
        if(copy($path . $img, $dirName . '/' . $img)){
            return '<img src="' . $dirName . '/' . $img . '" alt="" style="width: 200px;"/><br> successful: ' . $dirName . '/' . $img;
        }else{
            return 'probs moving file 2';
        }
    }
}

function gistPlaceHolder($a)
{
    print '<section class="gist-container pholder">';
    $p = ($a > 5)? 5: $a;
    $p = ($p === 0)? 1: $p;
    for($l = 1;$l <= $p; $l++){
        print '<article class="background">';
            print '<div class="a"></div>';
            print '<div class="b"></div>';
            print '<div class="c"></div>';
            print '<div class="d"></div>';
            print '<div class="e"></div>';
            print '<div class="f"></div>';
            print '<div class="g"></div>';
            print '<div class="h"></div>';
            print '<div class="i"></div>';
            print '<div class="j"></div>';
            print '<div class="k"></div>';
            print '<div class="l"></div>';
            print '<div class="m"></div>';
        print '</article>';
        if($l !== $p)
            print '<hr/>';
    }
    print '</section>';
}