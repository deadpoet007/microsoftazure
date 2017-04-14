<?php
session_start();
$name=$_SESSION['load'];
?>
<!DOCTYPE HTML>
<HTML>

 <HEAD>
	  <TITLE> JSC3D - Test </TITLE>
	  <META NAME="Author" CONTENT="JSC3D">

	<link rel="stylesheet" href="css/uploader.css">
	<script type="text/javascript" src="js/jquery_1.5.2.js"></script>
	<script type="text/javascript" src="js/uploader.js"></script>
 </HEAD>

 <BODY>


 	<script type="text/javascript">
$(document).ready(function()
{
	new multiple_file_uploader
	({
		form_id: "fileUpload", 
		autoSubmit: true,
		server_url: "uploader.php" // PHP file for uploading the browsed files
	});
});
</script>

 	<div class="upload_box">
				<form name="fileUpload" id="fileUpload" action="javascript:void(0);" method="post" enctype="multipart/form-data">
				<div class="file_browser"><input type="file" name="multiple_files[]" id="_multiple_files" class="hide_broswe" multiple /></div>
				<div class="file_upload"><input type="submit" value="Upload" class="upload_button" /> </div>
				</form>

			</div>	
<div class="file_boxes">

	</div>
	<div align="left" id="main_frame" style="width:490px; margin:auto; position:relative; font-size: 9pt; color: #777777;">
		<table style="width:100%">
	<tr>
		<td>

			



  <div data-role="main" class="ui-content">
    <form method="post" action="/open/extrude.php">
      <label for="points">Extrusion Factor(0 to 1)</label>
      <input type="range" name="scale" min="0" max="1" step="0.1" value="0.1" />
      <input type="submit" value="extrude" data-inline="true" value="Submit">
    </form>
  </div>


 	<!--<img src="smile22.jpeg" alt="Smiley face" height="200" width="240">-->
 	<a href="http://localhost/open/extrude.php"  style="font-size:16px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
       
    </td><td>
		<canvas id="cv" style="border: 1px solid;" width="490" height="368" ></canvas>
		<div id="statistics" style="position:absolute; width:100px; height:50px; left:10px; top:10px; font:12px Courier New; color:red; background:transparent;"></div>
		<div id="loading" style="position:absolute; left:90px; top:159px;"></div>
		<div style="float:left;">
		<select name="model_list" id="model_list">
			<option> </option>
		<option><?php echo $name; ?></option>
		</select>
		<button id="load" onclick="loadModel();">Load</button>
</br></br>
<form method="get" action="D:\xampp\htdocs\open\avi.stl">
<button type="submit">Download!</button>
</form>


<a href="D:\xampp\htdocs\open\avi.stl" download="avi.stl">Download</a>


		</div>
		<div style="float:right;">
		<select name="colour" id="colour">
		<option>red</option>
		<option>green</option>
		<option>blue</option>
</select>
<button id="change" onclick="changecolour();">Change</button><br>
		</div><br>
