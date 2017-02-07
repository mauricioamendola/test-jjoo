function checkValidez(str){
    var legales = /[a-z ]+/i;
    var string = str.split("");
    var valido = true;
    var i = 0;
    var largo = string.length;

    while(valido == true && i < largo){
        valido = legales.test(string[i]);
        if(valido){
            i++;
        } else {
            valido = false;
        }
    }

    if (i == largo){
        return true;
    } else {
        return false;
    }
}


