<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_maratonregister&layout=edit&id='.$this->item->id); ?>"
      method="post" id="adminForm" name="adminForm" enctype="multipart/form-data" >
    <?php if ( $this->item->num_tes != '') : ?>
    <h1>Tesserato Fidal</h1>
    <?php elseif ( $this->item->other_num_tes != '') : ?>
    <h1>Tesserato altra federazione</h1>
    <?php else: ?>
    <h1>Amatore</h1>
    <?php endif; ?>
    <fieldset id="name_container">
    <label for="first_name">Nome</label>
    <input id="first_name" name="first_name" value ="<?php echo $this->item->first_name; ?>" />
    <?php if (key_exists('first_name', $errors)) echo '<p class="error">'.$errors['first_name']['message'].'</p>';?>
    <label for="last_name">Cognome</label>
    <input id="last_name" name="last_name" value ="<?php echo $this->item->last_name; ?>" />
    <?php if (key_exists('last_name', $errors)) echo '<p class="error">'.$errors['last_name']['message'].'</p>';?>
    </fieldset>
    <fieldset id="num_tes_container" >
    <legend>Tesserato FIDAL</legend>
    <label for="num_tes">N° Tessera Fidal</label>
    <input id="num_tes" name="num_tes" value ="<?php echo $this->item->num_tes; ?>" />
    <?php if ($this->item->num_tes != '') :
        $fidal =  JModel::getInstance('fidal', 'MaratonRegisterModel');
        $fidal = $fidal->loadFromCode($this->item->num_tes);
        if ($fidal === false) : ?>
        <br/>
        <p> Codice tesserato non presente in archivio</p>
        <?php elseif($this->item->num_tes_datetime_confirmed) : ?>
        <br/>
        <p>La tessera è intestata a:</p>
        <ul>
            <li >Nome: <span id="nome"><?php echo $fidal->nome; ?></span></li>
            <li >Cognome: <span id="cogn"><?php echo $fidal->cogn; ?></span></li>
            <li >Data di nascita: <span id="dat_nas"><?php echo $fidal->dat_nas; ?></span></li>
            <li>Società: <?php echo $fidal->denom; ?></li>
            <li>Regione: <?php echo $fidal->cod_reg; ?></li>
            <li>Categoria: <?php echo $fidal->categ; ?></li>
        </ul>   
        <p>L'escrizione è stata confermata il <?php echo $this->item->num_tes_datetime_confirmed;?></p> 
        <?php else: ?>
        <br/>
        <p>La tessera è intestata a:</p>
        <ul>
            <li >Nome: <span id="nome"><?php echo $fidal->nome; ?></span></li>
            <li >Cognome: <span id="cogn"><?php echo $fidal->cogn; ?></span></li>
            <li >Data di nascita: <span id="dat_nas"><?php echo $fidal->dat_nas; ?></span></li>
            <li>Società: <?php echo $fidal->denom; ?></li>
            <li>Regione: <?php echo $fidal->cod_reg; ?></li>
            <li>Categoria: <?php echo $fidal->categ; ?></li>
        </ul>
        <a id="confirm_fidal" href="#">Conferma la registrazione</a>
        <script type="text/javascript">
            $("confirm_fidal").addEvent("click", function(){
            $("first_name").setProperty("value",$("nome").get("text"));
            $("last_name").setProperty("value",$("cogn").get("text"));
            $("date_of_birth").setProperty("value",$("dat_nas").get("text"));
            return false;
    });
        </script>
        
        <?php endif; ?>
    <?php endif; ?>
    <?php if (key_exists('num_tes', $errors)) echo '<p class="error">'.$errors['num_tes']['message'].'</p>';?>
    </fieldset>
    <fieldset id="other_num_tes_container" >
    <legend>Tesserato altra associazione</legend>
    <label for="other_ass_name">Nome Associazione</label>
    <input id="other_ass_name" name="other_ass_name" value ="<?php echo $this->item->other_ass_name; ?>" />
    <?php if (key_exists('other_ass_name', $errors)) echo '<p class="error">'.$errors['other_ass_name']['message'].'</p>';?>
    <label for="other_num_tes">N° Tessera</label>
    <input id="other_num_tes" name="other_num_tes" value ="<?php echo $this->item->other_num_tes; ?>" />
    <?php if (key_exists('other_num_tes', $errors)) echo '<p class="error">'.$errors['other_num_tes']['message'].'</p>';?>
    </fieldset>
    <fieldset>
    <label for="date_of_birth">Data di nascita</label>
    <?php 
    echo JHTML::calendar($this->escape($this->item->date_of_birth), 'date_of_birth', 'date_of_birth', '%Y-%m-%d'); ?>
    <?php if (key_exists('date_of_birth', $errors)) echo '<p class="error">'.$errors['date_of_birth']['message'].'</p>';?>
    </fieldset>
    <fieldset id="sex_container">
    <legend>Sesso</legend>
    <label for="male">M</label>
    <input <?php echo ($this->item->sex == 'M' ? 'checked="checked"' : ''); ?> type="radio" id="male" name="sex" value ="M" />
    <label for="female">F</label>
    <input <?php echo ($this->item->sex == 'F' ? 'checked="checked"' : ''); ?> type="radio" id="female" name="sex" value ="F" />
    <?php if (key_exists('sex', $errors)) echo '<p class="error">'.$errors['sex']['message'].'</p>';?>
    </fieldset>
    <fieldset id="citizenship_container">
    <label for="citizenship">Cittadinanza</label>
    <input id="citizenship" name="citizenship" value ="<?php echo $this->item->citizenship; ?>" />
    <?php if (key_exists('citizenship', $errors)) echo '<p class="error">'.$errors['citizenship']['message'].'</p>';?>
    </fieldset>
    <fieldset id="address_container">
    <label for="address">Indirizzo</label>
    <input id="address" name="address" value ="<?php echo $this->item->address; ?>" />
        <?php if (key_exists('address', $errors)) echo '<p class="error">'.$errors['address']['message'].'</p>';?>
    <label for="zip">CAP</label>
    <input id="zip" name="zip" value ="<?php echo $this->item->zip; ?>" />
        <?php if (key_exists('zip', $errors)) echo '<p class="error">'.$errors['zip']['message'].'</p>';?>
    <label for="city">Città</label>
    <input id="city" name="city" value ="<?php echo $this->item->city; ?>" />
        <?php if (key_exists('city', $errors)) echo '<p class="error">'.$errors['city']['message'].'</p>';?>
    </fieldset>
    <fieldset id="phone_container">
    <label for="phone">Telefono</label>
    <input id="phone" name="phone" value ="<?php echo $this->item->phone; ?>" />
        <?php if (key_exists('phone', $errors)) echo '<p class="error">'.$errors['phone']['message'].'</p>';?>
    </fieldset>
    <fieldset id="medical_certificate_container">
    <?php
        $medical_certificate_fname = JPATH_BASE.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
                'components'.DIRECTORY_SEPARATOR.'com_maratonregister'.DIRECTORY_SEPARATOR.'medical_certificate'.DIRECTORY_SEPARATOR.
                $this->item->medical_certificate_fname;
        if (is_file($medical_certificate_fname)) : ?>
        <a target="_blank" href="<?php echo 
                '../components/com_maratonregister/medical_certificate/'.
                $this->item->medical_certificate_fname; ?>">Certificato medico</a></br>
                <p>Caricato il <?php echo $this->item->medical_certificate_datetime;?></p> 
    <label for="medical_certificate_confirm_datetime">Conferma certificato medico</label>
    <input <?php echo ($this->item->medical_certificate_confirm_datetime != '' ? 'checked="checked" ' : ''); ?> type="checkbox" id="medical_certificate_confirm_datetime" name="medical_certificate_confirm_datetime" value ="1" />
    <p id="medical_certificate_confirm_datetime_ask" style="display: none; clear: both;">Il certificato medico era già stato confermato. Se non ritieni sia più valido contatta l'atleta 
       per segnalare le difformità riscontrate</br>
       <?php if ($this->item->phone != '') : ?>
       Telefono: <?php echo $this->item->phone; ?></br>
       <?php endif; ?>
       <?php if ($this->item->email != '') : ?>
       Mail: <a href="mailto:<?php echo $this->item->email; ?>"><?php echo $this->item->email; ?></a><br/>
       <?php endif; ?>
       <a id="medical_certificate_confirm_datetime_confirm" href="#">Conferma</a> <a id="medical_certificate_confirm_datetime_cancel" href="#">Annulla</a>
    </p>
    <?php else : ?>
    <label for="medical_certificate">Certificato Medico</label>
    <input type="file" id="medical_certificate" name="medical_certificate" value ="" />
        <?php if (key_exists('medical_certificate', $errors)) echo '<p class="error">'.$errors['medical_certificate']['message'].'</p>';?>
    <?php endif; ?>
    </fieldset>
    <fieldset id="game_card_container">
    <?php
        $game_card_fname = JPATH_BASE.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
                'components'.DIRECTORY_SEPARATOR.'com_maratonregister'.DIRECTORY_SEPARATOR.'game_card'.DIRECTORY_SEPARATOR.
                $this->item->game_card_fname;
        if (is_file($game_card_fname)) : ?>
        <a target="_blank" href="<?php echo 
                '../components/com_maratonregister/game_card/'.
                $this->item->game_card_fname; ?>">Cartellino di partecipazione</a></br>
        <p>Caricato il <?php echo $this->item->game_card_datetime;?></p>        
        <? else : ?>
        <p>Cartellino di partecipazione non disponibile</p>
        <?php endif; ?>
    </fieldset>
    <fieldset id="payment_type_container">
    <legend>Modalità di pagamento</legend>
    <?php $disabled= ''; 
    if ($this->item->payment_confirm_datetime != '')
        $disabled= 'disabled="disabled"';  ?>
    
    <label for="bank_transfer">Bonifico bancario</label>
    <input <?php echo $disabled;?> <?php echo ($this->item->payment_type == 'bank_transfer' ? 'checked="checked"' : ''); ?> type="radio" id="bank_transfer" name="payment_type" value ="bank_transfer" />
    <label for="money_order">Bollettino postale</label>
    <input <?php echo $disabled;?> <?php echo ($this->item->payment_type == 'money_order' ? 'checked="checked"' : ''); ?> type="radio" id="money_order" name="payment_type" value ="money_order" />
    <label for="paypal">Paypal</label>
    <input <?php echo $disabled;?> <?php echo ($this->item->payment_type == 'paypal' ? 'checked="checked"' : ''); ?> type="radio" id="paypal" name="payment_type" value="paypal" />
    
    <?php if (key_exists('payment_type', $errors)) echo '<p class="error">'.$errors['payment_type']['message'].'</p>';?>
    <?php
        $payment_fname = JPATH_BASE.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.
                'components'.DIRECTORY_SEPARATOR.'com_maratonregister'.DIRECTORY_SEPARATOR.'payment_receipt'.DIRECTORY_SEPARATOR.
                $this->item->payment_fname;
        if (is_file($payment_fname)) : ?>
    
        <label>
        <a target="_blank" href="<?php echo 
                '../components/com_maratonregister/payment_receipt/'.
                $this->item->payment_fname; ?>">Ricevuta di pagamento</a></br>
        <p>Caricata il <?php echo $this->item->payment_datetime;?></p> 
    </label>
    <?php else : ?>
    <label for="payment_fname">Ricevuta di pagamento</label>
    <input type="file" id="payment_fname" name="payment_fname" value ="" />
        <?php if (key_exists('medical_certificate', $errors)) echo '<p class="error">'.$errors['medical_certificate']['message'].'</p>';?>
    <?php endif; ?>
    <label for="payment_confirm_datetime">Conferma pagamento</label>
    <input <?php echo ($this->item->payment_confirm_datetime != '' ? 'checked="checked" ' : ''); ?> type="checkbox" id="payment_confirm_datetime" name="payment_confirm_datetime" value ="1" />    
    <p id="payment_confirm_datetime_ask" style="display: none; clear: both;">La ricevuta di pagamento era già stata confermata. Se non ritieni sia più valida contatta l'atleta 
       per segnalare le difformità riscontrate</br>
       <?php if ($this->item->phone != '') : ?>
       Telefono: <?php echo $this->item->phone; ?></br>
       <?php endif; ?>
       <?php if ($this->item->email != '') : ?>
       Mail: <a href="mailto:<?php echo $this->item->email; ?>"><?php echo $this->item->email; ?></a><br/>
       <?php endif; ?>
       <a id="payment_confirm_datetime_confirm" href="#">Conferma</a> <a id="payment_confirm_datetime_cancel" href="#">Annulla</a>
    </p>
    </fieldset>
    <fieldset id="email_container">
    <label for="email">Email</label>
    <input id="email" name="email" value ="<?php echo $this->item->email; ?>" />
    <?php if (key_exists('email', $errors)) echo '<p class="error">'.$errors['email']['message'].'</p>';?>
    </fieldset>
    <fieldset id="pectoral_container">
    <label for="pectoral">Pettorale</label>
    <input id="pectoral" name="pectoral" value ="<?php echo $this->item->pectoral; ?>" /><br/>
    <?php if ($this->item->pectoral == '') : ?>
    <a id="generate_pectoral" href="#">Genera un pettorale</a>
    <?php endif; ?>
    </fieldset>    
    <input type="hidden" id="task" name="task" value="maratonregister" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<a href="https://www.facebook.com/caiofior/" title="Realizzato da Claudio Fior">&#169; 2013 by <img src="http://www.gravatar.com/avatar/2e8d2d37da66c6874a65f69879f8e590.png" width="10" height="10" alt="Claudio Fior" /></a>
