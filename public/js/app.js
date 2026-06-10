document.addEventListener("DOMContentLoaded", function(){


// TRACKING
const trackForm = document.getElementById("trackForm");

if(trackForm){
trackForm.addEventListener("submit", function(e){
e.preventDefault();

fetch("api/track.php",{
method:"POST",
body:new FormData(this)
})
.then(res=>res.text())
.then(data=>{
document.getElementById("trackResult").innerHTML = data;
})
})
}

});

// FAQ ACCORDION
document.querySelectorAll(".accordion-header").forEach(item=>{
item.addEventListener("click", function(){

const parent = this.parentElement;

parent.classList.toggle("active");

});
});

