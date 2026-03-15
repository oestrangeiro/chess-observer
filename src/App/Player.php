<?php

	namespace App;

	use App\Request;

	class Player {

		private String 	$playerID;
		private String 	$playerName;
		private String 	$dateJoined;
		private String 	$lastTimeOnline;

		// Atributos das rápidas, o resto dos modos é lixo desinteressnte
		private int 	$currentRating;
		private int 	$bestRating;
		private int 	$wins;
		private int 	$loses;
		private int 	$draws;
		private int 	$totalTimesPlayed;
		private int 	$amountOfFollowers;
		private float 	$percentualOfVictories;
		// private $reqObj;
		// private $endpoints;

		public function __construct(String $playerName){

			$this->playerName 	= $playerName;
			$endpoints = [
				'URL_PLAYER_INFO' 	=> 'https://api.chess.com/pub/player/',
				'URL_PLAYER_STATS' 	=> 'https://api.chess.com/pub/player/'
			];
			$reqObj = new Request();

			$this->getPlayerBaseInfo($endpoints['URL_PLAYER_INFO'], $reqObj);
			$this->getPlayerStats($endpoints['URL_PLAYER_STATS'], $reqObj);
		}

		public function getPlayerBaseInfo(String $endpoint, $reqObj){

			$response = file_get_contents(
				$endpoint . $this->playerName,
				false,
				$reqObj->getContext()
			);

			$playerDataJSON = json_decode($response, TRUE);

			$this->setPlayerBaseInfo($playerDataJSON);

		}

		public function setPlayerBaseInfo($playerDataJSON){

			$this->playerID 			= $playerDataJSON['player_id'];
			$this->amountOfFollowers 	= $playerDataJSON['followers'];
			$this->lastTimeOnline 		= $playerDataJSON['last_online'];
			$this->dateJoined 			= $playerDataJSON['joined'];

		}

		public function getPlayerStats(String $endpoint, $reqObj){

			$response = file_get_contents(
				$endpoint . $this->playerName . '/stats',
				false,
				$reqObj->getContext()
			);

			$playerDataJSON = json_decode($response, TRUE);

			$this->setPlayerStats($playerDataJSON);

		}

		public function setPlayerStats($playerDataJSON){

			$this->currentRating 			= $playerDataJSON['chess_rapid']['last']['rating'];
			$this->bestRating 				= $playerDataJSON['chess_rapid']['best']['rating'];
			$this->wins 					= $playerDataJSON['chess_rapid']['record']['win'];
			$this->loses 					= $playerDataJSON['chess_rapid']['record']['loss'];
			$this->draws 					= $playerDataJSON['chess_rapid']['record']['draw'];
			$this->totalTimesPlayed 		= $this->wins + $this->loses + $this->draws;
			$this->percentualOfVictories 	= (float) ($this->wins / $this->totalTimesPlayed);

		}

		public function returnDataInArray(): array{

			$data = [
				'player_id' 	=> $this->playerID,
				'player_name' 	=> $this->playerName,
				'date_joined' 	=> $this->dateJoined,
				'last_time_online' => $this->lastTimeOnline,
				'current_rating' => $this->currentRating,
				'best_rating' => $this->bestRating,
				'wins' => $this->wins,
				'loses' => $this->loses,
				'draws' => $this->draws,
				'total_times_played' => $this->totalTimesPlayed,
				'percentual_of_victories' => round($this->percentualOfVictories, 2) * 100,
				'amount_of_followers' => $this->amountOfFollowers
			];

			return $data;
		}

	}