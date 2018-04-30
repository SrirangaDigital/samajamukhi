<?php

class dataModel extends Model {

	public function __construct() {

		parent::__construct();
	}

	public function getFilesIteratively($dir, $pattern = '/*/'){

		$files = [];
	    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(rtrim($dir, "/")));
		$regex = new RegexIterator($iterator, $pattern, RecursiveRegexIterator::GET_MATCH);

	    foreach($regex as $file => $object) {
	        
			array_push($files, $file);
	    }

	    sort($files);
	    return ($files);
	}

	public function getIdFromPath($path){

		$id = str_replace(PHY_METADATA_URL, '', $path);
		$id = str_replace('/index.json', '', $id);
		// $id = str_replace('/', '_', $id);
		return $id;
	}

	public function processFulltext($text){

		$text = preg_replace('/\s+/', ' ', $text);
		return $text;
	}

	public function insertProfile($type) {

		$db = $this->db->useDB();
		$collection = $this->db->createCollection($db, constant(strtoupper($type) . '_COLLECTION'));

		$xml = simplexml_load_file(XML_SRC_URL . $type . '.xml');

		foreach ($xml->entry as $entry) {

			$row = [];

			$row['id'] = (string) $entry->name->attributes()['id'];
			$row['name'] = (string) $entry->name;
			if(!empty($entry->period)) $row['period'] = (string) $entry->period;
			$row['bio'] = preg_replace('/<bio>(.*)<\/bio>/su', "$1", $entry->bio->asXML());

			if(isset($entry->works->work)) {
				
				$worksArray = [];
				foreach ($entry->works->work as $work) {

					$eachWork = [];;
					$eachWork['title'] = (string) $work->title;
					if(isset($work->remarks))
						$eachWork['remarks'] = preg_replace('/<remarks>(.*)<\/remarks>/su', "$1", $work->remarks->asXML());

					if((string) $work->attributes()['src'])
						$eachWork['source'] = (string) $work->attributes()['src'];

					array_push($worksArray, $eachWork);
				}
				$row['works'] = $worksArray;
			}
			$result = $collection->insertOne($row);
		}
	}

}

?>
