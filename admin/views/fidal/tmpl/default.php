<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_maratonregister&task=fidal'); ?>" method="post" name="adminForm">
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
                <input type="hidden" name="task" value="fidal" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
<script type="text/javascript">
    $$('form').addEvent("submit",function () {
        if(this.task.get("value") == "fidal_deleteall") {
            if (!confirm("Stai per cancellare tutti gli iscritti alla federazione FIDAL. Sei sicuro?"))
                throw new Error("Not valid");
        }
    });
</script>