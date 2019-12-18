<?php
		
		//投稿機能

	if(!empty($_POST["name"])&&(!empty($_POST["comment"])&&(empty($_POST["number"])&&(!empty($_POST["nc_pass"]))))){
											 //名前,コメント,パスワード空でない時、hiddenの編集番号が空の時
		$name=$_POST["name"]; //名前

		$comment=$_POST["comment"]; //コメント

		$date=date("Y年m月d日H:i:s"); //日付

		$nc_pass=$_POST["nc_pass"]; //名前・コメントのパスワード

		$filename="mission_3-5.txt"; //テキストファイル指定

	if(file_exists($filename)){

		$file=file($filename,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //テキストファイル読み込み

		$num=end($file);

		$part=explode("<>",$num);

		$count=(int)($part[0])+1;

	}else{

		$count=1;

	}
		$fp=fopen($filename,"a");

		$post=$count."<>".$name."<>".$comment."<>".$date."<>".$nc_pass."<>"; //全ての結合

		fwrite($fp,$post."\n");
	
		fclose($fp);

	} //if文終わり


		//削除機能

	if(!empty($_POST["delete"])&&(!empty($_POST["delete_pass"]))){ //削除・パスワードが空でない場合

		$delete=$_POST["delete"]; //削除

		$delete_pass=$_POST["delete_pass"]; //パスワード

		$filename="mission_3-5.txt"; //テキストファイル指定

		$file=file($filename,FILE_SKIP_EMPTY_LINES); //テキストファイル読み込み

		$fp=fopen($filename,"w"); //上書き処理

	for($j=0;$j<count($file);$j++){ //ループ処理

		$delete_post=explode("<>", $file[$j]); //分割

	if($delete_post[0] == $delete && $delete_post[4] == $delete_pass){ //投稿番号とパスワードと削除番号が一致したら

		fwrite($fp,""); //削除処理

	}else{ //一致しない場合

		fwrite($fp,$file[$j]); //何もしない 

	} //if文終わり

	} //for文終わり

		fclose($fp);

	} //if文終わり


		//編集選択

		$edit_num="";

		$edit_name="";

		$edit_com="";

	if(!empty($_POST["edit"])&&(!empty($_POST["edit_pass"]))){  //編集・パスワードが空でない場合

		$edit=$_POST["edit"]; //編集

		$edit_pass=$_POST["edit_pass"]; //パスワード

		$filename="mission_3-5.txt"; //ファイル指定

		$file=file($filename,FILE_SKIP_EMPTY_LINES); //ファイル読み込み

	for($i=0;$i<count($file);$i++){ //ループ処理

		$edit_post=explode("<>", $file[$i]); //分割

	if($edit_post[0] == $edit && $edit_post[4] == $edit_pass){  //投稿番号とパスワードと編集番号が一致したら

		$edit_num=$edit_post[0];

		$edit_name=$edit_post[1];

		$edit_com=$edit_post[2];

	} //if文終わり

	} //for文終わり

	} //if文終わり


		//編集機能

	if(!empty($_POST["number"])&&(!empty($_POST["nc_pass"]))){ //hiddenのフォームから送られてくる番号が空でないとき

		$name=$_POST["name"]; //名前

		$comment=$_POST["comment"]; //コメント
		
		$date=date("Y年m月d日H:i:s"); //日付

		$nc_pass=$_POST["nc_pass"];

		$edit_count=$_POST["number"]; //hiddenの編集番号

		$filename="mission_3-5.txt"; //ファイル指定

		$file= file($filename,FILE_SKIP_EMPTY_LINES); //ファイル読み込み

		$fp=fopen($filename,"w");

	for($T=0;$T<count($file);$T++){ //ループ処理

		$cut=explode("<>",$file[$T]); //分割

	if($cut[0] == $edit_count && $cut[4] == $nc_pass){ //編集稿番号とパスワードと投稿番号が等しいとき

		$edit_count = $cut[0];

		fwrite($fp,$edit_count."<>".$name."<>".$comment."<>".$date."<>".$nc_pass."<>"."\n"); //新規書き込み
	
	}else{ //編集番号と投稿番号が等しくないとき
		
		fwrite($fp,$file[$T]);
	
	} //if文終わり

	} //for文終わり

		fclose($fp);

	} //if文終わり

?>

<iDOCTYPE html>

<html lang=ja>

<head>

		<title>mission_3-5</title>

		<meta charset="utf-8">

</head>

<body>


<form action="mission_3-5.php" method="post">

<br>

	【投稿フォーム】

	<input type="text" name="name"placeholder="名前" value="<?php echo $edit_name; ?>" >

	<input type="text"name="comment" placeholder="コメント"value="<?php echo $edit_com; ?>" >

	<input type="password" name="nc_pass" placeholder="パスワード">

	<input type="submit" name="submit" value="送信">

	<input type="hidden" name="number"value="<?php echo $edit_num; ?>" >

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

		$filename="mission_3-5.txt"; //テキストファイル指定
		
		$fp=fopen($filename,"a");

		$file= file($filename,FILE_SKIP_EMPTY_LINES); //ファイルを全て配列に入れる

	foreach($file as $value){ //ループ処理

		$divide=explode("<>",$value); //$valueを分割

		echo $divide[0]. " ";  //ブラウザに表示

		echo $divide[1]. " ";

		echo $divide[2]. " ";


		echo $divide[3]. " <br>";
	
	}

?>
