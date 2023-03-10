<?= $this->extend('Layouts/index') ?>
<?= $this->section('content') ?>
<!-- BEGIN MAIN CODE -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<script>
    $(document).ready(function() {
        // Evento cambiar el combo de vehículos.
        //https://reqres.in/api/articles
        $("#idCar").change(function() {
            let datos = {
                'idCarro': $("#idCar").val()
            }

            //console.log(datos);
            $.ajax({
                type: "POST",
                url: "/Mantenimientocarro/buscar",
                data: datos,
                //dataType: "json",
                encode: true,
            }).done(function(data) {
                console.log("Mensaje ajax= "+ data);
            });
            // axios.post('/Mantenimientocarro/buscar', datos)
            //     .then(response => console.log('console.log() ' + JSON.stringify(response.data)))
            //     .catch(error => {
            //         console.error('There was an error!', error);
            //     });
        });

    });
</script>

<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">Ingrese datos del mantenimiento</h5>
                <form id="frmCarro" name="frmCarro" class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <select class="form-select" id="idCar" name="idCar" aria-label="State">
                                <option value="0" selected>Elegir Vehículo</option>
                                <option value="1">Mitsubishi Lancer gts 2010</option>
                                <option value="2">Hyundai Tucson 2020</option>
                                <option value="3">Mitsubishi Lancer glx 2005</option>
                            </select>
                            <label for="floatingSelect">Vehículo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="floatingEmail" placeholder="Your Email">
                            <label for="floatingEmail">Your Email</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                            <label for="floatingTextarea">Address</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingCity" placeholder="City">
                                <label for="floatingCity">City</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="State">
                                <option selected>New York</option>
                                <option value="1">Oregon</option>
                                <option value="2">DC</option>
                            </select>
                            <label for="floatingSelect">State</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingZip" placeholder="Zip">
                            <label for="floatingZip">Zip</label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End floating Labels Form -->

            </div>
        </div>
    </div>
    <div class="col-md-3">

    </div>
</div>

<!-- END MAIN CODE -->
<?= $this->endSection() ?>