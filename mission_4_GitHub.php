<?php
// set up required information for database
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

$editNum = $_POST['editNum'];
$passE = $_POST['passwordE'];

if ((!empty($editNum)) && (!empty($passE))) {
	$sql = "SELECT * from myTable WHERE id = $editNum";
	$row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

	if ($row["pass"] == $passE) {
		$valueName = $row["name"];
		$valueCom = $row["comment"];
		$valuePass = $row["pass"];
		$valueNum = $row["id"];
	} 
}


?> 
 

 
 <!DOCTYPE html>
 
 <html lang = "ja">
	<head>
		<meta charset = "UTF-8"> 
		<title>Mission4</title>
	</head>
	<body>
		<form action = "mission_4.php" method = "post">
		<table border = "0">
			<tr>
				<td><input type = "text" name = "name" placeholder = "名前" value = "<?php echo $valueName; ?>"></td>
			</tr>
			<tr>
				<td><input type = "text" name = "comment" placeholder = "コメント" value = "<?php echo $valueCom; ?>"></td>
			</tr>
			<tr>
				<td><input type = "text" name = "password" placeholder = "パスワード" value = "<?php echo $valuePass; ?>"> 
				<button type="submit" style = "color: white; background-color: LightCoral;">送信</button></td>
			</tr>
			<tr>
				<td><input type = "hidden" name = "numToEdit" value = "<?php echo $valueNum; ?>"></td>
			</tr>
			<tr>
				<td height = "10px"></td>
			</tr>
			<tr>
				<td><input type = "text" name = "deleteNum" placeholder = "削除対象番号"></td>
			</tr>
			<tr>
				<td><input type = "text" name = "passwordD" placeholder = "パスワード">
				<button type="submit" style = "color: white; background-color: DarkTurquoise;">削除</button></td>
			</tr>
			<tr>
				<td height = "10px"></td>
			</tr>	
			<tr>
				<td><input type = "text" name = "editNum" placeholder = "編集対象番号"></td>
			</tr>
			<tr>
				<td><input type = "text" name = "passwordE" placeholder = "パスワード">
				<button type="submit" style = "color: white; background-color: DarkSeaGreen;">編集</button></td>
			</tr>
		</table>
		</form>
	</body>
</html>

<?php


// get comment, name and password from input
$comment = $_POST['comment'];
$name = $_POST['name'];
$pass = $_POST['password'];
$deleteNum = $_POST['deleteNum'];
$passD = $_POST['passwordD'];
$valueNum= $_POST['numToEdit'];


// set up required information for database
$dsn = 'mysql:dbname=tt_22_99sv_coco_com;host=localhost';
$user = 'tt-22.99sv-coco.';
$password = 'NBgy6W';
$pdo = new PDO($dsn,$user,$password);


// CREATE A TABLE
$sql = "CREATE TABLE myTable"
."("
."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."pass TEXT"
.")";
$stmt = $pdo->query($sql);


// ADD
if ((!empty($name)) && (!empty($comment)) && (!empty($pass)) && (empty($valueNum))) {
	$date = new DateTime();
	$date = $date->format('Y/m/d H:i:s');

	 // prepare to put data into table
	$sql = $pdo->prepare("INSERT INTO myTable (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
	$sql->bindParam(':name', $nameT, PDO::PARAM_STR);
	$sql->bindParam(':comment', $commentT, PDO::PARAM_STR);
	$sql->bindParam(':date', $date, PDO::PARAM_STR);
	$sql->bindParam(':pass', $passT, PDO::PARAM_STR);
	
	// get comment, name and password from input
	$nameT = $name;
	$commentT = $comment;
	$passT = $pass;
	$sql -> execute();
	
	// SHOW DATE
	$sql = 'SELECT * FROM myTable';
	$results = $pdo->query($sql);
	foreach ($results as $row) {
		// $rowの中にはテーブルのコラムが入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].',';
		echo $row['pass'].'<br>';
	}	
}
	
	
if ((empty($name)) && (empty($deleteNum)) && (empty($editNum))) {
		// SHOW DATE
	$sql = 'SELECT * FROM myTable';
	$results = $pdo->query($sql);
	foreach ($results as $row) {
		// $rowの中にはテーブルのコラムが入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].',';
		echo $row['pass'].'<br>';
	}
}


// DELETE
if ((!empty($deleteNum)) && (!empty($passD))) {
	$sql = "SELECT * from myTable WHERE id = $deleteNum";
	$row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

	if ($row["pass"] == $passD) {
		$sql = "delete from myTable where id=$deleteNum";
		$result = $pdo->query($sql);
		
	// SHOW DATE
		$sql = 'SELECT * FROM myTable';
		$results = $pdo->query($sql);
		foreach ($results as $row) {
			// $rowの中にはテーブルのコラムが入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].',';
			echo $row['date'].',';
			echo $row['pass'].'<br>';
		}
	} else {
		$text = 'パスワードがまちがっています';
		echo $text.'<br>';
		
		// SHOW DATE
		$sql = 'SELECT * FROM myTable';
		$results = $pdo->query($sql);
		foreach ($results as $row) {
			// $rowの中にはテーブルのコラムが入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].',';
			echo $row['date'].',';
			echo $row['pass'].'<br>';
		}
	} 
} 


// EDIT
if ((!empty($editNum)) && (!empty($passE))) {
	$sql = "SELECT * from myTable WHERE id = $editNum";
	$row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

	if ($row["pass"] != $passE) {
		$text = 'パスワードがまちがっています';
		echo $text.'<br>';
	}
	// SHOW DATE
	$sql = 'SELECT * FROM myTable';
	$results = $pdo->query($sql);
	foreach ($results as $row) {
		// $rowの中にはテーブルのコラムが入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].',';
		echo $row['pass'].'<br>';	
	}
}



if ((!empty($name)) && (!empty($comment)) && (!empty($valueNum)) && (!empty($pass))) {
	$date = new DateTime();
	$date = $date->format('Y/m/d H:i:s');
	$sql = "update myTable set name='$name', comment='$comment', date='$date', pass='$pass' where id=$valueNum";
	$result = $pdo->query($sql);
	// SHOW DATE
	$sql = 'SELECT * FROM myTable';
	$results = $pdo->query($sql);
	foreach ($results as $row) {
		// $rowの中にはテーブルのコラムが入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].',';
		echo $row['pass'].'<br>';
	}
}

?>

