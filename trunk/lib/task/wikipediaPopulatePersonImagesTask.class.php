<?php

class wikipediaPopulatePersonImagesTask extends sfBaseTask
{
	protected function configure()
	{
		// // add your own arguments here
		// $this->addArguments(array(
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));

		$this->addOptions(array(
		new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
		new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
		new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'master'),
		// add your own options here
		));

		$this->namespace        = 'wikipedia';
		$this->name             = 'populatePersonImages';
		$this->briefDescription = 'Get images and licences from wikimedia for entities';
		$this->detailedDescription = <<<EOF
The [wikipedia:populatePersonImages|INFO] gets images with appropriate licences from Wikimedia for entities.
Call it with:

  [php symfony wikipedia:populatePersonImages|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array())
	{
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

		$creator = PluginsfGuardUserTable::retrieveByUsername('isc_bot');
		$licences = array(	'Apache-2.0',
							'APACHE-2.0',
							'BSD',
							'cc-by',
							'Cc-by',
							'cc-by-2.0',
							'Cc-by-2.0',
							'cc-by-2.5',
							'Cc-by-2.5',
							'cc-sa',
							'Cc-sa',
							'cc-by-sa',
							'Cc-by-sa',
							'cc-by-sa-2.0',
							'Cc-by-sa-2.0',
							'cc-by-sa-2.5',
							'Cc-by-sa-2.5',
							'FAL',
							'GFDL',
							'GPL',
							'GPL',
							'MIT',
							'MPL',
							'MTL'
		);

		if (!$creator) {
			throw new sfCommandException("Couldn't find isc_bot user.");
		}
		
		//Retrieve all entities that have a wikipedia page URL
		$q = Doctrine_Query::create()
		->select('e.id, e.name, eu.url, f.id, s.id')
		->from('Entity e, e.Urls eu, e.Facts f, f.Stories s')
		->where('e.id IN (311,1729,1803,1924,2861,2985,3109,3111,3112,3113,3114,3115,3120,3126,3128,3129,3130,3131,3132,3135,3138,3139,3140,3141,3142,3143,3144,3145,3147,3148,3149,3153,3155,3160,3161,3164,3167,3170,3171,3172,3173,3174,3175,3176,3177,3180,3184,3188,3189,3190,3194,3195,3196,3207,3208,3210,3211,3213,3217,3228,3229,3230)')
		->andWhere('eu.urltype = ?', 'Wikipedia')
		->orderBy('e.name');
		
		$entities = $q->fetchArray();
		
		foreach ($entities as $entity) {
				
			//Need wikified name to use as key in JSON query later on
			$wikifiedName = str_replace("http://en.wikipedia.org/wiki/", "", $entity['Urls'][0]['url']);
			$wikipediaUrl = $entity['Urls'][0]['url'];
			$dbpediaUrl = str_replace("http://en.wikipedia.org/wiki/", "http://dbpedia.org/data/", $wikipediaUrl);
			
			$dbpediaUrl = str_replace("'", "%27", $dbpediaUrl);
			$dbpediaUrl = str_replace(',', "%2C", $dbpediaUrl);
			
			$dbpediaJsonUrl = $dbpediaUrl . '.json';
			$dbpediaRdfUrl = $dbpediaUrl . '.rdf';
			
			//The json method, sometimes json fails on dbpedia
			print 'Requesting ' . $dbpediaJsonUrl . " ...\n";
			$entityObject = json_decode(file_get_contents($dbpediaJsonUrl));
			//print_r($entityObject->{'http://dbpedia.org/resource/' . $wikifiedName}->{'http://xmlns.com/foaf/0.1/img'});
			$imageUrl = $entityObject->{'http://dbpedia.org/resource/' . $wikifiedName}
			->{'http://xmlns.com/foaf/0.1/img'}[0]
			->{'value'};
			
			if (!$imageUrl) {
				//Try the rdf method for when json is not available
				print 'JSON maybe invalid, requesting ' . $dbpediaRdfUrl . " ...\n";
				$entityRdf = file_get_contents($dbpediaRdfUrl);
				$start = strpos($entityRdf, '<foaf:img');
				$end = strpos($entityRdf, "\"/>",$start);
				$imageUrl = substr($entityRdf, $start, $end-$start);
				$urlChunks = explode("\"",$imageUrl);
				$imageUrl = html_entity_decode($urlChunks[3], ENT_QUOTES, 'utf-8');				
			}

				
			if (($imageUrl) && ($imageUrl != 'utf-8')) {
				print 'Found image: ' . $imageUrl . "\n" ;

				//now need to get license!!!
				$wikimediaPrefix = 'http://commons.wikimedia.org/w/index.php?title=File:';

				$urlChunks = explode("/",$imageUrl);
				$wikimediaUrl = $wikimediaPrefix . urlencode($urlChunks[7]) . '&action=edit';

				print 'wikimedia url: ' . $wikimediaUrl . "\n";
				
				system("wget -q -O /tmp/Dbpedia.html \"$wikimediaUrl\"");

				$wikimediaPage = file_get_contents('/tmp/Dbpedia.html');

				unlink('/tmp/Dbpedia.html');
				
				if ((!$wikimediaPage) || (stristr($wikimediaPage, 'Wikimedia Commons does not yet have a media file called'))) {
					print "No wikimedia page.\n\n";
				}
				else {
					
					//First extract the licence form this morass!!
					$start = strpos($wikimediaPage, 'wpTextbox1');
					$end = strpos($wikimediaPage, '</textarea>',$start);
					$editPage = substr($wikimediaPage, $start, $end-$start);
					
					//get the liicenses from our list
					foreach ($licences as $alicence) {
						if (strstr($editPage, $alicence)) {
							$licence = $alicence;
						}
					}
					
					//Find Author so we can attribute
					$start = strpos($editPage, 'Author');
					
					if ($start) {
						$end = strpos($editPage, "\n",$start);
						$author = substr($editPage, $start, $end-$start);
						$author = str_replace("Author= ", "", $author);
						$author = str_replace("Author=", "", $author);						
					}
				
					print 'Author: ' . $author . "\n";
					print 'Licence: ' . $licence . "\n";
					print 'Image: ' . $imageUrl . "\n";	
					
					//if ($imageUrl && $author && $licence) {
						
						//wow, we got this far, now enter info into DB.						
						$entityDoctrineObject = Doctrine_Manager::getInstance()->getConnection('master')->getTable('Entity')->findOneById($entity['id']);

						$entityDoctrineObject->set('photo_url', $imageUrl)
						->set('photo_caption', $author)
						->set('photo_licence', $licence);
						$entityDoctrineObject->save();
						$entityDoctrineObject->free();

						print 'Added image: ' . $imageUrl . " to database\n\n" ;
						
						unset($imageUrl);
						unset($author);
						unset($licence);
						
					//}
					//else {
					//	print "Sorry, I couldn't find the author or licence for this image\n\n";
					//}
				}
			}
			else {
				print 'Sorry, I found no image for ' . $entity['name'] . "\n\n";
			}

			//sleep for a bit to be nice to dbpedia
			usleep(2000000);
		}
	}
}
