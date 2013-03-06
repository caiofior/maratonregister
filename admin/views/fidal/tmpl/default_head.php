<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
        <th width="5">
                Numero tessera FIDAS
        </th>
        <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>                   
        <th>
                Nome
        </th>
        <th>
                Cognome
        </th>
        <th>
                Data di nascita
        </th>
        <th>
                Azioni
        </th>
</tr>