
// Afficher comment sélectionner une location de matériel de chantier en ligne
// en utilisant AJAX 


$(function () {
    $('#selectionne').on('click', classifiedBuy);
    $('#selectionne').on('click', color1);

});
function classifiedBuy() {
    $.get('application/get-selectionne.php', function (response) {
        $('#serviceDetails').html(response);
    });
}

function color1() {
        $('#selectionne').css('color','#f9bb2d');
        $('#reservation').css('color','#666');
        $('#reception').css('color','#666');
}




// Afficher comment réserver ma location de matériel
// en utilisant AJAX 

$(function () {
    $('#reservation').on('click', classifiedReservation);
    $('#reservation').on('click', color2);
});
function classifiedReservation() {
    $.get('application/get-reservation.php', function (response) {
        $('#serviceDetails').html(response);
    });
}
function color2() {
    $('#reservation').css('color','#f9bb2d');
    $('#selectionne').css('color','#666');
    $('#reception').css('color','#666');
}




// Afficher comment réceptionner mon matériel ou équipement
// en utilisant AJAX

$(function () {
    $('#reception').on('click', classifiedReception);
    $('#reception').on('click', color3);
});
function classifiedReception() {
    $.get('application/get-reception.php', function (response) {
        $('#serviceDetails').html(response);
    });
}

function color3() {
    $('#reception').css('color','#f9bb2d');
    $('#reservation').css('color','#666');
    $('#selectionne').css('color','#666');
}




/*
pouvoir afficher le mot de passe en clair avant de se connecter
*/
let passwor=document.getElementById('pass');
let icone=document.getElementById('eyes');

icone.addEventListener("click",changerclick);
passwor.addEventListener("click",function(){
    if(this.ariaValueMax.length>0){
        icone.classList.add('visible');
    }else{
        icone.classList.remove('visible');
    }
});


function changerclick(){
    if(passwor.getAttribute("type")=="password"){
        passwor.setAttribute("type","text");
        this.innerHTML='<i class="fa-solid fa-eye-slash"></i>';
    }
    else{
        passwor.setAttribute("type","password");
        this.innerHTML='<i class="fa-solid fa-eye"></i>';
        
    }
    

}