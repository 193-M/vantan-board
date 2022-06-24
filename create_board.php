<?php
session_start(); 

if (empty($_SESSION['id'])) {
    header('Location: /vantan-board/index.php');
    exit;
}

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
}

if (!empty($_POST['title'])) {
    $title = $_POST['title'];

    $sql = 'INSERT INTO `boards` (title, userId, createdAt)';
    $sql .= ' VALUES (:title, :userId, NOW())';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $_SESSION['id'], PDO::PARAM_INT);
    $result = $stmt->execute();
    if($result) {
        $message = '掲示板を作成しました';
    } else {
        $message = '作成に失敗しました';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>新規作成</title>
  </head>
  <body>
    <header>
      <div>
        <a href="/vantan-board/index.php">TOP</a>
        <a href="/vantan-board/register.php">新規登録</a>
        <a href="/vantan-board/login.php">ログイン</a>
        <a href="/vantan-board/logout.php">ログアウト</a>
      </div>
      <h1>掲示板の新規作成</h1>
    </header>
    <div>
      <div style="color: red">
        <?php echo $message; ?>
      </div>
      <form action="/vantan-board/board_create.php" method="post">
        <label>タイトル: <input type="text" name="title"/></label><br/>
        <input type="submit" value="新規作成">
      </form>
    </div>
  </body>
</html>
