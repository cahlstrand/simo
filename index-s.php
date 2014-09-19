<!DOCTYPE HTML>
<html lang="en"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>&Aring;land Islands 0.9</title>
		<meta name="keywords" content="maanpuolustus, tykki, amos, mlrs, archer, 120mm, patria, bonus, excalibur, 155mm"/>
    <style>body {margin: 5px; padding: 5px;}</style>
	</head>
  
  <body>
    <div id="container"></div>
    <script src="k510.js"></script>
	<!-- <style>html, body, #map-canvas {height: 100%;margin: 0px;padding: 5px}</style> -->

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script defer="defer">
	var myVar = setInterval(function(){myTimer()},1000);
    var stage = new Kinetic.Stage({
	container: 'container',
	width: 1580, height: 1010});
    var layer1 = new Kinetic.Layer(); 
	var layer2 = new Kinetic.Layer();
	var layer3 = new Kinetic.Layer(); var kxptr = layer3.getContext();
	var layer4 = new Kinetic.Layer(); var k4ptr = layer4.getContext();
	var layer5 = new Kinetic.Layer();
	var layer6 = new Kinetic.Layer();
	var layer7 = new Kinetic.Layer();
	//ryhmät
	var gro1 = new Kinetic.Group({draggable: true});layer7.add(gro1);
	var gro2 = new Kinetic.Group({draggable: false});layer7.add(gro2);
	var gro3 = new Kinetic.Group({draggable: false});layer7.add(gro3);
	var gro4 = new Kinetic.Group({draggable: false});layer7.add(gro4);
	
	var tornit=[];
	//var obj = [];
	var laskuri1 = 0;var laskuri2 = 0;var laskuri3 = 0; 
	var ofset=-4; var simrun=0;
	var tiktak = 1; //näkyy
	var apu={x:0,y:0};var apu2={x:0,y:0};
	var lay5={x:0,y:0};var lay6={x:0,y:0};
	var maps=['maanpnet.jpg','anzio_landing_1944.jpg','anzio_beachhead_1944.jpg','omaha.jpg','sicily_assault_1943.jpg','saidor_ops_1947.jpg','egypt_napoleon_camp_1798.jpg','europe_mediterranean_1190.jpg','waterloo_battle.jpg','Vietnam09.jpg', 'kartta1.jpg','iwojima.jpg','berlin.jpg'];
	var gkartta;
	var gmapx=[62.93,41.493,41.493,49.371,37.51,-5.644,29.854,50.59,50.676,13.56,42.502,24.793,52.536];
	var gmapy=[31.445,12.752,12.752,-0.879,14.436,146.454,33.147,22.6,4.414,108.69,2.144,141.324,13.388];
	var gmapz=[13,12,12,15,9,13,7,5,15,7,9,15,12];
	var gtyp=[1,1,1,1,1,1,1,1,1,1,1,2,1];
	var ymparisto=['Matkakehä','Tuulikartta','Operaattorit','Lämpötila','Näkyvyys','Taustamelu dB','VHF kohina dBm'];
	var glist=['2Dim','gmap','3Dim'];
	
var karttapixmap = new Image();
		karttapixmap.onload = function(){k4ptr.drawImage(karttapixmap, 300, 25,988,988);}
		karttapixmap.src = './kartat/' + maps[0];
 
