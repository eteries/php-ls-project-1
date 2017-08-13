var form = document.forms.namedItem('order-form');

form.addEventListener('submit', function(event) {
    var successPopup = document.querySelector('#success');
    var errorPopup = document.querySelector('#error');
    var successOutput = successPopup.querySelector('.status-popup__message');
    var errorOutput = errorPopup.querySelector('.status-popup__message');

    var oData = new FormData(form);

    var oReq = new XMLHttpRequest();
    oReq.open('POST', 'php/form.php', true);
    oReq.onload = function(oEvent) {
        if (oReq.status == 200) {
            successOutput.innerHTML = oReq.response;
            successPopup.style.display = 'block';
        } else {
            errorOutput.innerHTML = "Ошибка " + oReq.status + " загрузки данных.<br \/>";
            errorPopup.style.display = 'block';
        }
    };

    oReq.send(oData);
    event.preventDefault();
}, false);