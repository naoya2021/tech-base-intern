<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>最近ハマっていること</h1>
    <?php
        ini_set('display_errors',0);
       $dsn = 'mysql:dbname=tb230617db;host=localhost';
        $user = 'tb-230617';
        $SqlPassword = 'sKwFAVYz35';
        $pdo = new PDO($dsn, $user, $SqlPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //編集機能
        if($_POST['edit']){
        $edit_num = $_POST['edit_num'];
        $edit_password = $_POST['edit_password'];
            if(!empty($edit_num && $edit_password)){
                $sql = 'SELECT * FROM m501table WHERE id = :id';
                $stmt = $pdo->prepare($sql);  
                $stmt->bindParam(':id', $edit_num, PDO::PARAM_INT); 
                $stmt->execute(); 
                $results = $stmt->fetchAll(); 
                foreach ($results as $row){
                   if($row['password'] == $edit_password){
                        $edit_item = $row['id'];
                        $name = $row['name'];
                        $comment = $row['comment'];
                        $edit_password_item = $row['password'];
                    }
                    else{
                       echo 'パスワードが違います。';
                    }
                }
            }
            
        
                
                
        }
    ?>
    
    <form action = "" method = "POST">
        <input type = "text" name = 'name' value = '<?php ini_set('display_errors', 0); echo $name; ?>' placeholder = '名前'><br>
        <input type = "text" name = 'comment' value = '<?php ini_set('display_errors', 0); echo $comment; ?>' placeholder = 'コメント'><br>
        <input type = "password" name = 'password' value = '<?php ini_set('display_errors',0); echo $password; ?>' placeholder = 'パスワード'>
        <input type = "hidden" name = 'edit_item' value = '<?php ini_set('display_errors',0); echo $edit_item; ?>' >
        <input type = "hidden" name = 'edit_password_item' value = '<?php ini_set('display_errors',0); echo $edit_password_item; ?>' >
        <input type = 'submit' name = 'submit'><br>
        
        <input type = 'number' name = 'delete_num' value ='' placeholder = '削除する場所を入力'><br>    
        <input type = "password" name = 'delete_password' value = '' placeholder = 'パスワードを入力'>
        <input type = 'submit' name = 'delete' value='削除'><br>
        
        <input type = 'number' name = 'edit_num' value ='' placeholder = '編集する場所を入力'><br>
        <input type = "password" name = 'edit_password' value = '' placeholder = 'パスワードを入力'>
        <input type = 'submit' name = 'edit' value='編集'>
    </form>
  
    <?php
    ini_set('display_errors',0);
    $edit_item = $_POST['edit_item'];
    $edit_password_item = $_POST['edit_password_item'];
    $edit_password = $_POST['edit_password'];
    $delete_password = $_POST['delete_password'];
    $name=$_POST['name'];
    $comment=$_POST['comment'];
    $password = $_POST['password'];
    //普通に送信した場合と編集後の送信です。
    if($_POST['submit']){
        
        
        $dsn = 'mysql:dbname=tb230617db;host=localhost';
        $user = 'tb-230617';
        $SqlPassword = 'sKwFAVYz35';
        $pdo = new PDO($dsn, $user, $SqlPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "CREATE TABLE IF NOT EXISTS m501table"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "password TEXT"
        .");";
        $stmt = $pdo->query($sql);
        
        //普通に送信した場合
        if(empty($edit_item && $edit_password_item)){
            if(!empty($name && $comment && $password)){
                   
                    if(empty($sql)){
                        
                        $id = 1;
                        $sql = $pdo -> prepare("INSERT INTO m501table (id, name, comment, password) VALUES (:id, :name, :comment, :password)");
                        $sql -> bindParam(':id', $id, PDO::PARAM_STR);
                        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                        $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                        $sql -> execute();
                    }
                    else{
                        $sql = $pdo -> prepare("INSERT INTO m501table (id, name, comment, password) VALUES (:id, :name, :comment, :password)");
                        $sql -> bindParam(':id', $num, PDO::PARAM_STR);
                        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                        $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                        $sql -> execute();
                    }
                
                $sql = 'SELECT * FROM m501table ';
                $stmt = $pdo->prepare($sql);
               
                $stmt->execute();                            
                $results = $stmt->fetchAll(); 
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['password'].'<br>';
                echo "<hr>";
                }
            }
            
        }
        //編集した場合の送信
        else{
            $sql = 'UPDATE m501table SET name=:name,comment=:comment,password=:password WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $edit_item, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt-> bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(); 
            foreach ($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['password'].'<br>';
            echo "<hr>";
            }
        }
            
        
    }
    
    elseif($_POST['delete']){
        $delete_num = $_POST['delete_num'];
        $delete_password = $_POST['delete_password'];
        
        $sql = 'SELECT * FROM m501table WHERE id = :id';
        $stmt = $pdo->prepare($sql);  
        $stmt->bindParam(':id', $delete_num, PDO::PARAM_INT); 
        $stmt->execute();  
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
                   if($row['password'] == $delete_password){
                       $sql = 'DELETE from m501table where id=:id';
                       $stmt = $pdo->prepare($sql);
                       $stmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
                       $stmt->execute();
                   }
                   else{
                        echo 'パスワードが違います。';
                    }
                }
    }
  　
    
     
            

    
   
    ?>
    
      
    
</body>
</html>