// graafiset objektit ****************************************

	var kello = new Kinetic.Rect({
		x: 1075 ,y: 770 ,width: 10, height: 10, opacity: 0.5, id:'kello',
		fill: 'red', stroke: 'black', strokeWidth: 3}); layer2.add(kello);
	
	teekompassi();teetuulikartta();teeoper();teetemps();
	
	var kentta1 = new Kinetic.Line({
        points: [400,900, 400,100, 500,100, 500,300, 800,300, 800,400, 500,400, 500,500, 900,500, 900,100, 800,100, 800,0],
        stroke: 'white', strokeWidth: 8}); 
	var kentta2 = new Kinetic.Line({
        points: [350,600, 350,100, 600,100, 600,300, 800,300, 800,400, 500,400, 500,500, 900,500, 900,100, 800,100, 800,0],
        stroke: 'white', strokeWidth: 8});

		activekentta = kentta1; //layer2.add(activekentta);

	var hitzone = new Kinetic.Rect({
		x: 300 ,y: 10 ,width: 988, height: 988, opacity: 0.01,
		fill: 'green', stroke: 'black', strokeWidth: 1}); layer2.add(hitzone);
	
	apu.x = 600; apu.y = 0;
	var g23 = new Kinetic.Rect({
		x: apu.x-500 ,y: apu.y+1 , width: 53, height: 23, opacity: 0.5,cornerRadius: 8,
		fill: 'lightgray', stroke: 'black', strokeWidth: 2}); layer2.add(g23);
	var g23text = new Kinetic.Text({
        x: apu.x-495, y: apu.y+5,
        text: glist[0],fill:'blue',fontSize: 18
		}); layer2.add(g23text); 
	
	var dim23 = new Kinetic.Rect({
		x: apu.x-300 ,y: apu.y+1 , width: 145, height: 23, opacity: 0.5,cornerRadius: 8,
		fill: 'lightgray', stroke: 'black', strokeWidth: 2}); layer2.add(dim23);
	var dim23text = new Kinetic.Text({
        x: apu.x-290, y: apu.y+5,
        text: ymparisto[0],fill:'blue',fontSize: 18
		}); layer2.add(dim23text); 
		
	var arena = new Kinetic.Rect({
		x: apu.x-130 ,y: apu.y+1 , width: 100, height: 23, opacity: 0.5,cornerRadius: 8,
		fill: 'lightgray', stroke: 'black', strokeWidth: 2}); layer2.add(arena);
	var arenatext = new Kinetic.Text({
        x: apu.x-125, y: apu.y+5,
        text: 'Next map',fill:'blue',fontSize: 18
		}); layer2.add(arenatext);

		var reset = new Kinetic.Rect({
		x: apu.x ,y: apu.y+1 , width: 65, height: 23, opacity: 0.5,cornerRadius: 8,
		fill: 'green', stroke: 'black', strokeWidth: 2}); layer2.add(reset);
	var rst1 = new Kinetic.Text({
        x: (apu.x + 3), y: apu.y+5,
        text: 'Reset',fontSize: 18,
        fill: 'green'}); layer2.add(rst1);
		
	var sim = new Kinetic.Rect({
		x: apu.x+100 ,y: apu.y+1 , width: 150, height: 23, opacity: 0.5,cornerRadius: 8,
		fill: 'lightgray', stroke: 'black', strokeWidth: 2}); layer2.add(sim);
	var simtext = new Kinetic.Text({
        x: apu.x+112, y: apu.y+5, 
        text: 'Start simulation',fill:'blue',fontSize: 18
		}); layer2.add(simtext);

	var infotext = new Kinetic.Text({
        x: apu.x+300, y: apu.y+9,
        text: 'Klikkaa kartalle iskupaikat, siirrä matkakehää tarvittaessa',fill:'blue',fontSize: 14
		}); layer2.add(infotext);
	
		
	apu.x = 1350; apu.y = 0;
	var reset2 = new Kinetic.Rect({
		x: apu.x ,y: apu.y+1 , width: 65, height: 23, opacity: 0.5,cornerRadius: 8,
		fill: 'yellow', stroke: 'black', strokeWidth: 2}); layer2.add(reset2);
	var rst2 = new Kinetic.Text({
        x: (apu.x + 3), y: apu.y+5,
        text: 'Reset',fontSize: 18,
        fill: 'darkgreen'}); layer2.add(rst2);
		
		apu.x = 170; apu.y = 0;
	var reset3 = new Kinetic.Rect({
		x: apu.x ,y: apu.y+1 , width: 65, height: 23, opacity: 0.5,cornerRadius: 8,
		fill: 'yellow', stroke: 'black', strokeWidth: 2}); layer2.add(reset3);
	var rst3 = new Kinetic.Text({
        x: (apu.x + 3), y: apu.y+5,
        text: 'Reset',fontSize: 18,
        fill: 'darkgreen'}); layer3.add(rst3);
		
		apu.x = 1430; apu.y = 100; //oik palstan kuvat
		var amospixmap = new Image();amospixmap.onload = function(){kxptr.drawImage(amospixmap, apu.x, apu.y,150,395);}
		amospixmap.src = 'oik1.jpg';

		var krhpixmap = new Image();krhpixmap.onload = function(){kxptr.drawImage(krhpixmap, apu.x,apu.y+400,150,495);}
		krhpixmap.src = 'oik2.jpg';
		
		setlay5();
		 
		apu2.x = 5; apu2.y = 100; //vas palstan kuva
