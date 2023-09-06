const form = document.getElementById("register");
form.addEventListener("submit", function(event)
{
    const email = form.email.value;
    const fname = form.fullname.value;
    const uName = form.username.value;
    const pWord = form.password.value;
    const cpWord = form.confirmpassword.value;
    const alertMsg = document.getElementById("alertMsg");
    
    if(email === "")
    {
        event.preventDefault();
        console.log("Field is blank. Please enter your email.");
        alertMsg.innerHTML = "Field is blank. Please enter your email.";
    }
    
    if(uName === "")
    {
        event.preventDefault();
        console.log("Field is blank. Please enter a username.");
        alertMsg.innerHTML = "Field is blank. Please enter a username.";
    }
    
    if(pWord === "")
    {
        event.preventDefault();
        console.log("Field is blank. Please enter a password.");
        alertMsg.innerHTML = "Field is blank. Please enter a password.";
    }
    
    if(fname === "")
    {
        event.preventDefault();
        console.log("Field is blank. Please enter your full name.");
        alertMsg.innerHTML = "Field is blank. Please enter your full name.";
    }
    
    if(pWord != cpWord)
    {
        event.preventDefault();
        console.log("Passwords do not match. Please confirm your password.");
        alertMsg.innerHTML = "Passwords do not match. Please confirm your password.";
    }
    
    
});


