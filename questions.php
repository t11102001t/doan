<?php
  include('connect.php');

  $sql = $conn->prepare("SELECT * FROM ds_cau_hoi ORDER BY RAND()");
	$sql->execute();
  echo json_encode($sql->fetchAll(PDO::FETCH_ASSOC),JSON_UNESCAPED_UNICODE);
?>