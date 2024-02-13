
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
              <h5 class="card-title">JIRAMA</h5>

              <!-- Horizontal Form -->
              <form  class="row g-3" method="post" action="<?php echo site_url('Back-Office/Jirama_Controller/jirama_trait?id=' . $datas[0]['id']); ?>" enctype="multipart/form-data">

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Cout par Watt</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" name="cout" min="0" class="form-control" placeholder="<?php echo $datas[0]['coutparwatt']; ?>" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Capacite max</label>
                    <div class="col-sm-7">
                      <input type="number" id="decimalInput" step="0.01" min="0" name="capacite" class="form-control" placeholder="<?php echo $datas[0]['capacitemax']; ?>" required>
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
                    <th>Cout par Watt</th>
                    <th>Capacite maximum</th>
                  </tr>
                  <tr>
                    <td><?php echo $datas[0]['coutparwatt']; ?></td>
                    <td><?php echo $datas[0]['capacitemax']; ?></td>
                  </tr>
            </table>

        </div>
    </section>

  </main><!-- End #main -->