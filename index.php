<?php 
require_once 'config.php';
echo $_SERVER['REQUEST_URI'];

require_once SOURCE_BASE . 'partials/header.php';
// headerとfooterを別タグで管理することで、部品化することができる。

$rpath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);
// str_replaceでは第一引数を第二引数の空文字とし、第三引数にて空文字になった部分までのパスが削られた上で取得される。
$method = strtolower($_SERVER['REQUEST_METHOD']);

route($rpath, $method);

// デフォルトでhomeが表示されるようにする
function route($rpath, $method) {
    if($rpath === '') {
        $rpath = 'home';
    }
    
    $targetFile = SOURCE_BASE . "controllers/{$rpath}.php";
    // $targetfileに読み込みたいファイルが格納されることになる。

    if(!file_exists($targetFile)) {
        // 読み込みたいパスが存在しない場合は、エラーを表示するファイルへ飛ぶように設定する。
        require_once SOURCE_BASE . "views/404.php";
        return;
        // 対象のファイルが存在しない場合には、処理を終了させるようretrunしてあげる。
    }
    // 上記の文でif文が起動したら、ここは流れないのでelseを省略し記載してある。
    require_once $targetFile;

    $fn = "\\controller\\{$rpath}\\{$method}";

    $fn();
}



// if($_SERVER['REQUEST_URI'] === 'login') {
//     require_once SOURCE_BASE . 'controllers/login.php';
// } elseif($_SERVER['REQUEST_URI'] === '/poll/part1/end/register') {
//     require_once SOURCE_BASE . 'controllers/register.php';
// } elseif($_SERVER['REQUEST_URI'] === '/poll/part1/end/') {
//     require_once SOURCE_BASE . 'controllers/home.php';
// }

require_once SOURCE_BASE . 'partials/footer.php';

?>
