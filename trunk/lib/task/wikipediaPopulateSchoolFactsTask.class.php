<?php

class wikipediaPopulateSchoolFactsTask extends sfBaseTask
{
	protected function configure()
	{
		$this->addOptions(array(
		new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
		new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
		new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
		// add your own options here
		));

		$this->namespace        = 'wikipedia';
		$this->name             = 'populateSchoolFacts';
		$this->briefDescription = 'Looks up people in dbpedia and finds out what school they went to and adds this as a fact';
		$this->detailedDescription = <<<EOF
The [wikipedia:populateSchoolFacts|INFO] task does things.
Call it with:

  [php symfony wikipedia:populateSchoolFacts|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array())
	{
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

		$creator = PluginsfGuardUserTable::retrieveByUsername('isc_bot');
		$fact_type = Doctrine::getTable('FactType')->findOneByType('Education');
		$source_type = Doctrine::getTable('SourceType')->findOneByType('Website');
		$school_entity_type = Doctrine::getTable('EntityType')->findOneByTitle('School/University');

		if (!$creator) {
			throw new sfCommandException("Couldn't find isc_bot user.");
		}

		if (!$fact_type) {
			throw new sfCommandException("Couldn't find 'Education' fact type.");
		}

		if (!$source_type) {
			throw new sfCommandException("Couldn't find 'Published article' source type.");
		}

		if (!$school_entity_type) {
			throw new sfCommandException("Couldn't find 'School/University' entity type.");
		}
		//Retrieve all people who have a wikipedia page URL
		$q = Doctrine_Query::create()
		->select('e.id, e.name, eu.url')
		->from('Entity e, e.EntityType et, e.Urls eu')
		->where('et.title = ?', 'Person')
		->andWhere('eu.title = ?', 'Wikipedia page')
		->orderBy('e.name');

		$people = $q->fetchArray();

		foreach ($people as $person) {
	
			//Need wikified name to use as key in JSON query later on
			$wikifiedName = str_replace("http://en.wikipedia.org/wiki/", "", $person['Urls'][0]['url']);
			$wikipediaUrl = $person['Urls'][0]['url'];
			$dbpediaUrl = str_replace("http://en.wikipedia.org/wiki/", "http://dbpedia.org/data/", $wikipediaUrl);
			$dbpediaJsonUrl = $dbpediaUrl . '.json';
				
			print 'Requesting ' . $dbpediaJsonUrl . " ...\n";

			$personObject = json_decode(file_get_contents($dbpediaJsonUrl));

			$almaMaterUrl = $personObject->{'http://dbpedia.org/resource/' . $wikifiedName}
			->{'http://dbpedia.org/property/almaMater'}[0]
			->{'value'};

			if ($almaMaterUrl) {

				print 'Alma mater URL is ' . $almaMaterUrl . ".\n";

				//to get data, we need to replace the "string" resource with the string "data"
				$almaMaterJsonUrl = str_replace('resource', 'data', $almaMaterUrl) . '.json';

				print 'Requesting ' . $almaMaterJsonUrl . "...\n";

				$almaMaterObject = json_decode(utf8_encode(file_get_contents($almaMaterJsonUrl)));

				if ($almaMaterObject) {
					$almaMaterName = $almaMaterObject->{$almaMaterUrl}->{'http://dbpedia.org/property/name'}[0]->{'value'};
				}
				else {
					//If almaMaterObject is null it probably means that invalid JSON is being received
					//from DBPedia. If this is the case we can try to guess the name of the school...
					$almaMaterName = str_replace('http://dbpedia.org/resource/', '', $almaMaterUrl);
					$almaMaterName = str_replace('_', ' ', $almaMaterName);
					$almaMaterName = str_replace('%27', "'", $almaMaterName);
					$almaMaterName = str_replace('%2C', ",", $almaMaterName);
				}


				if($almaMaterName) {

					print 'Alma mater is named ' . $almaMaterName . ".\n";

					$schoolEntity = Doctrine::getTable('Entity')->findOneByName($almaMaterName);

					if (empty($schoolEntity)) {

						$schoolEntity = new Entity;
						$schoolEntity->set('entity_type_id', $school_entity_type['id'])
						->set('name', $almaMaterName)
						->set('created_by', $creator['id'])
						->set('version_comment', 'Alma Mater')
						->set('description', $almaMaterName . ' is an alma mater according to dbpedia');
						$schoolEntity->save();

						print "Added " . $almaMaterName . " to entities.\n";
					}
					else {
						print "An Entity named $almaMaterName already exists.\n";
					}


					//Need to check if fact already added!
					$factQuery = Doctrine_Query::create()
					->select('f.*')
					->from('Fact f')
					->Where('f.entity_id= ?', $person['id'])
					->andWhere('f.related_entity_id= ?', $schoolEntity['id']);

					$fact = $factQuery->fetchArray();

					if (empty($fact)) {
						$fact = new Fact;
						$fact->set('entity_id', $person['id']);
						$fact->set('related_entity_id', $schoolEntity['id']);
						$fact->set('title', 'attended');
						$fact->set('description', $person['name'] . ' was educated at ' . $almaMaterName);
						$fact->set('created_by', $creator['id']);
						$fact->set('fact_type_id', $fact_type['id']);
						$fact->save();

						// Fact source
						$fs = new FactSource;
						$fs->set('fact_id', $fact['id'])
						->set('url', $url)
						->set('SourceType', $source_type)
						->set('is_supporting', true)
						->set('title', 'Wikipedia Page')
						->set('Creator', $creator);

						$fs->save();

						print "Added fact: " . $person['name'] . " attended " . $schoolEntity . "\n";

						$fs->free();

						$fact->free();

					}
					else {
						print "Fact already exists\n";
					}
				}
				else {
					print 'Alma mater name not found, probably due to invalid JSON from DBPedia.' . "\n";
				}
			}
			else {
				print 'No alma mater, oh well.' . "\n";
			}

			//sleep for a bit to be nice to dbpedia
			usleep(2000000);
		}
	}
}