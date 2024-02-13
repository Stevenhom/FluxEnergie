
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
            
            <div class="col-md-12" >
              <?php if (!empty($cout) && isset($cout[0])) { ?>
                  <table>
                          <tr>
                            <th>Heure</th>
                            <th>Panneau (W)</th>
                            <th>Groupe (W)</th>
                            <th>Jirama (W)</th>
                            <th>Consommation (W)</th>
                            <th></th>
                          </tr>
                          <?php  for ($i=0; $i < sizeof($cout); $i++) { ?>
                            <tr>
                              <td><?php echo date('H',strtotime($cout[$i]['heure'])); ?></td>
                              <td><?php echo $cout[$i]['capacite_panneau']; ?> </td>
                              <td><?php echo $cout[$i]['groupe']; ?> </td>
                              <td><?php echo $cout[$i]['jirama_capacite_max']; ?> </td>
                              <td><?php echo $cout[$i]['resultat_consommation']; ?> </td>
                            </tr>
                            <?php }  ?> 
                            <tr>
                              <td></td>
                              <td><?php echo $cout_t[0]['tarif_panneau']; ?> </td>
                              <td><?php echo $cout_t[0]['tarif_groupe']; ?> </td>
                              <td><?php echo $cout_t[0]['tarif_jirama']; ?> </td>
                              <td><p>Total : </p><h3><?php echo $cout_t[0]['total_conso']; ?></h3> Ar </td>
                            </tr>
                    </table>
                    <br>
                    <heading><a href="<?php echo site_url('Back-Office/SController/home')?>">Retour</a></heading>
                    <?php } else { ?>
                        <p>Les données sont vides</p>
                    <?php } ?>
                </div>

      </div>
     
    </section>
  
  </main><!-- End #main -->

  