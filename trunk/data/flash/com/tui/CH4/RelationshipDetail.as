package com.tui.CH4
{	
	import flash.display.MovieClip;
	import flash.display.Shape;
	import flash.xml.*;
	import flash.events.*;
	import flash.text.TextFieldAutoSize;
	import flash.text.TextFormat;
	import flash.ui.Mouse;
	import flash.ui.MouseCursor
	import flash.display.Loader;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.utils.Timer;
	import flash.geom.Rectangle;
	import flash.net.navigateToURL;


	public class RelationshipDetail extends MovieClip
	{					
		// PROPERTIES
		const LOAD_BASE:String = "/entities/ENTA/connections/ENTB.xml";
		var loader:URLLoader;
		var numconnections:int;
		var myXML:XML;
		var currentconnection:int;
		var pointer:Shape;
		var descriptionCurrent:Boolean;		// there are two text fields (to do the sliding on prev/next)
											// this is set true if the current text field is "description"
											// and not "descriptionb"
											
		public var pointerLeft:Boolean;
		
		private var IDA:int;
		private var IDB:int;
		
		
		// constructor: a = the ID of the first entity, b = the ID of the second entity
		public function RelationshipDetail(a:int, b:int)
		{
			sortTextFieldLinks();

			numconnections = 0;
			nameA.text = "";
			nameB.text = "";
			posA.text = "";
			posB.text = "";
			description.text = "";
			descriptionCurrent = true;

			IDA = a;
			IDB = b;

			prevbutt.visible = false;
			nextbutt.visible = false;

			description.y=31;
			descriptionb.y=31;

			pointerLeft = true;

			if(a > -1)
			{
				loader = new URLLoader();
				// attempt to load the XML
				loader.addEventListener(Event.COMPLETE, showInfo);
				
				var theURL:String = LOAD_BASE;
				theURL = theURL.replace("ENTA", a);
				theURL = theURL.replace("ENTB", b);
								
				//loader.load(new URLRequest(LOAD_BASE + "a=" + a + "&b=" + b));
				loader.load(new URLRequest(theURL));
			}
			
			
		}
		
		
		
		
		private function clickName(e:MouseEvent):void
		{
			var url:String = "/entities/";
			url += (e.currentTarget.name == "nameA") ? IDA : IDB;
			var request:URLRequest = new URLRequest(url);
			try {
				navigateToURL(request, "_self"); // second argument is target
			} catch (e:Error) { }
		}

		private function linkMouseOver(e:MouseEvent):void
		{
			Mouse.cursor = MouseCursor.BUTTON;
		}
		private function linkMouseOut(e:MouseEvent):void
		{
			Mouse.cursor = MouseCursor.AUTO;
		}


		private function sortTextFieldLinks():void
		{
			var format:TextFormat = nameA.getTextFormat();
			format.underline = true;
			nameA.setTextFormat(format);
			nameA.defaultTextFormat = format;
			
			format = nameB.getTextFormat();
			format.underline = true;
			nameB.setTextFormat(format);
			nameB.defaultTextFormat = format;
			
			nameA.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOver);
			nameB.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOver);
			
			nameA.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOut);
			nameB.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOut);
			
			nameA.addEventListener(MouseEvent.CLICK, clickName);
			nameB.addEventListener(MouseEvent.CLICK, clickName);
		}

		
		

		
		private function showImage(inURL:String, inX:int)
		{
			var imageLoader:Loader = new Loader();
			configureListeners(imageLoader.contentLoaderInfo);
			var image:URLRequest = new URLRequest(inURL);
			imageLoader.load(image);
			imageLoader.mouseEnabled = false;
			addChild(imageLoader);
			imageLoader.x = inX;
			imageLoader.y = 5;
		}
		
	    private function configureListeners(dispatcher:IEventDispatcher):void {
            dispatcher.addEventListener(Event.COMPLETE, scaleImage);
            dispatcher.addEventListener(HTTPStatusEvent.HTTP_STATUS, httpError);
            dispatcher.addEventListener(IOErrorEvent.IO_ERROR, imageError);
        }


		private function hideAnims():void
		{
			loadanimA.visible = false;
			loadanimB.visible = false;
		}


		// silent event handlers
		private function imageError(e:ErrorEvent):void	{ hideAnims(); }
		private function httpError(e:HTTPStatusEvent):void { hideAnims(); }



		public function setPointer():void
		{
			var arrowXSize:int = 9;	// how many pixels does the arrow stick out?
			var arrowYSize:int = 8; // how many pixels EITHER SIDE of the point is this arrow?
		
			var startX:Number = (pointerLeft) ? 1 : (this.width-2.2);
			var xOffset:int = (pointerLeft) ? 0-(arrowXSize+2) : arrowXSize;
			
			pointer = new Shape();
			pointer.graphics.lineStyle(3,0xFFFFFF,1);
			pointer.graphics.beginFill(0xFFFFFF,1);
			
			var commands:Vector.<int> = new Vector.<int>(4, true);
			commands[0] = 1;
			commands[1] = 2;
			commands[2] = 2;
			commands[3] = 2;
			
			var coord:Vector.<Number> = new Vector.<Number>(8, true);
    		coord[0] = startX + xOffset;
    		coord[1] = 0; 
    		coord[2] = startX; 
    		coord[3] = 0-arrowYSize; 
    		coord[4] = startX; 
    		coord[5] = arrowYSize; 
    		coord[6] = startX + xOffset;
    		coord[7] = 0;

			pointer.graphics.drawPath(commands, coord);
			pointer.graphics.endFill();		
			
			pointer.graphics.lineStyle(3,0x999999,1);		
			
			pointer.graphics.moveTo(startX-0.5,0-arrowYSize);
			pointer.graphics.lineTo(startX+xOffset+1,0);
			pointer.graphics.lineTo(startX-0.5,arrowYSize);
			
			pointer.x = 0;
			pointer.y = 60;
			
			this.addChild(pointer);
		}

		
		
		
		private function scaleImage(e:Event):void
		{
			hideAnims();
			
			var l:Loader = e.target.loader;
			
			//var MAX_HEIGHT = 65;
			var MAX_HEIGHT = 100;
		
			if(l.height > MAX_HEIGHT)
			{
				var ratio:Number = (l.width/l.height);
				l.height = MAX_HEIGHT;
				l.width = MAX_HEIGHT*ratio;
			}
			
			//if(l.x > 100) {
				//l.x = 400-l.width;
			//}
				
			l.x -= int(l.width*0.5);
				
			//this.swapChildren(nextbutt, l);
			//this.swapChildren(prevbutt, l);
		}



		private function showInfo(e:Event):void
		{
			myXML = new XML(loader.data);
						
			// TODO: Check results
			
			numconnections = myXML.connection.length();
			currentconnection = 0;
		
			nameA.text = myXML.connection.entity[0].@name
			posA.text = myXML.connection.entity[0].position;
			
			
			if(nameA.text.length > 28) nameA.text = nameA.text.substr(0,28) + "...";
			if(nameB.text.length > 28) nameB.text = nameB.text.substr(0,28) + "...";
			
			
			nameB.text = myXML.connection.entity[1].@name
			posB.text = myXML.connection.entity[1].position;

			description.text = myXML.connection[0].description;

			showImage(myXML.connection[0].entity[0].photourl, 45);
			showImage(myXML.connection[0].entity[1].photourl, 325);

			if(numconnections > 1)
			{
				conninfo.text = "1 of " + numconnections + " connections";
				prevbutt.addEventListener(MouseEvent.CLICK, PrevNext);
				nextbutt.addEventListener(MouseEvent.CLICK, PrevNext);
				
				prevbutt.visible = true;
				nextbutt.visible = true;
			}
			description.autoSize = TextFieldAutoSize.CENTER;
		}
		


		private function stopMouseDownProp(e:MouseEvent):void
		{
			e.stopImmediatePropagation();
		}


		
		
		private function PrevNext(e:MouseEvent):void
		{			
			e.stopImmediatePropagation();

			// which textfield should we set
			var newdesc:TextField  = (descriptionCurrent) ? descriptionb : description;
			var olddesc:TextField  = (descriptionCurrent) ? description : descriptionb;

			// increment or decrement currentconnection based on which button fired this 
			// handler
			if(e.currentTarget.name == "prevbutt")
			{
				currentconnection--;
				if(currentconnection < 0) currentconnection = numconnections-1;
			}
			else
			{
				currentconnection++;
				if(currentconnection == numconnections) currentconnection = 0;
			}

			// then set the fields.
			newdesc.text = myXML.connection[currentconnection].description;
			conninfo.text = (currentconnection+1) + " of " + numconnections + " connections.";
			
			var r:Rectangle = new Rectangle(0,0,newdesc.width,olddesc.width);
			olddesc.scrollRect = r;
			if(e.currentTarget.name == "prevbutt") 
			{
				r.offset(r.width,0);
			}
			else
			{
				r.offset(0-r.width,0);
			}
			newdesc.scrollRect = r;
			
			prevbutt.removeEventListener(MouseEvent.CLICK, PrevNext);
			nextbutt.removeEventListener(MouseEvent.CLICK, PrevNext);

			var t:Timer = new Timer(10);
			t.addEventListener(TimerEvent.TIMER, shiftDescriptions);
			t.start();
		}
		
		
		
		
		
		
		private function shiftDescriptions(e:TimerEvent):void
		{
			var newdesc:TextField  = (descriptionCurrent) ? descriptionb : description;
			var olddesc:TextField  = (descriptionCurrent) ? description : descriptionb;
			
			// is this a previous or next shift?
			var directionPrev:Boolean = (newdesc.scrollRect.x > 0);
			
			var SHIFT_AMOUNT:int = 8;
			
			var rN:Rectangle = newdesc.scrollRect;
			var rO:Rectangle = olddesc.scrollRect;
			
			if(directionPrev)
			{
				rN.offset(0-SHIFT_AMOUNT, 0);
				rO.offset(0-SHIFT_AMOUNT, 0);
			}
			else
			{
				rN.offset(0+SHIFT_AMOUNT, 0);
				rO.offset(0+SHIFT_AMOUNT, 0);
			}
			
			newdesc.scrollRect = rN;
			olddesc.scrollRect = rO;
			

			// check if we need to stop
			if(((directionPrev)&&(rN.x <= 0))||((!directionPrev)&&(rN.right <= 0)))
			{
					rN.x = 0;
					newdesc.scrollRect = rN;					// set the position properly
					descriptionCurrent = !descriptionCurrent;	// switch descriptionCurrent
					e.currentTarget.stop();						// stop the timer

					// and allow clicks to the prev/next arrows again
					prevbutt.addEventListener(MouseEvent.CLICK, PrevNext);
					nextbutt.addEventListener(MouseEvent.CLICK, PrevNext);
					prevbutt.addEventListener(MouseEvent.MOUSE_DOWN, stopMouseDownProp);
					nextbutt.addEventListener(MouseEvent.MOUSE_DOWN, stopMouseDownProp);

			}
		}
	}

}