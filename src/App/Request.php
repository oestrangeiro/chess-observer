<?php

	namespace App;

	class Request {
		
		private $context;

		public function __construct(){
			$this->fakingBrowser();
		}

		public function fakingBrowser() {

			$options = array(
						'http' => array(
						'method' => 'GET',
						'header' => "Accept=language: en\n".
									"Cookie: MeusOvos=true\n".
									"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13)"
						)
			);

			$this->context = stream_context_create($options);

		}

		public function getContext(): mixed {
			return $this->context;
		}

	}