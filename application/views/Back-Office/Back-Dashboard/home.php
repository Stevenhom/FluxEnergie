
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Menu</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('Back-Office/SController/home');?>">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8 ">
          <div class="row">

            <!-- Sales Card -->
           

              
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">



                <div class="card-body">
                  <h5 class="card-title">Coté Administrateur <span>| 2023</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6></h6>
                      <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1">Bienvenue sur le site où vous pouvez entretenir vos activites</span>

                    </div>
                  </div>

                </div>
              </div>
             
            </div><!-- End Customers Card -->

            
            <div class="col-md-12" >
              <?php if (!empty($conso) && isset($conso[0])) { ?>
                <table>
                    <tr>
                        <th>Heure</th>
                        <th>Production</th>
                        <th>Consommation</th>
                    </tr>
                    <?php for ($i = 0; $i < sizeof($conso); $i++) { ?>
                        <tr>
                            <td><?php echo date('H', strtotime($conso[$i]['heure'])); ?></td>
                            <td >
                              <a  href="<?php echo site_url('Back-Office/SController/link_prod?heure=' . $conso[$i]['heure']); ?>">
                                    <?php echo $conso[$i]['production']; ?>
                              </a>
                            </td>
                            <td >
                              <a style="color: <?php echo ($conso[$i]['resultat_consommation'] > $conso[$i]['production']) ? 'red' : 'green'; ?>" href="<?php echo site_url('Back-Office/SController/cout'); ?>">

                                    <?php echo $conso[$i]['resultat_consommation']; ?>
                              </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                
                    <br>
                    <heading><a href="<?php echo site_url('Back-Office/SController/cout')?>">Tarif et Cout</a></heading>
                    <?php } else { ?>
                        <p>Les données sont vides</p>
                    <?php } ?>
                </div>

      </div>
     
    </section>
  
  </main><!-- End #main -->

  