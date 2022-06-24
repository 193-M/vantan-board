<?php
  session_start();

  if(empty($_GET['id'])){
    header('Location: /vantan-board/index.php');
    exit;
  }
  $id = $_GET['id'];

  $message = '';
  try {
    $DBSERVER = 'localhost';
    $DBUSER = 'board';
    $DBPASSWD = 'boardpw';
    $DBNAME = 'board';

    $dsn = 'mysql:'
        . 'host=' . $DBSERVER . ';'
        . 'dbname=' . $DBNAME . ';'
        . 'charset=utf8';
    $pdo = new PDO($dsn, $DBUSER, $DBPASSWD, array(PDO::ATTR_EMULATE_PREPARES => false));
  } catch (Exception $e) {
    $message = "接続に失敗しました: {$e->getMessage()}";
    
    

    $sql = 'SELECT * FROM `boards` WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
    $board = $stmt->fetch();

    if(empty($board)){
        header('Location: /vantan-board/index.php');
        exit;
    }  

?>

<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <title>掲示板作成</title>
 </head>
 <body>
 <header>
   <div>
     <a href="/board/index.php">TOP</a>
     <a href="/board/create_board.php">掲示板作成</a>
     <a href="/board/register.php">新規作成</a>
     <a href="/board/login.php">ログイン</a>
     <a href="/board/logout.php">ログアウト</a>
   </div>
   <h1><?php echo $board['title']; ?></h1>
 </header>
 <div>
   <div style="color: red">
       <?php echo $message; ?>
   </div>
   <div>
     コメント一覧
