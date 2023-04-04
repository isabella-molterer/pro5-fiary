$(document).ready(function() {
    var hiddenForm = $('#hiddenForm .sampleForm');
    var submit = $('#hiddenForm .sampleForm .submit');
    submit.id = '';

    $('#saveForm').click(function(e) {
       e.preventDefault();
       console.log('save');

       var allButtons = $("button.submit");
       // console.log(allButtons);
       var allForms = $("form");

       // console.log(allForms);

      // $('#edit_besatzung_submit1').click();
       for (var i = 0; i < allButtons.length; i++) {
           allButtons[i].click();
           //allForms[i].submit();
           console.log('click');
       }

    });

    var collectionHolder = $('div#createEntry_besatzung');
    var newLinkLi = $('<li style="list-style-type:none;"></li>');


    //$('div#createEntry_besatzung').append('<div><a href="#" class="add-tag">Füge ein Besatzungsmitglied hinzu</a></div>');

    var selectedKategorie = $('#createEntry_unterkategorie').val();
    toggleVisibility(selectedKategorie);

   $('#createEntry_unterkategorie').change(function() {
        selectedKategorie = $(this).val();
       toggleVisibility(selectedKategorie);
    });

   $count = 10;
    /*$('.add-tag').click(function(e) {
        e.preventDefault();

        // add a new tag form (see code block below)
        //addTagForm(collectionHolder, newLinkLi);
        addBesatzung($count++);
    });*/
});

function addBesatzung(count) {
    console.log('addBesatzung');

    var hiddenForm = $('#hiddenForm .sampleForm');
    var submit = $('#hiddenForm .sampleForm .submit');
    submit.id = '';
    submit.id = 'edit_besatzung_submit' + count;
    submit.name = 'edit_besatzung[submit' + count + ']';

    $('#createEntry_besatzung .row').append(hiddenForm);

    // form hinzufügen
}


function addTagForm(collectionHolder, newLinkLi) {
    console.log("AddTAgForm");
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
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