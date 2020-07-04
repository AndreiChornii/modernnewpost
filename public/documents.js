'use strict';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// сохраняем ттн

var field_ttn = document.querySelector('#userttn');
var ttnError = document.querySelector("#userttn + .auth__error");
var button_ttn = document.querySelector('#ttnbtn');

var formManagerTtn = {
    ttn: field_ttn,
    ttnError: ttnError,
    sendBtn: button_ttn
};

formManagerTtn.valid = function valid() {

    var isError = false;

    if (!(/^[0-9]{14}$/i.test(this.ttn.value))) {
        this.ttnError.classList.remove('auth__error_hide');
        this.ttnError.classList.add('auth__error_show');
        isError = true;
    }
//    return true;
    return !isError;
};

formManagerTtn.send = function send() {

    if (!this.valid()) {
        console.log('invalid ttn number');
        
        return null;
    }
    ;

    var data = {
        ttn: this.ttn.value
    };

    fetch('/documents', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (documents_and_ttn) {
        let containerLi = document.querySelector('#right ul');
        while (containerLi.firstChild) {
            containerLi.removeChild(containerLi.firstChild);
        }
        console.log(documents_and_ttn);
        for (var prop in documents_and_ttn.documents) {
            let li = document.createElement('li');
            li.className = 'doc_in_list';
//            console.log(li);
            li.innerHTML = documents_and_ttn.documents[prop].ttn;
//            console.log(documents[prop]);
            containerLi.appendChild(li);
        }
        eventOnClickAtList();
        
        let containerLiRezult = document.querySelector('#rezult');
        while (containerLiRezult.firstChild) {
            containerLiRezult.removeChild(containerLiRezult.firstChild);
        }
        let ul = document.createElement('ul');
        let liStatus = document.createElement('li');
        liStatus.innerHTML = 'Статус доставки: ' + documents_and_ttn.ttn.Status;
        ul.appendChild(liStatus);
        let liWarehouseSender = document.createElement('li');
        liWarehouseSender.innerHTML = '<b>Отправлено: </b>' + documents_and_ttn.ttn.WarehouseSender;
        ul.appendChild(liWarehouseSender);
        let liWarehouseRecipient = document.createElement('li');
        liWarehouseRecipient.innerHTML = '<b>Получено: </b>' + documents_and_ttn.ttn.WarehouseRecipient;
        ul.appendChild(liWarehouseRecipient);
        containerLiRezult.appendChild(ul);
    });
};

formManagerTtn.setClearHandler = function setClearHandler() {
    var elements = document.querySelectorAll('.auth__text');

    elements.forEach(function (element) {
        element.onclick = function () {
            this.nextElementSibling.classList.remove('auth__error_show');
            this.nextElementSibling.classList.add('auth__error_hide');
        }
    });
}

formManagerTtn.init = function () {
    this.sendBtn.onclick = this.send.bind(this);// bind чтоб в this всегда было formManager
    this.setClearHandler();
}

formManagerTtn.init();