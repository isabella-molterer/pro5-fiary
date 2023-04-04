/**
 * Created by Natascha on 06.11.2018.
*/
$(".costum-button").on("click", function() {
    $("body").scrollTop(0);
});

var errorP='<p class="errors">Pflichtfeld darf nicht leer sein!</p>';




/* Erster Test der Animationen für die Progress Bar beim Eintrag erstellen */




    $(".custom-button").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });



var addTagLink = $('<a href="#" class=" custom-button add_tag_link">Füge ein Besatzungsmitglied hinzu</a>');
var newLinkLi = $('<li style="list-style-type:none;"></li>').append(addTagLink);

    /* Abbrechen */
$(document).ready(function() {


    var collectionHolder = $('div#createEntry_besatzung');
    collectionHolder.append(newLinkLi);


    $('div#createEntry_besatzung>div').append('<a href="#" class="remove-tag delete custom-button">Entfernen</a>');

    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });

   /* if($('div#createEntry_besatzung div div div select option[value=""]').is("[selected]")){
    console.log("JA");
        console.log($(this).parent());
        $(this).parent().parent().parent().remove();
    }

    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });*/



    collectionHolder.data('index', collectionHolder.find(':input').length);



    addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see code block below)
        addTagForm(collectionHolder, newLinkLi);
    });





    /*on document load hide all einsatzkategories*/
    $('div#brandeinsatz').hide();
    $('div#brandsicherheitswache').hide();
    $('div#technischerEinsatz').hide();

    /*wrap input+label checkboxes into a div*/
    $('input[type=checkbox]+label').each(function () {
        $(this).prepend($(this).prev());
        $(this).wrap("<div class='col-6 col-sm-6 col-lg-3 left checkboxFormat'></div>");
    });
    $('input[type=radio]+label').each(function () {
        $(this).prepend($(this).prev());
        $(this).wrap("<div class='col-6 col-sm-6 col-lg-3 left checkboxFormat'></div>");
    });

    $('div#form_anlass div').each(function () {
        $(this).removeClass("col-lg-3");
        $(this).addClass("col-lg-6");
    });

    $('div.uebung').hide();
    $('div.einsatz').hide();
    $('div.tätigkeiten').hide();

    $('#form_save').addClass("custom-button");
    $('#form_save').unwrap();


    var textkategorie=sessionStorage.getItem('kategorie');



    /*$('button.next-button').hide();*/

    if($("#createEntry_beginnZeit").val()!= null){
        $('button.next-button').show();
}

    /*while clicking on one of the main kategories*/
  /*  $(".kategorie").click(function () {

    $('button.next-button').show();



        var kategorie = $(this).val();
        console.log(kategorie);
        sessionStorage.setItem('kategorie', kategorie);

    });*/

    $('#createEntry_kategorie').change(function(){
        var textkategorie = ($(this).val());
        sessionStorage.setItem('kategorie', textkategorie);
        console.log(($(this).val()));
});


        if( $('#createEntry_kategorie option[value="Einsatz"]').is("[selected]")){
            textkategorie = 'Einsatz';
            console.log('Einsatz');

        }
        if( $('#createEntry_kategorie option[value="Übung"]').is("[selected]")){
            textkategorie = 'Übung';
        }
        if( $('#createEntry_kategorie option[value="Tätigkeit"]').is("[selected]")){
            textkategorie = 'Tätigkeit';
        }

        $("p#kategorie_einfügen").text('Kategorie: ' + textkategorie);




        if (textkategorie == 'Einsatz') { //Einsatz
            $('#createEntry_kategorie option[value="Einsatz"]').attr("selected", "selected");

            $("#title").text(textkategorie + 'details');
            $("#subtitle").text('Bitte gib hier die Details des Einsatzes bekannt!');


            $('div.uebung').hide();
            $('div.tätigkeiten').hide();
            $('div.einsatz').show();
            $('#createEntry_unterkategorie option').slice(4, 61).remove(); //remove übung

        } else if (textkategorie == 'Übung') { //Übung
            $('#createEntry_kategorie option[value="Übung"]').attr("selected", "selected");

            $("#title").text(textkategorie + 'sdetails');
            $("#subtitle").text('Bitte gib hier die Details der ' + textkategorie + ' bekannt!');

            $('#createEntry_unterkategorie option').slice(1, 4).remove();
            $('#createEntry_unterkategorie option').slice(27, 61).remove();

            $('div.einsatz').hide();
            $('div.tätigkeiten').hide();
            $('div.uebung').show();

            $('#lage label').text("Übungsannahme");
            $('#form_lagebeimEintreffen').attr("placeholder", "Genaue Beschreibung der Übungsannahme...");

        } else if (textkategorie == 'Tätigkeit'){ //Tätigkeit
            $('#createEntry_kategorie option[value="Tätigkeit"]').attr("selected", "selected");

            $("#title").text(textkategorie + 'sdetails');
            $("#subtitle").text('Bitte gib hier die Details der ' + textkategorie + ' bekannt!');

            $('#createEntry_unterkategorie option').slice(1, 30).remove();

            $('div.einsatz').hide();
            $('div.uebung').hide();
            $('div.tätigkeiten').show();
        }


        //$('#form_unterunterkategorie').attr('required', 'true');
        $('#createEntry_unterkategorie').attr('required', 'true');

        $('#createEntry_unterkategorie').change(function () {
            var selectedKategorie = $(this).val();
            console.log(selectedKategorie);
            if (selectedKategorie == '0') { //brandeinsatz
                $('div#brandsicherheitswache').hide();
                $('div#brandsicherheitswache input').attr('disabled', 'true');
                $('div#technischerEinsatz').hide();
                $('div#technischerEisnatz select').attr('disabled', 'true');
                $('div#brandeinsatz').show();
            } else if (selectedKategorie == '1') {
                $('div#brandeinsatz').hide();
                $('div#brandeinsatz input').attr('disabled', 'true');
                $('div#technischerEinsatz').hide();
                $('div#technischerEisnatz select').attr('disabled', 'true');
                $('div#brandsicherheitswache').show();
            } else if (selectedKategorie == '2') {

                $('div#brandsicherheitswache').hide();
                $('div#brandsicherheitswache input').attr('disabled', 'true');
                $('div#brandeinsatz').hide();
                $('div#brandeinsatz input').attr('disabled', 'true');
                $('div#technischerEinsatz').show();
            } else if (selectedKategorie == '3'){
                $('div#brandeinsatz').hide();
                $('div#brandeinsatz input').attr('disabled', 'true');
                $('div#brandsicherheitswache').hide();
                $('div#brandsicherheitswache input').attr('disabled', 'true');
                $('div#technischerEinsatz').hide();
                $('div#technischerEisnatz select').attr('disabled', 'true');
                $('div#createEntry_unterunterkategorie').attr('required', 'true');

            }





    });

});

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

    // also add a remove button, just for this example
    newFormLi.append('<a href="#" class="remove-tag custom-button">Entfernen</a>');

    newLinkLi.before(newFormLi);

    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}



$(document).ready(function() {
    var open = $('.open-navnew'),
        close = $('.close');


    open.click(function() {
        if($('#wrapper').hasClass('toggled')){

            $('#wrapper').removeClass('toggled');
        }else{

            $('#wrapper').addClass('toggled');
        }

    });




    $('#häuser_newentry').DataTable( {
        "order": [[ 0, "asc" ]],
        "stateSave": true,
        "pagingType": "simple",
        "lengthMenu": [[3, 5, 10, 20, -1], [3, 5, 10, 20, "All"]],
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Nichts gefunden - sorry",
            "info": "Seite _PAGE_ von _PAGES_",
            "infoEmpty": "Keien Einträge verfügbar",
            "infoFiltered": "(gefiltert von _MAX_ Gesamteinträgen)",
            "search": "Suchen",
            "paginate":{
                "previous":"<",
                "next":">"
            }


        }
    } );


    //Buttons vertauschen

    $('button.btn-warning').before($('button.prev-button'));
    $('div.craue_formflow_buttons button:nth-child(3)').remove();
});





