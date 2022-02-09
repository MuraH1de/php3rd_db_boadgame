<?php
    try {
        //ID:'root', Password: 'root'
        $pdo = new PDO('mysql:dbname=sugoroku;charset=utf8;host=localhost','root','root');
    } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
    }

    $stmt = $pdo->prepare("SELECT * FROM boad_table");
    $status = $stmt->execute();
    $boad_all=0;
    while($boad_table[] = $stmt->fetch(PDO::FETCH_ASSOC)){
        $boad_all += 1;
    }
    //echo $boad_all;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>

    <!-- <link rel="stylesheet" href="css/reset.css"> -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main>
    <div class="left_main">
        <h1>すごろく作成！</h1>

        <div class="edit_zone">
            <h2>すごろくボードの編集をしてください。</h2>

            <div class="edit">
                <h3>編集</h3>
                <form method="POST" action="edit_boad.php">
                    <select name="number">
                        <option value="">-</option>
                        <?php 
                            for($n=1;$n<=$boad_all;$n++){
                                echo "<option value='{$n}'>{$n}</option>";
                            }
                        ?>
                    </select><br>
                    <label>ボーナス：<input type="text" name="bonus" class="bonus"></label><br>
                    <label>1回休み：<input type="text" name="stop_status" class="stop_status"></label><br>
                    <label>内容：<input type="text" name="text" class="text"></label><br>
                    <button type="submit">更新</button>
                </form>
            </div>

            <div class="insert">
                <h3>追加</h3>
                <form method="POST" action="insert_boad.php">
                    <select name="number">
                        <option value="">-</option>
                        <?php 
                            for($n=1;$n<=$boad_all;$n++){
                                echo "<option value='{$n}'>{$n}</option>";
                            }
                        ?>
                    </select><br>
                    <label>ボーナス：<input type="text" name="bonus" class="bonus"></label><br>
                    <label>1回休み：<input type="text" name="stop_status" class="stop_status"></label><br>
                    <label>内容：<input type="text" name="text" class="text"></label><br>
                    <button type="submit">追加</button>
                </form>
            </div>

            <div class="delete">
                <h3>削除</h3>
                <form method="GET" action="delete_boad.php">
                    <select name="number">
                        <option value="">-</option>
                        <?php 
                            for($n=1;$n<=$boad_all;$n++){
                                echo "<option value='{$n}'>{$n}</option>";
                            }
                        ?>
                    </select>
                    <button type="submit">削除</button>
                </form>
            </div>
        </div>

        <!-- 画面遷移 -->
        <button onclick="location.href='./number_select.php'" class="next_button">すごろく画面決定！</button>

    </div>

    <div class="right_main">
        <table class="game_table">
            <tr><th>マス</th><th>内容</th></tr>
            <?php
                for($i=0;$i<$boad_all;$i++){
                    echo "<tr><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td></tr>";
                }
            ?>

        </table>
    </div>
</main>
</body>
</html>