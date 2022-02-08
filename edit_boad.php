<?php

//1.対象のIDを取得
$id = $_GET['number'];
$bonus = $_GET['bonus'];
$stop_status = $_GET['stop_status'];
$text = $_GET['text'];

//echo "GET->".$id."<br>";

//2.DB接続します
try {
    //ID:'root', Password: 'root'
    $pdo = new PDO('mysql:dbname=sugoroku;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
}



//更新
$stmt = $pdo->prepare("UPDATE boad_table SET bonus = :bonus, stop_status = :stop_status, text = :text WHERE id = :id");
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