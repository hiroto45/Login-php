<?php
 include('./dbconfig.php');
 
 try{
   $mail = $_POST['name'];
   $password = $_POST['password'];
   $mailtype = pathinfo($mail,PATHINFO_EXTENSION);//メアドの末尾を取得
   $errMessage = [];

   
  if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($mail) && !empty($password)){
   $ArrayMailType = ['com', 'exe','mail'];
   if(in_array($mailtype,$ArrayMailType)){
    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $password)) {
      // ハッシュ化したパスワードをデータベースから取得
      $sql = 'SELECT `password`  FROM `login.bbs` WHERE mail = ?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array($mail));
      $FromDB = $stmt->fetch();
  
      if ( $FromDB !== false && password_verify($password, $FromDB['password'])){
          header('Location: ./mainhome.php');//ログイン完了
          exit();
      }else{
          $errMessage['LoginErr'] = 'メールアドレスまたはパスワードが間違っています！';
      }
  } else {
      $errMessage['passworderr'] = "パスワードを条件に合わせて入力してください";
  }
   }else{
    $errMessage['arrayErr'] = "パスワードの拡張子が異なっています";
   }
  }elseif(empty($mail) && !empty($password)){
    $errMessage['inputMailErr'] = 'メールアドレスを入力してください';
  }elseif(!empty($mail) && empty($password)){
  $errMessage['inputPasswordErr'] = 'パスワードを入力してください';
  };

  if(isset($errMessage)){
    session_start();
    $_SESSION['errMessage'] = $errMessage;
    header('Location: ./rogin.php');
    exit();
  }
 }catch(PDOException $e){
  echo $e->getmessage();
 }

?>



















