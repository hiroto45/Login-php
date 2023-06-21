<?php
 include('./dbconfig.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <main>
    <div class="login">
      <form action="./rogindata.php" method ="POST">
        <h1>ログインしてください</h1>
        <?php 
          session_start();
          if(isset($_SESSION['errMessage'])){
            $errMessage = $_SESSION['errMessage'];
           foreach($errMessage as $msg){
            echo $msg . "<br>";
           }
           unset($_SESSION['errMessage']);
          }   
        ?>
         <input type="text" placeholder="メールアドレス" name="name">
         <input type="text" placeholder="パスワード" name="password">
         <button type="submit">ログインする</button>
      </form>
    </div>

    <div class="New-login">
      <form  action="./data.php" method = "POST">
        <h1>初めての方はこちら</h1>
        <input type="text" placeholder="メールアドレス" name="name">
         <input type="text" placeholder="パスワード" name="password">
         <button type="submit">新規登録する</button>
      </form>
    </div>
    <p>*パスワードは半角英数字をそれそれ1文字以上含んだ、8文字以上で設定してください。</p>
  </main>
</body>
<?php
  return false;
?>
</html>




