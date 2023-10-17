<?= $this->extend('Layouts/index') ?>
<?= $this->section('content') ?>
<!-- BEGIN MAIN CODE -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        var fechaActual = new Date().toISOString().slice(0, 10);
        document.getElementById('idFecha').value = fechaActual;
        cargarOrigenes();
        //cargarMotivos();
        cargarFormasPago();
        ocultarSpinner();

        $('#idCatDetalle').change(function() {

            if ($('#idCatDetalle').val() == "0") {
                $('#btnAgregarDetalleModal').prop('disabled', true);
                $('#btnAgregarDetalleModal').focus();
            } else {
                $('#btnAgregarDetalleModal').removeAttr('disabled');
            }
        });

        $("#idOrigen").change(function() {

            if ($("#idOrigen").val() == 0) {
                //console.log("(#idOrigen).change=> 0");
                return;
            }
            let datos = {
                'idOrigen': $("#idOrigen").val()
            }
            $.ajax({
                type: "POST",
                url: "/Mantenimientocarro/listarMotivos",
                data: datos,
                //dataType: "json",
                encode: true,
            }).done(function(data) {
                $('#idMotivo').html('');
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
        });

        $("#idFormaPago").change(function(eval) {
            //console.log("(#idOrigen).change=> 0");
            return;
        });

        $("#idMotivo").change(function() {

            if ($("#idMotivo").val() == 0) {
                //console.log("(#idMotivo).change=> 0");
                return;
            }
            let datos = {
                'idMotivo': $("#idMotivo").val()
            }
            $.ajax({
                type: "POST",
                url: "/Mantenimientocarro/listarMotivos",
                data: datos,
                //dataType: "json",
                encode: true,
            }).done(function(data) {
                //console.log("(#idMotivo).change=> " + JSON.stringify(data));
            });
        });

        $("#btnAgregarDetalle").click(
            function() {
                $('#btnAgregarDetalleModal').prop('disabled', true);
                var datos = obtenerCategorias();
            }
        );

        $('#tableDetalles').on('click', '.eliminarFila', function() {

            var fila = $(this).closest('tr');
            var montoTotal = $('#idMontoFactura').val();
            var valorDelTD = fila.find('td:eq(1)').text();
            montoTotal = parseFloat(montoTotal) - parseFloat(valorDelTD);
            ////console.log(valorDelTD);
            $('#idMontoFactura').val(parseFloat(montoTotal).toFixed(2));
            fila.remove();
        });

        $("#btnAgregarDetalleModal").click(
            function() {
                cargarDatosDetalle()
            }
        );


        // Agregar un manejador de eventos al cambio del checkbox
        $("#idIVA").change(function() {
            var inputMonto = document.getElementById('idMontoFactura').value;

                if (this.checked) {
                    if (!isNaN(inputMonto)) {
                    var monto = parseFloat(inputMonto);
                    var resultado = monto + (monto * 0.13); // Sumar el 13%
                    $("#idMontoFactura").val(resultado.toFixed(2)); 
                }

            } else {
                $("#idMontoFactura").val( $("#hdMonto").val());
            }
        });




    });

    function obtenerCategorias() {
        $('#idMontoDetalle').val('');
        $('#idDetalleCat').val('');
        $('#idCatDetalle').html('');
        let datos = {
            idOrigen: $("#idOrigen").val()
        };

        $.ajax({
            type: "POST",
            url: "/Mantenimientocarro/listarCategorias",
            data: datos,
            encode: true,
        }).done(function(data) {
            try {
                $('#idCatDetalle').prepend('<option value="0" selected>Eliga </option>');
                var select = document.getElementById("idCatDetalle");
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
                    option.text = datos[i].descripcion;
                    select.appendChild(option);
                }
                //console.log("cargarDetalles() => " + data);
            } catch (error) {
                //console.log(error);
                //console.log(data);
                return false;
            }
        });
    }

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

    function enviarFactura() {
        if (validarCamposIngreso()) {
            Swal.fire({
                title: 'Insertar registro',
                text: 'Desea ingresar el registro',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    enviarFacturaGuardar();
                }
            });
        }
    }

    function enviarFacturaGuardar() {
        mostrarSpinner();
        var filas = $('#tableDetalles tbody tr');
        var datosDetalle = [];
        filas.each(function() {
            var fila = $(this);
            var celdas = fila.find('td');
            var filaDatos = {};
            celdas.each(function(index) {
                var columna = $(this);
                var nombreColumna = $('#tableDetalles thead th').eq(index).text();
                filaDatos[nombreColumna] = columna.text();
            });
            datosDetalle.push(filaDatos);
        });
        //console.log("enviarFacturaGuardar()=>");
        //console.log(JSON.stringify(datosDetalle));
        let datos = {
            'IdMotivo': $("#idMotivo").val(),
            'IdOrigen': $("#idOrigen").val(),
            'Detalle': $("#idDetalle").val(),
            'MontoFactura': $("#idMontoFactura").val(),
            'FormaPago': $("#idFormaPago").val(),
            'fecha': $("#idFecha").val(),
            'JsonDetalles': JSON.stringify(datosDetalle)
        }
        console.log(JSON.stringify(datos));

        $.ajax({
            type: "POST",
            url: "/Mantenimientocarro/procesarFactura",
            data: datos,
            encode: true,
        }).done(function(data) {
            if (data === "200") {
                //console.log("enviarFactura() => " + data);
                // Swal.fire({
                //     title: 'Registro ingresado!',
                //     text: 'Click para continuar!',
                //     icon: 'success',
                //     confirmButtonText: 'Cool!'
                // });
                toastr.success("Registro ingresado!");
                limpiarCampos();
                ocultarSpinner();
            } else {
                //console.log("enviarFactura() => " + data);
                toastr.error("ERROR");
                ocultarSpinner();
                Swal.fire({
                    title: 'Error registrando el registro!',
                    text: data,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
        ocultarSpinner();
    }

    function validarCamposIngreso() {
        if ($("#idOrigen").val() == "0") {
            $("#idOrigen").focus();
            toastr.warning("Ingrese Vehiculo");
            ocultarSpinner();
            return false;
        }
        if ($("#idMotivo").val() == "0") {
            $("#idMotivo").focus();
            toastr.warning("Ingrese Establecimiento");
            ocultarSpinner();
            return false;
        }
        if ($("#idFormaPago").val() == "0") {
            $("#idFormaPago").focus();
            toastr.warning("Ingrese Forma de pago");
            ocultarSpinner();
            return false;
        }

        if ($("#idMontoFactura").val() === undefined || $("#idMontoFactura").val() === "") {
            toastr.warning("Ingrese Monto valido o 0");
            $("#idMontoFactura").focus();
            ocultarSpinner();
            return false;
        }
        return true;
    }

    function limpiarCampos() {
        $('.limpiar').val('');
        $('#idOrigen').val('0');
        $('#idMotivo').val('0');
        $('#idFormaPago').val('0');
        $('#tableDetalles tbody tr').remove();
        var fechaActual = new Date().toISOString().slice(0, 10);
        document.getElementById('idFecha').value = fechaActual;
    }

    function soloNumeros(event) {
        var codigoTecla = event.which || event.keyCode;
        if ((codigoTecla >= 48 && codigoTecla <= 57) ||
            codigoTecla == 8(codigoTecla >= 37 && codigoTecla <= 40)) {
            return true;
        } else {
            return false;
        }
    }

    function mostrarSpinner() {
        document.getElementById("spinner").style.display = "block";
    }

    function ocultarSpinner() {
        document.getElementById("spinner").style.display = "none";
    }

    function cargarDatosDetalle() {
        var idDetalle = $("#idCatDetalle").val();
        var idDetalleDescripcion = $("#idCatDetalle option:selected").text();
        var monto = $("#idMontoDetalle").val();
        if (monto === undefined || monto === "") {
            monto = "0";
        }
        var detalle = $("#idDetalleCat").val();
        var tabla = document.getElementById("tableDetalles");
        if (idDetalle == "0") {
            $("#idCatDetalle").focus();
        } else {
            var consecutivo = 1;
            var fila = document.createElement("tr");
            var celda1 = document.createElement("td");
            var celda2 = document.createElement("td");
            celda2.classList.add('sumar')
            var celda3 = document.createElement("td");
            var celda4 = document.createElement("td");
            var boton = document.createElement('button');
            var span = document.createElement('span');
            span.classList.add('bi')
            span.classList.add('bi-trash')
            boton.classList.add('btn');
            boton.classList.add('btn-outline-danger');
            boton.classList.add('eliminarFila');
            boton.appendChild(span);
            var ultimaFila = tabla.rows[tabla.rows.length - 1];
            var ultimoValor = ultimaFila.cells[0].textContent;
            if (ultimoValor == "#") {
                celda1.textContent = consecutivo;
            } else {
                celda1.textContent = parseInt(ultimoValor) + 1;
            }
            celda2.textContent = parseFloat(monto).toFixed(2);
            celda3.textContent = idDetalleDescripcion + "|" + detalle + "|" + idDetalle;
            celda4.appendChild(boton);
            fila.appendChild(celda1);
            fila.appendChild(celda2);
            fila.appendChild(celda3);
            fila.appendChild(celda4);
            tabla.querySelector("tbody").appendChild(fila);
            var total = 0;
            $('.sumar').each(function() {
                var valor = parseFloat($(this).text()) || 0;
                total += valor;
            });
            $('#idMontoFactura').val(total.toFixed(2));
            $('#hdMonto').val(total.toFixed(2));
        }
    }
</script>

<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">Ingrese datos</h5>
                <form id="frmCarro" name="frmCarro" class="row g-3">
                    <input type="hidden" id=hdMonto>
                    <div class="col-md-5">
                        <div class="form-floating">
                            <select class="form-select limpiar" id="idOrigen" name="idOrigen" aria-label="State">
                                <option selected value="0">Elegir</option>
                            </select>
                            <label for="idOrigen">Origen</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select limpiar" id="idMotivo" name="idMotivo" aria-label="State">
                                <option selected value="0">Elegir</option>
                            </select>
                            <label for="idMotivo">Motivo</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <select class="form-select limpiar" id="idFormaPago" aria-label="State">
                                <option value="0" selected>Elegir</option>
                            </select>
                            <label for="idFormaPago">Forma Pago</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-floating">
                            <textarea class="form-control limpiar" placeholder="Address" id="idDetalle" style="height: 100px;"></textarea>
                            <label for="idDetalle">Detalle</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <!-- <input type="text" class="form-control limpiar mask" id="idMontoFactura" placeholder="Monto" onkeypress="return soloNumeros(event)"> -->
                            <input type="number" class="form-control limpiar" id="idMontoFactura" name="idMontoFactura" step="0.01" min="0" max="9000000" placeholder="0.00">
                            <label for="idMontoFactura">Monto</label>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="date" class="form-control limpiar" id="idFecha" placeholder="Fecha">
                            <label for="idFecha">Fecha</label>
                        </div>
                    </div>

                    <div class="col-md-5">
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="idIVA">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Aplicar IVA</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                    </div>



                    <div class="col-md-12 d-grid gap-2">
                        <button type="button" id="btnAgregarDetalle" data-bs-toggle="modal" href="#ModalToggle" role="button" class="btn btn-outline-success">Agregar Detalle</button>
                    </div>

                    <div class="col-md-12">
                        <ul class="list-group" id="ListaDetalles">
                        </ul>

                        <table class="table table-striped table-hover" id="tableDetalles">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        <button type="button" id="btnEnviarFactura" class="btn btn-primary" onclick="enviarFactura();">Guardar
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status" id="spinner">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </button>
                        <button type="reset" class="btn btn-secondary">Limpiar</button>
                    </div>
                </form><!-- End floating Labels Form -->

            </div>
        </div>
    </div>
    <div class="col-md-2">

    </div>
</div>

<div class="modal fade" id="ModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Detalle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="idCatDetalle" name="idCatDetalle" aria-label="State">
                            <option selected value="0">Elegir</option>
                        </select>
                        <label for="idCatDetalle">Detalle</label>
                    </div>
                </div>

                <br>

                <div class="col-md-12">
                    <div class="form-floating">
                        <!-- <input type="text" class="form-control" id="idMontoDetalle" placeholder="Monto" onkeypress="return soloNumeros(event)"> -->
                        <input type="number" class="form-control limpiar" id="idMontoDetalle" name="idMontoDetalle" step="0.01" min="0" max="9000000" placeholder="0.00">
                        <label for="idMontoDetalle">Monto</label>
                    </div>
                </div>

                <br>

                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Address" id="idDetalleCat" style="height: 100px;"></textarea>
                        <label for="idDetalleCat">Detalle</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-outline-success" id="btnAgregarDetalleModal" data-bs-dismiss="modal" disabled>Agregar</button>

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CODE -->
<?= $this->endSection() ?>