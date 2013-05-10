<?php
 // No direct access
defined('_JEXEC') or die('Restricted access'); 
$document = JFactory::getDocument();

$document->addScript('http://bp.yahooapis.com/2.4.21/browserplus-min.js');
$document->addScript(JURI::root().'administrator/components/com_maratonregister/plupload/plupload.js');
$document->addScript(JURI::root().'administrator/components/com_maratonregister/plupload/plupload.gears.js');
$document->addScript(JURI::root().'administrator/components/com_maratonregister/plupload/plupload.silverlight.js');
$document->addScript(JURI::root().'administrator/components/com_maratonregister/plupload/plupload.flash.js');
$document->addScript(JURI::root().'administrator/components/com_maratonregister/plupload/plupload.browserplus.js');
$document->addScript(JURI::root().'administrator/components/com_maratonregister/plupload/plupload.html4.js');
$document->addScript(JURI::root().'administrator/components/com_maratonregister/plupload/plupload.html5.js');


JHtml::_('behavior.framework');

?>
<form action="<?php echo JRoute::_('index.php?option=com_maratonregister&task=import'); ?>" method="post" name="adminForm" enctype="multipart/form-data">
<div id="container">
    <div id="filelist">Modalità di caricamento.</div>
    <br />
    <a id="pickfiles" href="javascript:;">Seleziona i file</a> 
    <a id="uploadfiles" href="javascript:;">Carica i file</a>
</div>
</form>
<a href="https://www.facebook.com/caiofior/" title="Realizzato da Claudio Fior">&#169; 2013 by <img src="http://www.gravatar.com/avatar/2e8d2d37da66c6874a65f69879f8e590.png" width="10" height="10" alt="Claudio Fior" /></a>
<script type="text/javascript">
// Custom example logic
function $(id) {
	return document.getElementById(id);
}


var uploader = new plupload.Uploader({
	runtimes : "gears,html5,flash,silverlight,browserplus",
        unique_names : true,
	browse_button : "pickfiles",
	container: "container",
        multipart:true,
        chunk_size: "100kb",
	max_file_size : "20mb",
	url : "components/com_maratonregister/upload.php",
	flash_swf_url : "components/com_maratonregister/plupload/plupload.flash.swf",
	silverlight_xap_url : "components/com_maratonregister/plupload/plupload.silverlight.xap",
	filters : [
		{title : "CSV", extensions : "csv"}
	]
});
uploader.bind("Init", function(up, params) {
	document.getElementById("filelist").innerHTML = "<div>Mdoalità di caricamento: " + params.runtime + "</div>";
});

uploader.bind("FilesAdded", function(up, files) {
	for (var i in files) {
            if (typeof files[i] == "object") {
		document.getElementById("filelist").innerHTML += "<div id=\"" + files[i].id + "\">" + files[i].name + " (" + plupload.formatSize(files[i].size) + ") <b></b></div>";
            }
	}
});

uploader.bind("UploadProgress", function(up, file) {
	document.getElementById(file.id).getElementsByTagName("b")[0].innerHTML = "<span>" + file.percent + "%</span>";
});
uploader.bind('UploadComplete', function(up, files) {
        for (var i in files) {
            if (typeof files[i] == 'object') {
                resp = import_data(files[i].id,0);
                while(
                        resp.position !== "end" &&
                        resp.position !== "error"
                    ) {
                            resp = import_data(files[i].id,resp.position);
                    }
            }
	}
});
uploader.bind("Error", function(up, error) {
	console.log(error);
});
$("uploadfiles").onclick = function() {
	uploader.start();
	return false;
};
function import_data (filename,position) {
            
               var resp = "";
                   new Request.JSON({
                   async:false,
                   url:"components/com_maratonregister/import.php",
                   data: {
                       filename : filename,
                       position : position
                   },
                   onSuccess: function (responseJSON) {
                       resp = responseJSON;
                       document.getElementById(filename).getElementsByTagName("b")[0].innerHTML = "<span>" + responseJSON.message + "</span>";
                   }
                }).send(); 
                return resp;
}
uploader.init();
</script>