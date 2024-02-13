
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
            <div class="col-md-5" >
            <table>
                <tr>
                    <th>Caractéristique</th>
                    <th>Valeur</th>
                </tr>
                <?php
                $caracteristiques = array(
                    'Nombre d\'eleve' => $datas[0]['nombre_eleve'],
                    'Puissance machine' => $datas[0]['puissance_machine'],
                    'Consommation fixe' => $datas[0]['conso_fixe']
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
              <p>Résultat : <h2><?php echo $datas[0]['resultat_consommation']; ?></h2> </p>
            </br>
            <p><a href="<?php echo site_url('Back-Office/SController/home');?>">retour</a></p>
      </div>
     
    </section>
  
  </main><!-- End #main -->

  