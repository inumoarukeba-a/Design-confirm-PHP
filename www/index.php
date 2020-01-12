<?php
/**
 * [タイトル]
 * ディレクターさんが一分でも早く帰る.php
 *
 * [概要]
 * テストサーバーを使って、クライアントさまにデザインカンプをお見せするのを便利にするかもしれないphpです。
 * デザインファイル（jpg）の存在を確認し、各phpファイルを自動生成します。
 * 生成したphpのURLのリストを./index.phpにアウトプットします。
 *
 * [構成]
 * ./index.php                  [本ファイル]
 * ./__design/                  [デザイン格納ディレクトリ]
 * ./__template/template.php    [phpを自動生成する際のテンプレート]
 * ./css/                       [CSS]
 *
 * [使い方]
 * 01.本ディレクトリ名をデザイン提出日などに変更してください。（ex:20170101）
 * 02./__design/ディレクトリに作成したデザインを格納してください。
 * 03.本ディレクトリをテストサーバーにアップしてください。
 * 04.本ディレクトリのパーミッションを[757]にしてください。
 * 05.ブラウザで./index.phpにアクセスしてください。後はphpが自動で実行します。
 *
 * @author  Ataru Nakano
 * @version 0.11
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" xmlns:fb="http://ogp.me/ns/fb#"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$ua=$_SERVER['HTTP_USER_AGENT'];
if((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false)){
echo '<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />';
}else{
echo '<meta name="viewport" content="width=1366">';
}
?>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="description" content="" />
<meta name="keywords" content="" />

<title>index</title>

<link href="css/common.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body class="page-index">


<?php

  // -----------------------------------------
  // 設定
  // -----------------------------------------
  // エラー出力
  ini_set( 'display_errors', 1 );
  // デザインディレクトリ
  $designDirName  = "/__design/";
  $designDir      = dirname(__FILE__) . $designDirName;
  // テンプレートディレクトリ
  $templateDirName= "/__template/";
  $templateFile   = dirname(__FILE__) . $templateDirName . "template.php";
  // 当ディレクトリ
  $dirPath        = dirname(__FILE__) . "/";
  $dirName        = basename(__DIR__);
  $dirUrl         = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
  // 正規表現パターン
  $reg            = "/(.*)(?:\.([^.]+$))/";


  // -----------------------------------------
  // 見出しを出力
  // -----------------------------------------
  echo "<h1>「" . $dirName . "」のデザインファイル一覧</h1>";


  // -----------------------------------------
  // デザインディレクトリを確認し、phpファイルを生成する
  // -----------------------------------------
  // ディレクトリの存在を確認し、ハンドルを取得
  if( is_dir( $designDir ) && $handle = opendir( $designDir ) ) {
    // ループ処理
    while( ($file = readdir($handle)) !== false ) {
      if( filetype( $path = $designDir . $file ) == "file" ) {
        /********************
        各ファイルへの処理と変数の役割
        $file       ファイル名.jpg
        $fileName   ファイル名.php
        $path       ファイルのパス
        $contents   生成するphpのテンプレート
        $imagePath  生成するphpから見た、画像へのパス
        $fileHandle ハンドル
        ********************/
        // テンプレート読み込み
        $contents   = file_get_contents($templateFile);
        // 読み込んだテンプレートの内容に、画像のパスを挿入する
        $imagePath  = dirname($_SERVER["SCRIPT_NAME"]) . $designDirName . $file;
        $contents   = str_replace( "<%IMAGEPATH>", htmlspecialchars($imagePath), $contents);
        // 画像ファイルと同じ名前を変数にセットする
        preg_match( $reg, $file, $retArr );
        $fileName   = $retArr[1] . ".php";
        // ファイル生成 & 書き込み
        $fileHandle = fopen( $fileName, 'w' );
        fwrite( $fileHandle, $contents );
        fclose( $fileHandle );
      }
    }
  }


  // -----------------------------------------
  // 生成したphpの一覧./index.phpに作成する
  // -----------------------------------------
  if( is_dir( $dirPath ) && $handle = opendir( $dirPath ) ) {
    // [ul]タグ
    echo "<ul>";
      // ループ処理
      while( ($file = readdir($handle)) !== false ) {
        // phpファイルのみ取得（このファイルを除く）
        if(
          filetype( $path = $dirPath . $file ) == "file"
          && strpos($file,'php') !== false
          && strpos($file,'index.php') === false
        ) {
          /********************
          各ファイルへの処理
          $file ファイル名.php
          $path ファイルのパス
          ********************/
          // [li]タグ
          echo "<li>";
          echo "<a href=" . $dirUrl . $file . ">";
          // ファイル名を出力する
          echo $dirUrl . $file;
          // [li]タグ
          echo "</li>";
        }
      }
    // [ul]タグ
    echo "</ul>";
  }

?>


</body>
</html>
