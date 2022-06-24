<?php
session_start();

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
$id = $_GET['id'];
$sql = 'SELECT * FROM `boards` WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$board = $stmt->fetch();

if (empty($board)) {
    header('Location: /vantan-board/index.php');
    exit;
}

if (!empty($_POST['message'])) {
    $message = $_POST['message'];

    $sql = 'INSERT INTO `comments` (boardId, userId, comment, createdAt)';
    $sql .= ' VALUES (:boardId, :userId, :comment, NOW())';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':boardId', $id, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->bindValue(':comment', $message, PDO::PARAM_STR);
    $result = $stmt->execute();
    if ($result) {
        // コメントしました
    } else {
        $message = 'コメントできませんでした';
    }
}

$sql = 'SELECT * FROM `comments` WHERE boardId = :boardId ORDER BY createdAt';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':boardId', $id, PDO::PARAM_STR);
$stmt->execute();
$comments = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $board['title'] ?></title>
  </head>
  <body>
    <header>
      <div>
        <a href="/vantan-board/index.php">TOP</a>
        <a href="/vantan-board/register.php">新規作成</a>
        <a href="/vantan-board/login.php">ログイン</a>
        <a href="/vantan-board/logout.php">ログアウト</a>
        <a href="/vantan-board/create_board.php">掲示板作成</a>
      </div>
      <h1><?php echo $board['title']; ?></h1>
    </header>
    <div>
      <ul>
        <?php
        foreach ($comments as $comment) {
            $sql = 'SELECT * FROM `users` WHERE id = :userId';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':userId', $comment['userId'], PDO::PARAM_INT);
            $stmt->execute();
            $creater = $stmt->fetch();
            echo "<li>{$comment['comment']} ({$comment['createdAt']}) 投稿者:{$creater['name']}</li>";
        }
        ?>
      </ul>
    </div>
    <?php if (!empty($_SESSION['id'])) { ?>
      <div>
        <form action="/vantan-board/board.php?id=<?php echo $id; ?>" method="post">
          <label>コメント: <input type="text" name="message"/></label><br/>
          <input type="submit" value="コメントする">
        </form>
      </div>
    <?php } ?>
  </body>
</html>
