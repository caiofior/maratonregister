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
if (key_exists('submit', $_REQUEST) && key_exists('file', $_REQUEST)) {
    if (is_string($_REQUEST['file'])) {
        $_REQUEST['file']=array($_REQUEST['file']);
    }
    $targetDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'plupload'.DIRECTORY_SEPARATOR;


    foreach ($_REQUEST['file'] as $file ) {
        ob_start();
        if(is_file($targetDir.$file.'.csv')) {
            echo '<p>Elaborazione del file '.$file.'.csv</p>';
            ob_flush();
            flush();
            $file = fopen($targetDir.$file.'.csv','r');
            if ($file  !== false) {
            fseek($file, -1, SEEK_END);
            $last = ftell($file);
            fseek($file, 0);
            $headers= array(
                0=>'num_tes',
                1=>'categ',
                2=>'cod_soc',
                3=>'denom',
                4=>'dat_mov',
                5=>'cogn',
                6=>'nome',
                7=>'dat_nas',
                8=>'stran',
                9=>'cod_reg'
            );
            $n =0;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $db->setQuery('START TRANSACTION;');
            $db->query();
            while (($row = fgetcsv($file, 1000, ';')) !== false) {
                set_time_limit(0);
                if ($n == 0) {
                    foreach ($row as $key=>$value)
                        $headers[$key] =  strtolower ($value); 
                }
                else {

                    $values = array();
                    foreach ($row as $key=>$data) {
                        $values[$key]=$db->quote($data);
                    }
                    $rheaders = array_flip($headers);
                    $query = $db->getQuery(true);
                    $query->delete($db->quoteName('#__fidal_fella'))
                            ->where('num_tes ="'.$row[$rheaders['num_tes']].'"');
                    $db->setQuery($query);
                    $db->query();
                    $query = $db->getQuery(true);
                    $query
                        ->insert($db->quoteName('#__fidal_fella'))
                        ->columns($db->quoteName($headers))
                        ->values(implode(',', $values));
                    $db->setQuery($query);
                    $db->query();
                }
                $n ++;

                if (intval($n/10)== $n/10) {
                    ob_flush();
                    flush();
                    echo '<p>Elaborazione in corso '.intval(ftell($file)/$last*100).' %</p>';
                    echo str_repeat(' ', 1000);
                    ob_flush();
                    flush();
                }
            }
            $query = $db->getQuery(true);
            $db->setQuery('COMMIT;');
            $db->query();
            }

        }
    }
    ob_end_flush();
} 
?>
<form action="<?php echo JRoute::_('index.php?option=com_maratonregister&task=import'); ?>" method="post" name="adminForm" enctype="multipart/form-data">
<div id="container">
    <div id="filelist">Modalità di caricamento.</div>
    <br />
    <a id="pickfiles" href="javascript:;">Seleziona i file</a> 
    <a id="uploadfiles" href="javascript:;">Carica i file</a>
</div>
    <input disabled="disabled" type="submit" id="submit" name="submit" value="Importa">
</form>
<script type="text/javascript">
// Custom example logic
function $(id) {
	return document.getElementById(id);
}


var uploader = new plupload.Uploader({
	runtimes : 'gears,html5,flash,silverlight,browserplus',
        unique_names : true,
	browse_button : 'pickfiles',
	container: 'container',
        multipart:true,
        chunk_size: '100kb',
	max_file_size : '20mb',
	url : 'components/com_maratonregister/upload.php',
	flash_swf_url : 'components/com_maratonregister/plupload/plupload.flash.swf',
	silverlight_xap_url : 'components/com_maratonregister/plupload/plupload.silverlight.xap',
	filters : [
		{title : "CSV", extensions : "csv"}
	]
});
uploader.bind('Init', function(up, params) {
	document.getElementById('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
});

uploader.bind('FilesAdded', function(up, files) {
	for (var i in files) {
            if (typeof files[i] == 'object') {
		document.getElementById('filelist').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
            }
	}
});

uploader.bind('UploadProgress', function(up, file) {
	document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
});
uploader.bind('UploadComplete', function(up, files) {
        for (var i in files) {
            if (typeof files[i] == 'object') {
		el = new Element('input');
                el.setProperty('type','hidden');
                el.setProperty('name','file[]');
                el.setProperty('value',files[i].id);
                $("submit").grab(el,'before');
            }
	}
        $("submit").removeProperty("disabled");
	console.log(files);
});
uploader.bind('Error', function(up, error) {
	console.log(error);
});
$('uploadfiles').onclick = function() {
	uploader.start();
	return false;
};
uploader.init();
</script>