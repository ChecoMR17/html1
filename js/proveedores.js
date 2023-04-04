let Tbl_Familias;

$(document).ready(() => {
  $("#Form_Familias").on("submit", function (e) {
    Guardar_Familias(e);
  });
  Mostrar_Familias();
});

let Guardar_Familias = (e) => {
  e.preventDefault();
  let data = new FormData($("#Form_Familias")[0]);
  Swal.fire({
    title: "¿Estás seguro(a) de guardar?",
    text: "",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Continuar!",
  }).then((Opcion) => {
    if (Opcion.isConfirmed) {
      Swal.fire({
        imageUrl: "../img/Cargando.gif",
        imageWidth: 400,
        imageHeight: 400,
        background: "background-color: transparent",
        showConfirmButton: false,
        customClass: "transparente",
      });
      setTimeout(() => {
        $.ajax({
          type: "POST",
          url: "../Archivos/Proveedores/operaciones.php?op=Guardar_Familias",
          data: data,
          contentType: false,
          processData: false,
          success: function (result) {
            //console.log(result);
            if (result == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Guardado!",
                showConfirmButton: false,
                timer: 2500,
              });
              Tbl_Familias.ajax.reload();
              $("#Btn_Limpiar_Pr").click();
              Mostrar_Familias();
            } else if (result == 202) {
              Swal.fire({
                position: "center",
                icon: "warning",
                title: "¡La familia que intenta registrar ya existe!",
                showConfirmButton: false,
                timer: 2500,
              });
            } else {
              Swal.fire({
                position: "center",
                icon: "error",
                title: "¡Error, Inténtalo más tarde!",
                showConfirmButton: false,
                timer: 1500,
              });
            }
          },
        });
      }, 250);
    } else {
      Swal.fire({
        position: "center",
        icon: "info",
        title: "¡Operación cancelada!",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });
};

let Datos_Modificar_F = (Id_Proveedores) => {
  $.post(
    "../Archivos/Proveedores/operaciones.php?op=Datos_Modificar_F",
    { Id_Proveedores },
    (result) => {
      result = JSON.parse(result);
      //console.log(result);
      $("#Id_Proveedores").val(Id_Proveedores);
      $("#Nombre_Proveedores").val(result.Desc_Fam);
      $("#Ganancia").val(result.Ganancia);
    }
  );
};

let Mostrar_Lista_Familias = () => {
  setTimeout(() => {
    Tbl_Familias = $("#Tbl_Familias")
      .dataTable({
        language: {
          search: "BUSCAR",
          info: "_START_ A _END_ DE _TOTAL_ ELEMENTOS",
        },
        dom: "Bfrtip",
        buttons: ["copy", "excel", "pdf"],
        autoFill: true,
        colReorder: true,
        rowReorder: true,
        ajax: {
          url: "../Archivos/Proveedores/operaciones.php?op=Mostrar_Lista_Familias",
          type: "post",
          dataType: "json",
          error: (e) => {
            console.log("Error función listar()\n" + e.responseText);
          },
        },
        bDestroy: true,
        iDisplayLength: 20,
        order: [[0, "asc"]],
      })
      .DataTable();
  }, 250);
};

let Mostrar_Familias = () => {
  $.post(
    "../Archivos/Proveedores/operaciones.php?op=Mostrar_Familias",
    (result) => {
      $("#Familias").html(result);
      $("#Familias").selectpicker("refresh");
    }
  );
};
let Limpiar = () => {
  $("#Btn_Limpiar_Pr").click();
};
