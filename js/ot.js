let Tbl_OT;
$(document).ready(() => {
  $("#Form_Ordenes_Trabajo").on("submit", function (e) {
    Guardar_Ordenes_Trabajo(e);
  });
  Mostrar_Clientes();
  Mostrar_Lista_OT();
});

let Guardar_Ordenes_Trabajo = (e) => {
  e.preventDefault();
  let data = new FormData($("#Form_Ordenes_Trabajo")[0]);
  console.log(data);

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
          url: "../Archivos/Ordenes/Operaciones.php?op=Guardar_Ordenes_Trabajo",
          data: data,
          contentType: false,
          processData: false,
          success: function (result) {
            console.log(result);
            if (result == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Guardado!",
                showConfirmButton: false,
                timer: 2500,
              });
              Limpiar_F_OT();
              Tbl_OT.ajax.reload();
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

let Ejecucion_Ot = (Id) => {
  Swal.fire({
    title: "¿Estás seguro(a) de ejecutar la orden de trabajo?",
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
        $.post(
          "../Archivos/Ordenes/Operaciones.php?op=Ejecucion_Ot",
          { Id },
          (result) => {
            if (result == 200) {
              Swal.fire({
                position: "center",
                icon: "success",
                title: "!En ejecución¡",
                showConfirmButton: false,
                timer: 2500,
              });
              Tbl_OT.ajax.reload();
            } else {
              Swal.fire({
                position: "center",
                icon: "error",
                title: "¡Error, inténtelo mas tarde¡",
                showConfirmButton: false,
                timer: 2500,
              });
            }
          }
        );
      }, 250);
    } else {
      Swal.fire({
        position: "center",
        icon: "info",
        title: "!Operación cancelada¡",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });
};
let Datos_Modificar = (Id) => {
  $.post(
    "../Archivos/Ordenes/Operaciones.php?op=Datos_Modificar",
    { Id },
    (result) => {
      result = JSON.parse(result);
      console.log(result);
      Swal.fire({
        position: "center",
        icon: "info",
        title: "¡Listo para modificar!",
        showConfirmButton: false,
        timer: 1000,
      });
      $("#Id").val(Id);
      $("#Cliente").val(result.Id_Cliente);
      $("#Cliente").selectpicker("refresh");
      $("#Prioridad").val(result.Prioridad);
      $("#Prioridad").selectpicker("refresh");
      $("#Proyecto").val(result.Proyecto);
      $("#Fecha_Inicio").val(result.Fecha_Inicio);
      $("#Fecha_Final").val(result.Fecha_Final);
      $("#Detalles").val(result.Detalles);
      $(".form-check-input").attr("disabled", false);
      if (result.Status == "U") {
        $("#S_Ejecucion").prop("checked", true);
      } else if (result.Status == "C") {
        $("#S_Concluido").prop("checked", true);
      } else if (result.Status == "B") {
        $("#S_Cancelado").prop("checked", true);
      }
      Buscar_Obras();
      setTimeout(() => {
        $("#Obras").val(result.Id_Obra);
        $("#Contactos").val(result.Id_Contacto);
        $("#Obras").selectpicker("refresh");
        $("#Contactos").selectpicker("refresh");
      }, 250);
    }
  );
};
let Mostrar_Lista_OT = () => {
  Tbl_OT = $("#Tbl_Ordenes_Trabajo")
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
        url: "../Archivos/Ordenes/Operaciones.php?op=Mostrar_Lista_OT",
        type: "post",
        dataType: "json",
        error: (e) => {
          console.log("Error función listar() \n" + e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 200,
      order: [[0, "desc"]],
    })
    .DataTable();
};

let Mostrar_Clientes = () => {
  $.post(
    "../Archivos/Ordenes/Operaciones.php?op=Mostrar_Clientes",
    (result) => {
      $("#Cliente").html(result);
      $("#Cliente").selectpicker("refresh");
    }
  );
};

let Buscar_Obras = () => {
  Cliente = $("#Cliente").val();
  $.post(
    "../Archivos/Ordenes/Operaciones.php?op=Buscar_Obras",
    { Cliente },
    (result) => {
      $("#Obras").html(result);
      $("#Obras").selectpicker("refresh");
      Buscar_Contactos(Cliente);
    }
  );
};
let Buscar_Contactos = (Cliente) => {
  $.post(
    "../Archivos/Ordenes/Operaciones.php?op=Buscar_Contactos",
    { Cliente },
    (result) => {
      $("#Contactos").html(result);
      $("#Contactos").selectpicker("refresh");
    }
  );
};

let Limpiar_F_OT = () => {
  $("#Id").val("");
  $("#Cliente").val("");
  $("#Obras").html("");
  $("#Contactos").html("");
  $("#Prioridad").val("");
  $("#Proyecto").val("");
  $("#Fecha_Inicio").val("");
  $("#Fecha_Final").val("");
  $("#Detalles").val("");
  $("#S_Concluido").attr("disabled", true);
  $("#S_Cancelado").attr("disabled", true);
  $("#Cliente").selectpicker("refresh");
  $("#Prioridad").selectpicker("refresh");
  $("#Obras").selectpicker("refresh");
  $("#Contactos").selectpicker("refresh");
};
