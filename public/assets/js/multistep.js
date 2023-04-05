/**
 * Created by Natascha on 06.11.2018.
*/
$(".costum-button").on("click", function() {
    $("body").scrollTop(0);
});

var errorP='<p class="errors">Pflichtfeld darf nicht leer sein!</p>';

$(".custom-button").click(function() {
    $("html, body").animate({
        scrollTop: 0
    }, 800);
    return false;
});

var addTagLink = $('<a href="#" class=" custom-button add_tag_link">Füge ein Besatzungsmitglied hinzu</a>');
var newLinkLi = $('<li style="list-style-type:none;"></li>').append(addTagLink);

$(document).ready(function() {
    var collectionHolder = $('div#createEntry_besatzung');
    collectionHolder.append(newLinkLi);

    $('div#createEntry_besatzung>div').append('<a href="#" class="remove-tag delete custom-button">Entfernen</a>');

    $('.remove-tag').click(function(e) {
        e.preventDefault();
        $(this).parent().remove();
        return false;
    });

    collectionHolder.data('index', collectionHolder.find(':input').length);

    addTagLink.on('click', function(e) {
        e.preventDefault();
        addTagForm(collectionHolder, newLinkLi);
    });

    $('div#brandeinsatz').hide();
    $('div#brandsicherheitswache').hide();
    $('div#technischerEinsatz').hide();

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

    if($("#createEntry_beginnZeit").val()!= null){
        $('button.next-button').show();
    }

    $('#createEntry_kategorie').change(function(){
        var textkategorie = ($(this).val());
        sessionStorage.setItem('kategorie', textkategorie);
    });

    if( $('#createEntry_kategorie option[value="Einsatz"]').is("[selected]")){
        textkategorie = 'Einsatz';
    }

    if( $('#createEntry_kategorie option[value="Übung"]').is("[selected]")){
        textkategorie = 'Übung';
    }

    if( $('#createEntry_kategorie option[value="Tätigkeit"]').is("[selected]")){
        textkategorie = 'Tätigkeit';
    }

    $("p#kategorie_einfügen").text('Kategorie: ' + textkategorie);

    if (textkategorie == 'Einsatz') {
        $('#createEntry_kategorie option[value="Einsatz"]').attr("selected", "selected");
        $("#title").text(textkategorie + 'details');
        $("#subtitle").text('Bitte gib hier die Details des Einsatzes bekannt!');
        $('div.uebung').hide();
        $('div.tätigkeiten').hide();
        $('div.einsatz').show();
        $('#createEntry_unterkategorie option').slice(4, 61).remove();
    } else if (textkategorie == 'Übung') {
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
    } else if (textkategorie == 'Tätigkeit'){
        $('#createEntry_kategorie option[value="Tätigkeit"]').attr("selected", "selected");
        $("#title").text(textkategorie + 'sdetails');
        $("#subtitle").text('Bitte gib hier die Details der ' + textkategorie + ' bekannt!');
        $('#createEntry_unterkategorie option').slice(1, 30).remove();
        $('div.einsatz').hide();
        $('div.uebung').hide();
        $('div.tätigkeiten').show();
    }

    $('#createEntry_unterkategorie').attr('required', 'true');

    $('#createEntry_unterkategorie').change(function () {
        var selectedKategorie = $(this).val();
        if (selectedKategorie == '0') { 
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

    var open = $('.open-navnew');

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

    $('button.btn-warning').before($('button.prev-button'));
    $('div.craue_formflow_buttons button:nth-child(3)').remove();
});

function addTagForm(collectionHolder, newLinkLi) {
    var prototype = collectionHolder.data('prototype');
    var index = collectionHolder.data('index');
    
    var newForm = prototype.replace(/__name__/g, index);
    collectionHolder.data('index', index + 1);

    var newFormLi = $('<li></li>').append(newForm);
    newFormLi.append('<a href="#" class="remove-tag custom-button">Entfernen</a>');
    newLinkLi.before(newFormLi);

    $('.remove-tag').click(function(e) {
        e.preventDefault();
        $(this).parent().remove();
        return false;
    });
}



