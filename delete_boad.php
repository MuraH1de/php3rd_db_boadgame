<?php

//1.対象のIDを取得
$id = $_GET['number'];
echo "GET->".$id."<br>";

//2.DB接続します
try {
    //ID:'root', Password: 'root'
    $pdo = new PDO('mysql:dbname=sugoroku;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
}

//3.削除SQLを作成
$stmt = $pdo->prepare('DELETE FROM boad_table WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

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
for($id=1;$id<=$boad_all;$id++){
    if($id != $boad_table[$id-1]["id"]){
        $stmt = $pdo->prepare("UPDATE boad_table SET id = :new WHERE id = :old");
        $stmt->bindValue(':new', $id, PDO:: PARAM_INT);
        $stmt->bindValue(':old', $boad_table[$id-1]["id"], PDO:: PARAM_INT);
        $status = $stmt->execute();
        echo "id->".$id."<br>";
    }
}


//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    header("Location: index.php");
    exit;
}


?>