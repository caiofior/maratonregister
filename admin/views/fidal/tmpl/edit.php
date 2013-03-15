<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<h1>Dati tesserato</h1>
<table>
    <tbody>
        <tr>
            <th>Nome</th>
            <td><?php echo $this->item->nome;?></td>
        </tr>
        <tr>
            <th>Cognome</th>
            <td><?php echo $this->item->cogn;?></td>
        </tr>
        <tr>
            <th>Data di nascita</th>
            <td><?php echo $this->item->dat_nas;?></td>
        </tr>
        <tr>
            <th>Numero tessera</th>
            <td><?php echo $this->item->num_tes;?></td>
        </tr>
        <tr>
            <th>Categoria</th>
            <td><?php echo $this->item->categ;?></td>
        </tr>
        <tr>
            <th>Società</th>
            <td><?php echo $this->item->denom;?></td>
        </tr>
        <tr>
            <th>Straniero</th>
            <td><?php echo $this->item->stran;?></td>
        </tr>
        <tr>
            <th>Regione</th>
            <td><?php echo $this->item->cod_reg;?></td>
        </tr>
    </tbody>
</table>
<form action="<?php echo JRoute::_('index.php?option=com_maratonregister'); ?>"
    <input type="hidden" id="task" name="task" value="fidal" />
    <?php echo JHtml::_('form.token'); ?>
</form>