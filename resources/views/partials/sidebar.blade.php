<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left info">
          <p>{{ auth()->user()->name }}</p>
        </div>
        <br>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Cauta...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENIU PRINCIPAL</li>
        <li>
          <a href="/suppliers">
            <i class="fa fa-th"></i> <span>Furnizori</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Nomenclator</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/countries"><i class="fa fa-circle-o"></i>Tari</a></li>
            <li><a href="/supplier_group"><i class="fa fa-circle-o"></i>Grupa furnizor</a></li>
            <li><a href="/supplier_status"><i class="fa fa-circle-o"></i>Status furnizor</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Vehicole</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Certificare</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Specii</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Sortimente cherestea</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Grupuri cherestea</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Conditii de plata</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Status facturi</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Unitati de masura</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>