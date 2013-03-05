<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
        <th width="5">
                Identificativo
        </th>
        <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>                   
        <th>
                Nome e Cognome
        </th>
        <th>
                Data di nascita
        </th>
        <th>
                Numero tessera FIDAS
        </th>
        <th>
                Città
        </th>
        <th>
                Data regsitrazione
        </th>
        <th>
                Azioni
        </th>
</tr>