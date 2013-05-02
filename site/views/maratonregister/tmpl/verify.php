<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.7
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
    <?php if (!is_null($this->atlete) && !is_null($this->atlete->id)) :    ?>
    <p>Benvenuto <?php echo $this->atlete->first_name; ?> <?php echo $this->atlete->last_name; ?></p>
    <p class="confirmed">Ti sei registrato il <?php echo format_date($this->atlete->registration_datetime); ?> </p>
    <?php if ($this->atlete->payment_datetime == '') :?>
    <p class="unconfirmed">Non ci è perventuo il tuo pagamento</p>
    <?php else : ?>
    <p class="confirmed">Abbiamo ricevuto il tuo pagamento il <?php echo format_date($this->atlete->payment_datetime); ?> ed è in attesa di conferma</p>
    <?php if ($this->atlete->payment_confirm_datetime == '') :?>
    <p class="info">Il tuo pagamento è in attesa di conferma.</p>
    <?php else : ?>
    <p class="confirmed">Il tuo pagamento è stato confermato il <?php echo format_date($this->atlete->payment_confirm_datetime); ?>.</p>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->atlete->num_tes == '') : ?>
    <?php if ($this->atlete->medical_certificate_fname == '' ) :?>
    <p class="unconfirmed">Non ci è arrivato un tuo certificato medico.</p>
    <?php else : ?>
    <p class="confirmed">Ci hai inviato il tuo certificato medico il <?php echo format_date($this->atlete->medical_certificate_datetime); ?>.</p>
    <?php if ($this->atlete->medical_certificate_confirm_datetime == '' ) :?>
    <p class="info">Il certificato medico è in attesa di conferma</p>
    <?php else : ?>
    <p class="confirmed">Il certificato medico è stato confermato il <?php echo format_date($this->atlete->medical_certificate_confirm_datetime); ?></p>
    <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->atlete->pectoral == ''):?>
    <p class="info">La tua iscrizione non è stata confermata dall'organizzazione</p>
    <?php else: ?>
    <p class="confirmed">La tua iscrizione è confermata dall'organizzazione.</p>
    <?php endif; ?>
    <?php elseif (!is_null($this->atlete)) : ?>
    <p class="unconfirmed">Non risulti registrato alla Maratonina dei Borghi di Pordenone. <a href="?option=com_maratonregister">Registrati</a>
    </p>
    <?php endif; ?>
    <?php if (key_exists('message', $_REQUEST)) : ?>
    <p><?php echo $_REQUEST['message']; ?></p>
    <?php endif; ?>
    <form action="?option=com_maratonregister&task=verify" method="post" id="registration" name="registration" enctype="multipart/form-data">
    <fieldset >
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
    <input type="submit" id="submit" name="submit" value="Controlla"/>
    </form>
 

