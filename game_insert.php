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
    $boad_all=0;
    while($boad_table[] = $stmt->fetch(PDO::FETCH_ASSOC)){
        $boad_all += 1;
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
        $goal = $boad_all-1;
        $position = 1;
    }
    else{
        $position = $user_table[$user_id]["position"];
        $goal = $user_table[$user_id]["goal"];
    }
    


    //行先を確認する
    $id = $position + $dice;
    if($id > $boad_all){
        $id = $boad_all;
    }
    $stmt = $pdo->prepare("SELECT * FROM boad_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO:: PARAM_INT);
    $status = $stmt->execute();
    $target_table = $stmt->fetch(PDO::FETCH_ASSOC);
    $text = $target_table["text"];
    //var_dump($target_table);
    //echo '<br />';
    //echo 'bonus=>'.$target_table["bonus"].'<br />';
    //echo 'text=>'.$text.'<br />';

    //user_table 更新
    $position = $position + $dice + $target_table["bonus"];
    if($position > $boad_all){
        $position = $boad_all;
    }
    //echo 'position=>'.$position.'<br />';
    $stop_status = $target_table["stop_status"];
    //$stop_status = 0;
    //echo 'stop_status=>'.$stop_status.'<br />';
    if($dice == 0){
        $stop_status = 0;
    }

    //echo "goal->".$goal."<br>";
    //echo "dice->".$dice."<br>";
    //echo "bonus->".$target_table["bonus"]."<br>";
    $goal = $goal - $dice - $target_table["bonus"];
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
    $bonus = $target_table["bonus"];
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
            <h2 class="result"><?= $text; ?></h2>
            <h3><?= $position; ?>番目のマスに止まっているよ。</h3>
            <h3>ゴールまで、あと<?= $goal; ?>マスだよ。</h3>
            
            <button type ="button" onclick="location.href='game_index.php'">次の人へ</button><br>

            <button onclick="location.href='./index.php'" class="initial_button">はじめにもどる</button>
        </div>

        <div class="right_main">
            <table class="game_table">
                <!-- <tr><th>マス</th><th>内容</th></tr> -->
                <?php
                    $table_header = '<tr><th>マス</th><th>内容</th>';
                    //var_dump($user_table);
                    for($u=0;$u<$user_all;$u++){
                        //echo '$u->'.$u.'user_name'.$user_table[$u]["user_name"].'<br>';

                        $table_header = $table_header.'<th>'.$user_table[$u]["user_name"].'</th>';
                    }
                    $table_header = $table_header.'</tr>';
                    echo $table_header;

                    $line = "";
                    for($i=0;$i<$boad_all;$i++){
                        //echo  '$i->'.$i.'<br>';
                        if($i == $position - 1){
                            //echo "<tr class='table_config'><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td><td></td><td></td></tr>";
                            $line = "<tr class='table_config'><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td>";
                        }
                        else{
                            //echo "<tr><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td><td></td><td></td></tr>";
                            $line = "<tr><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td>";
                        }

                        for($u=0;$u<$user_all;$u++){
                        //echo  '$u->'.$u.'<br>';
                        //echo  '$user_id->'.$user_id.'<br>';
                        //echo  '$position->'.$position.'<br>';
                        //echo  '$user_table[$u]["position"]->'.$user_table[$u]["position"].'<br>';

                            if($user_id-1 == $u){
                                if($i == $position-1){
                                    $line = $line."<td>●</td>";
                                }
                                else{
                                    $line = $line."<td></td>";
                                }
                            }
                            else{
                                if($i == $user_table[$u]["position"]-1){
                                    $line = $line."<td>●</td>";
                                }
                                else{
                                    $line = $line."<td></td>";
                                }
                            }
                        }
                        
                        echo $line."</tr>";
                    }
                ?>

            </table>
        </div>

    </main>

</body>
</html>