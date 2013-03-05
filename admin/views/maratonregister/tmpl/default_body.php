<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo $item->id; ?>
                </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                        <?php echo $item->first_name; ?> <?php echo $item->last_name; ?>
                </td>
                <td>
                        <?php echo $item->date_of_birth; ?>
                </td>
                <td>
                        <?php echo $item->num_tes; ?>
                </td>
                <td>
                        <?php echo $item->city; ?>
                </td>
                <td>
                        <?php echo $item->registration_datetime; ?>
                </td>
                <td>
                    
                </td>
        </tr>
<?php endforeach; ?>