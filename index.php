<?php
	
	use App\Player;

	require "vendor/autoload.php";

	$listOfPlayers = [
		'inimigodascatraca',
		'anciao_cababom',
		'fibonacci078',
		'thur50'
	];

	$listOfArrays = [];

	foreach ($listOfPlayers as $player){
		$playerObj = new Player($player);
		echo "Coletando estatísticas de '{$player}'\n";
		$listOfArrays[] = $playerObj->returnDataInArray();
	}

	$foo = json_encode($listOfArrays, JSON_PRETTY_PRINT);

	$filePointer = fopen('friends.json', 'w');

	fwrite($filePointer, $foo);

	echo "Arquivo salvo com sucesso!\n";