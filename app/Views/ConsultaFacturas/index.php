<?= $this->extend('Layouts/index') ?>
<?= $this->section('content') ?>
<!-- BEGIN MAIN CODE -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    
</style>
<script>
    $(document).ready(function() {
        cargarOrigenes();
        cargarFormasPago();
        cargarMotivos();
        var tabla = document.getElementById('tableFacturas');


        // Agrega un manejador de eventos de clic a la tabla
        tabla.addEventListener('click', function(event) {
            var fila = event.target.closest('tr'); // Encuentra la fila más cercana al elemento clicado
            if (fila) {
                var primeraCelda = fila.querySelector('td'); // Obtiene el primer <td> de la fila

                if (primeraCelda) {
                    var contenidoPrimeraCelda = primeraCelda.textContent;
                    // Realiza aquí la acción que desees con el contenido de la primera celda
                }
            }
            //console.log('Contenido de la primera celda: ' + contenidoPrimeraCelda);
            buscarFacturasId(contenidoPrimeraCelda);
        });

        $('#tableFacturas').on('click', '.mostrarDetalles', function() {

            var fila = $(this).closest('tr');
            var valorDelTD = fila.find('td:eq(0)').text();
            //console.log("valorDelTD ", valorDelTD);
            CargarFacturaDetalle(valorDelTD);


        });

    });

    function CargarFacturaDetalle(id) {
        let datos = {
            'IdFactura': id,
            'detalle': 1
        }
        // console.log(JSON.stringify(datos));
        $.ajax({
            type: "POST",
            url: "/ConsultaFacturas/buscarFactura",
            data: datos,
            encode: true,
        }).done(function(data) {
            // console.log(datos);
            var table = $('#tableDetallesModal').DataTable();
            try {
                var datos = JSON.parse(data);
                console.log(datos);
              //  debugger;
                table.clear().draw();
                $.each(datos, function(index, data) {
                    // Agrega una fila a la tabla con los datos del JSON
                    table.row.add([data.detalle, data.montoDetalle, data.descripcion]).draw(false);
                });

            } catch (error) {
                //console.log(error);
                //console.log(data);
                return false;
            }
            for (var i = 0; i < datos.length; i++) {

              // console.log(datos[i]);
                //document.getElementById('idFecha').value = fechaActual;


            }
            //$("#ModalToggle").show();
            // toastr.success("Consulta realizada!");
        });
    }

    function cargarFormasPago() {
        $.ajax({
            type: "POST",
            url: "/Mantenimientocarro/listarFormaPago",
            encode: true,
        }).done(function(data) {
            var select = document.getElementById("idFormaPago");
            try {
                var datos = JSON.parse(data);
            } catch (error) {
                //console.log(error);
                //console.log(data);
                return false;
            }
            for (var i = 0; i < datos.length; i++) {
                var option = document.createElement("option");
                option.value = datos[i].id;
                option.text = datos[i].formaPago;
                select.appendChild(option);
            }
            //console.log("cargarFormasPago() => " + data);
        });
    };

    function cargarOrigenes() {
        $.ajax({
            type: "POST",
            url: "/Mantenimientocarro/listarOrigenes",
            encode: true,
        }).done(function(data) {
            var select = document.getElementById("idOrigen");
            try {
                var datos = JSON.parse(data);
            } catch (error) {
                //console.log(error);
                //console.log(data);
                return false;
            }
            for (var i = 0; i < datos.length; i++) {
                var option = document.createElement("option");
                option.value = datos[i].id;
                option.text = datos[i].Nombre;
                select.appendChild(option);
            }
            //console.log("cargarCarros() => " + data);
        });
    };

    function cargarMotivos() {
        $.ajax({
            type: "POST",
            url: "/Mantenimientocarro/listarMotivos",
            // data: datos,
            //dataType: "json",
            encode: true,
        }).done(function(data) {
            $('#idMotivo').html('');
            var nuevaOpcion = $('<option>', {
                value: '0',
                text: 'Todos'
            });
            $('#idMotivo').append(nuevaOpcion);
            var select = document.getElementById("idMotivo");
            try {
                var datos = JSON.parse(data);
            } catch (error) {
                //console.log(error);
                //console.log(data);
                return false;
            }
            for (var i = 0; i < datos.length; i++) {
                var option = document.createElement("option");
                option.value = datos[i].id;
                option.text = datos[i].nombre;
                select.appendChild(option);
            }
        });
    }

    function verDetalle() {
        console.log("z");
    }

    function buscarFacturas() {
        limpiarCampos();
        let datos = {
            'IdMotivo': $("#idMotivo").val(),
            'IdOrigen': $("#idOrigen").val(),
            'FormaPago': $("#idFormaPago").val(),
            'fechaI': $("#idFechaI").val(),
            'fechaF': $("#idFechaF").val(),
        }
       // console.log(JSON.stringify(datos));

        $.ajax({
            type: "POST",
            url: "/ConsultaFacturas/buscarFactura",
            data: datos,
            encode: true,
        }).done(function(data) {
            var tbody = $('#tableFacturas tbody');
            var datos = JSON.parse(data);
            var tabla = $('#tableFacturas').DataTable();
            tabla.clear().draw(); // Limpiar la tabla si hay datos anteriores

            if (!tieneDatos(datos)) {
                toastr.warning("Sin datos que mostrar!");
                return;
            }

            $.each(datos, function(index, item) {
                var boton = document.createElement('button');
                var span = document.createElement('span');
                span.classList.add('bi')
                span.classList.add('bi-trash')
                boton.classList.add('btn');
                boton.classList.add('btn-outline-danger');
                boton.classList.add('mostrar');
                boton.appendChild(span);


                var fecha = new Date(item.fecIngreso.date);
                var año = fecha.getFullYear();
                var mes = (fecha.getMonth() + 1).toString().padStart(2, "0"); // Sumar 1 al mes, ya que los meses comienzan en 0
                var dia = fecha.getDate().toString().padStart(2, "0");
                var fechaFormateada = año + "-" + mes + "-" + dia;

                tabla.row.add([
                    item.IdFactura,
                    item.origen,
                    item.motivo,
                  //  item.detalle,
                    item.montoTotal,
                    fechaFormateada,
                    '<button type="button" class="btn btn-outline-primery mostrarDetalles" data-bs-toggle="modal" href="#ModalToggle">ver</button>'
                ]).draw();
            });
            toastr.success("Consulta realizada!");
        });
        // ocultarSpinner();
    }

    function tieneDatos(objeto) {
        for (var propiedad in objeto) {
            if (objeto.hasOwnProperty(propiedad)) {
                return true; // El objeto tiene al menos una propiedad
            }
        }
        return false; // El objeto está vacío
    }

    function buscarFacturasId(id) {
        let datos = {
            'IdFactura': id
        }
        // console.log(JSON.stringify(datos));
        $.ajax({
            type: "POST",
            url: "/ConsultaFacturas/buscarFactura",
            data: datos,
            encode: true,
        }).done(function(data) {
            // console.log(datos);

            try {
                var datos = JSON.parse(data);
            } catch (error) {
                //console.log(error);
                //console.log(data);
                return false;
            }
            for (var i = 0; i < datos.length; i++) {
                var fechaActual = datos[i].fecIngreso.date;
               // console.log(datos[i]);
                //document.getElementById('idFecha').value = fechaActual;

                $("#OrigenDB").val(datos[i].origen);
                $("#motivoDB").val(datos[i].motivo);
                $("#detalleDB").val(datos[i].detalle);
                $("#montoDB").val(datos[i].SubTotal);
                $("#lineasDB").val(datos[i].lineas);
                $("#fechaDB").val(datos[i].fecIngreso.date.slice(0, 10));
                $("#totalDB").val(datos[i].descripcionTotal);
                $("#IVADB").val(datos[i].IVA);
                $("#montoTotalDB").val(datos[i].montoTotal);

            }
            //$("#ModalToggle").show();
            // toastr.success("Consulta realizada!");
        });
        // ocultarSpinner();
    }

    function limpiarCampos() {
        $('#OrigenDB').val('');
        $('#motivoDB').val('');
        $('#detalleDB').val('');
        $('#montoDB').val('');
        $('#lineasDB').val('');
        $('#fechaDB').val('');
        $('#totalDB').val('');
        $("#IVADB").val('');
        $('#montoTotalDB').val('');
    }
