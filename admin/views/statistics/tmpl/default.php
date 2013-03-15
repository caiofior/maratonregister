<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$db = JFactory::getDBO();
?>
<h1>Statistiche</h1>
<table>
    <tbody>
        <tr>
            <th>Iscritti</th>
            <td><?php 
            $query = '
                    SELECT COUNT(*) FROM `#__atlete` WHERE removed <> 1;
                ';
                $db->setQuery($query);
                echo $db->loadResult();
            ?></td>
        </tr>
        <tr>
            <th>Voci archivio tesserati FIDAL</th>
            <td><?php 
            $query = '
                    SELECT COUNT(*) FROM `#__fidal_fella` ;
                ';
                $db->setQuery($query);
                echo $db->loadResult();
            ?></td>
        </tr>
        <tr>
            <th>Pettorale più basso</th>
            <td><?php 
            $query = '
                    SELECT MIN(`pectoral`) FROM `#__atlete` WHERE removed <> 1;
                ';
                $db->setQuery($query);
                $p = $db->loadResult();
                if ($p >0 ) echo $p ;
                else echo '--';
            ?></td>
        </tr>
        <tr>
            <th>Pettorale più alto</th>
            <td><?php 
            $query = '
                    SELECT MAX(`pectoral`) FROM `#__atlete` WHERE removed <> 1;
                ';
                $db->setQuery($query);
                $p = $db->loadResult();
                if ($p > 0 ) echo $p ;
                else echo '--';
            ?></td>
        </tr>
    </tbody>
</table>
<form action="<?php echo JRoute::_('index.php?option=com_maratonregister'); ?>"
    <input type="hidden" id="task" name="task" value="fidal" />
    <?php echo JHtml::_('form.token'); ?>
</form>