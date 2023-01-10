<?php


function printTable(array $data) : void
{	
	for ($i = 0; $i < count($data); $i++) {
		if (!is_array($data[$i])) {
			throw new Exception("Element [$i] should be an array");
		}
		if ($i === 0) {
			continue;
		} else {
			$diff = array_diff_key($data[$i - 1], $data[$i]);
			if (!empty($diff)) {
				throw new Exception("Array keys should be equal, difference between rows " . $i - 1 . " and $i: \"" . implode('", "', array_keys($diff)) . "\"");
			}
		}
	}

	$getCellLength = function (array $arr, int $add = 0) : int {
		$cellLength = 0;
		foreach ($arr as $elem) {
			$len = strlen((string)$elem);
			if ($len > $cellLength) {
				$cellLength = $len;
			}
		}
		return $cellLength + $add;
	};

	$columnsLength = [];
	$tableHeader = sprintf("%3s|", " ");
	foreach (array_keys($data[array_key_first($data)]) as $colName) {
		$columnVal = array_column($data, $colName);
		$columnVal[] = $colName;
		$columnsLength[$colName] = $getCellLength($columnVal, 1);
		$tableHeader .= sprintf(" %-" . $columnsLength[$colName] . "s|", $colName);
	}

	$tableDelimiter = str_repeat('-', array_reduce($columnsLength,
		function (int $prev, int $cur) : int {
			$prev += $cur;
			return $prev;
		}, 0) + 10
	);
	$tableDelimiter = sprintf("%3s", $tableDelimiter);

	$tableBody = "";
	$i = 0;
	foreach ($data as $row) {
		$tableRow = sprintf("%3s|", (string)$i++);
		foreach ($row as $colName => $cellValue) {
			$tableRow .= sprintf(" %-" . $columnsLength[$colName] . "s|", $cellValue);
		}
		$tableBody .= $tableRow . "\n" . $tableDelimiter . "\n";
	}
	
	echo $tableHeader . "\n" . $tableDelimiter . "\n" . $tableBody;
}


$data = [
	[
		'internal_history_id' => '2230893',
		'external_id' => '8615',
		'external_commission' => '0.0005'

	],
	[
		'internal_history_id' => '2230891',
		'external_id' => '2159',
		'external_commission' => '0.0200'

	],
	[
		'internal_history_id' => '2230892',
		'external_id' => '5349',
		'external_commission' => '0.0060'

	],
	[
		'internal_history_id' => '563089',
		'external_id' => '8659',
		'external_commission' => '0.0054'

	],
	[
		'internal_history_id' => '217403',
		'external_id' => '1462',
		'external_commission' => '0.0040'

	],
	[
		'internal_history_id' => '2230883',
		'external_id' => '8859',
		'external_commission' => '0.0008'

	],
	[
		'internal_history_id' => '2230581',
		'external_id' => '5988',
		'external_commission' => '0.0040'

	],
];


try {
	printTable($data);
} catch (Exception $e) {
	echo "Error: " . $e->getMessage() . "\n";
}



