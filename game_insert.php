<?php
    $dice = $_POST['dice'];
    //echo 'dice=>'.$dice.'<br>';

    try {
        //ID:'root', Password: 'root'
        $pdo = new PDO('mysql:dbname=sugoroku;charset=utf8;host=localhost','root','root');
    } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
    }

    //ゲームのボード取得
    $stmt = $pdo->prepare("SELECT * FROM boad_table");
    $status = $stmt->execute();
    while($boad_table[] = $stmt->fetch(PDO::FETCH_ASSOC)){
    }

    // サイコロの投げた数確認
    $stmt = $pdo->prepare("SELECT count(*) FROM game_table");
    $status = $stmt->execute();
    $count_all = $stmt->fetch(PDO::FETCH_ASSOC);
    $count_number = intval($count_all["count(*)"]);
    //echo 'サイコロ振った数=>'.$count_number.'<br />';

    //ユーザ情報を読み込む
    $stmt = $pdo->prepare("SELECT * FROM user_table");
    $status = $stmt->execute();
    $user_all = 0;
    while($user_table[] = $stmt->fetch(PDO::FETCH_ASSOC)){
        $user_all += 1;
    }
    //echo $user_table[0]["user_name"].'<br />';
    //echo $user_table[1]["user_name"].'<br />';
    //echo 'ユーザ数=>'.$user_all.'<br />'; //全ユーザ数

    //誰の順番か判定
    if($count_number == 0){
        $user_id = 0;
    }
    else{
        $user_id = $count_number % $user_all;
    }
    //echo 'user_id=>'.$user_id.'user_name=>'.$user_table[$user_id]["user_name"].'<br />';

    //何ターン目か確認
    $turn = intdiv($count_number, $user_all) + 1;
    if($turn == 1){
        $goal = 29;
        $position = 1;
    }
    else{
        $position = $user_table[$user_id]["position"];
        $goal = $user_table[$user_id]["goal"];
    }
    


    //行先を確認する
    $id = $position + $dice;
    if($id > 29){
        $id = 29;
    }
    $stmt = $pdo->prepare("SELECT * FROM boad_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO:: PARAM_INT);
    $status = $stmt->execute();
    $turn_value = $stmt->fetch(PDO::FETCH_ASSOC);
    $text = $turn_value["text"];
    //var_dump($turn_value);
    //echo '<br />';
    //echo 'bonus=>'.$turn_value["bonus"].'<br />';
    //echo 'text=>'.$text.'<br />';

    //user_table 更新
    $position = $position + $dice + $turn_value["bonus"];
    if($position > 29){
        $position = 29;
    }
    //echo 'position=>'.$position.'<br />';
    $stop_status = $turn_value["stop_status"];
    //$stop_status = 0;
    //echo 'stop_status=>'.$stop_status.'<br />';
    if($dice == 0){
        $stop_status = 0;
    }

    $goal = $goal - $dice - $turn_value["bonus"] - 1;
    if($goal < 0){
        $goal = 0;
    }
    //echo 'goal=>'.$goal.'<br />';
    $user_id += 1;
    //echo 'user_id=>'.$user_id.'<br />';
    $stmt = $pdo->prepare("UPDATE  user_table SET position = :position, stop_status = :stop_status, goal = :goal  WHERE user_id = :user_id");
    $stmt->bindValue(':position', $position, PDO:: PARAM_INT);
    $stmt->bindValue(':stop_status', $stop_status, PDO:: PARAM_INT);
    $stmt->bindValue(':goal', $goal, PDO:: PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO:: PARAM_INT);
    $status = $stmt->execute();

    //game_table 更新
    //echo 'サイコロ振った数=>'.$count_number.'<br />';
    //echo '人数=>'.$user_all.'<br />';
    //echo 'ターン数=>'.$turn.'<br />';
    $bonus = $turn_value["bonus"];
    //echo 'position=>'.$position.'<br />';
    $stmt = $pdo->prepare("INSERT INTO game_table(id, turn, user_id, dice, bonus, position)VALUES(NULL, :turn, :user_id, :dice, :bonus, :position)");
    $stmt->bindValue(':turn', $turn, PDO:: PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO:: PARAM_INT);
    $stmt->bindValue(':dice', $dice, PDO:: PARAM_INT);
    $stmt->bindValue(':bonus', $bonus, PDO:: PARAM_INT);
    $stmt->bindValue(':position', $position, PDO:: PARAM_INT);
    $status = $stmt->execute();


    // if($status==false){
    //     $error = $stmt->errorInfo();
    //     exit("ErrorMessage:".$error[2]);
    // }else{
    //     header("Location: game_index.php");
    //     exit;
    // }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.1.3.min.js"></script>
    
    <title>Game</title>

    <!-- <link rel="stylesheet" href="css/reset.css"> -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <main>
        <div class="left_main">

            <h1>すごろく</h1>
            <h2>サイコロの目は<?= $dice; ?>だったよ。</h2>
            <h2><?= $text; ?></h2>
            <h3><?= $position; ?>番目のマスに止まっているよ。</h3>
            <h3>ゴールまで、あと<?= $goal; ?>マスだよ。</h3>
            
            <button type ="button" onclick="location.href='game_index.php'">次の人へ</button>
        </div>

        <div class="right_main">
            <table class="game_table">
                <tr><th>マス</th><th>内容</th></tr>
                <?php
                    for($i=0;$i<29;$i++){
                        echo "<tr><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td></tr>";
                    }
                ?>

            </table>
        </div>

    </main>

</body>
</html>