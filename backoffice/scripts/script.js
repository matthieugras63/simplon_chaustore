/* This function change the h2 html value, and also change the background-color in the menu according to the active tab, giving
the inactive class to his siblings. Moreover, active tab has an opacity of 1 and siblings have an opacity of 0.5 */

$(function() {
    $('#menu ul li').click(function() {
        var idRecovered = $(this).attr('id');
        $('#DBAdmin h2').html(idRecovered);
        $(this).css('background-color', '#5976EE').css('opacity', '1').removeClass('inactive');
        $(this).siblings().css({
            'background-color': 'white',
            'opacity': '0.5'
        }).addClass('inactive');
        if ($('section h3, section>div:last-of-type').css('display', 'none')) {
            $('section h3, section>div:last-of-type').toggle();
        }
    })
});


$(function() {
    $('header ul li').click(function() {
        var htmlRecovered = $(this).html();
        if (htmlRecovered === "Accueil") {
            window.location = "index.php";
        } else if (htmlRecovered === "Inscription") {
            window.location = "forms/register.php"
        } else {
            window.location = "forms/connect.php"
        }
    })
})
/* This function recover the html text into the button the user clicked on. According to what's written, it has different actions.  */


$(function() {
    $('button').not('#cross').click(function() {
        var htmlRecovered = $(this).html();
        if (htmlRecovered === "Visualiser") {
            $('#container').toggle();
            changeModal(htmlRecovered);
        } else if (htmlRecovered === "Ajouter") {
            var textMenu = $('#menu ul li').not('.inactive').attr('class');
            window.location = "form_add/add_" + textMenu + ".php";
        } else if (htmlRecovered === "Modifier") {
            var textMenu = $('#menu ul li').not('.inactive').attr('class');
            window.location = "form_update/update_" + textMenu + ".php";
        } else if (htmlRecovered === "Supprimer") {
            var textMenu = $('#menu ul li').not('.inactive').attr('class');
            window.location = "form_delete/delete_" + textMenu + ".php";
        } else {
            window.location = "../index.php";
        }
    })
})


/* This function toggle display block/none of the modal container when clicked on the cross */

$(function() {
    $('#cross').click(function() {
        $('#container').toggle();
        if ($('#modal>div').css('display', 'block')) {
            $('#modal>div').toggle();
        }
    })
})

/* This function toggle the modal window and change his contents according to the button the user clicked on */

function changeModal(a) {
    $('#modal>div').attr('id', a);
    if (a === "Visualiser") {
        $('#modal>h4').html($('#DBAdmin h2').html() + " - " + a + " les données");
        $('#modal div h4').html("Voici les données actuellement enregistrées :");
    } else {
        $('#modal>h4').html($('#DBAdmin h2').html() + " - " + a + " des données");
        $('#modal div h4').html("");
    }
    $('#modal #' + a).toggle();
    var checkClass = $('#DBAdmin h2').html();
    $('#modal .' + checkClass).siblings('div').toggle();
}
