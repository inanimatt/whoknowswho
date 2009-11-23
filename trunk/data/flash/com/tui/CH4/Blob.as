package com.tui.CH4
{	
    import flash.display.Sprite; 
    import flash.display.Shape; 
	import flash.text.TextField;
	import flash.text.TextFieldAutoSize;
	import flash.text.AntiAliasType;
	import flash.text.TextFormat;
	import flash.text.Font;
    import flash.geom.Point; 
    import flash.events.*; 
	import flash.geom.Rectangle;
	import flash.display.Loader;
	import flash.net.URLRequest;


    public class Blob extends Sprite 
    { 				
		private var size:Number;	
		private var highlightstate:int; // 0 is no highlight, 1 = secondary highlight, 2 = main highlight
		public var bounder:Rectangle;
		public var labelLeft:Boolean;	// is the text label to the left of the blob?
		public var isAbove:Boolean;		// is the top box above or below the Y centre? true = above
		public var hasImage:Boolean;	// is this the "main blob", which has an image?
		
		// using vectors instead of arrays due to big supposed performance increases
		private var linked:Vector.<int>;
		private var connectors:Vector.<int>;

		public var myIndex:int = 0;		// this blob's index
		public var ID:int = 0;
		
		private var Name:String;
		
		private var myLabel:TextField;
		private var boxLeft:Shape;
		private var boxRight:Shape;
		private var boxAbove:Shape;
		private var boxBelow:Shape;
		private var Top:Sprite;
		//private var mbSprite:Sprite;		// used only for the main entity
		
		private var myXFactor:Number, myYFactor:Number;
		
		// constructor (name of the entity, x position, y position, height (in z terms) of the blob)
		public function Blob(inName:String, inX:Number, inY:Number, inSize:Number)
		{
			isAbove = false;
			highlightstate = 0;
			hasImage = false;
			
			linked = new Vector.<int>();
			connectors = new Vector.<int>();
		
			this.x = inX;
			this.y = inY;
			
			size = inSize;
			
			setName(inName);		
			createFullBox(inSize);
						
			//this.scaleX = this.width/(this.width+1);
			//this.scaleY = this.height/(this.height+1);
			
		}
	
	
	
		// loads an image for this blob. Generally there's only an image for the main blob
		public function loadImage(inURL:String):void
		{			
			var image = new Loader();
			image.contentLoaderInfo.addEventListener(Event.COMPLETE, completeImage);
			image.contentLoaderInfo.addEventListener(SecurityErrorEvent.SECURITY_ERROR, imageError);
			image.contentLoaderInfo.addEventListener(HTTPStatusEvent.HTTP_STATUS, httpError);
			image.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR, imageError);

			var imagedata:URLRequest = new URLRequest(inURL);
			image.load(imagedata);		
			addChild(image);
		}
		
		// silent event handlers
		private function imageError(e:ErrorEvent):void
		{
		}
		private function httpError(e:HTTPStatusEvent):void
		{
		}
		
		
		
		// called when the image for this blob is completely loaded
		private function completeImage(e:Event):void
		{
			hasImage=true;
			
			var l:Loader = e.target.loader;
			var MAX_HEIGHT = 100;
			
			if(l.height > MAX_HEIGHT)
			{
				var ratio:Number = (l.width/l.height);
				l.height = MAX_HEIGHT;
				l.width = MAX_HEIGHT*ratio;
			}
			
			// centre the image
			l.x = 0 - l.width*0.5;
			l.y = 0 - l.height*0.5;
			
			l.mouseEnabled = false;
			
			this.removeChild(Top);
			this.removeChild(boxAbove);
			this.removeChild(boxBelow);
			this.removeChild(boxLeft);
			this.removeChild(boxRight);
			
			
			// make a background sprite to use as the hit area
			var mbSprite:Sprite = new Sprite();
			mbSprite.graphics.beginFill(0xFF0000,1);
			mbSprite.graphics.drawRect(-30,-30,60,60);
			mbSprite.mouseEnabled = false;
			mbSprite.visible = false;
			this.addChild(mbSprite);
			this.hitArea = mbSprite;
		}
	
	

		
		private function makeTextField():void
		{
			var myFont:Font = new Arial();
			
			myLabel = new TextField();
			myLabel.autoSize = TextFieldAutoSize.LEFT;
			myLabel.selectable = false;
			myLabel.background = false;
			myLabel.embedFonts = true;
			myLabel.antiAliasType = AntiAliasType.ADVANCED;
			myLabel.text = Name;
			
	
			var format:TextFormat = new TextFormat();
            format.font = myFont.fontName;
		 	//format.font = "Arial";
            format.color = 0x000000;
			format.size = 11;

			//format.size = 10 + int(size/10);	
			
			myLabel.setTextFormat(format);
			myLabel.defaultTextFormat = format;
			
			
			if(myLabel.textWidth > 150)
			{
				myLabel.wordWrap = true;
				myLabel.width = 150;
			}
			//myLabel.doubleClickEnabled = true;
			myLabel.mouseEnabled = false;
			
			//myLabel.cacheAsBitmap = true;
		}
        
		
		public function createFullBox(blockheight:int):void
		{
			
			var MAX_BLOCK_HEIGHT:int = 70;
			//var MAX_BLOCK_HEIGHT:int = 5000;
			
			var TEXT_PADDING:int = 2;
			var base = -70 + (MAX_BLOCK_HEIGHT - blockheight);
			//var base = (0-MAX_BLOCK_HEIGHT) + (MAX_BLOCK_HEIGHT - blockheight);

			makeTextField();

			var myWidth = myLabel.width + (TEXT_PADDING*2);
			var myHeight = myLabel.height;
			
			var xPos:int = 0 - (myWidth*0.5);
			var yPos:int = 0 - (myHeight*0.5);
		
			myLabel.x = TEXT_PADDING;

			boxLeft = createBox(xPos, yPos, base, blockheight, myHeight, 0x98999E);
			boxLeft.rotationY = -90;
			this.addChild(boxLeft);
			
			boxRight = createBox(xPos+myWidth, yPos, base, blockheight, myHeight, 0x98999E);
			boxRight.rotationY = -90;
			this.addChild(boxRight);
			
			boxAbove = createBox(xPos, yPos, base, myWidth, blockheight, 0x98999E);
			boxAbove.rotationX = 90;
			this.addChild(boxAbove);
			
			boxBelow = createBox(xPos, yPos+myHeight, base, myWidth, blockheight, 0x98999E);
			boxBelow.rotationX = 90;
			this.addChild(boxBelow);
			
			Top = createBoxSprite(xPos, yPos, base, myWidth, myHeight, 0xFFFFFF);
			
			Top.addChild(myLabel);
			this.addChild(Top);			
		}
		
        public function createBox(xPos:int = 0, yPos:int = 0, zPos:int = 100, w:int = 50, h:int = 50, color:int = 0xDDDDDD):Shape 
        { 
            var box:Shape = new Shape(); 
            box.graphics.beginFill(color, 1.0); 
            box.graphics.drawRect(0, 0, w, h); 
            box.graphics.endFill(); 
			
            box.x = xPos; 
            box.y = yPos; 
            box.z = zPos; 
            return box; 
        } 
		
		public function createBoxSprite(xPos:int = 0, yPos:int = 0, zPos:int = 100, w:int = 50, h:int = 50, color:int = 0xDDDDDD):Sprite
        { 
            var box:Sprite = new Sprite(); 
            //box.graphics.lineStyle(0, color, 1); 
            box.graphics.beginFill(color, 1.0); 
            box.graphics.drawRect(0, 0, w, h); 
            box.graphics.endFill(); 

			box.x = xPos; 
            box.y = yPos; 
            box.z = zPos; 
			
			box.mouseEnabled = false;
            return box; 
			
        } 
		

		public function linkWith(linker:int):void
		{
			linked.push(linker);
		}
		
		public function addConnector(connector:int):void
		{
			connectors.push(connector);
		}
		
		
		public function setName(inName:String):void
		{
			Name = inName;
		}
		
		
		// figure out what color to set the shape based on the highlightstate global, and whether this is the 
		// top of the block or one of the sides.
		private function getColor(isTop:Boolean):int
		{
			var rcolor:int;
			
			switch(highlightstate)
			{
				
				case 0:	// default off
					rcolor = (isTop) ? 0xFFFFFF : 0x98999E;
				break;
				case 1:	// secondary highlight
					rcolor = (isTop) ? 0xD8EBF9 : 0x90B9D5;
				break;
				case 2:	// main highlight
					rcolor = (isTop) ? 0xF66826 : 0xF08505;
				break;
			}
			
			return rcolor;
		}

		
		public function setHighlight(inState:int):void
		{
			if(hasImage) return;
			
			if(highlightstate == inState) return;

			highlightstate = inState;	
		
			var topColor:int = getColor(true);
			var sideColor:int = getColor(false);

			this.removeChild(boxLeft);
			
			boxLeft = createBox(boxLeft.x, boxLeft.y, boxLeft.z, size, boxLeft.height, sideColor);
			boxLeft.rotationY = -90;
			this.addChild(boxLeft);
			
			this.removeChild(boxRight);
			boxRight = createBox(boxRight.x, boxRight.y, boxRight.z, size, boxRight.height, sideColor);
			boxRight.rotationY = -90;
			this.addChild(boxRight);
			
			this.removeChild(boxAbove);
			boxAbove = createBox(boxAbove.x, boxAbove.y, boxAbove.z, boxAbove.width, size, sideColor);
			boxAbove.rotationX = 90;
			this.addChild(boxAbove);
			
			this.removeChild(boxBelow);
			boxBelow = createBox(boxBelow.x, boxBelow.y, boxBelow.z, boxBelow.width, size, sideColor);
			boxBelow.rotationX = 90;
			this.addChild(boxBelow);
			
			// change the label's text color
			var format:TextFormat = myLabel.getTextFormat();
            format.color = (highlightstate == 2) ? 0xFFFFFF : 0x000000;
			myLabel.setTextFormat(format);
			
			this.removeChild(Top);
			Top = createBoxSprite(Top.x, Top.y, Top.z, Top.width, Top.height, topColor);
			Top.addChild(myLabel);
			this.addChild(Top);
		}
		
		
		// not only sets x and y, but sets the bounding rect too (getBounds() doesn't work well)
		public function moveTo(inX:int, inY:int):void
		{
			this.x = inX;
			this.y = inY;
		}
		
		
		// instead of moving the object itself, which has lots of overheads, we can move it's "rect"
		// until we're happy. Then we can move the object itself to the rect.
		public function moveRect(inX:int, inY:int):void
		{
			bounder.x = inX;
			bounder.y = inY
		}
		
		
		
		// what is the name label for this blob?
		public function getName():String
		{
			return Name;
		}
		
		// returns the "linked" array
		//public function getLinks():Array
		public function getLinks():Vector.<int>
		{
			return linked;
		}
		
		// returns the "connections" array
		//public function getConnections():Array
		public function getConnections():Vector.<int>
		{
			return connectors;
		}
		
		
		
		/*public function optimise(which:int):void
		{
			switch(which)
			{
				case 0:	// top left
					boxBelow.visible = true;
					boxAbove.visible = false;
					boxLeft.visible = false;
					boxRight.visible = true;
				break;
				case 1: // top right
					boxBelow.visible = true;
					boxAbove.visible = false;
					boxLeft.visible = true;
					boxRight.visible = false;					
				break;
				case 2: // bottom left
					boxBelow.visible = false;
					boxAbove.visible = true;
					boxLeft.visible = false;
					boxRight.visible = true;
				break;
				case 3: // bottom right
					boxBelow.visible = false;
					boxAbove.visible = true;
					boxLeft.visible = true;
					boxRight.visible = false;
				break;
			}
		}*/
		
		
    } 
}