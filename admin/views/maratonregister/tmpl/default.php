<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('stylesheet','administrator/components/com_maratonregister/assets/css/com_maratonregister.css');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_maratonregister'); ?>" method="post" name="adminForm" id="adminForm" >
        <fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search">Filtra:</label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($_REQUEST['filter_search']); ?>" title="Filtra" />
                        <div class="left">
                            <input type="hidden" id="payment_filter" name="payment_filter" value="<?php if(key_exists('payment_filter', $_REQUEST)) echo $_REQUEST['payment_filter'];?>">
                        Pagamento: <a id="payment_filter_check" class="jgrid hasTip"  title="Pagamento">
                            <span class="state disabled">
                                <span class="text">Pagamento</span>
                            </span>
                        </a>
                        </div>
                        <div class="left">
                        <input type="hidden" id="medical_certificate_filter" name="medical_certificate_filter" value="<?php if(key_exists('medical_certificate_filter', $_REQUEST)) echo $_REQUEST['medical_certificate_filter'];?>">
                        Certificato medico: <a id="medical_certificate_filter_check" class="jgrid hasTip"  title="Certificato medico">
                            <span class="state disabled">
                                <span class="text">Certificato medico</span>
                            </span>
                        </a>
                        </div>
                        <div class="left">
                        <input type="hidden" id="pectoral_filter" name="pectoral_filter" value="<?php if(key_exists('pectoral_filter', $_REQUEST)) echo $_REQUEST['pectoral_filter'];?>">
                        Numero di pettorale: <a id="pectoral_filter_check" class="jgrid hasTip"  title="Numero di pettorale">
                                <span class="state disabled">
                                    <span class="text">Numero di pettorale</span>
                                </span>
                        </a>
                        </div>
			<button type="submit" class="btn">Filtra</button>
			<button type="button" onclick="document.id('pectoral_filter').value='';document.id('medical_certificate_filter').value='';document.id('payment_filter').value='';document.id('filter_search').value='';this.form.submit();">Pulisci</button>
		</div>
        </fieldset>
        <div class="clr"> </div>
        <table class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
        <div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="hidemainmenu" value="0"/>  
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
<script type="text/javascript" src="components/com_maratonregister/assets/js/maratonregistertable.js"></script>
<a href="https://www.facebook.com/caiofior/" title="Realizzato da Claudio Fior">&#169; 2013 by <img src="http://www.gravatar.com/avatar/2e8d2d37da66c6874a65f69879f8e590.png" width="10" height="10" alt="Claudio Fior" /></a>