<?php

//1.対象のIDを取得
$id = $_POST['number'];
$bonus = $_POST['bonus'];
$stop_status = $_POST['stop_status'];
$text = $_POST['text'];

echo "GET->".$id."<br>";

//2.DB接続します
try {
    //ID:'root', Password: 'root'
    $pdo = new PDO('mysql:dbname=sugoroku;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
}

//マス数確認
$stmt = $pdo->prepare("SELECT * FROM boad_table");
$status = $stmt->execute();
$boad_all=0;
while($boad_table[] = $stmt->fetch(PDO::FETCH_ASSOC)){
    $boad_all += 1;
    echo "マス->".$boad_all."<br>";
}
//echo $boad_all;


//id更新
for($i=$boad_all;$i>=1;$i--){
    echo "id->".$i."<br>";
    if($i >= $id){
        $stmt = $pdo->prepare("UPDATE boad_table SET id = :new WHERE id = :old");
        $stmt->bindValue(':new', $i+1, PDO:: PARAM_INT);
        $stmt->bindValue(':old', $i, PDO:: PARAM_INT);
        $status = $stmt->execute();
        echo "id更新<br>";
    }
}

//追加
$stmt = $pdo->prepare("INSERT INTO boad_table(id, bonus, stop_status, text)VALUES(:id, :bonus, :stop_status, :text)");
$stmt->bindValue(':id', $id, PDO:: PARAM_INT);
$stmt->bindValue(':bonus', $bonus, PDO:: PARAM_INT);
$stmt->bindValue(':stop_status', $stop_status, PDO:: PARAM_INT);
$stmt->bindValue(':text', $text, PDO:: PARAM_STR);
$status = $stmt->execute();



//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    header("Location: index.php");
    exit;
}


?>