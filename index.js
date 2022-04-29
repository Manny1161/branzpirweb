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
function openReview() {
    document.getElementById("openReviewForm").style.display = "block";
    document.getElementById("openOverviewForm").style.display = "none";
    document.getElementById("openContactForm").style.display = "none";
}

function openContact() {
    document.getElementById("openReviewForm").style.display = "none";
    document.getElementById("openOverviewForm").style.display = "none";
    document.getElementById("openContactForm").style.display = "block";
}

function openOverview() {
    document.getElementById("openReviewForm").style.display = "none";
    document.getElementById("openOverviewForm").style.display = "block";
    document.getElementById("openContactForm").style.display = "none";
}

function openImage(element) {
    document.getElementById("profImg").src = element.src;
    document.getElementById("openImageForm").style.display = "block";
}

function openImages() {
    document.getElementById("openImageCard").style.display = "block";

}
function closeImages() {
    document.getElementById("openImageCard").style.display = "none";
}

function closeImage() {
    document.getElementById("openImageForm").style.display = "none";
}
function closeProfilePicture() {
    document.getElementById("openProfilePictureForm").style.display = "none";
}
function closeEditProfile() {
    document.getElementById("openEditProfileForm").style.display = "none";
}
function closeContact() {
    document.getElementById("openContactForm").style.display = "none";
}
var modal = document.getElementById("openEditProfileForm");
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

