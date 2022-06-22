<?PHP
$message = '接続に成功しました';
try {
  $DBSERVER = 'localhost';
  $DBNAME = 'board';
  $DBUSER = 'board'; //作成したユーザー名
  $DBPASSWD = 'boardpw'; //作成したユーザーのパスワード
  $dsn = "mysql:host={$DBSERVER};dbname={$DBNAME};charset=utf8";
  $pdo = new \PDO($dsn, $DBUSER, $DBPASSWD, array(\PDO::ATTR_EMULATE_PREPARES => false));   
} catch (Exception $e){
  $message="接続に失敗しました:{$e->getMessage()}";
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
        <a href="/vantan_board/index.php">TOP</a>
        <a href="/vantan_board/register.php">新規作成</a>
        <a href="/vantan_board/login.php">ログイン</a>
        <a href="/vantan_board/logout.php">ログアウト</a>
    </div>
    <h1>新規作成</h1>
  </header>
  <div>
    <form action="/vantan_board/register.php" method="post">
	<label>アカウント名: <input type="text" name="name"></label><br>
	<label>メールアドレス: <input type="email" name="email"/></label><br>
        <label>パスワード: <input type="password" name="password"/></label><br>
        <input type="submit" value="新規登録">
    </form>
  </div>
</body>
</html>

