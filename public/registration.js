"use strict";

//sendBtn.onclick = send;

var formManager = {
    name: document.querySelector("#username"),
    nameError: document.querySelector("#username + .auth__error"),
    email: document.querySelector("#useremail"),
    emailError: document.querySelector("#useremail + .auth__error"),
    regbtn: document.querySelector("#regbtn")
};

formManager.valid = function valid(){

    var isError = false;

    if (!(/^[а-яa-z0-9\-_\.]{5,25}$/i.test(this.name.value))) {
        this.nameError.classList.remove('auth__error_hide');
        this.nameError.classList.add('auth__error_show');
        isError = true;
    }

    if (!(/^[0-9a-z.\-_]{1,15}@[0-9a-z.\-_]{1,14}\.[a-z.\-_]{1,10}$/i.test(this.email.value))) {
        this.emailError.classList.remove('auth__error_hide');
        this.emailError.classList.add('auth__error_show');
        isError = true;
    }

    return !isError;
};

formManager.send = function send() {

    if (!this.valid()) return null;

//    var user = new Map([
//        ['name', this.name.value],
//        ['email', this.email.value]
//    ]);
    
    var data = {
        login: this.name.value,
        email: this.email.value
    };

//    console.log(user);
//    
//    var data = [];
//    data.push(user);
//    
//    console.log(data);

    fetch('/user/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(data)
//        body: (data)
    }).then(function(response){
        return response.json();
    }).then(function(data){
        console.log(data);
        alert(data.message);
    });
};

formManager.setClearHandler = function setClearHandler(){
    var elements = document.querySelectorAll('.auth__text');

    elements.forEach(function(element) {
        element.onclick = function(){
            this.nextElementSibling.classList.remove('auth__error_show');
            this.nextElementSibling.classList.add('auth__error_hide');
        }
    });
};

formManager.init = function(){
    this.regbtn.onclick = this.send.bind(this);// bind чтоб в this всегда было formManager
    this.setClearHandler();
};

formManager.init();