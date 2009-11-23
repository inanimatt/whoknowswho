package com.tui.CH4
{	
	import flash.display.MovieClip;	
	import flash.display.Shape;
	import flash.xml.*;
	import flash.events.*;
	import flash.text.TextFieldAutoSize;
	import flash.text.TextFormat;
	import fl.controls.ProgressBarDirection;
	import fl.controls.ProgressBarMode;
	import flash.display.Loader;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.navigateToURL;
	import flash.ui.Mouse;
	import flash.ui.MouseCursor

	public class EntityDetail extends MovieClip
	{					
		// PROPERTIES
		const LOAD_BASE:String = "/entities/ENTID/quickinfo.xml";
		private var loader:URLLoader;
		private var pointer:Shape;
		public var ID:int;
		public var myArrowPos:int;

		public function EntityDetail(inID:int)
		{
			entityName.autoSize = TextFieldAutoSize.LEFT;
			entityText.autoSize = TextFieldAutoSize.LEFT;
			connlink.autoSize = TextFieldAutoSize.LEFT;
			
			// interest progress bar
			interest.mode = ProgressBarMode.MANUAL;
			interest.direction = ProgressBarDirection.RIGHT;
			interest.maximum = 100;
			interest.minimum = 0;
			interest.setProgress(0, interest.maximum);

			// connectedness progress bar
			connectedness.mode = ProgressBarMode.MANUAL;
			connectedness.direction = ProgressBarDirection.RIGHT;
			connectedness.maximum = 100;
			connectedness.minimum = 0;
			connectedness.setProgress(0, connectedness.maximum);
			
			entityName.addEventListener(MouseEvent.CLICK, clickName);						
			ID = inID;
									
			maplink.htmlText = maplink.htmlText.replace("http://www.channel4.com","/entities/" + ID + "/map");
			biolink.htmlText = biolink.htmlText.replace("http://www.channel4.com","/entities/" + ID);

			if(inID > -1)
			{
				loader = new URLLoader();
				
				var theURL:String = LOAD_BASE;
				theURL = theURL.replace("ENTID", ID);
				
				// attempt to load the XML
				loader.addEventListener(Event.COMPLETE, showInfo);
				//loader.load(new URLRequest(LOAD_BASE + "id=" + ID));
				loader.load(new URLRequest(theURL));
			}
			
			
			sortTextFieldLinks();
		}
	
	
	
		private function sortTextFieldLinks():void
		{
			var format:TextFormat = connlink.getTextFormat();
			format.underline = true;
			connlink.setTextFormat(format);
			
			format = biolink.getTextFormat();
			format.underline = true;
			biolink.setTextFormat(format);
			
			format = maplink.getTextFormat();
			format.underline = true;
			maplink.setTextFormat(format);
			
			connlink.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOver);
			biolink.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOver);
			maplink.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOver);
			entityName.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOver);
			
			connlink.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOut);
			biolink.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOut);
			maplink.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOut);
			entityName.addEventListener(MouseEvent.MOUSE_OVER, linkMouseOut);
		}
		
		
		
		private function linkMouseOver(e:MouseEvent):void
		{
			Mouse.cursor = MouseCursor.BUTTON;
		}
		private function linkMouseOut(e:MouseEvent):void
		{
			Mouse.cursor = MouseCursor.AUTO;
		}
		
	
	
	
		private function clickName(e:MouseEvent):void
		{
			// METHOD 1: RELOAD PAGE
			var url:String = "/entities/" + ID;
			var request:URLRequest = new URLRequest(url);
			try {
				navigateToURL(request, "_self"); // second argument is target
			} catch (e:Error) { }
		}
	
	
	
		private function setAsMainBlob(e:MouseEvent):void
		{
			e.preventDefault();
			e.stopImmediatePropagation();
			this.dispatchEvent(new Event("ChangeBlob", false, false));
		}
		
		
		
		private function reduceText(intxt:String):String
		{
			var arr:Array = intxt.split(' ');
			
			trace(arr.length);
			
			trace(arr[arr.length-1]);
			
			arr = arr.slice(0, arr.length-1);
			//arr[arr.length-1] = "";
			
			return arr.join(' ') + "...";
		}
		
		
		private function showInfo(e:Event):void
		{
			var rXML:XML = new XML(loader.data);
						
			// TODO: Check results
			
			if(entityName.text == "")
				entityName.text = rXML.@n;
				
						
				
			entityText.text = rXML.position;
			
			
			if(entityName.height < 50)
			{
				entityText.y = entityName.y + (entityName.height-3);
				
				
				
				while((entityText.y + entityText.height > (interest.y - 3))&&(entityText.text.length > 5))
				{
					entityText.text = reduceText(entityText.text);
				}
				
			}
			else
			{
				// entity Name is too large for the sub-title. Hide it
				entityText.visible = false;
			}
			
			showImage(rXML.photourl);
			
			// interest progress bar
			interest.setProgress(rXML.interest, interest.maximum);

			// connectedness progress bar
			connectedness.setProgress(rXML.connectedness, connectedness.maximum);
			
			//trace(connlink.htmlText);
			// say how many connections there are
			connlink.htmlText = connlink.htmlText.replace("connections", rXML.connections.conn.length() + " connections");			
			connlink.htmlText = connlink.htmlText.replace("http://www.channel4.com", "/entities/" + ID + "/connections");				
			connlink.x = maplink.x - (connlink.width + 3);
		}
		
		
		
		
		private function showImage(inURL:String)
		{
			loadanim.visible = true;
			
			var imageLoader:Loader = new Loader();
			configureListeners(imageLoader.contentLoaderInfo);

			var image:URLRequest = new URLRequest(inURL);
			imageLoader.load(image);
			addChild (imageLoader);
			
			imageLoader.x = 44;
			imageLoader.y = 5;

		}
		
		
	    private function configureListeners(dispatcher:IEventDispatcher):void {
            dispatcher.addEventListener(Event.COMPLETE, scaleImage);
            dispatcher.addEventListener(HTTPStatusEvent.HTTP_STATUS, httpError);
            dispatcher.addEventListener(IOErrorEvent.IO_ERROR, imageError);
         }

		// silent event handlers
		private function imageError(e:ErrorEvent):void	{ loadanim.visible = false; }
		private function httpError(e:HTTPStatusEvent):void { loadanim.visible = false; }


		private function scaleImage(e:Event):void
		{
			loadanim.visible = false;
			var l:Loader = e.target.loader;
			
			var MAX_HEIGHT = 100;
			
			if(l.height > MAX_HEIGHT)
			{
				var ratio:Number = (l.width/l.height);
				l.height = MAX_HEIGHT;
				l.width = MAX_HEIGHT*ratio;
			}			
			
			l.x -= int(l.width*0.5);
		}

		
		
		
		
		public function setName(inName:String):void
		{
			entityName.text = inName;
		}
		
		
		public function setArrow(arrowPos:int):void
		{
			var arrowXSize:int = 12;	// how many pixels does the arrow stick out?
			var arrowYSize:int = 12; // how many pixels EITHER SIDE of the point is this arrow?
			var startX:Number;
			var startY:Number;
			var xOffset:int;
			var yOffset:int;
		
			switch(arrowPos)
			{
				case 0: 	// bottom left
					startX = 0;
					startY = this.height - 3;
					//startY = 0;
					xOffset = arrowXSize;
					yOffset = arrowYSize;
				break;
				case 1: 	// bottom right
				
					startX = this.width - 3;
					startY = this.height - 3;
					xOffset = 0-(arrowXSize);
					yOffset = arrowYSize
					
					//arrow.rotationY = 180;
					//arrow.x = 271;
				break;
				case 2: 	// top left
					startX = 0;
					startY = 0;
					xOffset = arrowXSize;
					yOffset = 0-arrowYSize;
					
					//arrow.rotationX = 180;
					//arrow.y = -146;
				break;
				case 3: 	// top right
				
					startY = 0;
					startX = this.width-3;
					xOffset = 0-arrowXSize;
					yOffset = 0-arrowYSize;
					
					//arrow.rotationZ = 180;				
					//arrow.x = 271;
					//arrow.y = -146;
				break;
			}
			
		
				
			pointer = new Shape();
			pointer.graphics.lineStyle(3,0xFFFFFF,1);
			pointer.graphics.beginFill(0xFFFFFF,1);
			
			
			var commands:Vector.<int> = new Vector.<int>(4, true);
			commands[0] = 1;	// move to
			commands[1] = 2;	// line to
			commands[2] = 2;	// line to
			commands[3] = 2;	// line to
			
			var coord:Vector.<Number> = new Vector.<Number>(8, true);
    		coord[0] = startX;
    		coord[1] = startY; 
    		coord[2] = startX; 
    		coord[3] = startY + yOffset; 
    		coord[4] = startX + xOffset; 
    		coord[5] = startY; 
    		coord[6] = startX;
    		coord[7] = startY;

			pointer.graphics.drawPath(commands, coord);
			pointer.graphics.endFill();		
			
			pointer.graphics.lineStyle(3,0xFC6B2C,1);		
			
			pointer.graphics.moveTo(0,1);
			pointer.graphics.lineTo(0,this.height-3);
			pointer.graphics.moveTo(this.width-3,1);
			pointer.graphics.lineTo(this.width-3,this.height-3);
			
			coord[7] = null;
			coord[6] = null;
			commands[3] = null;

			pointer.graphics.drawPath(commands, coord);
			this.addChild(pointer);			
		}
		
		
		
		
		
		
		
		public function setPointer():void
		{
		}

		
	
		
	}

}