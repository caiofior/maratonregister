<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 1.2
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('stylesheet','components/com_maratonregister/assets/css/com_maratonregister.css');
$errors = $this->getModel()->getErrors();
?>
<script type="text/javascript" >
var maraton_amount = <?php echo JComponentHelper::getParams('com_maratonregister')->get('maraton_amount','30'); ?>;
</script>
<h1>Registrati</h1>
<?php if (key_exists('message', $_REQUEST)) : ?>
<p><?php echo $_REQUEST['message']; ?></p>
<?php endif; ?>
<p>Già registrato? <a href="?option=com_maratonregister&amp;task=verify">Verifica lo stato della tua iscrizione</a></p>
<p id="choose_athlete">Seleziona il tipo di iscrizione</p>
<div id="athlete_selectors">
<a id="fidal" href="?option=com_maratonregister" title="Tesserati FIDAL">
    <img style="opacity:0.6; filter:alpha(opacity=40); " src="components/com_maratonregister/images/fidal.png" width="175" height="68" alt="Tesserato Fidal"/>
</a>
<a id="group_fidal" href="?option=com_maratonregister" title="Gruppo tesserati FIDAL">
    <img style="opacity:0.6; filter:alpha(opacity=40); " src="components/com_maratonregister/images/group_fidal.png" width="175" height="68" alt="Gruppo tesserati FIDAL"/>
</a>
<a id="other_ass" href="?option=com_maratonregister" title="Tesserati enti di promozione riconosciuti FIDAL sopra i 35 anni">
    <img style="opacity:0.6; filter:alpha(opacity=40); " src="components/com_maratonregister/images/altra_societa.png" width="175" height="68" alt="Società riconosciute FIDAL"/>
</a>
<a id="amateur" href="?option=com_maratonregister" title="Enti di promozione riconosciuti FIDAL al di sotto dei 35 anni">
    <img style="opacity:0.6; filter:alpha(opacity=40); " src="components/com_maratonregister/images/amatore.png" width="175" height="68" alt="Non tesserati FIDAL e altra federazione non FIDAL"/>
