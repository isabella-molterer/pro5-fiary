/**
 * Created by Natascha on 06.11.2018.
*/
$(".costum-button").on("click", function() {
    $("body").scrollTop(0);
});

var errorP='<p class="errors">Pflichtfeld darf nicht leer sein!</p>';

$(document).ready(function() {
    $(".next-button").click(function() {
        var current = $(this).parent();
        var next = $(this)
            .parent()
            .next();
        $(".progressbar li")
            .eq($("fieldset").index(next))
            .addClass("active");
        current.hide();
        next.show();
    });

    $(".prev-button").click(function() {
        var current = $(this).parent();
        var prev = $(this)
            .parent()
            .prev();
        $(".progressbar li")
            .eq($("fieldset").index(current))
            .removeClass("active");
        current.hide();
        prev.show();
    });

    $(".custom-button").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $(".reset-button").click(function() {
        location.reload();
        var current = $(this).parent();
        $(".progressbar li").removeClass("active");
        $(".progressbar li:first-child").addClass("active");
        current.hide();
        $("fieldset#kategoriewahl").show();

        if($("#form_kategorie_1").hasAttribute("selected")){
            $("#form_kategorie_1").removeAttr("selected");
        }
        if($("#form_kategorie_0").hasAttribute("selected")){
            $("#form_kategorie_0").removeAttr("selected");
        }

        if($("#form_kategorie_2").hasAttribute("selected")){
            $("#form_kategorie_2").removeAttr("selected");
        }
    });

    /* on document load hide all operation categories */
    $('div#brandeinsatz').hide();
    $('div#brandsicherheitswache').hide();
    $('div#technischerEinsatz').hide();

    /* wrap input+label checkboxes into a div */
    $('input[type=checkbox]+label').each(function(){
        $(this).prepend($(this).prev());
        $(this).wrap("<div class='col-6 col-sm-6 col-lg-3 left checkboxFormat'></div>");
    });
    $('input[type=radio]+label').each(function(){
        $(this).prepend($(this).prev());
        $(this).wrap("<div class='col-6 col-sm-6 col-lg-3 left checkboxFormat'></div>");
    });

    $('div#form_anlass div').each(function(){
        $(this).removeClass("col-lg-3");
        $(this).addClass("col-lg-6");
    });

    $('div.uebung').hide();
    $('div.einsatz').hide();
    $('div.tätigkeiten').hide();

    $('#form_save').addClass("custom-button");
    $('#form_save').unwrap();

    /* while clicking on one of the main categories */
    $(".kategorie").click(function() {
        var kategorie=$(this).val();
        $("p#kategorie_einfügen").text('Kategorie: '+ kategorie);

        if(($('#form_unterkategorie option[value=""]').length==0)) {
            $('#form_unterkategorie').prepend($('<option>', {
                value: '',
                selected: 'selected',
                text: 'Bitte wählen...'
            }));
        }

        if (kategorie=='Einsatz') {
            $('#form_kategorie option[value="Einsatz"]').attr("selected", "selected");
            $("#title").text(kategorie + 'details');
            $("#subtitle").text('Bitte gib hier die Details des Einsatzes bekannt!');
            $('div.uebung').hide();
            $('div.tätigkeiten').hide();
            $('div.einsatz').show();
            $('#form_unterkategorie option').slice( 4,61 ).remove(); 
        } else if (kategorie=='Übung'){
            $('#form_kategorie option[value="Übung"]').attr("selected", "selected");
            $("#title").text(kategorie + 'sdetails');
            $("#subtitle").text('Bitte gib hier die Details der '+ kategorie +' bekannt!');
            $('#form_unterkategorie option').slice( 1,4 ).remove();
            $('#form_unterkategorie option').slice( 27, 61 ).remove();
            $('div.einsatz').hide();
            $('div.tätigkeiten').hide();
            $('div.uebung').show();
            $('#lage label').text("Übungsannahme");
            $('#form_lagebeimEintreffen').attr("placeholder", "Genaue Beschreibung der Übungsannahme...");
        } else { 
            $('#form_kategorie option[value="Tätigkeit"]').attr("selected", "selected");
            $("#title").text(kategorie + 'sdetails');
            $("#subtitle").text('Bitte gib hier die Details der '+ kategorie +' bekannt!');

            $('#form_unterkategorie option').slice( 1,30 ).remove();

            $('div.einsatz').hide();
            $('div.uebung').hide();
            $('div.tätigkeiten').show();
        }

        $('#form_unterunterkategorie').prepend($('<option>', {value : '', selected : 'selected', text: 'Bitte wählen...'}));
        $('#form_unterkategorie').attr('required', 'true');
        $('#form_unterkategorie').change(function(){
            var selectedKategorie=$(this).val();

            if (selectedKategorie=='0'){
                $('div#brandsicherheitswache').hide();
                $('div#brandsicherheitswache input').attr('disabled', 'true');
                $('div#technischerEinsatz').hide();
                $('div#technischerEisnatz select').attr('disabled', 'true');
                $('div#brandeinsatz').show();
            } else if(selectedKategorie=='1'){
                $('div#brandeinsatz').hide();
                $('div#brandeinsatz input').attr('disabled', 'true');
                $('div#technischerEinsatz').hide();
                $('div#technischerEisnatz select').attr('disabled', 'true');
                $('div#brandsicherheitswache').show();
            } else if(selectedKategorie=='2'){
                $('div#brandsicherheitswache').hide();
                $('div#brandsicherheitswache input').attr('disabled', 'true');
                $('div#brandeinsatz').hide();
                $('div#brandeinsatz input').attr('disabled', 'true');
                $('div#technischerEinsatz').show();
            } else {
                $('div#brandeinsatz').hide();
                $('div#brandeinsatz input').attr('disabled', 'true');
                $('div#brandsicherheitswache').hide();
                $('div#brandsicherheitswache input').attr('disabled', 'true');
                $('div#technischerEinsatz').hide();
                $('div#technischerEisnatz select').attr('disabled', 'true');
            }
        });
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
    });
});





