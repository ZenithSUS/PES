const btn_recover = document.getElementById('btn-recover');
const recover_email = document.getElementById('recover-email');
const recover_error = document.getElementById('recover-error');

btn_recover.onclick = function() {

    if (recover_email.value === "") {

        console.log("cant be empty");
        recover_error.innerHTML = 'Please enter email address associated with an account.'

    } else {

        console.log('Recover button clicked!');

        recover_error.innerHTML = ''
        
        recover_email

        alert('Recover button was clicked! Performing recovery action.');

    }
    
};