<script type="text/javascript">
    if($("medical_certificate_confirm_datetime") !== null) {
        $("medical_certificate_confirm_datetime").addEvent("change",function() {
            if (this.get("checked") === false) {
                $("medical_certificate_confirm_datetime_ask").show();
                this.set("checked","checked");
            }
        });
        $("medical_certificate_confirm_datetime_confirm").addEvent("click",function(event) {
           $("medical_certificate_confirm_datetime").set("checked",null);
           event.stopPropagation();
           $("medical_certificate_confirm_datetime_ask").hide();
           event.stop();
        });
        $("medical_certificate_confirm_datetime_cancel").addEvent("click",function(event) {
           $("medical_certificate_confirm_datetime_ask").hide();
           event.stop();
        });
    }
    if($("payment_confirm_datetime") !== null) {
        $("payment_confirm_datetime").addEvent("change",function() {
            if (this.get("checked") === false) {
                $("payment_confirm_datetime_ask").show();
                this.set("checked","checked");
            }
        });
        $("payment_confirm_datetime_confirm").addEvent("click",function(event) {
           $("payment_confirm_datetime").set("checked",null);
           event.stopPropagation();
           $("payment_confirm_datetime_ask").hide();
           event.stop();
        });
        $("payment_confirm_datetime_cancel").addEvent("click",function(event) {
           $("payment_confirm_datetime_ask").hide();
           event.stop();
        });
    }
    if($("generate_pectoral") !== null) {
        $("generate_pectoral").addEvent("click", function(){
            new Request.JSON({
                url:"index.php?option=com_maratonregister&task=generate_pectoral",
                onSuccess: function (responseJSON) {
                    $("pectoral").setProperty("value",responseJSON);
                }
             }).send();
            return false;
        });
    }
    $$("form").addEvent("submit", function(){
         if ($("task").get("value") !== "save")
             return;
         var status = true;
         el = this.getElements("p").destroy();
         mc = "";
         mc_el = $("medical_certificate");
         if (mc_el !== null)
            mc = "&medical_certificate="+mc_el.get("value");
         new Request.JSON({
            async:false,
            url:this.get("action")+"&submit=1&xhr=1"+mc,
            data: this.toQueryString(),
            onSuccess: function (responseJSON) {
                Object.each(responseJSON,function(object,id) {
                    status = false;
                    el = new Element("p");
                    el.addClass("error");
                    el.appendText(object.message);
                    $(id).grab(el,"after");
                });
                
            }
         }).send();
         if (status == false)
            throw new Error("Not valid");

});
    </script> 