//var ka2pixmap = new Image();ka2pixmap.onload = function(){kxptr.drawImage(ka2pixmap, 450,200,700,827);}
//ka2pixmap.src = 'komp.gif';
		var kapixmap = new Image();kapixmap.onload = function(){kxptr.drawImage(kapixmap, apu2.x,apu2.y+200,150,395);}
		kapixmap.src = 'vas1.jpg';
		
		var tjpixmap = new Image();tjpixmap.onload = function(){kxptr.drawImage(tjpixmap, apu2.x,apu2.y+600,150,95);}
		tjpixmap.src = 'tulenjohtaja.jpg';
		var sjpixmap = new Image();sjpixmap.onload = function(){kxptr.drawImage(sjpixmap, apu2.x,apu2.y+700,150,95);}
		sjpixmap.src = 'sj.jpg';
		var uavpixmap = new Image();uavpixmap.onload = function(){kxptr.drawImage(uavpixmap, apu2.x,apu2.y+800,150,95);}
		uavpixmap.src = 'ranger.jpg';
		var hnpixmap = new Image();hnpixmap.onload = function(){kxptr.drawImage(hnpixmap, apu2.x,apu2.y+100,150,95);}
		hnpixmap.src = './img-simo/hnx4.jpg';
		setlay6();
		
		/* oh.on('dragend', function() {
                //alert(oh.getPosition().x);
				
				oh.setText = '5';
				layer1.draw();
            }); */
		
stage.add(layer4); // taustakartta	
stage.add(layer2); // tie, rst-napit, hitzonet
stage.add(layer1); // circlet
stage.add(layer3); // kalusto bitmaps
stage.add(layer5); stage.add(layer6); stage.add(layer7);//dragdrops
 

