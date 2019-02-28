//variables
let username = document.getElementById('username'),
    password = document.getElementById('password'),
    submitBtn = document.getElementById('login-submit');


addListener();

// eventlistners
function addListener(){
    
    username.addEventListener('blur', validateUsername);
    password.addEventListener('blur', validatePassword);
    submitBtn.addEventListener('blur', sendBtn);
    submitBtn.addEventListener('click', validateData);
}

function validateUsername(){
    if(username.value !== '' ){
        username.style.borderBottomColor = 'green';
    }else {
        username.style.borderBottomColor = 'red';
    }
    sendBtn();
}
function validatePassword(){
    if(password.value !== ''){
        password.style.borderBottomColor = 'green';
        let var1 =document.getElementById('newtag');
        var1.remove();
    }else {
        password.style.borderBottomColor = 'red';
        let div = document.createElement('div');
        div.setAttribute('id', 'newtag');
        div.innerHTML = `
                     Password field cannot be empty
                    
                   `;
        document.getElementById('pass').appendChild(div);
    }
    sendBtn();
}
function sendBtn(){
    if(username.value == ''|| password.value == ''){
        submitBtn.disabled = true;
    } else{
        submitBtn.disabled = false;
    }

}

function validateData(e){
    e.preventDefault();
    
   var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function (){

        if (this.readyState == 4 && this.status == 200) {
       // Typical action to be performed when the document is ready:
       
       console.log(xhttp.responseText);
    }
    };

xhttp.open("GET", "/login/dologin", true);
xhttp.send();
    
}

