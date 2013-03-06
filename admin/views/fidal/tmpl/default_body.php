<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->num_tes; ?>
                </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->num_tes); ?>
                </td>
                <td>
                        <?php echo $item->nome; ?>
                </td>
                <td>
                        <?php echo $item->cogn; ?>
                </td>
                <td>
                        <?php echo $item->dat_nas; ?>
                </td>
                <td>
                    <a href="<?php echo JRoute::_('?option=com_maratonregister&task=fidal&view=maratonregister&layout=edit&id='.$item->id); ?>">
							Modifica</a>
                </td>
        </tr>
<?php endforeach; ?>