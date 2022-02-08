<?php
    $number = $_POST['number'];
    //echo $number.'<br\>';

    //DB接続します
    try {
        //ID:'root', Password: 'root'
        $pdo = new PDO('mysql:dbname=sugoroku;charset=utf8;host=localhost','root','root');
    } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
    }

    // 1. SQL文を用意
    //$stmt = $pdo->prepare("INSERT INTO user_count(number)VALUES(:number)");
    $stmt = $pdo->prepare("UPDATE user_count SET number = :number");
    //  2. バインド変数を用意
    $stmt->bindValue(':number', $number, PDO:: PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

    //  3. 実行
    $status = $stmt->execute();

    //user_tableの削除
    $stmt = $pdo->prepare("TRUNCATE TABLE user_table");
    $status = $stmt->execute();

    //game_tableの削除
    $stmt = $pdo->prepare("TRUNCATE TABLE game_table");
    $status = $stmt->execute();


    //４．データ登録処理後
    if($status==false){
        //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        $error = $stmt->errorInfo();
        exit("ErrorMessage:".$error[2]);
    }
    else{
        header("Location: user_regist.php");
        exit;
    }



?>