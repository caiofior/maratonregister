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
                        <?php if ($item->payment_confirm_datetime == '') :?>
                            <a class="jgrid hasTip"  title="Pagamento non confermato">
                                <span class="state unpublish">
                                    <span class="text">Pagamento non confermato</span>
                                </span>
                            </a>
                        <?php else : ?>
                            <a class="jgrid hasTip"  title="Pagamento confermato">
                                <span class="state publish">
                                    <span class="text">Pagamento confermato</span>
                                </span>
                            </a>
                        <?php endif; ?>
                        <?php if ($item->medical_certificate_confirm_datetime == '' ) :?>
                            <a class="jgrid hasTip"  title="Certificato medico non confermato">
                                <span class="state unpublish">
                                    <span class="text">Certificato medico non confermato</span>
                                </span>
                            </a>
                        <?php else : ?>
                            <a class="jgrid hasTip"  title="Certificato medico confermato">
                                <span class="state publish">
                                    <span class="text">Certificato medico confermato</span>
                                </span>
                            </a>
                        <?php endif; ?>
                    <?php if ($item->pectoral == '' ) :?>
                            <a class="jgrid hasTip"  title="Numero di pettorale non assegnato">
                                <span class="state unpublish">
                                    <span class="text">Numero di pettorale non assegnato</span>
                                </span>
                            </a>
                        <?php else : ?>
                            <a class="jgrid hasTip"  title="Pettorale assegnato">
                                <span class="state publish">
                                    <span class="text">Pettorale assegnato</span>
                                </span>
                                Pettorale : <?php echo $item->pectoral;?>
                            </a>
                        <?php endif; ?>
                        <?php if ($item->id == $item->group_reference_id) :?>
                        Referente di gruppo
                        <?php elseif ($item->group_reference_id != '') :?>
                        Membro di gruppo
                        <?php endif; ?>
                </td>
                <td>
                    <a  class="toolbar" href="<?php echo JRoute::_('?option=com_maratonregister&view=maratonregister&layout=edit&id='.$item->id); ?>">
                        <span style="display: block; width: 32px; height: 32px;" class="icon-32-edit"></span>
                    </a>
                </td>
        </tr>
<?php endforeach; ?>