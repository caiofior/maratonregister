<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('stylesheet','components/com_maratonregister/assets/css/com_maratonregister.css');
$errors = $this->getModel()->getErrors();
function format_date ($data) {
    $datetime = strptime($data, '%Y-%m-%d %H:%M:%S');
                    
                    $add_year = 1900;
                    if ($datetime['tm_year'] < 20) 
                        $add_year = 2000;
                    $datetime = mktime (
                            $datetime['tm_hour'],
                            $datetime['tm_min'],
                            $datetime['tm_sec'],
                            $datetime['tm_mon']+1,
                            $datetime['tm_mday'],
                            $datetime['tm_year']+$add_year);
                    return strftime('%d/%m/%Y  %H:%M',$datetime);
}
?>
    <h1>Verifica lo stato della registrazione</h1>
    <form action="?option=com_maratonregister&task=verify" method="post" id="registration" name="registration" enctype="multipart/form-data">
    <?php if (!is_null($this->atlete) && !is_null($this->atlete->id)) :    ?>
    <input type="hidden" id="atlete_id" name="atlete_id" value="<?php echo $this->atlete->id;?>" />
    <p>Benvenuto <?php echo $this->atlete->first_name; ?> <?php echo $this->atlete->last_name; ?></p>
    <?php if( $this->atlete->group_reference_id != '') :
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query
        ->select('denom')
        ->from('#__fidal_fella')
        ->where('num_tes = '.$db->quote($this->atlete->num_tes));
    $db->setQuery($query);
    $db->query();
    $group_name = $db->loadResult();
