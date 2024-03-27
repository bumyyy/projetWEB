
document.addEventListener("DOMContentLoaded", function() {
    companyName = document.getElementById('companyName').getAttribute("data-companyName");
    if (companyName != "") {
        searchInput = document.getElementById('search');
        searchInput.value = companyName;
        document.getElementById('btnsubmit').click();
        document.getElementById('companyName').setAttribute("data-companyName" , "");
        console.log("PASSE");
    }
});