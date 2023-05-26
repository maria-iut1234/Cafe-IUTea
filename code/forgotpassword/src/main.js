// function setFormMessage(formElement, type, message) {
//     const messageElement = formElement.querySelector(".form__message");

//     messageElement.textContent = message;
//     messageElement.classList.remove("form__message--success", "form__message--error");
//     messageElement.classList.add(`form__message--${type}`);
// }
function setInputError(inputElement, message) {
    inputElement.classList.add("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
}

function clearInputError(inputElement) {
    inputElement.classList.remove("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
}

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.querySelector("#login");
    const createAccountForm = document.querySelector("#createAccount");

 

    loginForm.addEventListener("submit", e => {
        e.preventDefault();

        //$(document).ready(function(){
            console.log("page loaded");
            
            var username = $("#username").val();
            var password = $("#password").val();

            // Perform your AJAX/Fetch login

            $.ajax(
                {
                    url: 'fetch.php',
                    method: 'POST',
                    data: {
                        login: 1,
                        usernamephp: username,
                        passwordphp: password
                    },
                    success: function(response){
                        //console.log(response);
                        if(response === "success")
                        {
                            window.location.replace("http://localhost/Homepage/index.html");
                        }
                        else
                        {
                            const errormsg = document.getElementById("loginError");
                            errormsg.classList.remove("form--hidden");
                        }
                    },
                    dataType: 'text'
                }
            );
    
            //setFormMessage(loginForm, "error", "Invalid username/password combination");
        //});
    })


    // document.querySelectorAll(".form__input").forEach(inputElement => {
    //     inputElement.addEventListener("blur", e => {
    //         if (e.target.id === "signupUsername" && e.target.value.length > 0 && e.target.value.length < 10) {
    //             setInputError(inputElement, "Username must be at least 10 characters in length");
    //         }
    //     });

    //     inputElement.addEventListener("input", e => {
    //         clearInputError(inputElement);
    //     });
    // });
});