
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
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Panneau</h5>

              <!-- Horizontal Form -->
              <form  class="row g-3" method="post" action="<?php echo site_url('Back-Office/Panneau_Controller/panneau_trait?id=' . $datas[0]['id']); ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Capacite max</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" min="0" name="capacite" class="form-control" placeholder="<?php echo $datas[0]['capacitemax']; ?>" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tarif en Watt</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" name="tarif" min="0" class="form-control" placeholder="<?php echo $datas[0]['tarifenwatt']; ?>" required>
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

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Réglage Panneau</h5>
                <div class="row mb-3">
                <table style="width:100%" border="1">
                  <tr>
                    <th>Intereval</th>
                    <th>Pourcentage %</th>
                    <th></th>
                  </tr>
                  <?php  for ($i=0; $i < sizeof($pourcentage); $i++) { ?>
                    <form method="post" action="<?php echo site_url('Back-Office/Panneau_Controller/pourcentagepanneau_trait?id=' . $pourcentage[$i]['id']); ?>" enctype="multipart/form-data">
                      <tr>
                        <td><?php echo date('H', strtotime($pourcentage[$i]['heuredebut'])); ?> - <?php echo date('H', strtotime($pourcentage[$i]['heurefin'])); ?> h</td>
                        <td> <div class="col-sm-7">
                          <input type="number" id="decimalInput" step="0.01" min="0" name="pourcentage" class="form-control" placeholder="<?php echo $pourcentage[$i]['pourcentage']; ?>" required>
                        </div></td>
                        <td><button type="submit" class="btn btn-primary">Update</button></td>
                      </tr>
                    </form>
                  <?php }  ?> 
                </table>
                <div class="text-center">
                 

                </div>
                  <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success">
                            <center><?php echo $this->session->flashdata('success'); ?></center>
                        </div>
                    <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6" >

          <table>
                  <tr>
                    <th>Label</th>
                    <th>Capacite en Watt</th>
                    <th>Tarif</th>
                  </tr>
                  <tr>
                    <td><?php echo $datas[0]['label']; ?></td>
                    <td><?php echo $datas[0]['capacitemax']; ?></td>
                    <td><?php echo $datas[0]['tarifenwatt']; ?></td>
                  </tr>
            </table>

        </div>
    </section>

  </main><!-- End #main -->