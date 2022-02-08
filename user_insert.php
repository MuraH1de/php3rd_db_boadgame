<?php
    //1. POSTデータ取得
    $name = $_POST['name'];
    //echo $name.'<br>';

    //2. DB接続します
    try {
        //ID:'root', Password: 'root'
        $pdo = new PDO('mysql:dbname=sugoroku;charset=utf8;host=localhost','root','root');
    } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
    }


    //何人読み込むか確認する
    $stmt = $pdo->prepare("SELECT * FROM user_count");
    $status = $stmt->execute();
    $user_number = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($user_number["number"]);
    //echo '<br />';

    // 1. SQL文を用意
    $stmt = $pdo->prepare("INSERT INTO user_table(user_id, user_name, position, stop_status, goal)VALUES(NULL, :user_name, 1, 0, 28)");

    //  2. バインド変数を用意
    $stmt->bindValue(':user_name', $name, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

    //  3. 実行
    $status = $stmt->execute();

    // 登録数確認
    $stmt = $pdo->prepare("SELECT count(*) FROM user_table");
    $status = $stmt->execute();
    $user_all = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($user_all["count(*)"]);
    //echo '<br />';


    //４．データ登録処理後
    if($status==false){
        //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        $error = $stmt->errorInfo();
        exit("ErrorMessage:".$error[2]);
    }
    else{
        if($user_number["number"] == $user_all["count(*)"]){
            header("Location: game_index.php");
            exit;
        }
        else{
            if($user_number["number"] < $user_all["count(*)"]){
                exit("Error!!");
            }
            else{
                header("Location: user_regist.php");
                exit;
            }
            
        }
    }
?>