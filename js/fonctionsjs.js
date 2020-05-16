function mode(idtext , idimg , mode, idBtn){
    var Texte = document.getElementById(idtext);
    var Image = document.getElementById(idimg);
    var MonBouton = document.getElementById(idBtn);
    //alert(formText.choix[1].value);
    if (mode == "texte"){
        Texte.style.visibility='visible';
        MonBouton.style.marginTop="-88px";
        Image.style.visibility='hidden';
        Image.style.marginTop="10px";
    }
    else if (mode == "image") {
        Texte.style.visibility='hidden';
        Image.style.visibility='visible';
        Image.style.marginTop="-393px";
        MonBouton.style.marginTop="5px";
    }
}


function checkForm(){

    if(document.getElementById('text_1').value == "" ){
        alert('Vous devez entrer un texte '+copie);
        return false;
    }else{
        document.getElementById('formText').submit();
    }
}