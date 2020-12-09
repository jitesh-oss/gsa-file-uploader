<?php
$js = plugins_url( 'assets/js', __FILE__ );
$uploadfile = plugins_url( 'upload.php', __FILE__ );
?>
<script type="text/javascript" src="<?= $js; ?>/plupload.full.min.js"></script>

<p>Browse to GSA files</p>

<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
<br />

<div id="container">
    <a id="pickfiles" href="javascript:;"><button type="button" class="btn btn-default">Select Files</button></a> 
    <a id="uploadfiles" href="javascript:;"><button type="button" class="btn btn-primary">Upload</button></a>
</div>

<br />
<pre id="console"></pre>


<script type="text/javascript">
// Custom example logic
var upload_file = '<?php echo $uploadfile; ?>';
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass an id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : upload_file,
	flash_swf_url : '<?= $js; ?>/Moxie.swf',
	silverlight_xap_url : '<?= $js; ?>/Moxie.xap',
	
	filters : {
		max_file_size : '5000mb',
		mime_types: [
			{title : "Text Files", extensions : "txt"}
		]
	},

	init: {
		PostInit: function() {
			document.getElementById('filelist').innerHTML = '';

			document.getElementById('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		},

		FileUploaded: function(up, file, data){
			console.log(data.response);
			// var obj = JSON.parse(data.response); 
			if(data.response == 'Connection Failure'){
				document.getElementById('console').appendChild(document.createTextNode("\nError #" + data.response));
			}
			else{
				var obj = JSON.parse(data.response); 
				document.getElementById('console').appendChild(document.createTextNode("\nMessage #" + obj.result +"\nFilename #"+obj.filename));
			}
		},

		Error: function(up, err) {
			document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
		}
	}
});

uploader.init();

</script>