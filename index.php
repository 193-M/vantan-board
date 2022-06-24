<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>トップ</title>
  </head>
  <body>
    <header>
      <div>
        <a href="/vantan-board/index.php">TOP</a>
        <a href="/vantan-board/register.php">新規登録</a>
        <a href="/vantan-board/login.php">ログイン</a>
        <a href="/vantan-board/logout.php">ログアウト</a>
      </div>
      <h1>トップ</h1>
    </header>
    <div>
        <?php echo "{$_SESSION['name']}さんようこそ"; ?>
    </div>
  </body>
</html>
