<?php
 include('./dbconfig.php');
 
 try{
  //パスワードの新規登録
   $mail = $_POST['name'];
   $password = $_POST['password'];
   $mailtype = pathinfo($mail,PATHINFO_EXTENSION);//メアドの末尾を取得

   
  if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($mail) && !empty($password)){
   $ArrayMailType = ['com', 'exe','mail'];
   if(in_array($mailtype,$ArrayMailType)){
    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $password)) {
      $hashpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
      //DBに同じ名前とメアドがないかを確認
       $sql = 'SELECT * FROM `login.bbs` WHERE mail = ? OR  password = ?';
       $stmt = $dbh->prepare($sql);
       $stmt->execute(array($mail,$hashpassword));
       $Data = $stmt->fetch();
       if(!$Data){
        //DBに新規登録する
         $stmt2 = $dbh->prepare("INSERT INTO `login.bbs` (mail,password) VALUES (:mail, :password)"); 
         $stmt2->bindParam(':mail', $mail);
         $stmt2->bindParam(':password', $hashpassword);
         $stmt2->execute();
         $uri = $_SERVER['HTTP_REFERER'];
         header('Location: ' . $uri);
         exit();
       }else{
        echo 'メールアドレスまたはパスワードが既に登録されています';
       };
    }else{
      echo "パスワードを条件に合わせて入力してください";
    }
   }else{
    echo 'メールアドレスの拡張子が不適切です';
   }
  }elseif(empty($mail) && !empty($password)){
    echo 'メールアドレスを入力してください';
  }elseif(!empty($mail) && empty($password))
  echo 'パスワードを入力してください';
 }catch(PDOException $e){
  echo $e->getmessage();
 }
?>




