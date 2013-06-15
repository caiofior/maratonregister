<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.0
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('stylesheet','components/com_maratonregister/assets/css/com_maratonregister.css');
$errors = $this->getModel()->getErrors();
?>
<h1>Registrati</h1>
<?php if (key_exists('message', $_REQUEST)) : ?>
<p><?php echo $_REQUEST['message']; ?></p>
<?php endif; ?>
<p>Gia registrato? <a href="?option=com_maratonregister&amp;task=verify">Verifica lo stato della tua iscrizione</a></p>
<form action="?option=com_maratonregister" method="post" id="registration" name="registration" enctype="multipart/form-data">
    <a id="fidal" href="?option=com_maratonregister" title="Tesserato Fidal">
        <img style="opacity:0.6; filter:alpha(opacity=40); " src="components/com_maratonregister/images/fidal.png" width="187" height="68" alt="Tesserato Fidal"/>
    </a>
    <a id="other_ass" href="?option=com_maratonregister" title="Tesserato altra federazione">
        <img style="opacity:0.6; filter:alpha(opacity=40); " src="components/com_maratonregister/images/altra_societa.png" width="187" height="68" alt="Tesserato altra federazione"/>
    </a>
    <a id="amateur" href="?option=com_maratonregister" title="Non tesserati fidal">
        <img  src="components/com_maratonregister/images/amatore.png" width="187" height="68" alt="Amatore"/>
    </a>
    <fieldset id="name_container">
    <input type="hidden" id="type_of_check" name="type_of_check" value="amateur"/>
    <label for="first_name">Nome</label>
    <input id="first_name" name="first_name" value ="" />
    <?php if (key_exists('first_name', $errors)) echo '<p class="error">'.$errors['first_name']['message'].'</p>';?>
    <label for="last_name">Cognome</label>
    <input id="last_name" name="last_name" value ="" />
    <?php if (key_exists('last_name', $errors)) echo '<p class="error">'.$errors['last_name']['message'].'</p>';?>
    </fieldset>
    <fieldset id="num_tes_container" style="display: none;">
    <label for="num_tes">N° Tessera Fidal</label>
    <input id="num_tes" name="num_tes" value ="" />
    <?php if (key_exists('num_tes', $errors)) echo '<p class="error">'.$errors['num_tes']['message'].'</p>';?>
    </fieldset>
    <fieldset id="other_num_tes_container" style="display: none;">
    <label for="other_ass_name">Nome Associazione</label>
    <input id="other_ass_name" name="other_ass_name" value ="" />
    <?php if (key_exists('other_ass_name', $errors)) echo '<p class="error">'.$errors['other_ass_name']['message'].'</p>';?>
    <label for="other_num_tes">N° Tessera</label>
    <input id="other_num_tes" name="other_num_tes" value ="" />
    <?php if (key_exists('other_num_tes', $errors)) echo '<p class="error">'.$errors['other_num_tes']['message'].'</p>';?>
    </fieldset>
    <fieldset>
    <label for="date_of_birth">Data di nascita</label>
    <?php echo JHTML::calendar($this->escape(""), 'date_of_birth', 'date_of_birth', '%d/%m/%Y'); ?>
    <?php if (key_exists('date_of_birth', $errors)) echo '<p class="error">'.$errors['date_of_birth']['message'].'</p>';?>
    </fieldset>
    <fieldset id="sex_container">
    <legend>Sesso</legend>
    <label for="male">M</label>
    <input type="radio" id="male" name="sex" value ="M" />
    <label for="female">F</label>
    <input type="radio" id="female" name="sex" value ="F" />
    <?php if (key_exists('sex', $errors)) echo '<p class="error">'.$errors['sex']['message'].'</p>';?>
    </fieldset>
    <fieldset id="citizenship_container">
    <label for="citizenship">Cittadinanza</label>
    <input id="citizenship" name="citizenship" value ="" />
    <?php if (key_exists('citizenship', $errors)) echo '<p class="error">'.$errors['citizenship']['message'].'</p>';?>
    </fieldset>
    <fieldset id="address_container">
    <label for="address">Indirizzo</label>
    <input id="address" name="address" value ="" />
        <?php if (key_exists('address', $errors)) echo '<p class="error">'.$errors['address']['message'].'</p>';?>
    <label for="zip">CAP</label>
    <input id="zip" name="zip" value ="" />
        <?php if (key_exists('zip', $errors)) echo '<p class="error">'.$errors['zip']['message'].'</p>';?>
    <label for="city">Città</label>
    <input id="city" name="city" value ="" />
        <?php if (key_exists('city', $errors)) echo '<p class="error">'.$errors['city']['message'].'</p>';?>
    </fieldset>
    <fieldset id="phone_container">
    <label for="phone">Telefono</label>
    <input id="phone" name="phone" value ="" />
        <?php if (key_exists('phone', $errors)) echo '<p class="error">'.$errors['phone']['message'].'</p>';?>
    </fieldset>
    <fieldset id="medical_certificate_container">
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
    <fieldset id=game_card_container">
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
    <fieldset id="payment_type_container">
    <legend>Modalità di pagamento</legend>
    <label for="bank_transfer">Bonifico bancario</label>
    <input type="radio" id="bank_transfer" name="payment_type" value ="bank_transfer" />
    <label for="money_order">Bollettino postale</label>
    <input type="radio" id="money_order" name="payment_type" value ="money_order" />
    <label for="paypal">Paypal</label>
    <input type="radio" id="paypal" name="payment_type" value="paypal" />
    <?php if (key_exists('payment_type', $errors)) echo '<p class="error">'.$errors['payment_type']['message'].'</p>';?>
    <div>
    <label for="payment_fname">Carica la ricevuta di pagamento</label>
    <div class="fileinputs">
        <input class="file" type="file" id="payment_fname" name="payment_fname" value ="" />
    </div>
    <?php if (key_exists('payment_fname', $errors)) echo '<p class="error">'.$errors['medical_certificate']['message'].'</p>';?>
    </div>
    </fieldset>
    <fieldset id="email_container">
    <label for="email">Email</label>
    <input id="email" name="email" value ="" />
    <?php if (key_exists('email', $errors)) echo '<p class="error">'.$errors['email']['message'].'</p>';?>
    </fieldset>
    <input type="submit" id="submit" name="submit" value="Registrati"/>
    </form>
    <a href="https://www.facebook.com/caiofior/" title="Realizzato da Claudio Fior">&#169; 2013 by <img src="http://www.gravatar.com/avatar/2e8d2d37da66c6874a65f69879f8e590.png" width="10" height="10" alt="Claudio Fior" /></a>
    <script type="text/javascript" src="components/com_maratonregister/assets/js/default.js"></script>
