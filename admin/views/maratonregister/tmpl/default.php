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
			<button type="submit" class="btn">Filtra</button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();">Pulisci</button>
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
<a href="https://www.facebook.com/caiofior/" title="Realizzato da Claudio Fior">&#169; 2013 by <img src="http://www.gravatar.com/avatar/2e8d2d37da66c6874a65f69879f8e590.png" width="10" height="10" alt="Claudio Fior" /></a>