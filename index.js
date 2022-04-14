function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
function onClick(element) {
    document.getElementById("img01").src = element.src;
    document.getElementById("modal01").style.display = "block";
    var captionText = document.getElementById("caption");
    captionText.innerHTML = element.alt;
}
function openEditProfile() {
    document.getElementById("openEditProfileForm").style.display = "block";
}
function openProfilePicture() {
    document.getElementById("openProfilePictureForm").style.display = "block";
}
function closeProfilePicture() {
    document.getElementById("openProfilePictureForm").style.display = "none";
}
function closeEditProfile() {
    document.getElementById("openEditProfileForm").style.display = "none";
}

var modal = document.getElementById("openEditProfileForm");
window.onclick = function(event) {
    if(event.target == modal) {
        modal.style.display = "none";
    }
}

$('#editBtn').click(function()
{
    $('#textBox').show();
    $('#subBtn').show();
});