?>
    <p>Fai parte del gruppo <?php echo $this->atlete->group_reference_id; ?> <?php echo $group_name; ?>:</p>
    <ul>
        <?php 
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('id,num_tes,pectoral');
                // From the hello table
                $query->from('#__atlete')->where(' (group_reference_id = '.$this->atlete->group_reference_id.'  AND id <> '.$db->quote($this->atlete->group_reference_id).') ');
                $db->setQuery($query);
                $db->query();
                $members = $db->loadObjectList();
        
        foreach($members as $member) : ?>
        <li>
            Tessera n°<?php echo $member->num_tes; ?>
            <?php if ($member->pectoral == '') :?>
            Pettorale non assegnato
            <?php else : ?>
            Pettorale <?php echo $member->pectoral; ?>
            <?php endif ?>
        </li>    
        <?php endforeach; ?>
    </ul>
    <?php endif;?>
    <p class="confirmed">Ti sei registrato il <?php echo format_date($this->atlete->registration_datetime); ?> </p>
    <?php if ( $this->atlete->payment_fname == '' ) :?>
    <p class="unconfirmed">Non è perventuo il tuo pagamento</p>
    <fieldset id="payment_type_updater">
    <legend>Modalità di pagamento</legend>
    <?php $disabled= ''; 
    if ($this->item->payment_confirm_datetime != '')
        $disabled= 'disabled="disabled"';  ?>
    <label for="bank_transfer">Bonifico bancario</label>
    <input <?php echo $disabled;?> <?php echo ($this->atlete->payment_type == 'bank_transfer' ? 'checked="checked"' : ''); ?> type="radio" id="bank_transfer" name="payment_type" value ="bank_transfer" />
    <label for="money_order">Bollettino postale</label>
    <input <?php echo $disabled;?> <?php echo ($this->atlete->payment_type == 'money_order' ? 'checked="checked"' : ''); ?> type="radio" id="money_order" name="payment_type" value ="money_order" />
    <label for="paypal">Paypal</label>
    <input <?php echo $disabled;?> <?php echo ($this->atlete->payment_type == 'paypal' ? 'checked="checked"' : ''); ?> type="radio" id="paypal" name="payment_type" value="paypal" />
    <div>
    <label for="payment_fname">Carica la ricevuta di pagamento</label>
    <div class="fileinputs">
        <input class="file" type="file" id="payment_fname" name="payment_fname" value ="" />
    </div>
    <?php if (key_exists('payment_fname', $errors)) echo '<p class="error">'.$errors['medical_certificate']['message'].'</p>';?>
    </div>
    </fieldset>
    <?php else : ?>
    <p class="confirmed">Abbiamo ricevuto il tuo pagamento il <?php echo format_date($this->atlete->payment_datetime); ?>.</p>
    <?php endif; ?>
    <?php if ($this->atlete->payment_confirm_datetime != '') :?>
    <p class="confirmed">Il tuo pagamento è stato confermato il <?php echo format_date($this->atlete->payment_confirm_datetime); ?>.</p>
    <?php elseif ($this->atlete->payment_fname != '' ): ?>
    <p class="info">Il tuo pagamento è in attesa di conferma.</p>
    <?php endif; ?>
    <?php if ($this->atlete->num_tes == '') : ?>
    <?php if ($this->atlete->medical_certificate_fname == '' ) :?>
    <p class="unconfirmed">Non è arrivato un tuo certificato medico.</p>
    <fieldset id="medical_certificate_updater">
    <div>
        <a href="components/com_maratonregister/images/health_form.pdf" class="targetblank" title="Autocertificazione buona salute per atleti stranieri">
            Autocertificazione buona salute per atleti stranieri
            <img width="100" hight="142" src ="components/com_maratonregister/images/health_form.jpg" alt="Autocertificazione buona salute per atleti stranieri" style="float: left;"/>
        </a>
    </div>
    <label for="medical_certificate">Carica il tuo Certificato Medico</label>
    <div class="fileinputs">
        <input class="file" type="file" id="medical_certificate" name="medical_certificate" value ="" />
    </div>
    <?php if (key_exists('medical_certificate', $errors)) echo '<p class="error">'.$errors['medical_certificate']['message'].'</p>';?>
    </fieldset>
    <?php else : ?>
    <p class="confirmed">Hai inviato il tuo certificato medico il <?php echo format_date($this->atlete->medical_certificate_datetime); ?>.</p>
    <?php if ($this->atlete->medical_certificate_confirm_datetime == '' ) :?>
    <p class="info">Il certificato medico è in attesa di conferma.</p>
    <?php else : ?>
    <p class="confirmed">Il certificato medico è stato confermato il <?php echo format_date($this->atlete->medical_certificate_confirm_datetime); ?>.</p>
    <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->atlete->num_tes == '') : ?>
    <?php if ($this->atlete->game_card_fname == ''):?>
    <p class="unconfirmed">Non è arrivato il tuo cartellino di partecipazione.</p>
    <fieldset id="game_card_updater">
    <div>
        <a href="components/com_maratonregister/images/game_card.pdf" class="targetblank" title="Cartellino di partecipazione gare su strada">
            Cartellino di partecipazione gare su strada
            <img width="100" hight="142" src ="components/com_maratonregister/images/game_card.jpg" alt="Cartellino di partecipazione gare su strada" style="float: left;"/>
        </a>
    </div>
    <label for="game_card_fname">Carica il tuo cartellino di partecipazione compilato</label>
    <div class="fileinputs">
        <input class="file" type="file" id="game_card_fname" name="game_card_fname" value ="" />
    </div>
    <?php if (key_exists('game_card_fname', $errors)) echo '<p class="error">'.$errors['game_card_fname']['message'].'</p>';?>
    </fieldset>
    <?php else: ?>
    <p class="confirmed">Il tuo cartellino di partecipazione è arrivato il <?php echo format_date($this->atlete->$this->atlete->game_card_datetime); ?>.</p>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->atlete->pectoral == ''):?>
    <p class="info">La tua iscrizione non è stata confermata dall'organizzazione.</p>
    <?php else: ?>
    <p class="confirmed">La tua iscrizione è confermata dall'organizzazione.</p>
    <?php endif; ?>
    <?php elseif (!is_null($this->atlete)) : ?>
    <p class="unconfirmed">Non risulti registrato alla <?php echo JComponentHelper::getParams('com_maratonregister')->get('maraton_name','Maratonina dei borghi di Pordenone');?>. <a href="?option=com_maratonregister">Registrati</a>
    </p>
    <?php endif; ?>
    <?php if (key_exists('message', $_REQUEST)) : ?>
    <p><?php echo $_REQUEST['message']; ?></p>
    <?php endif; ?>
    <fieldset id="atlete_data">
    <div>
    <label for="first_name">Nome</label>
    <input id="first_name" name="first_name" value ="" />
    <?php if (key_exists('first_name', $errors)) echo '<p class="error">'.$errors['first_name']['message'].'</p>';?>
    </div>
    <div>
    <label for="last_name">Cognome</label>
    <input id="last_name" name="last_name" value ="" />
    </div>
    <div>
    <label for="date_of_birth">Data di nascita</label>
    <?php echo JHTML::calendar($this->escape(""), 'date_of_birth', 'date_of_birth', '%d/%m/%Y'); ?>
    <?php if (key_exists('date_of_birth', $errors)) echo '<p class="error">'.$errors['date_of_birth']['message'].'</p>';?>
    </div>
    <div>
    <?php if (key_exists('last_name', $errors)) echo '<p class="error">'.$errors['last_name']['message'].'</p>';?>
    <label for="num_tes">N° Tessera Fidal</label>
    <input id="num_tes" name="num_tes" value ="" />
    <?php if (key_exists('num_tes', $errors)) echo '<p class="error">'.$errors['num_tes']['message'].'</p>';?>
    </div>
    </fieldset>
    <input type="submit" id="submit" name="submit" value="Controlla / Aggiorna"/>
    </form>
    <a id="author" href="https://www.facebook.com/caiofior/" title="Realizzato da Claudio Fior">&#169; 2013 by <img src="http://www.gravatar.com/avatar/2e8d2d37da66c6874a65f69879f8e590.png" width="10" height="10" alt="Claudio Fior" /></a>
    <script type="text/javascript" src="components/com_maratonregister/assets/js/verify.js"></script>

