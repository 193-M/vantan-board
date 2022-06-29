<header>
    <div>
        <a href="/vantan-board/index.php">TOP</a>
        {if empty($user)}
            <a href="/vantan-board/register.php">新規登録</a>
            <a href="/vantan-board/login.php">ログイン</a>
        {else}
            <a href="/vantan-board/create_board.php">掲示板作成</a>
            <a href="/vantan-board/logout.php">ログアウト</a>
        {/if}
    </div>
</header>