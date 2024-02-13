
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
              <h5 class="card-title">Pourcent</h5>

              <!-- Horizontal Form -->
              <form  class="row g-3" method="post" action="<?php echo site_url('Back-Office/Pourcentage_Controller/pourcentage_trait')?>" enctype="multipart/form-data">

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Heure début</label>
                    <div class="col-sm-7">
                      <input type="time" id="decimalInput" min="8" name="debut" value="12:00:00" class="form-control" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Heure fin</label>
                    <div class="col-sm-7">
                      <input type="time" id="decimalInput" min="8" name="fin" value="14:00:00" class="form-control" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Pourcentage Etudiant</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" min="0" name="pourcentage" class="form-control" required>
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

                    <?php if (isset($erreur)) : ?>
                      <div class="alert alert-danger">
                          <?php echo $erreur; ?>
                      </div>
                  <?php endif; ?>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

        </div>

      
      </div>

      <div class="col-md-8" >
      <?php if (!empty($datas) && isset($datas[0])) { ?>
          <table>
                  <tr>
                    <th>Heure du début</th>
                    <th>Heure de fin</th>
                    <th>Pourcentage</th>
                  </tr>
                  <tr>
                    <td><?php echo $datas[0]['heuredebut']; ?></td>
                    <td><?php echo $datas[0]['heurefin']; ?></td>
                    <td><?php echo $datas[0]['nombre']; ?></td>

                  </tr>
            </table>
            <?php } else { ?>
                <p>Les données sont vides</p>
            <?php } ?>
        </div>
    </section>

  </main><!-- End #main -->