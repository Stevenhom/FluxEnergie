
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Depense</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Layouts</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        
        <div class="col-lg-10">
        <form action="<?php echo base_url('Back-Office/Import_controller/importer_csv'); ?>" method="post" enctype="multipart/form-data">
          <input type="file" name="fichier_csv" accept=".csv">
          <button type="submit">Importer</button>
          <?php if ($this->session->flashdata('success')) { ?>
                        <div class="alert alert-success">
                            <center><?php echo $this->session->flashdata('success'); ?></center>
                        </div>
                    <?php } ?>
      </form>


        </div>
      </div>
    </section>

  </main><!-- End #main -->

  