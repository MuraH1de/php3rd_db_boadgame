<?php
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
    //echo $boad_all;

    // サイコロを振った回数確認
    $stmt = $pdo->prepare("SELECT count(*) FROM game_table");
    $status = $stmt->execute();
    $count_all = $stmt->fetch(PDO::FETCH_ASSOC);
    $count_number = intval($count_all["count(*)"]);
    //echo $count_number.'<br />';

    //ユーザ情報を読み込む
    $stmt = $pdo->prepare("SELECT * FROM user_table");
    $status = $stmt->execute();
    $user_all = 0;
    while($user_table[] = $stmt->fetch(PDO::FETCH_ASSOC)){
        $user_all += 1;
    }
    //echo $user_table[0]["user_name"].'<br />';
    //echo $user_table[1]["user_name"].'<br />';
    //echo $user_all.'<br />'; //全ユーザ数を確認

    if($count_number == 0){
        $user_id = 0;
    }
    else{
        $user_id = $count_number % $user_all;
    }
    //echo $user_id.$user_table[$user_id]["user_name"].'<br />';

    $stop_status = $user_table[$user_id]["stop_status"];
    $position = $user_table[$user_id]["position"];
    //echo "stop_status->".$stop_status;
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

            <h2><span id="user"><?= $user_table[$user_id]["user_name"]; ?></span>の番です。</h2>
            <h2>ゴールまで<span id="position"><?= $user_table[$user_id]["goal"]; ?></span>マスです。</h2>
            <button id="saikoro">サイコロを振る</button>
            <h2 id="stop">1回休みだよ</h2>
            <h2 id="saikoro_result">出た目は<span id="s_result"></span></h2>
            

            <form method="POST" action="game_insert.php" id="saikoro">
                <input type="radio" name="dice" value="0" id="zero">
                    <label class="s_result" for="zero">0</label>
                <input type="radio" name="dice" value="1" id="one">
                    <label class="s_result" for="one">1</label>
                <input type="radio" name="dice" value="2" id="two">
                    <label class="s_result" for="two">2</label>
                <input type="radio" name="dice" value="3" id="three">
                    <label class="s_result" for="three">3</label>
                <input type="radio" name="dice" value="4" id="four">
                    <label class="s_result" for="four">4</label>
                <input type="radio" name="dice" value="5" id="five">
                    <label class="s_result" for="five">5</label>
                <input type="radio" name="dice" value="6" id="six">
                    <label class="s_result" for="six">6</label><br>

                <button id="next" type="submit">すごろくの行き先を見る</button>
            </form>
        </div>

        <div class="right_main">
            <table class="game_table">
                <tr><th>マス</th><th>内容</th></tr>
                <?php
                    for($i=0;$i<$boad_all;$i++){
                        if($i == $position - 1){
                            echo "<tr class='table_config'><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td></tr>";
                        }
                        else{
                            echo "<tr><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td></tr>";
                        }
                        
                    }
                ?>

            </table>
        </div>
    </main>

    <script>
        $(".s_result").css("display","none");
        $("input[type='radio']").css("display","none");

        let stop_status = <?= $stop_status; ?>;
        let saikoro_result = 0;

        if(stop_status == 1){
            $("#saikoro").css("display","none");
            $("#saikoro_result").css("display","none");
            let elements = document.getElementsByName("dice");
            //console.log(elements);
            elements[saikoro_result].checked = true ;
        }

        if(stop_status == 0){
            $("#stop").css("display","none");
            $("#saikoro").on("click", function(){
                saikoro_result = Math.ceil(Math.random() * 6);
                //console.log(saikoro_result);
                $("#s_result").empty();
                $("#s_result").append(saikoro_result);

                let elements = document.getElementsByName("dice");
                //console.log(elements);
                elements[saikoro_result].checked = true ;
            })
        }

    </script>
</body>
</html>