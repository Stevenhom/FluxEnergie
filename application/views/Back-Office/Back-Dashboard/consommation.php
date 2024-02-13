
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
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Entrer consommation</h5>

              <!-- Horizontal Form -->
              
              <form  class="row g-3" method="post" action="<?php echo site_url('Back-Office/Consommation_Controller/consommation_trait');?>" enctype="multipart/form-data">

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre total</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" min="0" name="nombre" class="form-control" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Puissance Laptop</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step='0.01' min="0" name="puissance" class="form-control" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Conso fixe</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step='0.01' min="0" name="consommation" class="form-control" required>
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
      <div class="col-lg-10" >
      <?php if (!empty($datas) && isset($datas[0])) { ?>
          <table>
                  <tr>
                    <th>Nombre total d'élève</th>
                    <th>Puissance machine</th>
                    <th>Consommation fixe</th>
                  </tr>
                  <tr>
                    <td><?php echo $datas[0]['nombreeleve']; ?></td>
                    <td><?php echo $datas[0]['puissancemachine']; ?></td>
                    <td><?php echo $datas[0]['consofixe']; ?></td>
                  </tr>
            </table>
            <?php } else { ?>
                <p>Les données sont vides</p>
            <?php } ?>
        </div>
    </section>

  </main><!-- End #main -->