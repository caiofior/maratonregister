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
                    <a  class="toolbar" href="<?php echo JRoute::_('?option=com_maratonregister&task=fidal&view=fidal&layout=edit&num_tes='.$item->num_tes); ?>"title="Dettagli">
                        <span style="display: block; width: 32px; height: 32px;" class="icon-32-forward"></span>
                    </a>
                </td>
        </tr>
<?php endforeach; ?>