// events ***********************************************
	google.maps.event.addDomListener(window, 'load', initkartta);
	
	hitzone.on('click', function() {
        klik(stage.getPointerPosition(),11);
      });

	rst1.on('click', function() {
		laskuri1 = 0; layer1.removeChildren();
		layer1.draw();
	});
	
	rst2.on('click', function() {
		laskuri2 = 0; layer5.removeChildren();
		setlay5(); 
		layer5.draw();
	});
	
	rst3.on('click', function() {
		laskuri3 = 0; layer6.removeChildren();
		setlay6();
		layer6.draw();
	});
	
	g23text.on('click', function() {
			temppi=glist[0]; // ota eka
			glist.shift(); glist.push(temppi);
			g23text.setText(glist[0]);
			switch(glist[0]){
			case "2Dim":
				document.getElementById("map-canvas").style = "margin-left:300px;width:988px;height:988px;position:relative;top:0px";
				break;
			case "gmap":
				document.getElementById("map-canvas").style = "margin-left:300px;width:988px;height:988px;position:relative;top:-980px";
				break;
			case "3Dim":
				//alert('ei oo valmis');
				break;
			default:
				break;
			} //end switch
			//layer7.draw();
	});
	
	dim23text.on('click', function() {
		if (ymparisto.length > 1) {
			temppi=ymparisto[0]; // ota eka
			ymparisto.shift(); ymparisto.push(temppi);
			dim23text.setText(ymparisto[0]);
			gro1.hide();gro2.hide();gro3.hide();gro4.hide();
			switch(ymparisto[0]){
			case "Matkakehä":
				gro1.show();
				break;
			case "Tuulikartta":
				gro2.show();
				break;
			case "Operaattorit":
				gro3.show();
				break;
			case "Lämpötila":
				gro4.show();
				break;
			default:
				break;
			} //end switch
			layer7.draw();
		} //endif
	});
	
	arenatext.on('click', function() {
	if (maps.length > 1) {
		temppi=maps[0]; // ota eka
		maps.shift(); maps.push(temppi);
		karttapixmap.src = './kartat/' + maps[0];
		temppi=gmapx[0];
		gmapx.shift();gmapx.push(temppi);
		temppi=gmapy[0];
		gmapy.shift();gmapy.push(temppi);
		temppi=gmapz[0];
		gmapz.shift();gmapz.push(temppi);
		temppi=gtyp[0];
		gtyp.shift();gtyp.push(temppi);
		keskita(gmapx[0],gmapy[0],gmapz[0],gtyp[0]);
		}
	});
	
	simtext.on('click', function() {
		if (simrun == 0) {simrun=1;}
		else {simrun=0;}
	});
	
	
// funktiot ***********************
function klik(piste,radi){
		laskuri1++;
		if (laskuri1>9){ofset=-7} else {ofset=-4};
		var rtemp = new Kinetic.Circle({x: piste.x, y: piste.y, radius: radi,stroke: 'red', strokeWidth: 3});
		var rtemp2 = new Kinetic.Text({
        x: (piste.x+ofset), y: (piste.y-6), text: laskuri1, fontSize: 14, fontFamily: 'Courier',fill: 'darkred'});
		tornit[laskuri1-1]=rtemp;
		layer1.add(rtemp); layer1.add(rtemp2); layer1.draw();
	}

function setlay5(){
var obj = [];
lay5.x = 1300; lay5.y = 120; fn=16;
		var kehys = new Kinetic.Rect({
		x: lay5.x-10 ,y: lay5.y-70 , width: 140, height: 960,
		stroke: 'blue', strokeWidth: 2, fill:'yellow', opacity: 0.90}); layer5.add(kehys);

		var rtemp = new Kinetic.Text({
        x: lay5.x-5, y: lay5.y-60, text: 'Drag-and-drop',fontSize: 20, fontFamily: 'Calibri',fill: 'Blue',
        draggable: false});obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+0, text: 'Amos/1',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+25, text: 'Amos/2',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
				
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+90, text: 'Archer/1',fontSize: fn,fill: 'darkgreen',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+115, text: 'Archer/2',fontSize: fn,fill: 'darkgreen',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+200, text: '2xKrkk/1',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+225, text: '2xKrkk/2',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+250, text: '2xKrkk/3',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+300, text: 'MLRS/1',fontSize: fn,fill: 'maroon',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+325, text: 'MLRS/2',fontSize: fn,fill: 'maroon',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+390, text: '4x120mm/1',fontSize: fn,fill: 'indigo',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+415, text: '4x120mm/2',fontSize: fn,fill: 'indigo',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+440, text: '4x120mm/3',fontSize: fn,fill: 'indigo',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+500, text: '4xHaupitsi/1',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+525, text: '4xHaupitsi/2',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+550, text: '4xHaupitsi/3',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+590, text: '4xLeo/1',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+615, text: '4xLeo/2',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+640, text: '4xLeo/3',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+685, text: '4xCV/1',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+710, text: '4xCV/2',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+735, text: '4xCV/3',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+800, text: '3.2t/min 30km',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay5.x, y: lay5.y+825, text: '2.4t/min 40km',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		
		for(var i=0; i<obj.length; i++) {layer5.add(obj[i])}
}

