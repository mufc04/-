<?php


		$dsn='データベース名';

		$user='ユーザー名';

		$password='パスワード';

		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

		$sql = "CREATE TABLE IF NOT EXISTS mission_5_1"
		." ("
		. "id INT AUTO_INCREMENT PRIMARY KEY,"
		. "name char(32),"
		. "comment TEXT,"
		. "date DATETIME,"
		. "pass TEXT"
		.");";

		$stmt = $pdo->query($sql);


	//投稿機能

	if(!empty($_POST["name"])&&(!empty($_POST["comment"])&&(empty($_POST["number"])&&(!empty($_POST["nc_pass"]))))){
											 //名前,コメント,パスワード空でない時、hiddenの編集番号が空の時
		$dsn='データベース名';

		$user='ユーザー名';

		$password='パスワード';

		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

		$name = $_POST["name"]; //名前

		$comment = $_POST["comment"]; //コメント

		$date = date("Y-m-d,H:i:s"); //日付

		$nc_pass = $_POST["nc_pass"]; //名前・コメントのパスワード

		$sql = $pdo -> prepare("INSERT INTO mission_5_1 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");

		$sql -> bindParam(':name', $name, PDO::PARAM_STR);

		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);

		$sql -> bindParam(':date', $date, PDO::PARAM_STR);

		$sql -> bindParam(':pass', $nc_pass, PDO::PARAM_STR);

		$sql -> execute();

	}


	//削除機能

	if(!empty($_POST["delete"])&&(!empty($_POST["delete_pass"]))){ //削除・パスワードが空でない場合

		$dsn='データベース名';

		$user='ユーザー名';

		$password='パスワード';

		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

		$delete = $_POST["delete"]; //削除

		$delete_pass = $_POST["delete_pass"]; //パスワード

		$id = $_POST["delete"];

		$sql = 'delete from mission_5_1 where id=:id and pass=:pass';

		$stmt = $pdo->prepare($sql);

		$stmt -> bindParam(':id', $id, PDO::PARAM_INT);

		$stmt -> bindParam(':pass', $delete_pass, PDO::PARAM_STR);

		$stmt -> execute();

	}


	//編集番号選択

		$edit_num="";

		$edit_name="";

		$edit_com="";

	if(!empty($_POST["edit"])&&(!empty($_POST["edit_pass"]))){

		$dsn='データベース名';

		$user='ユーザー名';

		$password='パスワード';

		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

		$edit=$_POST["edit"]; //編集

		$edit_pass=$_POST["edit_pass"]; //パスワード

		$sql = 'SELECT * FROM mission_5_1';

		$edit_stmt = $pdo->query($sql);

		$edit_results = $edit_stmt->fetchAll();

	foreach ($edit_results as $edit_row){

	if($edit_row["id"] == $edit && $edit_row["pass"] == $edit_pass){

		$edit_num = $edit_row["id"];

		$edit_name = $edit_row["name"];

		$edit_com = $edit_row["comment"];

	}

	}

	}


	//編集実行

	if(!empty($_POST["number"])&&(!empty($_POST["nc_pass"]))){ //hiddenのフォームから送られてくる番号が空でないとき

		$dsn='データベース名';

		$user='ユーザー名';

		$password='パスワード';

		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

		$name=$_POST["name"]; //名前

		$comment=$_POST["comment"]; //コメント
		
		$date=date("Y-m-d,H:i:s"); //日付

		$nc_pass=$_POST["nc_pass"];

		$edit_count=$_POST["number"]; //hiddenの編集番号

		$sql = 'SELECT * FROM mission_5_1';

		$edit_stmt2 = $pdo->query($sql);

		$edit_data = $edit_stmt2->fetchAll();

	foreach ($edit_data as $edit_write){

	if($edit_write["id"] == $edit_count && $edit_write["pass"] == $nc_pass){

		$id = $_POST["number"];

		$sql = 'update mission_5_1 set name=:name,comment=:comment,date=:date where id=:id';

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':name', $name, PDO::PARAM_STR);

		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

		$stmt->bindParam(':date', $date, PDO::PARAM_STR);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		$stmt->execute();

	}

	}

	}

?>

<iDOCTYPE html>

<html lang=ja>

<head>

<title>簡易掲示板</title>

<meta charset="utf-8">

</head>

<body>

<form action="mission_5-1.php" method="post">

<br>

	【投稿フォーム】

	<input type="text" name="name" placeholder="名前" value="<?php echo $edit_name; ?>" >

	<input type="text"name="comment" placeholder="コメント" value="<?php echo $edit_com; ?>" >

	<input type="password" name="nc_pass" placeholder="パスワード">

	<input type="submit" name="submit" value="送信">

	<input type="hidden" name="number" value="<?php echo $edit_num; ?>" >

<br>

<br>

	【削除フォーム】

	<input type="text" name="delete" placeholder="削除対象番号">

	<input type="password" name="delete_pass" placeholder="パスワード">

	<input type="submit" name="send_delete" value="削除">

<br>

<br>

	【編集フォーム】

	<input type="text" name="edit" placeholder="編集対象番号">

	<input type="password" name="edit_pass" placeholder="パスワード">

	<input type="submit" name="send_edit" value="編集">

</form>

</body>

</html>

<?php

	//表示機能

		$dsn='データベース名';

		$user='ユーザー名';

		$password='パスワード';

		$sql = 'SELECT * FROM mission_5_1';
		
		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

		$stmt = $pdo->query($sql);

		$results = $stmt->fetchAll();
	
	foreach ($results as $row){
		
		echo $row['id'].',';
		
		echo $row['name'].',';
		
		echo $row['comment'].',';

		echo $row['date'].'<br>';	

	}

?>

	