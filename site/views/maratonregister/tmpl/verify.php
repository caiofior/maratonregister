<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.6.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$errors = $this->getModel()->getErrors();
?>
    <h1>Verifica lo stato della registrazione</h1>
    <?php if (!is_null($this->atlete) && !is_null($this->atlete->id)) :    ?>
    <p>Benvenuto <?php echo $this->atlete->first_name; ?> <?php echo $this->atlete->last_name; ?></p>
    <p>Ti sei registrato il <?php echo $this->atlete->registration_datetime; ?> </p>
    <?php if ($this->atlete->payment_datetime == '') :?>
    <p>Non ci è perventuo il tuo pagamento</p>
    <?php else : ?>
    <p>Abbiamo ricevuto il tuo pagamento il <?php echo $this->atlete->payment_datetime; ?></p>
    <?php if ($this->atlete->payment_confirm_datetime == '') :?>
    <p>Il tuo pagamento è in attesa di conferma.</p>
    <?php else : ?>
    <p>Il tuo pagamento è stato confermato il <?php echo $this->atlete->payment_confirm_datetime; ?>.</p>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->atlete->num_tes == '') : ?>
    <?php if ($this->atlete->medical_certificate_fname == '' ) :?>
    <p>Non ci è arrivato un tuo certificato medico.</p>
    <?php else : ?>
    <p>Ci hai inviato il tuo certificato medico il <?php echo $this->atlete->medical_certificate_datetime; ?>.</p>
    <?php if ($this->atlete->medical_certificate_confirm_datetime == '' ) :?>
    <p>È in attesa di conferma</p>
    <?php else : ?>
    <p>È stato confermato il <?php echo $this->atlete->medical_certificate_confirm_datetime; ?></p>
    <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <?php elseif (!is_null($this->atlete)) : ?>
    <p>Non risulti registrato alla maratona. <a href="?option=com_maratonregister">Registrati</a>
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
 

