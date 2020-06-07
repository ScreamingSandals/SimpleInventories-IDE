var editor = null;

$(function() {
    $('.inventorySelect').click(function () {
        $('#firstStep').hide();
        $('#secondStep').show();
        $('#secondStep [data-inventory="' + $(this).data('inventory') + '"]').show();
    });

    $('.materialAutocomplete').autocomplete({
        source: materialsForAutocomplete
    });

    $('.input-group > .materialAutocomplete').on('change paste keyup', function () {
        var value = $(this).val();
        if (materials.hasOwnProperty(value) && materials[value].link) {
            $(this).parent().find('img').attr('src', materials[value].link);
        } else {
            $(this).parent().find('img').attr('src', 'images/notexture.png');
        }
    });

    $('.input-group > .materialAutocomplete').each(function () {
        var value = $(this).val();
        if (materials.hasOwnProperty(value) && materials[value].link) {
            $(this).parent().find('img').attr('src', materials[value].link);
        } else {
            $(this).parent().find('img').attr('src', 'images/notexture.png');
        }
    });

    editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/groovy");

    editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true
    });

    editor.completers = [{
        getCompletions: function(editor, session, pos, prefix, callback) {
            callback(null, [
                {
                    name: "inventory", 
                    value: "inventory {  }",
                    meta: "static",
                    type: "snippet"
                },
                {
                    name: "item", 
                    value: "item('')",
                    meta: "inventory",
                    type: "snippet"
                }
            ]);

        }
    }];
});

function goToFirstStep() {
        $('#secondStep [data-inventory]').hide();
        $('#secondStep').hide();
        $('#firstStep').show();
}

var settings = {};

function launchIde() {
        var settingsDiv = $('#secondStep > div:visible');
        settings = {
            backItem: settingsDiv.find('[name="backItem"]').val(),
            pageBackItem: settingsDiv.find('[name="pageBackItem"]').val(),
            pageForwardItem: settingsDiv.find('[name="pageForwardItem"]').val(),
            cosmeticItem: settingsDiv.find('[name="cosmeticItem"]').val(),
            rows: parseInt(settingsDiv.find('[name="rows"]').val()),
            render_actual_rows: parseInt(settingsDiv.find('[name="render_actual_rows"]').val()),
            render_offset: parseInt(settingsDiv.find('[name="render_offset"]').val()),
            render_header_start: parseInt(settingsDiv.find('[name="render_header_start"]').val()),
            render_footer_start: parseInt(settingsDiv.find('[name="render_footer_start"]').val()),
            inventoryType: parseInt(settingsDiv.find('[name="inventoryType"]').val()),
            items_on_row: parseInt(settingsDiv.find('[name="items_on_row"]').val()),
            genericShop: settingsDiv.find('[name="genericShop"]').val() ? true : false,
            genericShopPriceTypeRequired: settingsDiv.find('[name="genericShopPriceTypeRequired"]').val() ? true : false,
            animationsEnabled: settingsDiv.find('[name="animationsEnabled"]').val() ? true : false,
            showPageNumber: settingsDiv.find('[name="showPageNumber"]').val() ? true : false,
            prefix: settingsDiv.find('[name="prefix"]').val(),
            allowAccessToConsole: settingsDiv.find('[name="allowAccessToConsole"]').val() ? true : false,
            allowBungeecordPlayerSending: settingsDiv.find('[name="allowBungeecordPlayerSending"]').val() ? true : false
        };
        $('#secondStep').hide();
        $('#ide').show();
        $('#inventory-preview').append('<tr><td colspan="' + (2 + settings.items_on_row) + '"><img src="images/container_header.png"></td></tr>');
        for (var i = 0; i < settings.render_actual_rows; i++) {
            var tr = $('<tr></tr>');
            tr.append('<td><img src="images/container_left.png"></td>');
            for (var j = 0; j < settings.items_on_row; j++) {
                tr.append('<td data-link="' + ((settings.items_on_row * i) + j) + '"><img src="" alt=""></td>');
            }
            tr.append('<td><img src="images/container_right.png"></td>');
            $('#inventory-preview').append(tr);
        }
        $('#inventory-preview').append('<tr><td colspan="' + (2 + settings.items_on_row) + '"><img src="images/container_footer.png"></td></tr>');

        $('[data-link=' + settings.render_header_start + '] img').attr('src', materials[settings.backItem].link);

        for (var i = settings.render_header_start + 1; i < settings.render_header_start + settings.items_on_row; i++) {
            $('[data-link=' + i + '] img').attr('src', materials[settings.cosmeticItem].link);
        } 

        $('[data-link=' + settings.render_footer_start + '] img').attr('src', materials[settings.pageBackItem].link);

        for (var i = settings.render_footer_start + 1; i < settings.render_footer_start + settings.items_on_row - 1; i++) {
            $('[data-link=' + i + '] img').attr('src', materials[settings.cosmeticItem].link);
        } 

        $('[data-link=' + (settings.render_footer_start + 8) + '] img').attr('src', materials[settings.pageForwardItem].link);

}

function executeGroovy() {
    var content = btoa(editor.getValue());
    $.ajax({
        type: 'POST',
        url: 'api.php?service=groovyPreProcessor',
        data: {
            groovyContent: content
        }
    }).done(function (data) {
        console.log(data);
    });
}
