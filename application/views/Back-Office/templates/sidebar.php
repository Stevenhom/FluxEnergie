  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?php echo site_url('Back-Office/SController/home');?>">
          <i class="bi bi-grid"></i>
          <span>Menu</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Gestion </span><i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('Back-Office/Panneau_Controller/panneau');?>">
              <i class="bi bi-circle"></i><span>Panneau solaire</span>
            </a>
          </li>
        </ul>

        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('Back-Office/Groupe_Controller/groupe');?>">
              <i class="bi bi-circle"></i><span>Groupe électrogène</span>
            </a>
          </li>
        </ul>

        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('Back-Office/Jirama_Controller/jirama');?>">
              <i class="bi bi-circle"></i><span>Jirama</span>
            </a>
          </li>
        </ul>

      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Consommation </span><i class="bi bi-chevron-down ms-auto"></i>
        </a>

        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('Back-Office/Consommation_Controller/consommation');?>">
              <i class="bi bi-circle"></i><span>Insertion Consommation</span>
            </a>
          </li>
        </ul>

        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo site_url('Back-Office/Pourcentage_Controller/pourcentage');?>">
              <i class="bi bi-circle"></i><span>Pourcentage</span>
            </a>
          </li>
        </ul>

      </li><!-- End Forms Nav -->



      <li class="nav-item">


        <li class="nav-item">
          <a href="<?php echo site_url('Back-Office/SController/graphique');?>">
            <i class="bi bi-circle"></i><span>Graphique</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo site_url('Back-Office/Import_Controller/import');?>">
            <i class="bi bi-circle"></i><span>Importation csv</span>
          </a>
        </li>


      </li><!-- End Forms Nav -->


    </ul>

  </aside><!-- End Sidebar-->