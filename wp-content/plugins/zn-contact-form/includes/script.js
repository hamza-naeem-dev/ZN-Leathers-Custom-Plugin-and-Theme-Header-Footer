const user_email_field = document.querySelector("#mail")
const email_error_box = document.querySelector(".validate_email")
const message_box = document.querySelector("#zncf-message")
const form = document.querySelector("form")
const qty_field = document.querySelector("#qty")
const header_scroll = document.querySelector("header")
const burger_icon = document.querySelector(".burger_style")
const menu = document.querySelector(".nav_links")


//Burger Menu Functionality for mobile
burger_icon.addEventListener("click", function(){
    menu.classList.toggle('is_open')
    burger_icon.classList.toggle('active')
})
//Close nav bar when link is clicked
const links = document.querySelectorAll('.nav_links a')
links.forEach(link => {
    link.addEventListener('click', function(){
        menu.classList.remove('is_open')
    })
})
form.addEventListener("submit",function(e){
    //Honey Pot Functionality
    const startTime = Date.now //Capture Start Time
    const EndTime = Date.now //Capture End Time
    const TimeDiff = EndTime - startTime / 1000; // Calculate Time Diff.

    const qty_data = qty_field.value
    if(qty_data !== "")
    {
        console.warn("Bot detected. Submission Failed")
        e.preventDefault();
        return
    }
    if(TimeDiff < 3) //Should be under 3 seconds to trigger honeypot
    {
        e.preventDefault()
        console.warn(`Bot detected: Form submitted in ${TimeDiff}s (Too fast!)`);
        alert("You're moving a bit too fast! Please wait a moment and try again.");
        return;
    }
    else{
        console.log("Form Submitted Successfully")
    }
    e.preventDefault();

    const formData = new FormData(form)
    formData.append("action", "zncf_submit");
    formData.append("zncf_plugin_nonce", zncf_ajax.ajax_nonce);

    fetch(zncf_ajax.ajax_url, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data=>{
        if(data.success){
            message_box.innerHTML = "<p style='color: green;'>" + data.data.message + "</p>";
            form.reset();
        }
        else{
            console.log("Something went wrong")
        }
    })
})

//Email Validation
user_email_field.addEventListener("input", function(){
    const catching_email = user_email_field.value;
    const email_pattern_validation = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(catching_email === "")
    {
        email_error_box.textContent = "Email Address is missing."
    }
    else if(!email_pattern_validation.test(catching_email))
    {
        email_error_box.textContent = "Invalid Email Address."
    }
    else{
        email_error_box.textContent = ""
    }
})

//Nav Scroll

window.addEventListener("scroll", function(){
    if(window.scrollY > 50)
    {
        header_scroll.classList.add("nav_scroll_bck")
    }
    else{
        header_scroll.classList.remove("nav_scroll_bck")
    }
})