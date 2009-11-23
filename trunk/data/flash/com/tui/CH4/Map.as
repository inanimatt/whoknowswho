package com.tui.CH4
{	
	import flash.display.Sprite;	
	import flash.display.Shape;
	import com.tui.CH4.Blob;
	import com.tui.CH4.Relationship;
	import flash.utils.Timer;
	import flash.events.TimerEvent;
	import flash.geom.Rectangle;
	import flash.events.*;
	import flash.geom.Point;
	import flash.geom.Vector3D;
	import flash.ui.Mouse;
	import flash.ui.MouseCursor;
	import flash.events.Event;
	import flash.display.Loader;
	import flash.net.URLRequest;
	import flash.xml.XMLNode;
	
	// for testing
	import flash.utils.getTimer;



	public class Map extends Sprite
	{					
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// properties

		const STAGE_WIDTH:int = 900;		// viewable width of the stage
		const STAGE_HEIGHT:int = 690;		// viewable height of the stage
		var MAX_BLOBS:int = 350;			// how many blobs will we allow on one map?
		var X_CENTRE:int = 470;				// the centre point (X axis)
		var Y_CENTRE:int = 365;				// the centre point (Y axis)
		var MAX_RADIUS:int = 270;			// how wide can our radius be?
		const MIN_RADIUS:int = 150;			// how close to the main blob can blobs get?

		private var fadeTimer:Timer;		// a timer used for fading the blobs/connections
		private var currentAlpha:Number;	// the current transparency level - used when fading
		private var currentMainPos:Number;  // when switching blobs, this is used to animate the new blob
											// into the centre. See "switchMainBlob" below
	
		// our two main arrays. Vectors offer better performance than arrays.
		private var blobs:Vector.<Blob>;				// our blobs (entities). See "Blob.as"
		private var connectors:Vector.<Relationship>;	// our conenctors (relationships). See "Relationship.as"
		
		private var mainBlob:Blob;			// our central blob
		private var isMouseDown:Boolean;	// is the mouse down at the moment?
		private var dragPoint:Point;		// a drag point to check against when dragging the map around
		private var eDetail:EntityDetail;	// our pop-up for when a blob is clicked. It's in the library.
											// Also, see "EntityDetail.as"
											
		private var rDetail:RelationshipDetail;	// our pop-up for when a connector is clicked. It's in the library.
												// Also, see "RelationshipDetail.as"
											
		private var pi:Number = Math.PI; 	// used for performance optimisation. Grabbing from local var much faster
		private var blobslength:int;		// used to increase loop performance. The length of the blobs vector
		private var connectorslength:int;	// ditto for connectors
//		private var aspectRatio:Number = STAGE_WIDTH/STAGE_HEIGHT;
		private var aspectRatio:Number = 1;

		private var backSprite:Sprite;		// used as a hitArea for the map - never visible.
		private var isSmall:Boolean;
		public var largeMapURL:String;		// in the small map, the URL for the large map
		private var bigImage:Loader;
		private var spot:Shape;
		public var bigImageOK:Boolean;		// in the small map we'll hide the speech bubble if the big image is bad
				
	
		private var timer:int;				// for testing only
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// CONSTRUCTOR
		public function Map(inXCentre:int, inYCentre:int, inIsSmall:Boolean = false)
		{
			X_CENTRE = inXCentre;
			Y_CENTRE = inYCentre;
			
			isSmall = inIsSmall;	// is this the small version of the map or the full one?
			
			// set up the entityDetail and relationshipDetail MovieClips
			if(!isSmall)
			{
				eDetail = new EntityDetail(-1);
				rDetail = new RelationshipDetail(-1,-1);
			}
		
			// prepare the timer only once
			fadeTimer = new Timer(40);
			fadeTimer.addEventListener("timer", timerHandler);

			// set some initial vars
			isMouseDown = false;	// the mouse is not currently down
			currentAlpha = 1;		// no transparency yet
			bigImageOK = false;		// no big image loaded yet
			
			
			// backSprite is used to provide a large hit area for the overall map
			backSprite = new Sprite();
			backSprite.graphics.beginFill(0x000000, 1);
			backSprite.graphics.drawRect(-1000,-1000,2000,2000);
			backSprite.graphics.endFill();
			backSprite.visible = false;
			backSprite.mouseEnabled = false;
			this.addChild(backSprite);
			this.hitArea = backSprite;			
						
			// we don't need to show so many blobs for the small map
			if(isSmall) MAX_BLOBS = int(MAX_BLOBS * 0.5);
		}
		


		








		// loads an image of the main entity for this map (but only if the map is a small version)
		public function loadImage(inURL:String):void
		{	
			var newURL:String = inURL;
			if(newURL.indexOf("/mid/") > 0)
			{
				newURL = newURL.replace("mid", "large");
			}
		
			bigImage = new Loader();
			bigImage.contentLoaderInfo.addEventListener(Event.COMPLETE, completeImage);
			bigImage.contentLoaderInfo.addEventListener(SecurityErrorEvent.SECURITY_ERROR, imageError);
			bigImage.contentLoaderInfo.addEventListener(HTTPStatusEvent.HTTP_STATUS, httpError);
			bigImage.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR, imageError);
			
			var imagedata:URLRequest = new URLRequest("http://wkw.c4tech.co.uk" + newURL);
			bigImage.load(imagedata);		
			addChild(bigImage);
		}
		
		// silent event handlers
		private function imageError(e:ErrorEvent):void	{ }
		private function httpError(e:HTTPStatusEvent):void { }

		
		// called when the image for this blob is completely loaded
		private function completeImage(e:Event):void
		{
			var l:Loader = e.target.loader;
			var MAX_HEIGHT = 200;
			
			if(l.height > MAX_HEIGHT)
			{
				var ratio:Number = (l.width/l.height);
				l.height = MAX_HEIGHT;
				l.width = MAX_HEIGHT*ratio;
			}
			
			// place the image
			l.x = 85-int(l.width*0.5);
			l.y = Y_CENTRE - int(l.height*0.5);
			
			// make the spotlight for this image
			spot = new Shape();
			spot.graphics.beginFill(0xFFFFFF,0.35);
			spot.graphics.drawEllipse(0,0,230,90);
			spot.graphics.endFill();
			
			spot.x = -35;
			spot.y = l.y + l.height - 72;
			
			bigImageOK = true;
			
			this.addChildAt(spot, this.getChildIndex(l));
		}
		
		
		
		
	




		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// returns the difference between the minimum and maximum distances of the entities in the XML
		private function getMinAndDelta(inXMLList:XMLList):Point
		{
			var dMin:int, dMax:int, d:int;
			
			// initialise the min and max
			dMin = 100000;
			dMax = 0;
			
			// get the length. Storing it in a loval var is quicker for the loop
			var mylen = inXMLList.length();
			
			// loop through, setting the min/max
			for(var i:int=0;i<mylen;i++)
			{
				// get the distance number for this entity
				d = int(inXMLList[i].@d);
				
				if(d < dMin) dMin = d;	// check for minimum
				if(d > dMax) dMax = d;	// check for maximum
			}
			
			return new Point(dMin, dMax-dMin);
			
			// avoid divide by zero here by returning the max figure instead of zero.
			//return (dMax - dMin == 0) ? dMax : dMax - dMin;
		}











		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Receives a gobbet of XML for this entity, and draws the map
		public function loadEntity(inData:String):void
		{			
			// prepare our XML
			var mapXML:XML = new XML(inData);	
						
			// TODO: Check it's OK			
						
			var list:XMLList = mapXML.entities.ent;

			// set the length in a local variable
			var mylen = list.length();
			
			// we'll set the MAX_RADIUS based on the number of items in the map. The more, 
			// the bigger the max-radius
			if(mylen > 50) MAX_RADIUS += ((mylen)-50);
			
			
			/*******  NEW CODE  **************/
			
			// .x is the minimum distance. .y is the delta between min and max
			var infoPt:Point = getMinAndDelta(list);
			
			// give divide-by-zero the slip
			if(infoPt.y == 0) infoPt.y = 1;
			
			// the radius delta - the difference between min and max radii
			var rDelta:int = MAX_RADIUS - MIN_RADIUS;
			
			// this is the pixel distance of each distance "step"
			var pxDist:int = rDelta / infoPt.y;
	
			/*******  NEW CODE  **************/
			

			blobs = new Vector.<Blob>();
			
			// if this is a small version of the map, show the big image
			if(isSmall) {
				loadImage(mapXML.entities.main.photourlbig);
				largeMapURL = mapXML.entities.main.largemap;
			}
			
			
			////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////
			
			// Make the main blob...
			prepareMainBlob(mapXML.entities.main.@n, 
							mapXML.entities.main.@id, 
							mapXML.entities.main.@t,
							mapXML.entities.main.photourl);
			
			////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////


			// don't allow more than MAX_BLOBS to be shown
			if(mylen > MAX_BLOBS) mylen = MAX_BLOBS;
			
			// Add all entities (blobs)
			var thetaInc:Number = 360/mylen;
			var theta:Number = 0;

			for(var i:int=0;i<mylen;i++)
			{
				// normalise the distance (radius) into the min and max radii for our map
				var entd:int = MIN_RADIUS + (rDelta - (((int(list[i].@d)-infoPt.x) * pxDist)));
				
				makeBlob(list[i].@n,
						 list[i].@id,
						 entd,
						 list[i].@t,
						 list[i].@c,
						 theta);
				theta += thetaInc;
			}

			// set blobslength to speed up loops over this vector
			blobslength = blobs.length;



			////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////
			// Add the connectors

			connectors = new Vector.<Relationship>;

			list = mapXML.connections.conn;
			mylen = list.length();
			// for every blob (except the first - main blob), link to the main blob
			for(i=0;i<mylen;i++)
			{
				makeConnection(list[i].@a,
							   list[i].@b, 
							   list[i].@id,
							   getSimpleConnectionType(list[i].@t));
			}

			// storing in a local variable speeds up for loops
			connectorslength = connectors.length;		
			
			
			setUpMap();			
			
			// let the main flash file know we're done
			this.dispatchEvent(new Event(Event.COMPLETE));
		}


		
		
		
		
		private function setUpMap():void
		{
			// add some event listeners
			this.addEventListener(MouseEvent.MOUSE_DOWN, mapMouseDown);
			this.addEventListener(MouseEvent.MOUSE_UP, mapMouseUp);
				
			if(isSmall) 
			{
				//this.addEventListener(MouseEvent.MOUSE_MOVE, mapMouseMoveSmall);
			}
			else
			{
				this.addEventListener(MouseEvent.MOUSE_MOVE, mapMouseMove);
			}
		}
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// uses the fact_type database tabel fields (hard-coded here) to decide which type of connection this is.
		// It's used when filtering with the check-boxes.
		private function getSimpleConnectionType(inType:int):int
		{
			var outType:int = 0;
			
			switch(inType)
			{
	/*			case 2,5,7,8: // personal
					return 0;
				break;*/
				
				case 1:
					return 1;
				break;
				case 3:
					return 1;
				break;
				case 4:
					return 1;
				break;
				case 9:
					return 1;
				break;
				
				
				/*case 1,3,4,9: // professional
					return 1;
				break; */
				case 6: // educational
					return 2;
				break;
			}
			return outType;
		}
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// returns true if the blobs with the two given indices are already connected	
		private function blobsConnected(inA:int, inB:int):Boolean
		{
			var blobALinks:Vector.<int> = Blob(blobs[inA]).getLinks();
			var linkslength:int = blobALinks.length;
			for(var i:int=0;i<linkslength; i++)
			{
				if(blobALinks[i] == inB) {
					return true;
				}
			}
			
			return false;
		}
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// creates a single connector
		private function makeConnection(blobA:int, blobB:int, id:int, t:int)
		{
			var indexA:int = getBlobIndexFromID(blobA);
			var indexB:int = getBlobIndexFromID(blobB);
			
			if((indexA > -1) && (indexB > -1) && (blobsConnected(indexA, indexB) == false))
			{		
				// link the blobs up
				blobs[indexA].linkWith(indexB);
				blobs[indexB].linkWith(indexA);
				makeBlobConnector(indexA,indexB,id,t);
			}
		}
			
			
			
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// makes a new Blob
		private function makeBlob(inName:String, inID:int, inDistance:int, inType:int, inConnectedness:int, inTheta:Number):void
		{
			var myX:Number;
			var myY:Number;
			var rX:int;
			
			var radians:Number = 0;

			// use inDistance to determine the radius (how far away this blob is from the centre)
			rX = int(inDistance * aspectRatio);	// make an ellipse with X being bigger than Y

			// convert the theta angle from degrees to radians
			radians = (inTheta/180) * pi;

			// work out the coordinates from the radius, radians and centre-points
			myX = rX * Math.cos(radians)+X_CENTRE;
			myY = inDistance * Math.sin(radians)+Y_CENTRE;

			// draw the motherlicker
			drawBlob(myX, myY, inName, inID, inConnectedness, inType);
		}







		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// creates a connector sprite between the two blobs (indexes of the blobs array),
		// and adds it to the connectors array.
		private function makeBlobConnector(blobA:int, blobB:int, inID:int, inType:int):void
		{						
			var con:Relationship = new Relationship(blobs[blobA].x, 
													blobs[blobA].y,
													blobs[blobB].x, 
													blobs[blobB].y);
			
			// set this connection's meaning
			con.rtype = inType;
			
			// and it's db ID
			con.ID = inID;
		
			// make this connector a dashed line if it's not between the main blob and somewhere else
			if((blobA != 0)&&(blobB != 0)) con.isDashed = true;
			
			// let it know the indices of the blobs it's connected to. This will help us to keep them 
			// all nicely linked up as we zoom
			con.startBlobIndex = blobA;
			con.endBlobIndex = blobB;

			// start with it invisible - we'll reveal them after disentanglement
			con.visible = false;

			// add it to the stage
			this.addChildAt(con, 0);
			//this.addChild(con);


			if(!isSmall)
			{
				// set up it's event handlers
				con.addEventListener(MouseEvent.MOUSE_OVER, mouseOverConnector);
				con.addEventListener(MouseEvent.MOUSE_OUT, mouseOutConnector);
				con.addEventListener(MouseEvent.CLICK, clickConnector);
			}
			else
			{
				con.mouseEnabled = false;
			}

			// add this connector index to the blob
			blobs[blobA].addConnector(connectors.length);

			// reciprocal
			blobs[blobB].addConnector(connectors.length);

			// add the connector to the connectors array
			connectors.push(con);
		}







		///////////////////////////////////////////////////////////////////////////////////////////////////////////		
		// sets the main, middle blob up. Called from the constructor
		private function prepareMainBlob(inName:String, inID:int, inType:int, inImageURL:String):void
		{ 
			mainBlob = new Blob(inName, X_CENTRE, Y_CENTRE, 0);
			
			this.addChild(mainBlob);
			
			mainBlob.ID = inID;
			mainBlob.moveTo(X_CENTRE, Y_CENTRE);
			mainBlob.loadImage(inImageURL);			
			
			if(!isSmall)
			//{		
				//mainBlob.addEventListener(MouseEvent.CLICK, clickBlob);
				//mainBlob.addEventListener(MouseEvent.DOUBLE_CLICK, doubleClickBlob);
				//mainBlob.addEventListener(MouseEvent.MOUSE_OVER, mouseOverBlob);
				//mainBlob.addEventListener(MouseEvent.MOUSE_OUT, mouseOutBlob);
			//}
			//else
			//{
				//mainBlob.mouseEnabled = false;
			//}
			
			
			mainBlob.addEventListener(MouseEvent.MOUSE_DOWN, mapMouseDown);
			mainBlob.addEventListener(MouseEvent.MOUSE_UP, mapMouseUp);
				
			if(!isSmall) 
			{
				mainBlob.addEventListener(MouseEvent.MOUSE_MOVE, mapMouseMove);
			}
			
			
			// let this blob know it's position in the array
			mainBlob.myIndex = blobs.length;
			blobs.push(mainBlob);
		}
		
		
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////		
		// searches the list of blobs and returns the index of the first blob with the given ID.
		private function getBlobIndexFromID(inID:int):int
		{
			for(var i:int=0;i<blobslength;i++)
			{
				if(Blob(blobs[i]).ID == inID) return i;
			}
			return -1;
		}
		
		
				
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// Creates the blob and sets it's properties. Called by makeBlob
		private function drawBlob(inX:Number, inY:Number, inName:String, inID:int, inConnectedness:int, inType:int):void
		{
			var b:Blob = new Blob(inName, inX,  inY, inConnectedness); //int(Math.random()*40));
			
			b.doubleClickEnabled = true;
			
			// start invisible - we'll pop them up after they're all done
			b.visible = false;
			
			this.addChildAt(b,0);
			//this.addChild(b);

			b.ID = inID;

			b.moveTo(inX, inY);
	
			if(!isSmall)
			{
				b.addEventListener(MouseEvent.CLICK, clickBlob);
				b.addEventListener(MouseEvent.DOUBLE_CLICK, doubleClickBlob);
				b.addEventListener(MouseEvent.MOUSE_OVER, mouseOverBlob);
				b.addEventListener(MouseEvent.MOUSE_OUT, mouseOutBlob);
			}
			else
			{
				b.mouseEnabled = false;
				b.doubleClickEnabled = false;
			}
					
			// let this blob know it's position in the array
			b.myIndex = blobs.length;
			
			// then add it to the array
			blobs.push(b);
		}
		
		




		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// One disentanglement pass. We're trying to make sure blobs aren't on top of one another. We run through
		// the blobs array checking whether this blobs bounding rect intersects with any other bounding rects.
		// If they do, we move the rect to the nearest available space with the same radius from the main blob
		private function disentanglePass():int
		{
			var entangledBlobs:int = 100;
			var numTries:int=0;
			
			timer = getTimer();
			
			while((entangledBlobs > 0)&&(numTries < 1))
			{
				entangledBlobs = 0;
				numTries++;
			
				for (var i:int=1;i<blobslength;i++)
				{
					var blob:Blob = blobs[i];
					var brect:Rectangle = blob.bounder;
					var numIntersects:int = numIntersectingRects(brect);

					if(numIntersects > 1)
					{
						entangledBlobs++;
						var newPos:Point = getNearestAvailableTheta(brect);
						blob.moveRect(newPos.x, newPos.y);
					}
				} // for				
			} // while loop
			
	
			return entangledBlobs;
		}
		
		





		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// runs through the blobs, finding intersecting bounding rects, and moving offending blobs around the 
		// circle, looking for space to put it.
		public function disentangleBlobsTheta():void
		{
			
			// firstly set all the rects of all of the blobs. We'll use these as proxies for the blobs,
			// moving them instead of the blobs themselves (for performance reasons)
			for(var i:int=1;i<blobslength;i++)
			{
				blobs[i].bounder = blobs[i].getBounds(this);
				blobs[i].bounder.width += 5;
				blobs[i].bounder.height += 5;
			}
			

			// then start the timer which will do the disentangling but allow the progress bar
			// to tick along
			var disTimer:Timer = new Timer(100,30);
			disTimer.addEventListener(TimerEvent.TIMER, disentangleTimer);
			disTimer.start();
			
			//recalculateConnectors();
			//dispatchEvent(new Event("DisentangleComplete"));	
		}
		
		
		
		



		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// called from "disentangleBlobsTheta" above, runs once every timer tick and does one pass.
		private function disentangleTimer(e:TimerEvent):void
		{
			var entangledBlobs:int = disentanglePass();

			if(entangledBlobs > 5)
			{
				for(var i:int=1;i<blobslength;i++) zoomBlob(Blob(blobs[i]), 20 + entangledBlobs);
			}
			else
			{
				for(i=1;i<blobslength;i++)
				{
					blobs[i].moveTo(blobs[i].bounder.x, blobs[i].bounder.y);
				}
			
				e.target.stop();
				e.target.removeEventListener(TimerEvent.TIMER, disentangleTimer);
				recalculateConnectors();
				dispatchEvent(new Event("DisentangleComplete"));			
			}
		}
		
		
		
	

		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// runs through the number of intersecting rectangles and returns them
		private function numIntersectingRects(brect:Rectangle):int
		{		
			var icount:int = 0;
			for(var i:int=1; i<blobslength; i++)
			{
				if(Rectangle(Blob(blobs[i]).bounder).intersects(brect)) icount++;
				if(icount > 1) break;
			}
			return icount;
		}
		
		
		
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// finds and returns a point that's on the same radius as the input blob, but
		// that will keep the blob out of the way of all other blobs (if possible)
		//private function getNearestAvailableTheta(blob:Blob):Point
		private function getNearestAvailableTheta(r:Rectangle):Point
		{			
			var XDist:Number = r.x - X_CENTRE;
			var YDist:Number = r.y - Y_CENTRE;
			
			var radius:Number = Math.sqrt(XDist*XDist + YDist*YDist);
			var rangle:Number = Math.atan(YDist/XDist);
			
			var newAngle:Number;
			var angleInc:Number = 0.07;
			if(r.x < X_CENTRE) rangle += pi;
			
			for(var i:int = 1; i < 45; i++)
			{
				// go one way
				newAngle = rangle + (angleInc*i);
				r.x = radius*Math.cos(newAngle)+X_CENTRE;
				r.y = radius*Math.sin(newAngle)+Y_CENTRE;
							
				var numIntersects:int = numIntersectingRects(r);				
				if(numIntersects == 1) return new Point(r.x, r.y);
				
				// then go the other way
				newAngle = rangle - (angleInc*i);
				r.x = radius*Math.cos(newAngle)+X_CENTRE;
				r.y = radius*Math.sin(newAngle)+Y_CENTRE;
				
				numIntersects = numIntersectingRects(r);	
				if(numIntersects == 1) return new Point(r.x, r.y);	
			}
			
			return new Point(r.x, r.y);
		}
		
		
		
		
		
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// called from the main flash file after disentanglement. It kicks off a reveal of all of the blobs using
		// a timer and a call to "revealSomeBlobs", below
		public function revealBlobs():void
		{
			var t:Timer = new Timer(30);
			t.addEventListener(TimerEvent.TIMER, revealSomeBlobs);
			t.start();
		}
		
	
		
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		// called from the timer set in "revealBlobs" above. Reveals the right number of blobs based on 
		// how many there are and how many iterations we use.
		private function revealSomeBlobs(e:TimerEvent):void
		{
			var NUM_TICKS = 20;	// how many timer ticks should it take to reveal all
			var NUM_TO_REVEAL:int = int(blobslength / NUM_TICKS);	// how many to reveal altogether
			var revealed:int = 0;	// how many have been revealed in this iteration so far
			var i:int = 1;		// our index to run through the array
			var myBlob:Blob;	// we make a Blob object to bind to the array item
			
			// if there aren't many blobs, sometimes we can not reveal any. This sorts this
			// problem out
			if(NUM_TO_REVEAL < 1) NUM_TO_REVEAL = 1;
			
			// run through until we've reached the end or we've revealed enough blobs
			while((i<blobslength)&&(revealed < NUM_TO_REVEAL))
			{
				// grab the blob at the index of the blobs array
				myBlob = blobs[i] as Blob;
				
				// if it's not yet visible...
				if(!myBlob.visible)
				{
					// make it visible
					myBlob.visible = true;
					showMainConnector(myBlob);
					
					// and increment how many have been made visible in this pass
					revealed++;
				}
				
				i++;	// keep those pesky infinite loops at bay
			}
			
			// if we've got to the end of the array, all of the blobs are now visible.
			if(i==blobslength)
			{
				// we're all done. Stop and remove the timer from memory
				e.currentTarget.stop();
				e.currentTarget.removeEventListener(TimerEvent.TIMER, revealSomeBlobs);
				
				// make sure all of the other connectors are visible
				showRemainingConnectors();
				
				// this is used if the map is small
				if(isSmall) {
					dispatchEvent(new Event("RevealComplete",false,false));
				}
			}
		}
		
		
		
		
		
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////		
		// sets the visible property of the connector connecting this blob to the mainblob to True
		private function showMainConnector(blob:Blob)
		{
			var c:Vector.<int> = blob.getConnections();
			var r:Relationship;
			
			for(var i:int=0; i<c.length;i++)
			{
				r = connectors[c[i]];
		
				if((r.startBlobIndex == 0)||(r.endBlobIndex == 0))
				{
					r.visible = true;
				}
			}
		}
		
		
		
		
		
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////		
		// Makes sure all connectors are visible	
		private function showRemainingConnectors()
		{
			for(var i:int=0;i<connectorslength;i++)
			{
				if(connectors[i].visible == false)	connectors[i].visible = true;
			}
		}
		
		



		
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////		
		// moves a blob closer or further from the centre, based on the amount (px of the hypoteneuse)
		private function zoomBlob(blob:Blob, amount:int):void
		{
			// get the radius using the power of Pythagoras
			var XDist:Number = (blob.bounder.x) - X_CENTRE;
			var YDist:Number = (blob.bounder.y) - Y_CENTRE;

			var r:Number = Math.sqrt(XDist*XDist + YDist*YDist);
				
				
			// alter the radius
			if (r < 0)  r = -r;	// faster than Math.abs();
			r += amount;
			
			// get the angle.
			var rangle:Number = Math.atan(YDist/XDist);			
			if(blob.bounder.x < X_CENTRE) rangle += pi;

			var myX:Number = r*Math.cos(rangle)+X_CENTRE;
			var myY:Number = r*Math.sin(rangle)+Y_CENTRE;
			
			// we have to offset because the X and Y of the blobs are slightly offset. 
			// See Blob.as - moveTo function
			blob.moveRect(myX, myY);
		}
		
		
		
		
		
		
		
		
		private function zoomBlobReal(blob:Blob, amount:int):void
		{
			// get the radius using the power of Pythagoras
			var XDist:Number = (blob.x) - X_CENTRE;
			var YDist:Number = (blob.y) - Y_CENTRE;

			var r:Number = Math.sqrt(XDist*XDist + YDist*YDist);
				
				
			// alter the radius
			if (r < 0)  r = -r;	// faster than Math.abs();
			r += amount;
			
			// get the angle.
			var rangle:Number = Math.atan(YDist/XDist);			
			if(blob.x < X_CENTRE) rangle += pi;

			var myX:Number = r*Math.cos(rangle)+X_CENTRE;
			var myY:Number = r*Math.sin(rangle)+Y_CENTRE;
			
			// we have to offset because the X and Y of the blobs are slightly offset. 
			// See Blob.as - moveTo function
			blob.moveTo(myX, myY);
		}
		
		
		
		
		
		
		
		
		private function highlightBlobAndConnections(blob:Blob):void
		{	
			blob.setHighlight(2);
					
			var links:Vector.<int> = blob.getLinks();
			var linkslength:int = links.length;
			
			for(var i:int=0;i<linkslength;i++)
			{
				blobs[links[i]].alpha = 1;
				blobs[links[i]].setHighlight(1);
			}
			
			// highlight my connections 
			var blobConnectors:Vector.<int> = blob.getConnections();
			linkslength = blobConnectors.length;
			for(i=0;i<linkslength;i++)
			{
				connectors[blobConnectors[i]].setHighlight(true);
			}
		}







		private function resetBlobsAndConnections():void
		{	
			// fade all blobs
			for(var i:int=0;i<blobslength;i++)
			{
				blobs[i].setHighlight(0);
			}
			
			// fade all connectors
			for(i=0;i<connectorslength;i++)
			{
				connectors[i].setHighlight(false);
			}
		}
		
		
		
		////////////////////////////////////////////////////////////////////////////////////////////////////
		// Called over and over to move the selected blob into the centre, and fade out all other blobs		
		private function switchMainBlob(bFirstTime:Boolean):void
		{
			var NUM_STEPS = 10;	

			// if this is the first time, work out the distances that we have to move, and the alpha that we
			if(bFirstTime)
			{	
				// find out how far we are from the centre
				var XDist:Number = (mainBlob.x) - X_CENTRE;
				var YDist:Number = (mainBlob.y) - Y_CENTRE;
				currentMainPos = Math.sqrt(XDist*XDist + YDist*YDist);
								
				fadeTimer.reset();
				fadeTimer.repeatCount = NUM_STEPS-1;
				fadeTimer.start();
			}
			
			var alphaDiff:Number = 1/NUM_STEPS;
			var posDiff:Number = currentMainPos/NUM_STEPS;
			
			currentAlpha -= alphaDiff;
			
			for(var i:int=0; i<blobslength;i++)
			{
				blobs[i].alpha = currentAlpha;
			}
			
			mainBlob.alpha = 1;
			zoomBlobReal(mainBlob, 0 - posDiff);
		}
		
		
		
		
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////

		private function clickBlob(e:MouseEvent):void
		{		
			closeEDetail();
			
			var blob:Blob = e.currentTarget as Blob;
			var b:Rectangle = blob.getBounds(this);
			
			var blobX:Number = b.x +( b.width*0.5);
			var blobY:Number = b.y;
						
			eDetail = new EntityDetail(blob.ID);
			eDetail.addEventListener(MouseEvent.CLICK, eDetailClick);
			eDetail.addEventListener("ChangeBlob", changeMainBlobByID);
			eDetail.removeEventListener(MouseEvent.MOUSE_OVER, defaultCursor);
			eDetail.removeEventListener(MouseEvent.MOUSE_OUT, handCursor);

			eDetail.x = blobX;
			eDetail.y = blobY - 13 - eDetail.height;
			
			eDetail.setName(blob.getName());
		
				
			if(blobX > 650) 
			{
				eDetail.x -= (eDetail.width);
				
				if(blobY < 200) 
				{
					// arrow top right
					eDetail.y = b.bottom + 10;
					eDetail.setArrow(3);
				} 
				else
				{
					// arrow bottom right
					eDetail.setArrow(1);
				}
			}
			else
			{
				if(blobY < 200) 
				{
					eDetail.y = b.bottom + 10;
					eDetail.setArrow(2);
				}
				else
				{
					eDetail.setArrow(0);
				}
			}
			
			highlightBlobAndConnections(blob);
			this.addChild(eDetail);
		}


		private function eDetailClick(e:MouseEvent):void
		{
			//closeEDetail();
		}
		

		private function doubleClickBlob(e:MouseEvent):void
		{		
			var b:Blob = e.currentTarget as Blob;
			changeMapMainBlob(b);
		}
		
		
		// called by the EntityDetail popup dispatching an event - the "View on Map" link has been 
		// clicked. We get the ID of the entity, then find it in the blobs array, then call 
		// chaneMapMainBlob (below) on the right blob, which does the trick.
		private function changeMainBlobByID(e:Event)
		{
			var blobID:int = getBlobIndexFromID(eDetail.ID);
			if(blobID >= 0) changeMapMainBlob(blobs[blobID]);
		}
		
		
		// clears out the stuff and sets off the animation to move the new blob to the centre, and 
		// reload the map around it.
		private function changeMapMainBlob(b:Blob):void
		{
			closeEDetail();

			blobs[0].setHighlight(0);
			
			for(var i:int=0;i<blobslength;i++)
			{
				blobs[i].removeEventListener(MouseEvent.CLICK, clickBlob);
				blobs[i].removeEventListener(MouseEvent.MOUSE_OUT, mouseOutBlob);
				blobs[i].removeEventListener(MouseEvent.MOUSE_OVER, mouseOverBlob);
				blobs[i].removeEventListener(MouseEvent.DOUBLE_CLICK, doubleClickBlob);
			}
			for(i=0;i<connectorslength;i++)
			{
				connectors[i].removeEventListener(MouseEvent.CLICK, clickConnector);
				connectors[i].removeEventListener(MouseEvent.MOUSE_OUT, mouseOutConnector);
				connectors[i].removeEventListener(MouseEvent.MOUSE_OVER, mouseOverConnector);
				
				this.removeChild(connectors[i]);
				connectors[i] = null;
			}
			connectors = new Vector.<Relationship>();
			connectorslength = 0;
			mainBlob = b;
			switchMainBlob(true);		
		}
		
		
		
		
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////
		

		private function mouseOverBlob(e:MouseEvent):void
		{
			if((!this.contains(eDetail))&&(!this.contains(rDetail)))
			{		
				highlightBlobAndConnections(e.currentTarget as Blob);
				Mouse.cursor = MouseCursor.ARROW;
			}
		}
		
		private function mouseOutBlob(e:MouseEvent):void
		{
			if((!this.contains(eDetail))&&(!this.contains(rDetail)))
			{		
				resetBlobsAndConnections();
				Mouse.cursor = MouseCursor.HAND;
			}
		}
		
		private function defaultCursor(e:MouseEvent):void
		{
			Mouse.cursor = MouseCursor.AUTO;
		}
		
		private function handCursor(e:MouseEvent):void
		{
			Mouse.cursor = MouseCursor.HAND;
		}
		
		
		private function clickConnector(e:MouseEvent):void
		{			
			closeEDetail();
			var conn:Relationship = e.currentTarget as Relationship;	
			rDetail = new RelationshipDetail(blobs[conn.startBlobIndex].ID, blobs[conn.endBlobIndex].ID);
			rDetail.addEventListener(MouseEvent.CLICK, eDetailClick);
			rDetail.addEventListener(MouseEvent.MOUSE_OVER, defaultCursor);
			rDetail.addEventListener(MouseEvent.MOUSE_OUT, handCursor);
				
			var r:Rectangle = conn.getBounds(this);

			var xOffset:Number = 0 - this.x ;
			var yOffset:Number = 0 - this.y;

			rDetail.x = xOffset + e.stageX;
			rDetail.y = yOffset + e.stageY-60;

			if(e.stageX > X_CENTRE)
			{
				rDetail.pointerLeft = false;
				rDetail.x -= (rDetail.width + 12);
			}
			else
			{
				rDetail.x += 12;
			}
			rDetail.setPointer();
			this.addChild(rDetail);
		}
		

		
		
		
		
		
		private function mouseOverConnector(e:MouseEvent):void
		{
			var conn:Relationship = e.currentTarget as Relationship;		
			conn.setHighlight(true);
			Mouse.cursor = MouseCursor.ARROW;
			//conn.Draw();
		}
		
		private function mouseOutConnector(e:MouseEvent):void
		{
			var conn:Relationship = e.currentTarget as Relationship;		
			conn.setHighlight(false);
			Mouse.cursor = MouseCursor.HAND;
			//conn.Draw();
		}
		
		
		
		private function timerHandler(event:TimerEvent):void 
		{
			switchMainBlob(false);
			if(fadeTimer.currentCount == fadeTimer.repeatCount)
			{
				// this code is run once the animation is complete
				mainBlob.moveTo(X_CENTRE, Y_CENTRE);
				mainBlob.setHighlight(0);
				
				dispatchEvent(new Event("LoadNewEntity"));
			}
		}
		
	    private function mapMouseDown(e:MouseEvent):void
		{
			if((e.target == this)||(e.currentTarget == mainBlob))
			{		
			
				//this.cacheAsBitmap = true;

			
				//for(var i:int=0;i<connectorslength;i++) connectors[i].visible = false;
			
				dragPoint = new Point(e.stageX,e.stageY);
				isMouseDown = true;
				closeEDetail();
			}
		}




		// if the entity detail panel (or relationship detail panel) is open, close it.
		public function closeEDetail():void
		{
				if(this.contains(eDetail)) 
				{
					eDetail.removeEventListener(MouseEvent.CLICK, eDetailClick);
					eDetail.removeEventListener("ChangeBlob", changeMainBlobByID);
					this.removeChild(eDetail);
					resetBlobsAndConnections();
				}
				if(this.contains(rDetail)) 
				{
					rDetail.removeEventListener(MouseEvent.CLICK, eDetailClick);
					rDetail.removeEventListener(MouseEvent.MOUSE_OVER, defaultCursor);
					rDetail.removeEventListener(MouseEvent.MOUSE_OUT, handCursor);
					this.removeChild(rDetail);
					resetBlobsAndConnections();
				}
		}


	    private function mapMouseUp(e:MouseEvent):void
		{
			//this.cacheAsBitmap = false;
			isMouseDown = false;
			//recalculateConnectors(true);
			//for(var i:int=0;i<connectorslength;i++) connectors[i].visible = true;
		}
		
	    private function mapMouseMove(e:MouseEvent):void
		{
			if((e.currentTarget == this)||(e.currentTarget == mainBlob))
			{
				if((isMouseDown)&&(e.buttonDown))
				{
					// drags the map around the stage
					var p:Point = new Point(e.stageX, e.stageY);				
					this.x += (p.x - dragPoint.x);
					this.y += (p.y - dragPoint.y);
					dragPoint = p;
					
					//optimiseBlobs();
					recalculateConnectors(true);
					
					if(e.currentTarget == mainBlob) e.stopImmediatePropagation();
				}
			}
		}
		
	    private function mapMouseMoveSmall(e:MouseEvent):void
		{
			if(isMouseDown)
			{
				// drags the map around the stage
				var p:Point = new Point(e.stageX, e.stageY);
				
				var xDiff:Number = (p.x - dragPoint.x);
				var yDiff:Number = (p.y - dragPoint.y);
				
				this.x = this.x + xDiff;
				this.y = this.y + yDiff;
				dragPoint = p;
				
				bigImage.x = bigImage.x - xDiff;
				bigImage.y = bigImage.y - yDiff;
				spot.x = spot.x - xDiff;
				spot.y = spot.y - yDiff;	
			}
			
			
			
		}
		
		private function mapMouseClick(e:MouseEvent):void
		{
			// nothing at the mo.
		}
		
		
		
		// make sure the back sprite (used as a hit area for the map) is big enough to cope with the map itself
		public function recalculateBackSprite():void
		{
			this.removeChild(backSprite);
			backSprite = new Sprite();
			backSprite.graphics.beginFill(0x000000, 1);
			backSprite.graphics.drawRect(-1000,-1000,this.width+2000,this.height+2000);
			backSprite.graphics.endFill();
			backSprite.visible = false;
			backSprite.mouseEnabled = false;
			this.addChild(backSprite);	
			this.hitArea = backSprite;
		}
		
		
		public function recalculateConnectors(recalculateFully:Boolean = false):void
		{
			var blobA:Blob;
			var blobB:Blob;
			var blobARect:Rectangle;
			var blobBRect:Rectangle;
			
			for(var i:int=0;i<connectorslength;i++)
			{
				blobA = Blob(blobs[connectors[i].startBlobIndex]);
				blobB = Blob(blobs[connectors[i].endBlobIndex]);
				
				blobARect = blobA.getBounds(this);
				blobBRect = blobB.getBounds(this);
																
				// find out the blobs that this connector is connected to, and recalculate it
				connectors[i].recalculate(blobARect.x + blobARect.width*0.5,
										  blobARect.y + blobARect.height*0.5,
										  blobBRect.x + blobBRect.width*0.5,
										  blobBRect.y + blobBRect.height*0.5);
			}
			
			if(!recalculateFully) recalculateBackSprite();
		}
		




		private function optimiseBlobs():void
		{
			var r:Rectangle;
			for(var i:int=0;i<blobslength;i++)
			{
				r = Blob(blobs[i]).getBounds(this);
				var pos:Point = this.localToGlobal(new Point(r.x,r.y));
				//var top:int = this.localToGlobal(r.y);
				
				if((pos.x < 0)||(pos.y < 0)||(pos.x > STAGE_WIDTH)||(pos.y > STAGE_HEIGHT))
				{
					Blob(blobs[i]).visible = false;
				}
				else
				{
					Blob(blobs[i]).visible = true;
				}
			}
		}






		public function zoomBy(amount:int):void
		{					
			var myAmount:int = amount*3;
			for(var i:int=0;i<blobslength;i++)
			{
				blobs[i].z += myAmount;
				//zoomBlobReal(blobs[i],myAmount);
			}
			recalculateConnectors(true);

			/*for(i=0;i<connectorslength;i++)
			{				
				connectors[i].z += myAmount;
			}*/
		}

		// deals with the filtering of relationships based on their type - triggered by the check-boxes at the top
		public function filter(fOn:Array):void
		{
			var hideConnectors:Vector.<int> = new Vector.<int>();
			
			for(var k:int=0;k<connectorslength;k++) connectors[k].visible = true;
			
			
			for(var i:int=0;i<=2;i++)
			{
				if(fOn.indexOf(i) <= -1)
				{
					// this type should be hidden
					for(k=0;k<connectorslength; k++)
					{
						if(connectors[k].rtype == i)
						{
							hideConnectors.push(k);
							connectors[k].visible = false;
						}
					}				
				}
			} // connector for loop
						
			
			for(i=1;i<blobslength;i++)
			{
				// initially set this blob to true
				blobs[i].visible = true;
				var blinks:Vector.<int> = blobs[i].getConnections();
				var blinkslength = blinks.length;
				
				// we're going to hide this blob if no connectors connected to it are on
				var bStayOn = false;
								
				for(k=0;k<blinkslength;k++)
				{
					if(connectors[blinks[k]].visible)
					{
						// only if this is a connector that's connected to the main entity
						if((connectors[blinks[k]].startBlobIndex == 0)||(connectors[blinks[k]].endBlobIndex == 0))
						{
							bStayOn = true;
							break;
						}
						else
						{
							connectors[blinks[k]].visible = false;
						}
					}
				}
								
				// if after checking the connectors they're all off, hide this blob
				if(!bStayOn) blobs[i].visible = false;
			}
		}
		
		
		
		// find out and return the ID of mainBlob. Called by the base Flash file
		public function getMainBlobID():int
		{
			return mainBlob.ID;
		}
		
		public function clearItems():void
		{
			for(var i:int=0;i<blobslength;i++)
			{
				this.removeChild(blobs[i]);
				blobs[i] = null;
			}
			blobs = new Vector.<Blob>();
			
			this.removeEventListener(MouseEvent.MOUSE_DOWN, mapMouseDown);
			this.removeEventListener(MouseEvent.MOUSE_UP, mapMouseUp);
			this.removeEventListener(MouseEvent.MOUSE_MOVE, mapMouseMove);
		}
		
		
		
		public function clearMainBlob():void
		{
			if(mainBlob)
			{
				this.removeChild(mainBlob);
				mainBlob = null;
			}
		}		
	} // end class
} // end package