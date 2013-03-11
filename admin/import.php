<?php
ini_set('display_errors',1);
ini_set('html_errors',1);
$config_file = dirname(__FILE__).DIRECTORY_SEPARATOR.
        '..'.DIRECTORY_SEPARATOR.
        '..'.DIRECTORY_SEPARATOR.
        '..'.DIRECTORY_SEPARATOR.
        'configuration.php';
if (!is_file($config_file)) 
    $config_file = '/home/caiofior/public_html/maratoninadeiborghi.it.master/configuration.php';
    
require ($config_file);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
$jconfig = new JConfig();
$mysqli = new mysqli($jconfig->host, $jconfig->user, $jconfig->password, $jconfig->db);
$table_name = $jconfig->dbprefix.'fidal_fella';
$targetDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'plupload'.DIRECTORY_SEPARATOR;
$file = fopen($targetDir.$_REQUEST['filename'].'.csv','r');

if ($file  === false) {
    echo json_encode(array(
        'position'=>'error',
        'message'=>'Errore nell\'importazione'
    ));
    exit;
}
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
if (($row = fgetcsv($file, 1000, ';')) !== false) {
    foreach ($row as $key=>$value)
        $headers[$key] =  strtolower ($value); 
}
fseek($file, -1, SEEK_END);
$last = ftell($file);
if (key_exists('position', $_REQUEST))
    fseek($file, intval($_REQUEST['position']));
else {
    fseek($file, 0);
    $_REQUEST['position']=0;
}

$n =0;
$row = fgetcsv($file, 1000, ';');
$mysqli->autocommit(false);
$rheaders = array_flip($headers);
while (($row = fgetcsv($file, 1000, ';')) !== false) {
    $values = array();
    
    foreach ($row as $key=>$data) {
        $key_name = $headers[$key];
        if (
                $key_name == 'dat_mov' ||
                $key_name == 'dat_nas'
            ) {
            $day = strptime($data,'%d/%m/%Y');
            $day = mktime(0, 0, 0, $day['tm_mon']+1, $day['tm_mday'], $day['tm_year']+1900);
            $values[$key]=  '"'.addslashes(strftime('%Y-%m-%d', $day)).'"';
            
            }
            else
            $values[$key]=  '"'.addslashes($data).'"';
    }
    $query = 'DELETE FROM '.$table_name.' WHERE num_tes='.$values[$rheaders['num_tes']];
    $mysqli->query($query);
    $query = 'INSERT INTO '.$table_name.' SET ';
    foreach ($values as $key=>$value) {
        if ($key > 0)
            $query .= ', ';
        $query .= $headers[$key].'='.$value;
    }
    $mysqli->query($query);
    $n ++;
    if (intval($n/1000)== $n/1000) {
        $mysqli->commit();
        echo json_encode(array(
            'position'=>max(ftell($file),intval($_REQUEST['position'])),
            'message'=>'Importazione '.intval(ftell($file)/$last*100).'%'
        ));
        exit;
    }
    
}
$mysqli->commit();
echo json_encode(array(
    'position'=>'end',
    'message'=>'Importazione completata'
));
