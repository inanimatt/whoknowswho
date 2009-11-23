package com.tui.CH4
{	
	import flash.display.Sprite;
	import flash.display.Shape;

	public class Relationship extends Sprite
	{				
		public var startX:int;
		public var startY:int;
		public var endX:int;
		public var endY:int;
		public var isDashed:Boolean;
		
		public var startBlobIndex:int;
		public var endBlobIndex:int;
		
		public var rtype:int;
		public var ID:int;
		
		private var myWidth:Number;
		private var myHeight:Number;
		
		private var highlighted:Boolean;
		
		private var Line:Shape;
		private var ClickArea:Sprite;
		

		public function Relationship(instartX:int, instartY:int, inendX:int, inendY:int)
		{
			this.x = (startX < endX) ? startX : endX;
			this.y = (startY < endY) ? startY : endY;
			Line = makeShape(instartX, instartY, inendX, inendY, 0);			
			ClickArea = makeSprite(instartX, instartY, inendX, inendY);
			this.addChild(ClickArea);		
			this.hitArea = ClickArea;
			this.addChild(Line);			
			isDashed = false;			
		}
		
			
		// re-works out where the start and end blobs are, and redraw them
		public function makeShape(instartX:int, instartY:int, inendX:int, inendY:int, inType:int):Shape
		{
			startX = instartX;
			startY = instartY;
			endX = inendX;
			endY = inendY;
			
			myWidth = (startX < endX) ? (endX - startX) : (startX - endX);
			myHeight = (startY < endY) ? (endY - startY) : (startY - endY);

			var sh:Shape =  new Shape();
			sh.x = 0;
			sh.y = 0;
			
			switch(inType)
			{
				case 0:		// normal line
					sh.graphics.lineStyle(0.1, 0xa9b3bc, 1);
				break;
				case 1:		// highlighted line
					sh.graphics.lineStyle(1, 0x506992, 1);
				break;
				case 2:		// clickArea
					sh.graphics.lineStyle(3, 0xFFFFFF, 1);
				break;
			}
			
				
			if((isDashed)&&(inType < 2))
			{
				DrawDashed(sh);
			}
			else
			{
					
				if(startX < endX)
				{		
					if(startY < endY)
					{
						sh.graphics.moveTo(0, 0);
						sh.graphics.lineTo(myWidth, myHeight);
					}
					else
					{
						sh.graphics.moveTo(0, myHeight);
						sh.graphics.lineTo(myWidth, 0);
					}
				}
				else
				{
					if(startY < endY)
					{
						sh.graphics.moveTo(myWidth, 0);
						sh.graphics.lineTo(0, myHeight);
					}
					else
					{
						sh.graphics.moveTo(myWidth, myHeight);
						sh.graphics.lineTo(0,0);
					}				
				}
			}
			return sh;
		}
		
		
		
		
		
		
		
		// makes the ClickArea hitArea for the connector. Saves a LOT on redrawing by doing this instead
		// of drawing it in with an alpha of 0.
		public function makeSprite(instartX:int, instartY:int, inendX:int, inendY:int):Sprite
		{
			startX = instartX;
			startY = instartY;
			endX = inendX;
			endY = inendY;
					
			myWidth = (startX < endX) ? (endX - startX) : (startX - endX);
			myHeight = (startY < endY) ? (endY - startY) : (startY - endY);

			var sh:Sprite = new Sprite();
			sh.x = 0;
			sh.y = 0;
			sh.mouseEnabled = false;
			sh.graphics.lineStyle(4, 0xFFFFFF, 1);
			
			if(startX < endX)
			{		
				if(startY < endY)
				{
					sh.graphics.moveTo(0, 0);
					sh.graphics.lineTo(myWidth, myHeight);
				}
				else
				{
					sh.graphics.moveTo(0, myHeight);
					sh.graphics.lineTo(myWidth, 0);
				}
			}
			else
			{
				if(startY < endY)
				{
					sh.graphics.moveTo(myWidth, 0);
					sh.graphics.lineTo(0, myHeight);
				}
				else
				{
					sh.graphics.moveTo(myWidth, myHeight);
					sh.graphics.lineTo(0,0);
				}				
			}
			
			sh.visible = false;
			return sh;
		}
		
		
		
		// re-works out where the start and end blobs are, and redraw them
		public function recalculate(instartX:int, instartY:int, inendX:int, inendY:int):void
		{
			if((instartX == startX)&&(instartY==startY)&&(inendX==endX)&&(inendY==endY)) return;
			
			startX = instartX;
			startY = instartY;
			endX = inendX;
			endY = inendY;

			this.x = (startX < endX) ? startX : endX;
			this.y = (startY < endY) ? startY : endY;

			this.removeChild(Line);
			this.removeChild(ClickArea);

			Line = makeShape(instartX, instartY, inendX, inendY, 0);

			ClickArea = makeSprite(instartX, instartY, inendX, inendY);			
			this.addChild(ClickArea);
			this.hitArea = ClickArea;
			this.addChild(Line);
		}
		



		public function setHighlight(isOn:Boolean):void
		{
			if(highlighted == isOn) return;
			highlighted = isOn;
			this.removeChild(Line);

			if(isOn)
			{
				Line = makeShape(startX, startY, endX, endY, 1);
			}
			else
			{
				Line = makeShape(startX, startY, endX, endY, 0);
			}
			
			this.addChild(Line);
		}
		
		
		// draws a dashed line from sX,sY to eX,eY)
		private function dashLine(sX:int,sY:int,eX:int,eY:int, inshape:Shape)
		{
			// get the radius and angle using the power of Pythagoras
			var XDist:Number = sX - eX;
			var YDist:Number = sY - eY;

			var full_radius:Number = Math.sqrt(XDist*XDist + YDist*YDist);
			
			// get the angle.
			var rangle:Number = Math.atan(YDist/XDist);		
			
			// if(eX < sX) rangle += Math.PI;
			if(eX < sX) rangle += 3.1415926535;	// PI
			
			var STEP:int = 5;
			var GAP:int = 5;
			var r:Number = 0;
			
			inshape.graphics.moveTo(sX, sY);
						
			var myX:Number = sX;
			var myY:Number = sY;
			
			while(r < full_radius)
			{
				myX = STEP*Math.cos(rangle)+myX;
				myY = STEP*Math.sin(rangle)+myY;
			
				inshape.graphics.lineTo(myX,myY);

				r+=STEP;
				
				myX = GAP*Math.cos(rangle)+myX;
				myY = GAP*Math.sin(rangle)+myY;
			
				inshape.graphics.moveTo(myX,myY);
				
				r+=GAP;
			}
		}
		
		
		
		public function DrawDashed(inshape:Shape):void
		{			
			if(startX < endX)
			{		
				if(startY < endY)
				{
					dashLine(0,0,myWidth,myHeight,inshape);
				}
				else
				{
					dashLine(0,myHeight,myWidth,0,inshape);
				}
			}
			else
			{
				if(startY < endY)
				{
					dashLine(myWidth,0,0,myHeight,inshape);
				}
				else
				{			
					dashLine(myWidth, myHeight,0,0,inshape);
				}				
			}
		}
	}
}