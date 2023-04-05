$(document).ready(function() {
    var submit = $('#hiddenForm .sampleForm .submit');
    submit.id = '';

    $('#saveForm').click(function(e) {
       e.preventDefault();
       var allButtons = $("button.submit");

       for (var i = 0; i < allButtons.length; i++) {
           allButtons[i].click();
       }
    });

    var selectedKategorie = $('#createEntry_unterkategorie').val();
    toggleVisibility(selectedKategorie);

   $('#createEntry_unterkategorie').change(function() {
        selectedKategorie = $(this).val();
       toggleVisibility(selectedKategorie);
    });

   $count = 10;
});

function addBesatzung(count) {
    var hiddenForm = $('#hiddenForm .sampleForm');
    var submit = $('#hiddenForm .sampleForm .submit');
    submit.id = '';
    submit.id = 'edit_besatzung_submit' + count;
    submit.name = 'edit_besatzung[submit' + count + ']';

    $('#createEntry_besatzung .row').append(hiddenForm);
}


function addTagForm(collectionHolder, newLinkLi) {
    var prototype = collectionHolder.data('prototype');
    var index = collectionHolder.data('index');

    var newForm = prototype.replace(/__name__/g, index);
    collectionHolder.data('index', index + 1);
    var newFormLi = $('<li></li>').append(newForm);
    newLinkLi.before(newFormLi);
}

function toggleVisibility(select) {
    var unterkategorieDiv = $('#createEntry_unterunterkategorie').parent();
    var brandeinsatz = $('#createEntry_brandeinsatz').parent();
    var brandwache = $('#createEntry_brandsicherheitswache').parent();
    if (select == '0') {
        unterkategorieDiv.hide();
        brandeinsatz.show();
        brandwache.hide();
    } else if (select == '1') {
        unterkategorieDiv.hide();
        brandeinsatz.hide();
        brandwache.show();
    } else if (select == '2') {
        unterkategorieDiv.show();
        brandeinsatz.hide();
        brandwache.hide();
    } else {
        unterkategorieDiv.hide();
        brandeinsatz.hide();
    }
}