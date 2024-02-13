
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Gestion</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Layouts</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row g-3">
        <div class="col">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $datas[0]['label']; ?></h5>

              <!-- Horizontal Form -->
              <form  class="row g-3" method="post" action="<?php echo site_url('Back-Office/Groupe_Controller/groupe_trait?id=' . $datas[0]['id']); ?>" enctype="multipart/form-data">

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Capacite max</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" min="0" name="capacite" class="form-control" placeholder="<?php echo $datas[0]['capacitemax']; ?>" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Capacité du réservoir</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" name="reservoir" min="0" class="form-control" placeholder="<?php echo $datas[0]['capacitereservoir']; ?>" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Consommation par litre par heure</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" name="conso" min="0" class="form-control" placeholder="<?php echo $datas[0]['consoparlitreheure']; ?>" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Prix essence</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" name="essence" min="0" class="form-control" placeholder="<?php echo $datas[0]['prixessence']; ?>" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Heure fin</label>
                    <div class="col-sm-7">
                      <input type="time" id="decimalInput" min="08:00:00" name="heure_groupe" class="form-control" required>
                    </div>
                  </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Valider</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
                <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success">
                            <center><?php echo $this->session->flashdata('success'); ?></center>
                        </div>
                    <?php } ?>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

        </div>

      
      </div>
      <div class="col" >

          <table>
                  <tr>
                    <th>Label</th>
                    <th>Capacite maximum</th>
                    <th>Capacité du réservoire</th>
                    <th>Consommation par litre heure</th>
                    <th>Prix d'essence</th>
                  </tr>
                  <tr>
                    <td><?php echo $datas[0]['label']; ?></td>
                    <td><?php echo $datas[0]['capacitemax']; ?></td>
                    <td><?php echo $datas[0]['capacitereservoir']; ?></td>
                    <td><?php echo $datas[0]['consoparlitreheure']; ?></td>
                    <td><?php echo $datas[0]['prixessence']; ?></td>
                  </tr>
            </table>

        </div>
    </section>

  </main><!-- End #main -->