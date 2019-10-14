var Photo = function(){

    var s = this;
    var imgShell;
	var imgCanvas,imgLayer;
	var imgScaleMin=0.1,imgScaleMax=5,imgScaleTimer;
    var canvasScale=2;//canvas实际放大倍数




    s.init = function(id){
        imgShell = $('#' + id);
        imgCanvas=$('<canvas></canvas>').attr({width:imgShell.width() * canvasScale,height:imgShell.height() * canvasScale,jcanvasScale:canvasScale}).css({scale:1/canvasScale}).prependTo(imgShell);
		imgCanvas[0].getContext("2d").imageSmoothingEnabled = true;
    }

    s.setImg = function(src){
        var img = new Image();
        img.onload = function(){
            var wd =  img.width;
            var ht = img.height;
            var size=imath.autoSize([wd,ht],[imgCanvas.width(),imgCanvas.height()],1);
			imgCanvas.css({opacity:0})
			.removeLayers()
			.drawImage({
				layer:true,
			  	source: src,
			  	width:size[0],height:size[1],
			  	x: imgCanvas.width()*0.5, y: imgCanvas.height()*0.5,
			  	scale:1,
			  	rotate:0,
			  	fromCenter: true
			  	// compositing: 'source-in'
			})
			.drawLayers();
			setTimeout(function(){
				imgCanvas.css({opacity:1});
			},100);
			var layer=imgCanvas.getLayer(-1);
			imgLayer=layer;
			img_addEvent(imgShell,imgCanvas,layer);
        }
        img.src = src;
    }


    //添加图片编辑事件
	function img_addEvent(shell,canvas,layer){
		shell.off().on('pinch',{layer:layer,canvas:canvas},img_pinch).on('pinchmove',{layer:layer},img_pinchmove).on('pinchscale',{layer:layer},img_pinchscale).on('pinchrotate',{layer:layer},img_pinchrotate);
	}//end func
    //单指双指触控
    function img_pinchmove(e,xOffset,yOffset){
        var layer=e.data.layer;
        layer.x+=xOffset;
        layer.y+=yOffset;
    }//end func
    
    function img_pinchscale(e,scaleOffset){
        var layer=e.data.layer;
        layer.scale+=scaleOffset*0.5;
        layer.scale=layer.scale<=imgScaleMin?imgScaleMin:layer.scale;
        layer.scale=layer.scale>=imgScaleMax?imgScaleMax:layer.scale;
    }//end func
    
    function img_pinchrotate(e,rotateOffset){
        var layer=e.data.layer;
        layer.rotate+=rotateOffset;
    // 		layer.rotate=layer.rotate>360?layer.rotate%360:layer.rotate;
    // 		layer.rotate=layer.rotate<-360?-layer.rotate%360:layer.rotate;
    }//end func

    function img_pinch(e){
        var canvas=e.data.canvas;
        canvas.drawLayers();
    }//end func

}