</script>

<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- <h5 class="card-title text-center">Ingrese datos</h5> -->
                <br>
                <form id="frmCarro" name="frmCarro" class="row g-3">
                    <div class=" row">
                        <div class="col-md-6">
                            <div class=" row">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <select class="form-select limpiar" id="idOrigen" name="idOrigen" aria-label="State">
                                            <option selected value="0">Todos</option>
                                        </select>
                                        <label for="idOrigen">Origen</label>
                                    </div>
                                </div>
                            </div>
                            <div class=" row" style="padding-top: 15px;">
                                <div class="col-md-12" style="padding-top: 15px;">
                                    <div class="form-floating">
                                        <select class="form-select limpiar" id="idMotivo" name="idMotivo" aria-label="State">
                                            <option selected value="0">Todos</option>
                                        </select>
                                        <label for="idMotivo">Motivo</label>
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top: 15px;">
                                    <div class="form-floating mb-3">
                                        <select class="form-select limpiar" id="idFormaPago" aria-label="State">
                                            <option value="0" selected>Todos</option>
                                        </select>
                                        <label for="idFormaPago">Forma Pago</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control limpiar" id="idFechaI" placeholder="Fecha">
                                        <label for="idFechaI">Fecha Inicio</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control limpiar" id="idFechaF" placeholder="Fecha">
                                        <label for="idFechaF">Fecha Fin</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group" style="padding-top: 6px;">
                                <span class="input-group-text">Origen:</span>
                                <input type="text" aria-label="First name" id="OrigenDB" disabled class="form-control">
                            </div>

                            <div class="input-group" style="padding-top: 6px;">
                                <span class="input-group-text">Motivo:</span>
                                <input type="text" aria-label="First name" id="motivoDB" disabled class="form-control">
                            </div>

                            <div class="input-group" style="padding-top: 6px;">
                                <span class="input-group-text">Detalle:</span>
                                <textarea class="form-control limpiar" placeholder="" disabled id="detalleDB" style="height: 50px;"></textarea>

                            </div>

                            <div class="input-group" style="padding-top: 6px;">
                                <span class="input-group-text">Lineas:</span>
                                <input type="text" aria-label="First name" disabled id="lineasDB" class="form-control">
                                <span class="input-group-text">Fecha:</span>
                                <input type="text" aria-label="First name" disabled id="fechaDB" class="form-control">
                            </div>

                            <div class="input-group" style="padding-top: 6px;">
                                <span class="input-group-text">SubTotal:</span>
                                <input type="text" aria-label="First name" id="montoDB" disabled class="form-control">
                                <span class="input-group-text">IVA:</span>
                                <input type="text" aria-label="First name" id="IVADB" disabled class="form-control">
                            </div>

                            <div class="input-group" style="padding-top: 6px;">
                                <span class="input-group-text">Total Factura:</span>
                                <input type="text" aria-label="First name" id="montoTotalDB" disabled class="form-control">
                            </div>

                            <div class="input-group" style="padding-top: 6px;">
                                <span class="input-group-text">Total Acumulado:</span>
                                <textarea class="form-control limpiar" placeholder="" id="totalDB" disabled style="height: 60px;"></textarea>
                            </div>

                        </div>
                        <!-- <div class="col-md-12 d-grid gap-2">
                        <button type="button" id="btnAgregarDetalle" data-bs-toggle="modal" href="#ModalToggle" role="button" class="btn btn-outline-success">Agregar Detalle</button>
                        </div> -->
                    </div>

                    <div class="row" style="padding-top: 15px;">
                        <div class="col-md-6">
                            <div class="text-center">
                                <button type="button" id="btnEnviarFactura" class="btn btn-primary" onclick="buscarFacturas();">Buscar
                                    <!-- <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status" id="spinner">
                                    <span class="sr-only"></span>
                                </div>
                            </div> -->
                                </button>
                                <button type="reset" class="btn btn-secondary">Limpiar</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="padding-top: 15px;">
                        <div class="col-md-12">


                            <table class="table table-striped table-hover" id="tableFacturas">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Origen</th>
                                        <th scope="col">Motivo</th>
                                        <!-- <th scope="col">Detalle</th> -->
                                        <th scope="col">Monto</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </form><!-- End floating Labels Form -->

                <br>
            </div>
        </div>
    </div>

</div>

<div class="modal fade " id="ModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Detalle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table class="table table-striped table-hover" id="tableDetallesModal">
                    <thead>
                        <tr>
                            <th scope="col">Detalle</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Descripcion</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button class="btn btn-outline-success" id="btnAgregarDetalleModal" data-bs-dismiss="modal" disabled>Agregar</button> -->

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CODE -->
<?= $this->endSection() ?>