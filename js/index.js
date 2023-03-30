$(document).ready(() => {
  $("#Form_Login").on("submit", function (e) {
    Consultar_Datos(e);
  });
});

let Consultar_Datos = (e) => {
  e.preventDefault();
  let data = new FormData($("#Form_Login")[0]);
  $.ajax({
    type: "POST",
    url: "../../FF/global/Operaciones_Sesion.php?op=login",
    data: data,
    contentType: false,
    processData: false,
    success: function (result) {
      console.log(result);
      if (result == 200) {
        window.location.href = "../../FF/pages/home.php";
      } else if (result == 201) {
        $("#Alert_Login").text("Usuario no encontrado");
      } else if (result == 202) {
        $("#Alert_Login").text("Contraseña incorrecta");
      } else if (result == 203) {
        $("#Alert_Login").text("Error");
      }
    },
  });
};
/*
let Cerrar_Sesion = () => {
  $.post(
    "../../FF/global/Operaciones_Sesion.php?op=Cerrar_Sesion",
    (result) => {
      console.log(result);
    }
  );
};*/
