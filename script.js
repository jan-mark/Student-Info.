document.getElementById("showPass").onchange = function () {
    const pass = document.getElementById("password");
    pass.type = this.checked ? "text" : "password";
};