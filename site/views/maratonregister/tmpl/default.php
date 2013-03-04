<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @version 0.1
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$errors = $this->getModel()->getErrors();
?>
<h1>Registrati</h1>
<form action="?option=com_maratonregister" method="post" id="registration" name="registration" enctype="multipart/form-data">
    <a id="fidal" href="?option=com_maratonregister">Tesserato Fidal</a>
    <a id="other_ass" href="?option=com_maratonregister">Tesserato altra federazione</a>
    <a id="amateur" href="?option=com_maratonregister">Amatore</a>
    <fieldset id="name_container">
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
    <?php echo JHTML::calendar($this->escape(""), 'date_of_birth', 'date_of_birth', '%Y-%m-%d'); ?>
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
    <label for="medical_certificate">Certificato Medico</label>
    <input type="file" id="medical_certificate" name="medical_certificate" value ="" />
        <?php if (key_exists('medical_certificate', $errors)) echo '<p class="error">'.$errors['medical_certificate']['message'].'</p>';?>
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
    </fieldset>
    <fieldset id="email_container">
    <label for="email">Email</label>
    <input id="email" name="email" value ="" />
    <?php if (key_exists('email', $errors)) echo '<p class="error">'.$errors['email']['message'].'</p>';?>
    </fieldset>
    <input type="submit" id="submit" name="submit" value="Registrati"/>
    </form>
    <script type="text/javascript">
    $("fidal").addEvent("click", function(){
        $("name_container").setStyle("display", "none");
        $("sex_container").setStyle("display", "none");
        $("citizenship_container").setStyle("display", "none");
        $("address_container").setStyle("display", "none");
        $("phone_container").setStyle("display", "none");
        $("other_num_tes_container").setStyle("display", "none");
        $("medical_certificate_container").setStyle("display", "none");
        $("num_tes_container").setStyle("display", "block");
        return false;
    });
    $("other_ass").addEvent("click", function(){
        $("name_container").setStyle("display", "block");
        $("sex_container").setStyle("display", "block");
        $("citizenship_container").setStyle("display", "block");
        $("address_container").setStyle("display", "block");
        $("phone_container").setStyle("display", "block");
        $("medical_certificate_container").setStyle("display", "block");
        $("other_num_tes_container").setStyle("display", "block");
        $("num_tes_container").setStyle("display", "none");
        return false;
    });
    $("amateur").addEvent("click", function(){
        $("name_container").setStyle("display", "block");
        $("sex_container").setStyle("display", "block");
        $("citizenship_container").setStyle("display", "block");
        $("address_container").setStyle("display", "block");
        $("phone_container").setStyle("display", "block");
        $("medical_certificate_container").setStyle("display", "block");
        $("other_num_tes_container").setStyle("display", "none");
        $("num_tes_container").setStyle("display", "none");
        return false;
    });
    $("submit").addEvent("click", function(){
        status = true;
         $("registration").getElements("p").destroy();
         new Request.JSON({
            async:false,
            url:$("registration").get("action")+"&submit=1&xhr=1&medical_certificate="+$("medical_certificate").get("value"),
            data: $("registration").toQueryString(),
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
        return status;
    });
    </script>    

