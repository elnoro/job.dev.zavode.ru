<?php
	try  {
		$db = new PDO('mysql:host=localhost;dbname=test', 'root', '1');
		// $arr = $db->query('SELECT * from comments')->fetchAll();
		$query = $db->query('SELECT * from comments');
		while ($row = $query->fetch(PDO::FETCH_ASSOC) ) {
			// Чтобы ключи соответствали указанным в задании
			$arr[$row['id']] = $row;
		}
		$db = null;
	}
	catch ( PDOException $e ){
		echo $e->getMessage();
	}
	
	// Функция-генератор фильтров для array_filter
	function filter_parent($parentId) {
		return function ($elem) use($parentId) {
			return $elem['parent'] == $parentId;
		};
	}
	for ($i = count($arr) - 1 ; $i > 0; --$i) {
		$filtered = array_filter($arr, filter_parent($i));
		if(count($filtered) !== 0) {
			$arr = array_diff_key($arr, $filtered);
			$arr[$i]['children'] = $filtered;
		}
	}
	print_r($arr);
?>