function setlay6(){
var obj = []; //alert(obj.length);
lay6.x = 160; lay6.y = 120; fn=16;co='magenta';
		var kehys = new Kinetic.Rect({
		x: lay6.x-7 ,y: lay6.y-70 , width: 140, height: 960,
		stroke: 'blue', strokeWidth: 2, fill:'yellow', opacity: 0.90}); layer6.add(kehys);

		var rtemp = new Kinetic.Text({
        x: lay6.x-5, y: lay6.y-60, text: 'Drag-and-drop',fontSize: 20, fontFamily: 'Calibri',fill: 'Blue',
        draggable: false});obj.push(rtemp);

		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y-25, text: 'Varasto',fontSize: fn,fill:co,
        draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y-5, text: 'Korjaamo',fontSize: fn,fill:co,
        draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+15, text: 'Liikkuva korjaamo',fontSize: fn,fill:co,
        draggable: true });obj.push(rtemp);

		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+35, text: 'Kalliosuoja',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+55, text: 'Sidontapaikka',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);

		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+75, text: 'Erikoisjoukko',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+95, text: 'Esikunta',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+110, text: 'EU-joukko',fontSize: fn,fill: co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+130, text: 'HN C-huolto',fontSize: fn,fill: co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+150, text: 'Kerosiinia',fontSize: fn,fill: co,draggable: true });obj.push(rtemp);

		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+200, text: 'Kaivuri/1',fontSize: fn,fill: 'darkred',draggable: true });obj.push(rtemp);
		var rtempc = rtemp.clone();
		rtempc.setY(rtemp.getY()+25); rtempc.setText('Kaivuri/2');obj.push(rtempc);
		var rtempc = rtemp.clone();
		rtempc.setY(rtemp.getY()+50); rtempc.setText('Lumiaura'); obj.push(rtempc);

		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+290, text: 'Crotale/1',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+310, text: 'Crotale/2',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+330, text: 'Stinger/1',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+350, text: 'Stinger/2',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+390, text: 'Nasams3/1',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+415, text: 'Nasams3/2',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+495, text: 'Radar/1',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+515, text: 'Radar/2',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+535, text: 'Maastotutka',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+590, text: 'Tulenjohtaja/1',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+610, text: 'Tulenjohtaja/2',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+630, text: 'Tulenjohtaja/3',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+650, text: 'Tulenjohtaja/4',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+690, text: 'Miinoite/1',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+710, text: 'Miinoite/2',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+730, text: 'Vesa Keskinen',fontSize: fn,fill: 'red',
        draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+750, text: 'Setamies',fontSize: fn,fill: 'red',draggable: true });obj.push(rtemp);
		
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+800, text: 'UAV-thermal',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		var rtemp = new Kinetic.Text({
        x: lay6.x, y: lay6.y+830, text: 'UAV-AESA',fontSize: fn,fill:co,draggable: true });obj.push(rtemp);
		
		for(var i=0; i<obj.length; i++) {layer6.add(obj[i])}
}

function myTimer(){
	var aika=new Date();
	if (tiktak == 0) {kello.show(); tiktak = 1;}
	else {kello.hide(); tiktak = 0;}
	if(simrun == 1) {simtext.setText(aika.getHours() + ':' + aika.getMinutes() + ':' + aika.getSeconds());}
	else {simtext.setText('Start simulation');}
	layer2.draw();
}

