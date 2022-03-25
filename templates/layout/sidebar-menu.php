<?php 
    $currentPath = lcfirst($this->request->getParam('controller'));
    $dashb = lcfirst($this->request->getParam('action')); 
    $user = $this->request->getAttribute('identity')->getOriginalData(); 
?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="<?php echo $this->Url->build(('/dashboard')); ?>" class="nav-link <?= $dashb == 'dashboard' ? 'active': '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a> 
          </li>
          
          <li class="nav-item"> 
            <a href="<?php echo $this->Url->build(('/items')); ?>" class="nav-link  
            <?php
            if($currentPath == 'items'){
              echo $dashb == 'dashboard' ?  '' : 'active';
            } 
            ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Items
              </p>
            </a>
          </li>   
          
          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/categories'), ['controller' => 'CategoriesController','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'categories' ? 'active': '' ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Categories 
              </p>
            </a>
          </li>   
          
          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/subcategories'), ['controller' => 'SubcategoriesController','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'subcategories' ? 'active': '' ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Sub Categories 
              </p>
            </a>
          </li>   

          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/transactions'), ['controller' => 'TransactionsController','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'transactions' ? 'active': '' ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Transactions
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/transactionItems'), ['controller' => 'TransactionItems','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'transactionItems' ? 'active': '' ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Transaction Items
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/outgoing'), ['controller' => 'Outgoing','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'outgoing' ? 'active': '' ?>">
              <!-- <i class="nav-icon fas fa-shopping-cart"></i> -->
              <i class="nav-icon fas fa-truck-moving"></i>
              <p>
                Outgoing Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/incoming'), ['controller' => 'IncomingController','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'incoming' ? 'active': '' ?>">
              <!-- <i class="nav-icon fas fa-users"></i> -->
              <i class="nav-icon fas fa-truck-loading"></i>
              <p>
                Incoming Management
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/company'), ['controller' => 'CompanyController','action' => 'index']); ?>" class="nav-link  <?= $currentPath == 'company' ? 'active': '' ?>">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Companies
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/transactionType'), ['controller' => 'TransactionTypeController','action' => 'index']); ?>" class="nav-link  <?= $currentPath == 'transactionType' ? 'active': '' ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Transaction Type
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/transactionStatus'), ['controller' => 'TransactionStatusController','action' => 'index']); ?>" class="nav-link  <?= $currentPath == 'transactionStatus' ? 'active': '' ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Transaction Status
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/users'), ['controller' => 'UsersController','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'users' ? 'active': '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>  
          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/user-roles'), ['controller' => 'UserRolesController','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'user-roles' ? 'active': '' ?>">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                User Roles
              </p>
            </a>
          </li>  
          <li class="nav-item">
            <a href="<?php echo $this->Url->build(('/auditTrails'), ['controller' => 'AuditTrails','action' => 'index']); ?>" class="nav-link <?= $currentPath == 'auditTrails' ? 'active': '' ?>">
  
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
              Audit Trails
              </p>
            </a>
          </li>  

        </ul>
      </nav>