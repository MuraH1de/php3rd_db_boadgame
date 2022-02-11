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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <div class="left_main">
        <h1>すごろく作成！</h1>

        <div class="edit_zone">
            <h2>すごろくボードの編集をしてください。</h2>

            <div class="edit">
                <!-- <h3>編集</h3> -->
                <form method="POST" action="edit_boad.php">
                    <h3><select name="number">
                        <option value="">-</option>
                        <?php 
                            for($n=1;$n<=$boad_all;$n++){
                                echo "<option value='{$n}'>{$n}</option>";
                            }
                        ?>
                    </select> 列目を編集します。</h3>
                    <label>ボーナス：<input type="text" name="bonus" class="bonus"></label><span class="comment">※例：1＝1マス進む、-1：1マスもどる</span><br>
                    <label>1回休み：<input type="text" name="stop_status" class="stop_status"></label><span class="comment">※例：1＝1回休み、0：通常通り</span><br>
                    <label>内容：<input type="text" name="text" class="text"></label><span class="comment">※コメントを記入してください！</span><br>
                    <button type="submit">更新</button>
                </form>
            </div>

            <div class="insert">
                <!-- <h3>追加</h3> -->
                <form method="POST" action="insert_boad.php">
                    <h3>
                    <select name="number">
                        <option value="">-</option>
                        <?php 
                            for($n=1;$n<=$boad_all;$n++){
                                echo "<option value='{$n}'>{$n}</option>";
                            }
                        ?>
                    </select> 列目に追加します。</h3>
                    <label>ボーナス：<input type="text" name="bonus" class="bonus"></label><span class="comment">※例：1＝1マス進む、-1：1マスもどる</span><br>
                    <label>1回休み：<input type="text" name="stop_status" class="stop_status"></label><span class="comment">※例：1＝1回休み、0：通常通り</span><br>
                    <label>内容：<input type="text" name="text" class="text"></label><span class="comment">※コメントを記入してください！</span><br>
                    <button type="submit">追加</button>
                </form>
            </div>

            <div class="delete">
                <!-- <h3>削除</h3> -->
                <form method="GET" action="delete_boad.php">
                    <h3>
                    <select name="number">
                        <option value="">-</option>
                        <?php 
                            for($n=1;$n<=$boad_all;$n++){
                                echo "<option value='{$n}'>{$n}</option>";
                            }
                        ?>
                    </select> 列目を削除します。</h3>
                    <button type="submit">削除</button>
                </form>
            </div>
        </div>

        <!-- 画面遷移 -->
        <button onclick="location.href='./number_select.php'" class="next_button">すごろく画面決定！</button>

    </div>

    <div class="right_main">
        <button class="board_button" id="button_table">表</button>
        <button class="board_button" id="button_2d">2D-MAP</button>
        <button class="board_button" id="button_3d">3D-MAP</button>

        <table class="game_table">
            <tr><th>マス</th><th>内容</th></tr>
            <?php
                for($i=0;$i<$boad_all;$i++){
                    echo "<tr><td>{$boad_table[$i]["id"]}</td><td>{$boad_table[$i]["text"]}</td></tr>";
                }
            ?>

        </table>
        <img src="img\2d_board.png" class="img_2d">
        <img src="img\3d_board.png" class="img_3d">
    </div>
</main>

<script>
    $("#button_table").on("click",function(){
        $(".game_table").show();
        $(".img_2d").hide();
        $(".img_3d").hide();
    })
    $("#button_2d").on("click",function(){
        $(".game_table").hide();
        $(".img_2d").show();
        $(".img_3d").hide();
    })
    $("#button_3d").on("click",function(){
        $(".game_table").hide();
        $(".img_2d").hide();
        $(".img_3d").show();
    })
</script>

</body>
</html>