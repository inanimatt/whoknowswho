<?php
	// Russ - Oct 09.  A fake PHP script to produce XML for the Channel4 Map Of Power Flash Map	
	$FIRST_NAMES = array("Russ","Graeme","Anna","Mark","Stuart","Jane","James","Flavia","Alice","Nick","Simon","Edwin","Tom","Richard","Kristina","Darren","Matt","Neil","Jamie","Vicky","Dorothy","Louise","Kevin","Marc");						 
	$LAST_NAMES  = array("Hendy","Crowley","Sherrington-Sorfova","Somerfield","Harrington","Vippond","Wilde","Man","Dryden","Lowman","Coxon","Love","Fletcher","Baker","Elia","Morman","Robinson","Aberdeen","Arnold","Taylor","Byrne","Brown","Sutcliffe","Haefner");

	class Entity
	{
		public $id = -1;
		public $name = "";
		public $distance = 0;
		public $type = 0;
		
		public function __construct($inname, $inid, $indistance, $intype)
		{
			$this->name = $inname;
			$this->id = $inid;
			$this->distance = $indistance;
			$this->type = $intype;
		}
	}	// Entity Class
	
	
	
	// Connection class
	class Connection
	{
		public $id = -1;
		public $a = 0;
		public $b = 0;
		public $type = 0;
		
		public function __construct($inid, $ina, $inb, $intype)
		{
			$this->id = $inid;
			$this->a = $ina;
			$this->b = $inb;
			$this->type = $intype;
		}
	}	// Entity Class

	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MAIN

	$NUM_ENTITIES = 100;		
	$MAX_ENTITIES_ALLOWED = 10000;
	
	$id = 12345;				// TODO: Make the initial entity ID a parameter


	// if querystring includes n=NUMBER, then we can set the number of entities to NUMBER
	if(isset($_GET['n']))
	{	
		// for some reason is_int doesn't play ball. is_numeric doesn't seem to cause trouble though
		$NUM_ENTITIES = (is_numeric($_GET['n'])) ? $_GET['n'] : $NUM_ENTITIES;
		
		// make sure it's not too darned big
		if($NUM_ENTITIES > $MAX_ENTITIES_ALLOWED) $NUM_ENTITIES = $MAX_ENTITIES_ALLOWED;
	}
	
	// if querystring includes id=NUMBER, then we can set the id of the first entity to NUMBER
	if(isset($_GET['id']))
	{	
		// for some reason is_int doesn't play ball. is_numeric doesn't seem to cause trouble though
		$id = (is_numeric($_GET['id'])) ? intval($_GET['id']) : $id;
	}

	$entities = array();
	$connections = array();
	
	for($i=0;$i<$NUM_ENTITIES;$i++)
	{
		$newname = $FIRST_NAMES[rand(0,count($FIRST_NAMES)-1)] . " " . $LAST_NAMES[rand(0,count($LAST_NAMES)-1)];
		$distance = rand(0, 1000);
		$entities[] = new Entity($newname, $id, $distance, rand(0,2));
		// inc the id by some random (but > 0) amount
		$id += rand(1, 5000);
	}
	
	$mainID = $entities[0]->id;
	$id = 1001;
	
	header("Content-type: text/xml");
	print "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
	
	// start the XML
	print "<map>\n\t<entities>\n";
	
	// Write teh entities first (and calculate the connections)
	for($i=0;$i<$NUM_ENTITIES;$i++)
	{
		if($i > 0) 
		{
			// connect this entity to the main (first) one
			$connections[] = new Connection($id, $entities[$i]->id, $mainID, rand(0,2));
			
			// random extra connection every 4 items
			if(($i % 4) == 0) $connections[] = new Connection($id, $entities[$i]->id, $entities[rand(1,$NUM_ENTITIES-1)]->id, rand(0,2));

			$id += rand(1,500);
		}
		
		// write out an entity node
		print ($i==0) ? "\t\t<main" : "\t\t<ent";
		print " id=\"" . $entities[$i]->id;
		print "\" n=\"" . $entities[$i]->name;
		print "\" d=\"" . $entities[$i]->distance;
		print "\" t=\"" . $entities[$i]->type; 
		
		if($i==0) 
		{
			print "\">\n\t<photourl>http://clients.tui.co.uk/channel4/xmlfeed/boris_small.gif</photourl>";
			print "\">\n\t<photourlbig>http://clients.tui.co.uk/channel4/xmlfeed/boz.png</photourlbig>";
			print "\">\n\t<welcome>Yo yo yo, blood. Welcome in here innit with my homies and ting</welcome>";
			print "\n</main>\n";
		}
		else
		{
			print "\" />\n";
		}
	}
	
	print "\t</entities>\n\t<connections>\n";
	
	// write out all of the connections
	for($i=0;$i<count($connections);$i++)
	{
		print "\t\t<conn id=\"" . $connections[$i]->id . "\" a=\"" . $connections[$i]->a;
		print "\" b=\"" . $connections[$i]->b;
		print "\" t=\"" . $connections[$i]->type;
		print "\" />\n";
	}
	
	print "\t</connections>\n</map>";

?>