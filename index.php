<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SimpleInventories IDE</title>
        
        <link rel="shortcut icon" href="favicon.png" >
        <link rel="stylesheet" href="assets/bootstrap-4.5.0/css/bootstrap.min.css" >
        <link rel="stylesheet" href="assets/fontawesome-5.13.0/css/all.min.css" >
        <link rel="stylesheet" href="css/jquery-ui.min.css" >
        <link rel="stylesheet" href="css/simpleinventories.css?<?php echo filemtime(__DIR__ . '/css/simpleinventories.css'); ?>" >

        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="assets/bootstrap-4.5.0/js/bootstrap.bundle.min.js"></script>
        <script src="assets/ace/ace.js"></script>
        <script src="assets/ace/ext-language_tools.js"></script>

        <script src="js/simpleinventories.js?<?php echo filemtime(__DIR__ . '/js/simpleinventories.js'); ?>"></script>
        <script src="js/groovy-parser.js?<?php echo filemtime(__DIR__ . '/js/groovy-parser.js'); ?>"></script>

        <script>
            var materials = <?php echo file_get_contents(__DIR__ . "/material.json"); ?>;
            var materialsForAutocomplete = Object.keys(materials);
        </script>
    </head>
    <body>
        <noscript>Sorry, this website is not working without JavaScript enabled!</noscript>

        <div class="container center" id="firstStep">
            <h2>Select inventory type</h2>
            
            <div class="row justify-content-center">
                <a class="inventorySelect" title="Generic Simple Inventory" data-inventory="si-generic">
                    <img class="img-fluid" src="images/si.png">
                </a>
                <a class="inventorySelect" title="ScreamingBedwars shop" data-inventory="bw-shop">
                    <img class="img-fluid" src="images/bw.png">
                </a>
            </div>
        </div>

        <div class="container" id="secondStep" style="display: none;">
            <a onclick="goToFirstStep();"><i class="fas fa-arrow-left"></i></a>
            <h2>Manage options</h2>
            <div data-inventory="si-generic" style="display: none;">
                <h3>Generic Simple Inventory</h3>

		        <p>backItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="backItem" class="form-control materialAutocomplete" type="text" value="BARRIER">
                    </div>
                </p>
		        <p>pageBackItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="pageBackItem" class="form-control materialAutocomplete" type="text" value="ARROW">
                    </div>
                </p>
		        <p>pageForwardItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="pageForwardItem" class="form-control materialAutocomplete" type="text" value="ARROW">
                    </div>
                </p>
		        <p>cosmeticItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="cosmeticItem" class="form-control materialAutocomplete" type="text" value="GRAY_STAINED_GLASS_PANE">
                    </div>
                </p>

		        <p>rows: <input name="rows" type="number" class="form-control" value="4"></p>
		        <p>render_actual_rows: <input name="render_actual_rows" class="form-control" type="number" value="6"></p>
		        <p>render_offset: <input name="render_offset" class="form-control" type="number" value="9"></p>
		        <p>render_header_start: <input name="render_header_start" class="form-control" type="number" value="0"></p>
		        <p>render_footer_start: <input name="render_footer_start" class="form-control" type="number" value="45"></p>
                <p><em>Note that now only inventory type CHEST works with this IDE!</em></p>
		        <p>inventoryType: <input name="inventoryType" class="form-control" type="text" value="CHEST"></p>

		        <p>items_on_row: <input name="items_on_row" class="form-control" type="number" value="9"></p>

                <p>genericShop: <input name="genericShop" type="checkbox"></p>
		        <p>genericShopPriceTypeRequired: <input name="genericShopPriceTypeRequired" type="checkbox" checked></p>
		        <p>animationsEnabled: <input name="animationsEnabled" type="checkbox"></p>
		        <p>showPageNumber: <input name="showPageNumber" type="checkbox" checked></p>
		        <p>prefix: <input name="prefix" class="form-control" type="text" value="Inventory"></p>
		        <p>allowAccessToConsole: <input name="allowAccessToConsole" type="checkbox"></p>
		        <p>allowBungeecordPlayerSending: <input name="allowBungeecordPlayerSending" type="checkbox"></p>
            </div>
            <div data-inventory="bw-shop" style="display: none;">
                <h3>ScreamingBedwars shop</h3>

		        <p>backItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="backItem" class="form-control materialAutocomplete" type="text" value="BARRIER">
                    </div>
                </p>
		        <p>pageBackItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="pageBackItem" class="form-control materialAutocomplete" type="text" value="ARROW">
                    </div>
                </p>
		        <p>pageForwardItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="pageForwardItem" class="form-control materialAutocomplete" type="text" value="ARROW">
                    </div>
                </p>
		        <p>cosmeticItem: 
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><img src="images/notexture.png" width="22"></span>
                        </div>
                        <input name="cosmeticItem" class="form-control materialAutocomplete" type="text" value="GRAY_STAINED_GLASS_PANE">
                    </div>
                </p>

		        <p>rows: <input name="rows" type="number" class="form-control" value="4"></p>
		        <p>render_actual_rows: <input name="render_actual_rows" class="form-control" type="number" value="6"></p>
		        <p>render_offset: <input name="render_offset" class="form-control" type="number" value="9"></p>
		        <p>render_header_start: <input name="render_header_start" class="form-control" type="number" value="0"></p>
		        <p>render_footer_start: <input name="render_footer_start" class="form-control" type="number" value="45"></p>
                <p><em>Note that now only inventory type CHEST works with this IDE!</em></p>
		        <p>inventoryType: <input name="inventoryType" class="form-control" type="text" value="CHEST"></p>

		        <p>items_on_row: <input name="items_on_row" class="form-control" type="number" value="9"></p>

                <input name="genericShop" type="hidden" value="1">
		        <input name="genericShopPriceTypeRequired" type="hidden" value="1">
		        <input name="animationsEnabled" type="hidden" value="1">
		        <input name="showPageNumber" type="hidden" value="1">
		        <input name="prefix" class="form-control" type="hidden" value="[BW] Shop">
		        <input name="allowAccessToConsole" type="hidden" value="0">
		        <input name="allowBungeecordPlayerSending" type="hidden" value="0">
            </div>
            <a class="btn btn-primary" onclick="launchIde();">Launch IDE</a>
        </div>

        <div id="ide" style="display: none;">
            <div class="row">
                <div class="col-sm-6">
                    <table id="inventory-preview">
                    </table>
                </div>
                <div class="col-sm-6">
                    <div id="editor">inventory {

}</div>
                </div>
            </div>
        </div>
    </body>
</html>