function teekompassi(){
	var i=0;
	for(i=0;i<8;i++){
		var kom1 = new Kinetic.Line({
		points:[400+145*Math.cos(i*6.283/8),400+145*Math.sin(i*6.283/8),
		400+155*Math.cos(i*6.283/8),400+155*Math.sin(i*6.283/8)],stroke:'green',strokeWidth:1});
		gro1.add(kom1);
		}
	for(i=0;i<36;i++){
		var kom1 = new Kinetic.Line({
		points:[400+195*Math.cos(i*6.283/36),400+195*Math.sin(i*6.283/36),
		400+205*Math.cos(i*6.283/36),400+205*Math.sin(i*6.283/36)],stroke:'red',strokeWidth:1});
		gro1.add(kom1);
		}
	var komtxt = new Kinetic.Text({x: 602, y: 360,text: '10',fontSize: 9,fill: 'red'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 594, y: 325,text: '20',fontSize: 9,fill: 'red'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 580, y: 293,text: '30',fontSize: 9,fill: 'red'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 560, y: 261,text: '40',fontSize: 9,fill: 'red'});gro1.add(komtxt);
	
	var komtxt = new Kinetic.Text({x: 225, y: 260,text: '140',fontSize: 9,fill: 'red'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 494, y: 300,text: '45',fontSize: 9,fill: 'green'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 294, y: 300,text: '135',fontSize: 9,fill: 'green'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 400, y: 190,text: 'MLRS',fontSize: 9,fill: 'maroon'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 400, y: 240,text: 'ARC',fontSize: 9,fill: 'darkgreen'});gro1.add(komtxt);
	var komtxt = new Kinetic.Text({x: 400, y: 290,text: '120mm',fontSize: 9,fill: 'indigo'});gro1.add(komtxt);
	
	var kom1 = new Kinetic.Circle({x: 400, y: 400, radius: 200, stroke: 'maroon', strokeWidth: 1}); gro1.add(kom1);
	var kom1 = new Kinetic.Circle({x: 400, y: 400, radius: 150, stroke: 'darkgreen', strokeWidth: 1}); gro1.add(kom1);
	var kom1 = new Kinetic.Circle({x: 400, y: 400, radius: 100, stroke: 'indigo', strokeWidth: 1}); gro1.add(kom1);
	var kom1 = new Kinetic.Rect({
		x: 380 ,y: 380 ,width: 40, height: 40, opacity: 0.3,
		fill: 'gray', stroke: 'blue', strokeWidth: 1}); gro1.add(kom1);
	var kom1 = new Kinetic.Line({points:[400,200,400,600],stroke:'red',strokeWidth:1}); gro1.add(kom1);
	var kom1 = new Kinetic.Line({points:[200,400,600,400],stroke:'red',strokeWidth:1}); gro1.add(kom1);
}	//end func

function teetuulikartta(){
		nuoli(400,400,500,500);nuoli(800,400,900,500);nuoli(400,700,500,800);nuoli(800,700,850,720);
		var komtxt = new Kinetic.Text({x: 10, y: 50,text: '! Vimpelin säätutkasta puuttuu vielä kaksoispolarisaatio',fontSize: 12,fill: 'blue',width:150});gro2.add(komtxt);
		var komtxt = new Kinetic.Text({x: 10, y: 90,text: 'Korppoo, Vantaa, Kuopio, Luosto, Utajärvi, Ikaalinen online',fontSize: 12,fill: 'blue',width:150});gro2.add(komtxt);
		gro2.hide();
		}

function teeoper(){
	var kom1 = new Kinetic.Ellipse({radius : {x : 150,y : 90},
		x: 450 ,y: 700 , opacity: 0.5,fill: 'orange', stroke: 'orange', strokeWidth: 1}); //gro3.add(kom1);
	var kom1 = new Kinetic.Ellipse({x: 820 ,y: 900 , opacity: 0.5,radius : {x : 90,y : 60},rotation:45,
		fill: 'blue', stroke: 'blue', strokeWidth: 1}); //gro3.add(kom1);
	var kom1 = new Kinetic.Arc({x: 293,y: 1013,angle: 90, innerRadius:5, outerRadius:350,rotation:-90,opacity:0.6,
  fill: 'orange'});gro3.add(kom1);
	var kom1 = new Kinetic.Rect({x:290,y:25, width:150, height:990, fill:'blue',opacity:0.5});gro3.add(kom1);
	var kom1 = new Kinetic.Rect({x:290,y:810, width:350, height:200, fill:'green',opacity:0.5});gro3.add(kom1);
	var komtxt = new Kinetic.Text({x: 10, y: 50,text: 'DNA FDD-3.5G 900MHz',fontSize: 12,fill: 'orange',width:140});gro3.add(komtxt);
	var komtxt = new Kinetic.Text({x: 10, y: 80,text: 'Sonera FDD-3.75G 900MHz',fontSize: 12,fill: 'blue',width:140});gro3.add(komtxt);
	var komtxt = new Kinetic.Text({x: 10, y: 110,text: 'Elisa FDD-3.75G 900MHz',fontSize: 12,fill: 'green',width:140});gro3.add(komtxt);
	gro3.hide();
	}

