
	<!-- Jquery Core Js -->
    <script src="<?= ASSET_URL?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?= ASSET_URL?>plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?= ASSET_URL?>plugins/momentjs/moment.js"></script>
    <!-- Select Plugin Js -->
    <script src="<?= ASSET_URL?>plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <script src="<?= ASSET_URL?>plugins/daterange-picker/js/daterange-picker.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?= ASSET_URL?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?= ASSET_URL?>plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?= ASSET_URL?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    
    <script src="<?= ASSET_URL?>plugins/jquery-validation/jquery.validate.js"></script>

    <script src="<?= ASSET_URL?>plugins/jquery-countto/jquery.countTo.js"></script>
    <!-- Custom Js -->
    <script src="<?= ASSET_URL?>js/admin.js"></script>
    <?php if($page_name == "home"){?>
        <script src="<?= ASSET_URL?>js/pages/dashboard.js"></script>
    <?php } ?>
    <?php if($page_name == "transaction"){?>
        <script src="<?= ASSET_URL?>js/pages/transaction.js"></script>
    <?php } ?>
	    <?php if($page_name == "cardlist"){?>
        <script src="<?= ASSET_URL?>js/pages/card.js"></script>
    <?php } ?>
    <?php if($page_name == "merchant") {?> 
        <script src="<?= ASSET_URL?>js/pages/merchant.js"></script>
    <?php }?>
    <?php if($page_name == "user") {?> 
        <script src="<?= ASSET_URL?>js/pages/user.js"></script>
    <?php }?>
    <?php if($page_name == "summary") {?> 
        <script src="<?= ASSET_URL?>js/pages/summary.js"></script>
    <?php }?>
    <?php if($page_name == "withdraw") {?> 
        <script src="<?= ASSET_URL?>js/pages/withdraw.js"></script>
    <?php }?>
    <?php if($page_name == "profile") {?> 
        <script src="<?= ASSET_URL?>js/pages/profile.js"></script>
    <?php }?>
	
	 <?php if($page_name == "transactionorderadmin") {?> 
        <script src="<?= ASSET_URL?>js/pages/transactionorderadmin.js"></script>
    <?php }?>
	
	
</body>

</html>