</a>
</div>
<form style="display:none;" action="?option=com_maratonregister" method="post" id="registration" name="registration" enctype="multipart/form-data">

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
    <fieldset id="date_of_birth_container">
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
        <a id="health_form_image" href="<?php echo JURI::root(); ?>components/com_maratonregister/images/health_form.pdf" class="targetblank" title="Autocertificazione buona salute per atleti stranieri">
            <img width="100" hight="142" src ="<?php echo JURI::root(); ?>components/com_maratonregister/images/health_form.jpg" alt="Autocertificazione buona salute per atleti stranieri" style="float: left;"/>
        </a>

        
        <label for="medical_certificate">Allega il tuo Certificato Medico</label>
        <div class="fileinputs">
            <input class="file" type="file" id="medical_certificate" name="medical_certificate" value ="" />
        </div>
        <br/>
        <a href="<?php echo JURI::root(); ?>components/com_maratonregister/images/health_form.pdf" class="targetblank" title="Autocertificazione buona salute per atleti stranieri">
            Autocertificazione buona salute per atleti stranieri
        </a>

    </div>
    
    <?php if (key_exists('medical_certificate', $errors)) echo '<p class="error">'.$errors['medical_certificate']['message'].'</p>';?>
    </fieldset>
    <fieldset id="game_card_container">
    <div>
        <a id="game_card_image" href="<?php echo JURI::root(); ?>components/com_maratonregister/images/game_card.pdf" class="targetblank" title="Cartellino di partecipazione gare su strada">
            Cartellino di partecipazione gare su strada
            <img width="100" hight="142" src ="<?php echo JURI::root(); ?>components/com_maratonregister/images/game_card.jpg" alt="Cartellino di partecipazione gare su strada" style="float: left;"/>
        </a>
    </div>
    <label for="game_card_fname"><span class="game_card_label">Allega il tuo cartellino di partecipazione compilato</span><span class="other_ass_card_label" style="display: none;">Copia della tessera societaria</span></label>
    <div class="fileinputs">
        <input class="file" type="file" id="game_card_fname" name="game_card_fname" value ="" />
    </div>
    <?php if (key_exists('game_card_fname', $errors)) echo '<p class="error">'.$errors['game_card_fname']['message'].'</p>';?>
    </fieldset>
    <fieldset id="payment_type_container">
    <legend>Modalità di pagamento</legend>
    <label for="bank_transfer">Bonifico bancario</label>
    <input class="payment_type iban" type="radio" id="bank_transfer" name="payment_type" value ="bank_transfer" />
    <label for="money_order">Bollettino postale</label>
    <input class="payment_type money_transfer" type="radio" id="money_order" name="payment_type" value ="money_order" />
    <label for="paypal">Paypal</label>
    <input class="payment_type paypal" type="radio" id="paypal" name="payment_type" value="paypal" />
    <label for="other">Altro</label>
    <input class="payment_type" type="radio" id="other" name="payment_type" value="other" />
    <?php $iban = JComponentHelper::getParams('com_maratonregister')->get('maraton_iban'); ?>
    <div id="iban_code" class="payment_code" style="display:none"><?php if ($iban != '') : ?>Il pagamento tramite bonifico va fatto sul conto con coordinate IBAN : <?php echo $iban;?><?php endif; ?></div>
    <?php $mt = JComponentHelper::getParams('com_maratonregister')->get('maraton_mt'); ?>
    <div id="mt_code" class="payment_code" style="display:none"><?php if ($mt != '') : ?>Il pagamento tramite Bollettino postale va fatto sul conto con coordinate : <?php echo $mt;?><?php endif; ?></div>
    <?php $paypal = JComponentHelper::getParams('com_maratonregister')->get('maraton_paypal'); ?>
    <div id="paypal_code" class="payment_code" style="display:none"><?php if ($paypal != '') : ?>Il pagamento tramite Paypal va fatto all'indirizzo : <?php echo $paypal;?><?php endif; ?></div>
    <?php if (key_exists('payment_type', $errors)) echo '<p class="error">'.$errors['payment_type']['message'].'</p>';?>
    <div>
    <label for="payment_fname">Allega la ricevuta di pagamento</label>
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
    <fieldset id="group_fidal_container">
    <legend>Componenti del gruppo</legend>
    <div>La quota di iscrizione è di <?php echo JComponentHelper::getParams('com_maratonregister')->get('maraton_amount','30'); ?> € a persona. </div>
    <div id="billing_group"></div>
    <div ><a class="add_member" href="#"><img title="Aggiungi" alt="Aggiungi" src="components/com_maratonregister/assets/images/plus.png"/></a></div>
    <div class="group_member">
    <div class="remove_memeber_container" style="display: none;"><a class="remove_memeber" href="#"><img title="Rimuovi" alt="Rimuovi" src="components/com_maratonregister/assets/images/minus.png"/></a></div>
    <label >N° Tessera Fidal</label>
    <input name="member_num_tes[]" value ="" />
    <label >Data di nascita</label>
    <input class="member_date_of_birth" title="" name="member_date_of_birth[]" id="member_date_of_birth" value="" type="text"><img src="media/system/images/calendar.png" alt="**Calendario**" class="calendar" id="member_date_of_birth_img">
    </div>
    </fieldset>
    <a id="uploader-template" style="display:none;" href="#"><span>Scegli il documento</span></a>
    <input type="submit" id="submit" name="submit" value="Registrati"/>
    </form>
    <br/>
    <a href="https://www.facebook.com/caiofior/" title="Realizzato da Claudio Fior">&#169; 2013 by <img src="http://www.gravatar.com/avatar/2e8d2d37da66c6874a65f69879f8e590.png" width="10" height="10" alt="Claudio Fior" /></a>
    <script type="text/javascript" src="components/com_maratonregister/assets/js/default.js"></script>
