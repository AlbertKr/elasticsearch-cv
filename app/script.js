function change() {
    if (document.getElementById('global').checked == true) {
        var form_global = document.getElementById("form_global");
        form_global.style.display = "flex";

        var form_diplomas = document.getElementById("form_diplomas");
        form_diplomas.style.display = "none";

        var form_competences = document.getElementById("form_competences");
        form_competences.style.display = "none";
    } else if (document.getElementById('diplomas').checked == true) {
        var form_global = document.getElementById("form_global");
        form_global.style.display = "none";

        var form_diplomas = document.getElementById("form_diplomas");
        form_diplomas.style.display = "flex";

        var form_competences = document.getElementById("form_competences");
        form_competences.style.display = "none";
    } else if (document.getElementById('competences').checked == true) {
        var form_global = document.getElementById("form_global");
        form_global.style.display = "none";

        var form_diplomas = document.getElementById("form_diplomas");
        form_diplomas.style.display = "none";

        var form_competences = document.getElementById("form_competences");
        form_competences.style.display = "flex";
    }
}