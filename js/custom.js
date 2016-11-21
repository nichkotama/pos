function fokusvro(fokus_ke) {
	fokus_ke.focus();
}
function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) {
        alert("Don't use space character");
        return false;
    }
}
function toRp(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    // return '' + rev2.split('').reverse().join('') + ',00';
    return '' + rev2.split('').reverse().join('');
}

var tagihan = 0;