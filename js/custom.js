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