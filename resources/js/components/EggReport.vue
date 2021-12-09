<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Quarterly Egg Report</h5>

                <div class="card-tools">
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">General</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" @click="loadProduction()" data-toggle="tab">Production</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" @click="loadSales()" data-toggle="tab">Sales</a></li>
                </ul>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">                  
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{totalrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{numberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL LAID</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">{{numberhatched}} eggs</h5>
                        <span class="description-text"> TOTAL HATCHED</span>                                              
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">{{numbersold}} eggs</h5>
                        <span class="description-text">TOTAL SOLD</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_2"> 
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Grade <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in gradepoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_4" @click="loadgradeProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_6" @click="loadkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Improved Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Other <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in exoticpoultrieslist" :key="item.id">                                
                            <a class="dropdown-item" tabindex="-1" href="#tab_8" @click="loadexoticProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            <ul v-for="item in hybridpoultrieslist" :key="item.id">
                            <a class="dropdown-item" tabindex="-1" href="#tab_9" @click="loadhybridProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">{{numberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL LAID</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{numberhatched}} eggs</h5>
                        <span class="description-text"> TOTAL HATCHED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.unk</h5>
                        <span class="description-text">UNKNOWN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_3">                                         
               
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{totalrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{numbersold}} eggs</h5>
                        <span class="description-text">TOTAL SOLD</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.hanuk</h5>
                        <span class="description-text">UNKNOWN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_4"> 
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Grade <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in gradepoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_4" @click="loadgradeProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Improved Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Other <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in exoticpoultrieslist" :key="item.id">                                
                            <a class="dropdown-item" tabindex="-1" href="#tab_8" @click="loadexoticProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            <ul v-for="item in hybridpoultrieslist" :key="item.id">
                            <a class="dropdown-item" tabindex="-1" href="#tab_9" @click="loadhybridProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">{{gradenumberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL LAID</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{gradenumberhatched}} eggs</h5>
                        <span class="description-text"> TOTAL HATCHED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.unk</h5>
                        <span class="description-text">UNKNOWN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_5"> 
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Grade <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in gradepoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_4" @click="loadgradeProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Improved Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Other <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in exoticpoultrieslist" :key="item.id">                                
                            <a class="dropdown-item" tabindex="-1" href="#tab_8" @click="loadexoticProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            <ul v-for="item in hybridpoultrieslist" :key="item.id">
                            <a class="dropdown-item" tabindex="-1" href="#tab_9" @click="loadhybridProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                      
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">{{kienyejinumberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL LAID</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{kienyejinumberhatched}} eggs</h5>
                        <span class="description-text"> TOTAL HATCHED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.unk</h5>
                        <span class="description-text">UNKNOWN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_6"> 
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Grade <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in gradepoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_4" @click="loadgradeProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Improved Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Other <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in exoticpoultrieslist" :key="item.id">                                
                            <a class="dropdown-item" tabindex="-1" href="#tab_8" @click="loadexoticProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            <ul v-for="item in hybridpoultrieslist" :key="item.id">
                            <a class="dropdown-item" tabindex="-1" href="#tab_9" @click="loadhybridProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                      
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">{{improvedkienyejinumberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL LAID</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{improvedkienyejinumberhatched}} eggs</h5>
                        <span class="description-text"> TOTAL HATCHED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.unk</h5>
                        <span class="description-text">UNKNOWN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_7"> 
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Grade <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in gradepoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_4" @click="loadgradeProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Improved Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Other <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in exoticpoultrieslist" :key="item.id">                                
                            <a class="dropdown-item" tabindex="-1" href="#tab_8" @click="loadexoticProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            <ul v-for="item in hybridpoultrieslist" :key="item.id">
                            <a class="dropdown-item" tabindex="-1" href="#tab_9" @click="loadhybridProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                      
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">{{exoticnumberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL LAID</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{exoticnumberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL HATCHED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.unk</h5>
                        <span class="description-text">UNKNOWN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_8"> 
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Grade <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in gradepoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_4" @click="loadgradeProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Improved Kienyeji <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiProduce(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Other <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in exoticpoultrieslist" :key="item.id">                                
                            <a class="dropdown-item" tabindex="-1" href="#tab_8" @click="loadexoticProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            <ul v-for="item in hybridpoultrieslist" :key="item.id">
                            <a class="dropdown-item" tabindex="-1" href="#tab_9" @click="loadhybridProduce(item.id)" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2019 - 30 Jul, 2019</strong>
                        </p>

                        <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px; display: block; width: 618px;" width="618" class="chartjs-render-monitor"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                        <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                        Add Products to Cart
                        <span class="float-right"><b>160</b>/200</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Complete Purchase
                        <span class="float-right"><b>310</b>/400</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Visit Premium Page</span>
                        <span class="float-right"><b>480</b>/800</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Send Inquiries
                        <span class="float-right"><b>250</b>/500</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">{{hybridnumberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL LAID</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">{{hybridnumberlaid}} eggs</h5>
                        <span class="description-text"> TOTAL HATCHED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.unk</h5>
                        <span class="description-text">UNKNOWN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane -->                                                                                                                                                
                </div>
                <!-- /.tab-content -->                                     
              </div>
              <!-- ./card-body -->

              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                id: '',
                gradepoultrieslist: {},
                gradenumberlaid: [], 
                gradenumberhatched: [],               
                kienyejipoultrieslist: {},
                kienyejinumberlaid: [],  
                kienyejinumberhatched: [],              
                improvedkienyejipoultrieslist: {},
                improvedkienyejinumberlaid: [],
                improvedkienyejinumberhatched: [],                
                exoticpoultrieslist: {},
                exoticnumberlaid: [],
                exoticnumberhatched: [],                
                hybridpoultrieslist: {},
                hybridnumberlaid: [],
                hybridnumberhatched: [],                
                totalrevenue: [],
                numberlaid: [],
                numberhatched: [],
                numbersold: []
            }
        },
        methods: {
            listPoultries(){
                axios.get('api/gradepoultrieslist').then((response) => {
                    this.gradepoultrieslist = response.data.data
                });
                axios.get('api/kienyejipoultrieslist').then((response) => {
                    this.kienyejipoultrieslist = response.data.data
                });
                axios.get('api/ikienyejipoultrieslist').then((response) => {
                    this.improvedkienyejipoultrieslist = response.data.data
                });
                axios.get('api/exoticpoultrieslist').then((response) => {
                    this.exoticpoultrieslist = response.data.data
                });
                axios.get('api/hybridpoultrieslist').then((response) => {
                    this.hybridpoultrieslist = response.data.data
                });                
            },
            loadGeneral(){
                axios.get('api/numberlaid').then(({data}) => {
                    this.numberlaid = data
                });
                axios.get('api/numberhatched').then(({data}) => {
                    this.numberhatched = data
                });
                axios.get('api/eggsales').then(({data}) => {
                    this.totalrevenue = data
                });
                axios.get('api/numbersold').then(({data}) => {
                    this.numbersold = data
                });                
            },
            loadProduction(){
                axios.get('api/numberlaid').then(({data}) => {
                    this.numberlaid = data
                });
                axios.get('api/numberhatched').then(({data}) => {
                    this.numberhatched = data
                });                
            },
            loadSales(){
                axios.get('api/eggsales').then(({data}) => {
                    this.totalrevenue = data
                });
                axios.get('api/numbersold').then(({data}) => {
                    this.numbersold = data
                });
            },
            loadgradeProduce(id){
                axios.get('api/gradenumberlaid/'+ id).then(({data}) => {
                    this.gradenumberlaid = data
                });
                axios.get('api/gradenumberhatched/'+ id).then(({data}) => {
                    this.gradenumberhatched = data
                });                
            },
            loadkienyejiProduce(id){
                axios.get('api/kienyejinumberlaid/'+ id).then(({data}) => {
                    this.kienyejinumberlaid = data
                });
                axios.get('api/kienyejinumberhatched/'+ id).then(({data}) => {
                    this.kienyejinumberhatched = data
                });
            },
            loadimprovedkienyejiProduce(id){
                axios.get('api/ikienyejinumberlaid/'+ id).then(({data}) => {
                    this.improvedkienyejinumberlaid = data
                });
                axios.get('api/ikienyejinumberhatched/'+ id).then(({data}) => {
                    this.improvedkienyejinumberhatched = data
                });
            },
            loadexoticProduce(id){
                axios.get('api/exoticnumberlaid/'+ id).then(({data}) => {
                    this.exoticnumberlaid = data
                });
                axios.get('api/exoticnumberhatched/'+ id).then(({data}) => {
                    this.exoticnumberhatched = data
                });
            },
            loadhybridProduce(id){
                axios.get('api/hybridnumberlaid/'+ id).then(({data}) => {
                    this.hybridnumberlaid = data
                });
                axios.get('api/hybridnumberhatched/'+ id).then(({data}) => {
                    this.hybridnumberhatched = data
                });
            }
        },
        mounted() {
            this.listPoultries();
            this.loadGeneral();
            console.log('Component mounted.')
        }
    }
</script>
