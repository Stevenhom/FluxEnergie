
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
    <canvas id="line-chart" width="200" height="100"></canvas>

          <?php
          // Extraire les valeurs de hcp.heure du tableau $consommation
          $labels = array_map(function($entry) {
              return "'" . $entry['heure'] . "'";
          }, $consoprod);
          $labelsString = implode(',', $labels);
          ?>

          <script>
              var ctx = document.getElementById('line-chart').getContext('2d');
              var data = <?php echo json_encode($consoprod); ?>;
              var labels = [<?php echo $labelsString; ?>];

              var chart = new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: labels,
                      datasets: [
                          {
                              data: data.map(entry => entry.production),
                              label: "Production",
                              borderColor: "#3e95cd",
                              fill: false
                          },
                          {
                              data: data.map(entry => entry.resultat_consommation),
                              label: "Consommation",
                              borderColor: "#c45850",
                              fill: false
                          }
                      ]
                  },
                  options: {
                      title: {
                          display: true,
                          text: 'Evolution de la production et de la consommation'
                      }
                  }
              });
          </script>
    </section>

  </main><!-- End #main -->