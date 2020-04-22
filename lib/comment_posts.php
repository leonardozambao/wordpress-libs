<?php 
require_once('../../../../wp-load.php');
$cookie = strtotime(date('Y-m-d'));
$pv_url = 'likes_'.md5($_POST['postId'].$_POST['commentId']);
$postID = $_POST['postId'];
$commentID = $_POST['commentId'];
$count_key = 'post_comment_count_'.$commentID;
$count = get_post_meta($postID, $count_key, true);
if(!isset($_COOKIE[$pv_url])){
    //salvo num cookie que dura 5 minutos.
    setcookie($pv_url, $cookie, time()+(60 * 5), COOKIEPATH, COOKIE_DOMAIN); // 5 minutos
    if($count==''){
        $count = 1; //quando o usuário entra, já conta como 1 visita
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, $count);
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
$output = json_encode(array('count' => $count));
echo $output;
?>