function teetemps(){
	var komtxt = new Kinetic.Text({x: 450, y: 750,text: '+13°C',fontSize: 18,fill: 'red'});gro4.add(komtxt);
	var komtxt = new Kinetic.Text({x: 510, y: 580,text: '+11°C',fontSize: 18,fill: 'red'});gro4.add(komtxt);
	var komtxt = new Kinetic.Text({x: 850, y: 650,text: '+9°C',fontSize: 18,fill: 'red'});gro4.add(komtxt);
	var komtxt = new Kinetic.Text({x: 770, y: 280,text: '+14°C',fontSize: 18,fill: 'red'});gro4.add(komtxt);
	var komtxt = new Kinetic.Text({x: 1200, y: 380,text: '+17°C',fontSize: 18,fill: 'purple'});gro4.add(komtxt);
	var komtxt = new Kinetic.Text({x: 10, y: 50,text: 'Maanpinta',fontSize: 18,fill: 'red'});gro4.add(komtxt);
	var komtxt = new Kinetic.Text({x: 10, y: 70,text: 'Vesi 1.0m syv.',fontSize: 18,fill: 'purple'});gro4.add(komtxt);
	gro4.hide();
	}

function nuoli(fromx, fromy, tox, toy){
    var headlen = 30;
    var kulma = Math.atan2(toy-fromy,tox-fromx);
    xxx = new Kinetic.Line({
        points: [fromx, fromy, tox, toy,
		tox-headlen*Math.cos(kulma-Math.PI/6),toy-headlen*Math.sin(kulma-Math.PI/6),tox, toy,
		tox-headlen*Math.cos(kulma+Math.PI/6),toy-headlen*Math.sin(kulma+Math.PI/6)],
        stroke: "red"
    }); gro2.add(xxx);
}	


function initkartta() {
  var mapOptions = {zoom: gmapz[0], center: new google.maps.LatLng(gmapx[0], gmapy[0])};
  gkartta = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
  gkartta.setMapTypeId(google.maps.MapTypeId.HYBRID);
}

function keskita(lati,longi,zuumi,tyyppi) {
	var latLng = new google.maps.LatLng(lati, longi);
	gkartta.panTo(latLng); gkartta.setZoom(zuumi);
	switch(tyyppi){
			case 2:
				gkartta.setMapTypeId(google.maps.MapTypeId.TERRAIN);
				break;
			default:
				gkartta.setMapTypeId(google.maps.MapTypeId.HYBRID);
				}
}

function nappi1(){gkartta.setMapTypeId(google.maps.MapTypeId.HYBRID);document.getElementById("b1").style = "background-color:lightgreen";document.getElementById("b2").style = "background-color:white";}
function nappi2(){gkartta.setMapTypeId(google.maps.MapTypeId.TERRAIN);document.getElementById("b1").style = "background-color:white";document.getElementById("b2").style = "background-color:lightgreen";}

</script><hr><br>
<button id="b1" type="button" style="background-color:lightgreen;color:black" onclick="nappi1()">Hybrid</button>
<button id="b2" type="button" style="background-color:white;color:black" onclick="nappi2()">Terrain</button>
<div id="map-canvas" style="margin-left:300px;width:988px;height:988px;position:relative;top:0px;"></div>
<!-- <img src="simo2013.jpg" width="225"> -->

</body>
</html>
