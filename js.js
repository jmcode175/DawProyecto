document.querySelector("form").addEventListener("submit", function (e) {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    if (!email || !password) {
      alert("Por favor, completa todos los campos.");
      e.preventDefault();
    }
  });
  document.getElementById("tipoNegocio").addEventListener("change", function () {
    var nuevoTipoContainer = document.getElementById("nuevoTipoNegocioContainer");
    nuevoTipoContainer.style.display = this.value === "otro" ? "block" : "none";
  });
  