</td></tr></table>
	</div>
	<script type="text/javascript" src="../jsc3d.js"></script>
	<script type="text/javascript" src="../jsc3d.touch.js"></script>
	<script type="text/javascript" src="../jsc3d.console.js"></script>
	<script type="text/javascript" src="../external/Sonic/sonic.js"></script>
	<script type="text/javascript">
		// setup and activate the console singleton
		//JSC3D.console.setup('main_frame', '120px');

		var canvas = document.getElementById('cv');
		var viewer = new JSC3D.Viewer(canvas);
		var logoTimerID = 0;
		var mod='',col='';
	function changecolour(){
	var colour=document.getElementById('colour');
	var index=colour.selectedIndex;
	col=colour[colour.selectedIndex].innerHTML;
	if(index==0){
	viewer.setParameter('ModelColor', '#ff0000');
viewer.init();
	viewer.update();
	}
	else if(index==1){
	viewer.setParameter('ModelColor', '#00ff00');
viewer.init();
viewer.update();}
	else if(index==2){
	viewer.setParameter('ModelColor', '#0000ff');
viewer.init();
viewer.update();
}
}
var name= "<?php echo $name; ?>";
		viewer.setParameter('SceneUrl', 'models/'+name);
		viewer.setParameter('InitRotationX', 20);
		viewer.setParameter('InitRotationY', 20);
		viewer.setParameter('InitRotationZ', 0);
		viewer.setParameter('BackgroundColor1','#01FF01');
		viewer.setParameter('BackgroundColor2', '#6A6AD4');
		viewer.setParameter('RenderMode', 'smooth');
		viewer.setParameter('SphereMapUrl', 'models/chrome.jpg');
		viewer.setParameter('ProgressBar', 'off');
		viewer.init();
		viewer.update();

		/*
		 * Disable interactions in logo time.
		 */
		viewer.enableDefaultInputHandler(false);
		logoTimerID = setInterval( function() { 
			viewer.rotate(0, 10, 0);
			viewer.update();
		}, 100);
		/*setTimeout( function() {
			viewer.enableDefaultInputHandler(true); 
			if(logoTimerID > 0)
				loadModel();
		}, 8000);*/

		/*
		 * Show our user-defined progress indicator in loading.
		 */
		viewer.onloadingstarted = function() {
			displayUserDefinedProgressBar(true);
		};
		viewer.onloadingcomplete = viewer.onloadingaborted = viewer.onloadingerror = function() {
			displayUserDefinedProgressBar(false);

			if(logoTimerID > 0)
				return;

			// show statistics of current model when loading is completed
			var scene = viewer.getScene();
			if(scene && scene.getChildren().length > 0) {
				var objects = scene.getChildren();
				var totalFaceCount = 0;
				var totalVertexCount = 0
				for(var i=0; i<objects.length; i++) {
					totalFaceCount += objects[i].faceCount;
					totalVertexCount += objects[i].vertexBuffer.length / 3;
				}
				var stats = totalVertexCount.toString() + ' vertices' + '</br>' + totalFaceCount.toString() + ' faces';
				document.getElementById('statistics').innerHTML = stats;
			}
			else {
				document.getElementById('statistics').innerHTML = '';
			}
		};

		function loadModel() {
			if(logoTimerID > 0) {
				clearInterval(logoTimerID);
				logoTimerID = 0;
				viewer.enableDefaultInputHandler(true);
			}
		 models = document.getElementById('model_list');
			viewer.replaceSceneFromUrl('models/' + models[models.selectedIndex].innerHTML);
			viewer.update();
	mod=models[models.selectedIndex].innerHTML;
		}

		function setRenderMode() {
			if(logoTimerID > 0)
				return;
			var modes = document.getElementById('render_mode_list');
			switch(modes.selectedIndex) {
			case 0:
				viewer.setRenderMode('point');
				JSC3D.console.logInfo('Set to point mode.');
				break;
			case 1:
				viewer.setRenderMode('wireframe');
				JSC3D.console.logInfo('Set to wireframe mode.');
				break;
			case 2:
				viewer.setRenderMode('flat');
				JSC3D.console.logInfo('Set to flat mode.');
				break;
			case 3:
				viewer.setRenderMode('smooth');
				JSC3D.console.logInfo('Set to smooth mode.');
				break;
			case 4:
				viewer.setRenderMode('texturesmooth');
				var scene = viewer.getScene();
				if(scene) {
					var objects = scene.getChildren();
					for(var i=0; i<objects.length; i++)
						objects[i].isEnvironmentCast = true;
				}
				JSC3D.console.logInfo('Set to environment-mapping mode.');
				break;
			default:
				viewer.setRenderMode('flat');
				break;
			}
			viewer.update();
		}

		/*
		 *	Create a user-defined progress bar.
		 */
		var sonic = new Sonic({
			width: 300, 
			height: 50, 
			stepsPerFrame: 1, 
			trailLength: 0.6, 
			pointDistance: .0333, 
			fps: 10, 
			padding: 5, 
			fillColor: '#95952B', 
			setup: function() {
				this._.lineWidth = 20;
			}, 
			path: [
				['line', 0, 20, 300, 20],
				['line', 300, 20, 0, 20]
			]
		});
		document.getElementById('loading').appendChild(sonic.canvas);

		function displayUserDefinedProgressBar(show) {
			if(show) {
				sonic.play();
				document.getElementById('loading').style.display = 'block';
			}
			else {
				sonic.stop();
				document.getElementById('loading').style.display = 'none';
			}
		}
		function save()
		{
		var text1=document.getElementById('text1');
		var text2=document.getElementById('text2');
		window.location.href = "http://ec2-54-69-60-194.us-west-2.compute.amazonaws.com/js3d1/demos/test_db.php?model=" +mod + "&colour=" + col+"&text1="+text1+"&text2="+text2;
		}
	</script>
</br></br>
	<img src="end.png">
 </BODY>
</HTML>
