
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Menu</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo site_url('Back-Office/SController/home');?>">Home</a></li>
          <li class="breadcrumb-item active">Link</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8 ">
          <div class="row">
            <h5 class="card-title">Détaille pour Consommation de <?php echo date('H',strtotime($datas[0]['heure'])); ?> heures</h5>
            <div class="col-md-10" >
            <table>

                <?php
                $caracteristiques = array(
                    'Capacité max panneau' => $datas[0]['panneau_capacite_max'],
                    'Pourcentage panneau' => $datas[0]['pourcentage_pourcentage'],
                    'Capacité du groupe' => $datas[0]['groupe'],
                    'Capacité max de Jirama' => $datas[0]['jirama_capacite_max'],
                    'Capacité du panneau suivant pourcentage' => $datas[0]['capacite_panneau']
                );

                foreach ($caracteristiques as $nom => $valeur) {
                    echo "<tr>";
                    echo "<td>$nom</td>";
                    echo "<td>$valeur</td>";
                    echo "</tr>";
                }
                ?>
            </table>
                </div>
              <p>Total : <h2><?php echo $datas[0]['production_res']; ?></h2> </p>
            </br>
            <p><a href="<?php echo site_url('Back-Office/SController/home');?>">retour</a></p>
      </div>
     
    </section>
  
  </main><!-- End #main -->

  