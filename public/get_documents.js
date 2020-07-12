'use strict';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function eventOnClickAtList() {
    var list = document.querySelectorAll(".doc_in_list");
//        console.log(list);
    let userttn = document.querySelector('#userttn');
//    console.log(userttn);
    for (let i = 0; i < list.length; i++) {
//            console.log(list[i]);

        list[i].onclick = function () {
//            console.log(this.innerText);
            userttn.value = this.innerText;
//            console.log(userttn);
            
            let sendbtn = document.querySelector('#ttnbtn');
            let event = new Event('click');
            sendbtn.dispatchEvent(event);
//            sendbtn.click();
        };
    }
}
/*
 получаем список ттн пользователя
 */
function get_added_documents() {
//    console.dir(document);

    fetch('/getAddedDocuments', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        }
    }).then(function (response) {
        return response.json();
    }).then(function (documents) {
        console.log(documents);
        let containerLi = document.querySelector('#right ul');
        for (var prop in documents) {
            let li = document.createElement('li');
            li.className = 'doc_in_list';
//            console.log(li);
            li.innerHTML = documents[prop].ttn;
//            console.log(documents[prop]);
            containerLi.appendChild(li);
        }
        eventOnClickAtList();
     });

}
;
console.log('get_documents');
get_added_documents();