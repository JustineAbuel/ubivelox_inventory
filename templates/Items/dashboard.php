  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0">Dashboard</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Dashboard</li>
                      </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">

              <?= $this->Flash->render() ?>

              <!-- Small boxes (Stat box) -->
              <div class="row">
                  <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                          <div class="inner">
                              <h3><?= $addedThisMonth ?></h3>

                              <p>Newly added item</p>
                          </div>
                          <div class="icon">
                              <i class="fa fa-truck-loading"></i>
                          </div>
                          <?= $this->Html->link(
                                ' More info  <i class="fas fa-arrow-circle-right"></i>',
                                ['controller' => 'Incoming',   'action' => 'index',],
                                ['class' => 'small-box-footer', 'escape' => false],
                            ); ?>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-success">
                          <div class="inner">
                              <h3><?= $items ?></h3>

                              <p>Items</p>
                          </div>
                          <div class="icon">
                              <i class="fa fa-shopping-cart"></i>
                          </div>
                          <?= $this->Html->link(
                                ' More info  <i class="fas fa-arrow-circle-right"></i>',
                                ['controller' => 'Items',   'action' => 'index',],
                                ['class' => 'small-box-footer', 'escape' => false],
                            ); ?>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-warning  ">
                          <div class="inner">
                              <h3><?= $returnedItems ?></h3>

                              <p>Returned Items</p>
                          </div>
                          <div class="icon">
                              <i class="fa fa-truck-moving"></i>
                          </div>
                          <?= $this->Html->link(
                                ' More info  <i class="fas fa-arrow-circle-right"></i>',
                                ['controller' => 'Outgoing',   'action' => 'index',],
                                ['class' => 'small-box-footer', 'escape' => false],
                            ); ?>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                          <div class="inner">
                              <h3><?= $damagedItem ?></h3>

                              <p>Damaged Item</p>
                              <small></small>
                          </div>
                          <div class="icon">
                              <i class="fa fa-exclamation-triangle"></i>
                          </div>
                          <?= $this->Html->link(
                                ' More info  <i class="fas fa-arrow-circle-right"></i>',
                                ['controller' => 'Outgoing',   'action' => 'index',],
                                ['class' => 'small-box-footer', 'escape' => false],
                            ); ?>
                      </div>
                  </div>
                  <!-- ./col -->
              </div>
              <!-- /.row -->
              <!-- Main row -->
              <!-- <div class="row"> 
          <section class="col-lg-7 connectedSortable"> 
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Ins and Outs 
                </h3>
                <div class="card-tools"> 
                </div>
              </div> 
              <div class="card-body">
                <div class="tab-content p-0"> 
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                   </div> 
                </div>
              </div> 
            </div> 
          </section>

          <section class="col-lg-5 connectedSortable">
            <div class="card">
              <div class="card-header">
                <p class="card-title">Recently Added Items</p>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div> 
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  
                <?php //foreach($latestitems as $latestitem):
                ?>
                  <li class="item">
                    <div class="product-img mr-2">  
                      <?php
                        // $imageclass = 'img-size-25'; 
                        // if(!$latestitem->image){      
                        //   echo $this->Html->image('item-default.png', ['class' => $imageclass, 'alt'=> $latestitem->item_name  ]); 

                        // }else{
                        //   echo $this->Html->image('uploads/itemimages/'.$latestitem->id.'/'.$latestitem->image, ['class' => $imageclass, 'alt'=> $latestitem->item_name ]);   

                        // }
                        ?>
                    </div>
                    <div class="product-info"> 
                      <?php
                        // echo $this->Html->link(
                        //   $latestitem->item_name ,
                        //   [ 'Controller' => 'ItemsController', 'action' => 'view', $latestitem->id ],
                        //   ['escape' => false, 'class'=>"product-title" ]
                        //   ); 
                        ?>
                        <span class="badge badge-warning float-right"><?= $latestitem->quantity ?></span>
                      <span class="product-description">
                        <?= $latestitem->item_description ?>
                      </span>
                    </div>
                  </li>
                  <?php //endforeach 
                    ?>  

                </ul>
              </div> 
              <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase"></a>
                <? php // echo $this->Html->link(
                // "View All Items", 
                // [ 'Controller' => 'ItemsController', 'action' => 'index' ],
                // ['escape' => false, 'class'=>"uppercase" ]
                // ); 
                ?>
              </div> 
            </div>
          </section>
        </div> -->
              <div class="row">
                  <div class="col-md-12">
                      <div class="card">
                          <div class="card-header">
                              <h5 class="card-title">
                                  <i class="fas fa-chart-pie mr-1"></i> Incoming and Outgoing Items
                              </h5>

                              <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                      <i class="fas fa-minus"></i>
                                  </button>
                                  <!-- <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div> -->
                                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                                      <i class="fas fa-times"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-8">
                                      <p class="text-center">
                                          <strong>In and Outs for month of <?= date('F') ?></strong>
                                      </p>

                                      <div class="chart tab-pane active" id="revenue-chart">
                                          <canvas id="revenue-chart-canvas" height="300" style="height: 300px"></canvas>
                                      </div>

                                  </div>
                                  <div class="col-md-4">
                                      <p class="text-center">
                                          <strong>Recently Added Items</strong>
                                      </p>

                                      <ul class="products-list product-list-in-card pl-2 pr-2">

                                          <?php foreach ($latestitems as $latestitem) : ?>
                                              <li class="item">
                                                  <div class="product-img mr-2">
                                                      <?php
                                                        $imageclass = 'img-size-25';
                                                        if (!$latestitem->image) {
                                                            echo $this->Html->image('item-default.png', ['class' => $imageclass, 'alt' => $latestitem->item_name]);
                                                        } else {
                                                            echo $this->Html->image('uploads/itemimages/' . $latestitem->id . '/' . $latestitem->image, ['class' => $imageclass, 'alt' => $latestitem->item_name]);
                                                        }
                                                        ?>
                                                  </div>
                                                  <div class="product-info">
                                                      <?php echo $this->Html->link(
                                                            $latestitem->item_name,
                                                            ['Controller' => 'ItemsController', 'action' => 'view', $latestitem->id],
                                                            ['escape' => false, 'class' => "product-title"]
                                                        );
                                                        ?>
                                                      <span class="badge badge-warning float-right"><?= $latestitem->quantity ?></span>
                                                      <span class="product-description">
                                                          <?= $latestitem->item_description ?>
                                                      </span>
                                                  </div>
                                              </li>
                                          <?php endforeach ?>
                                          <!-- /.item -->

                                      </ul>
                                  </div>
                              </div>
                          </div>
                          <div class="card-footer">
                              <p class="text-center">
                                  <strong>Low on stocks cards</strong>
                              </p>
                              <div class="row">
                                  <?php foreach ($lowstocksitems as $item) :

                                        if ($item->quantity <= 500) {
                                            $class = ' text-danger';
                                        } elseif ($item->quantity > 500 && $item->quantity <= 1000) {
                                            $class = ' text-warning';
                                        }
                                    ?>
                                      <div class="col-sm-3 col-6">
                                          <div class="description-block border-right">
                                              <h5 class="description-header <?= $class ?>"><?= $item->quantity ?></h5>
                                              <?php

                                                echo $this->Html->link(
                                                    $item->item_name,
                                                    ['Controller' => 'ItemsController', 'action' => 'view', $item->id],
                                                    ['escape' => false, 'class' => 'description-text ' . $class]
                                                );
                                                ?>
                                          </div>
                                      </div>

                                  <?php endforeach; ?>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>


              <!-- /.row (main row) -->
          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
      /*
       * Author: Abdullah A Almsaeed
       * Date: 4 Jan 2014
       * Description:
       *      This is a demo file used only for the main dashboard (index.html)
       **/

      /* global moment:false, Chart:false, Sparkline:false */

      $(function() {
          'use strict'
          <?php
            $label = [];
            foreach ($incoming as $key => $value) {
                $label[] = $value->month . '/' . $value->day;
                $incomingData[] = $value->totalQuantity;
            }

            foreach ($outgoing as $key => $value) {
                // $label[] = $value->month .'/'. $value->day; 
                $outgoingData[] = $value->totalQuantity;
            }
            ?><?php
                $this->Html->scriptStart(['block' => true]);
                echo "  
var salesChartData = {
  labels:  " . json_encode($label)  . ",
  datasets: [
    {
      label: 'Incoming',
      backgroundColor: 'rgba(60,141,188,0.9)',
      borderColor: 'rgba(60,141,188,0.8)',
      pointRadius: false,
      pointColor: '#3b8bba',
      pointStrokeColor: 'rgba(60,141,188,1)',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data: " . json_encode($incomingData) . "
    },
    {
      label: 'Outgoing',
      backgroundColor: 'rgba(210, 214, 222, 1)',
      borderColor: 'rgba(210, 214, 222, 1)',
      pointRadius: false,
      pointColor: 'rgba(210, 214, 222, 1)',
      pointStrokeColor: '#c1c7d1',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(220,220,220,1)',
      data:  " . json_encode($outgoingData) . "
    }
  ]
}


";


                $this->Html->scriptEnd();

                ?>

          // Make the dashboard widgets sortable Using jquery UI
          $('.connectedSortable').sortable({
              placeholder: 'sort-highlight',
              connectWith: '.connectedSortable',
              handle: '.card-header, .nav-tabs',
              forcePlaceholderSize: true,
              zIndex: 999999
          })
          $('.connectedSortable .card-header').css('cursor', 'move')

          /* Chart.js Charts */
          // Sales chart
          var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
          // $('#revenue-chart').get(0).getContext('2d');


          var salesChartOptions = {
              maintainAspectRatio: false,
              responsive: true,
              legend: {
                  display: false
              },
              scales: {
                  xAxes: [{
                      gridLines: {
                          display: false
                      }
                  }],
                  yAxes: [{
                      gridLines: {
                          display: false
                      }
                  }]
              }
          }

          // This will get the first returned node in the jQuery collection.
          // eslint-disable-next-line no-unused-vars
          var salesChart = new Chart(salesChartCanvas, {
              type: 'line',
              data: salesChartData,
              options: salesChartOptions
          })

      })
  </script>