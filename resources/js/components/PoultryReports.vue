<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Quarterly Poultry Report</h5>

                <div class="card-tools">
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">General</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" @click="loadFeeding()" data-toggle="tab">Feeding</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" @click="loadTreating()" data-toggle="tab">Treatment</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_4" @click="loadSales()" data-toggle="tab">Sales</a></li>
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
                        <strong>Sales: 1 Jan, 2018 - 30 Jul, 2018</strong>
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
                        <strong>Poultry Summary</strong>
                        </p>

                        <div class="progress-group">
                        Poultry Fed
                        <span class="float-right"><b>{{poultryfed}}</b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Poultry Vaccinated
                        <span class="float-right"><b>{{poultryvaccinated}}</b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Poultry Treated</span>
                        <span class="float-right"><b>{{poultrytreated}}</b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Prevalent Vaccine
                        <span class="float-right"><b>{{prevalentvaccine}}</b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Prevalent Drug
                        <span class="float-right"><b>{{prevalentdrug}}</b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-secondary" style="width: 50%"></div>
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
                        <h5 class="description-header">Ksh.{{totalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{totalrevenue - totalcosts}}</h5>
                        <span class="description-text">TOTAL PROFIT</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">9</h5>
                        <span class="description-text">FIG ON FARM</span>
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
                                            <a class="dropdown-item" href="#tab_5" @click="loadgradeDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_6" @click="loadkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_8" @click="loadexoticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_9" @click="loadhybridDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Sales: 1 Jan, 2018 - 30 Jul, 2018</strong>
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
                                    <strong>Poultry Feeding Summary</strong>
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
                                        <h5 class="description-header">Ksh.{{totalfeedingcosts}}</h5>
                                        <span class="description-text">TOTAL COST</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                                        <h5 class="description-header">Ksh.{{totalfeedcosts}}</h5>
                                        <span class="description-text">TOTAL FEED COST</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                                        <h5 class="description-header">Ksh.{{totalfeedingmisccosts}}</h5>
                                        <span class="description-text">TOTAL MISC. COST</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                                        <h5 class="description-header">9</h5>
                                        <span class="description-text">FIG ON FARM</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="tab_3">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_10" @click="loadgradeDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_11" @click="loadkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_12" @click="loadimprovedkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_13" @click="loadexoticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_14" @click="loadhybridDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Sales: 1 Jan, 2018 - 30 Jul, 2018</strong>
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
                                    <strong>Poultry Treatment Summary</strong>
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
                                        <h5 class="description-header">Ksh.{{totaltreatingcosts}}</h5>
                                        <span class="description-text">TOTAL COST</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                                        <h5 class="description-header">Ksh.{{totalvaccinecosts}}</h5>
                                        <span class="description-text">TOTAL VACCINE COST</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                                        <h5 class="description-header">Ksh.{{totaldrugcosts}}</h5>
                                        <span class="description-text">TOTAL DRUG COST</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                                        <h5 class="description-header">{{ totaltreatingmisccosts }}</h5>
                                        <span class="description-text">TOTAL MISC. COST</span>
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
                                            <a class="dropdown-item" href="#tab_15" @click="loadgradeSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_16" @click="loadkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_17" @click="loadimprovedkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_18" @click="loadexoticSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_19" @click="loadhybridSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Sales: 1 Jan, 2018 - 30 Jul, 2018</strong>
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
                                    <strong>Poultry Sales Summary</strong>
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
                                        <h5 class="description-header">Ksh.{{totalpoultryrevenue}}</h5>
                                        <span class="description-text">TOTAL POULTRY REVENUE</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                                        <h5 class="description-header">Ksh.noma</h5>
                                        <span class="description-text">empty REVENUE</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                                        <h5 class="description-header">9</h5>
                                        <span class="description-text">FIG ON FARM</span>
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
                                            <a class="dropdown-item" href="#tab_5" @click="loadgradeDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_6" @click="loadkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_8" @click="loadexoticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_9" @click="loadhybridDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
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
                        <strong>Feeding Summary</strong>
                        </p>

                        <div class="progress-group">
                        Acreage Planted
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Acreage Weeded
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Acreage Harvested</span>
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        To Be Fiiled
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
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{gradetotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{gradefeedingcosts}}</h5>
                        <span class="description-text">FEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text"> COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.0</h5>
                        <span class="description-text">ABSENT COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
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
                                          <a class="dropdown-item" href="#tab_5" @click="loadgradeDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Kienyeji<span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_6" @click="loadkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Improved Kienyeji <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Other <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_8" @click="loadexoticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                      <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_9" @click="loadhybridDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                          </ul>
                      </div>
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2021 - 30 Jul, 2021</strong>
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
                        <strong>Feeding Summary</strong>
                        </p>

                        <div class="progress-group">
                        Acreage Planted
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Acreage Weeded
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Acreage Harvested</span>
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        To Be Fiiled
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
                        <h5 class="description-header">Ksh.{{kienyejitotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{kienyejifeedingcosts}}</h5>
                        <span class="description-text">FEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text"> COST</span>
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
                                          <a class="dropdown-item" href="#tab_5" @click="loadgradeDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Kienyeji<span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_6" @click="loadkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Improved Kienyeji <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Other <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_8" @click="loadexoticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                      <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_9" @click="loadhybridDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Feeding Summary</strong>
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
                        <h5 class="description-header">Ksh.{{improvedkienyejitotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{improvedkienyejifeedingcosts}}</h5>
                        <span class="description-text">FEEDING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text">COST</span>
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
                                          <a class="dropdown-item" href="#tab_5" @click="loadgradeDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Kienyeji<span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_6" @click="loadkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Improved Kienyeji <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Other <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_8" @click="loadexoticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                      <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_9" @click="loadhybridDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Feeding Summary</strong>
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
                        <h5 class="description-header">Ksh.{{exotictotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{exoticfeedingcosts}}</h5>
                        <span class="description-text">FEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text">COST</span>
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

                  <div class="tab-pane" id="tab_9">
                      <div class="card-tools">
                          <ul class="nav nav-pills ml-auto p-2">
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Grade <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in gradepoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_5" @click="loadgradeDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Kienyeji<span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_6" @click="loadkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Improved Kienyeji <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_7" @click="loadimprovedkienyejiDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                  </div>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                      Other <span class="caret"></span>
                                  </a>
                                  <div class="dropdown-menu">
                                      <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_8" @click="loadexoticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                      </ul>
                                      <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                          <a class="dropdown-item" href="#tab_9" @click="loadhybridDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Feeding Summary</strong>
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
                        <h5 class="description-header">Ksh.{{hybridtotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{hybridfeedingcosts}}</h5>
                        <span class="description-text">FEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text">COST</span>
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

                    <div class="tab-pane" id="tab_10">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_10" @click="loadgradeTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_11" @click="loadkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_12" @click="loadimprovedkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_13" @click="loadexoticTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_14" @click="loadhybridTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
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
                        <strong>Treatment Summary</strong>
                        </p>

                        <div class="progress-group">
                        Acreage Planted
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Acreage Weeded
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Acreage Harvested</span>
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        To Be Fiiled
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
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{gradetreatingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{gradevaccinecosts}}</h5>
                        <span class="description-text">VACCINE COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{gradedrugcosts}}</h5>
                        <span class="description-text">DRUG COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.0</h5>
                        <span class="description-text">ABSENT COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                  </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="tab_11">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_10" @click="loadgradeTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_11" @click="loadkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_12" @click="loadimprovedkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_13" @click="loadexoticTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_14" @click="loadhybridTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2021 - 30 Jul, 2021</strong>
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
                        <strong>Treatment Summary</strong>
                        </p>

                        <div class="progress-group">
                        Acreage Planted
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Acreage Weeded
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Acreage Harvested</span>
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        To Be Fiiled
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
                        <h5 class="description-header">Ksh.{{kienyejitreatingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{kienyejivaccinecosts}}</h5>
                        <span class="description-text">VACCINE COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{kienyejidrugcosts}}</h5>
                        <span class="description-text">DRUG COST</span>
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

                  <div class="tab-pane" id="tab_12">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_10" @click="loadgradeTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_11" @click="loadkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_12" @click="loadimprovedkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_13" @click="loadexoticTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_14" @click="loadhybridTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Treatment Summary</strong>
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
                        <h5 class="description-header">Ksh.{{improvedkienyejitreatingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{improvedkienyejivaccinecosts}}</h5>
                        <span class="description-text">VACCINE COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{improvedkienyejidrugcosts}}</h5>
                        <span class="description-text">DRUG COST</span>
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

                  <div class="tab-pane" id="tab_13">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_10" @click="loadgradeTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_11" @click="loadkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_12" @click="loadimprovedkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_13" @click="loadexoticTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_14" @click="loadhybridTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Treatment Summary</strong>
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
                        <h5 class="description-header">Ksh.{{exotictreatingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{exoticvaccinecosts}}</h5>
                        <span class="description-text">VACCINE COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{exoticdrugcosts}}</h5>
                        <span class="description-text">DRUG COST</span>
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

                  <div class="tab-pane" id="tab_14">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_10" @click="loadgradeTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_11" @click="loadkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_12" @click="loadimprovedkienyejiTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_13" @click="loadexoticTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_14" @click="loadhybridTreating(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Treatment Summary</strong>
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
                        <h5 class="description-header">Ksh.{{hybridtreatingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{hybridvaccinecosts}}</h5>
                        <span class="description-text">VACCINE COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{hybriddrugcosts}}</h5>
                        <span class="description-text">DRUG COST</span>
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

                    <div class="tab-pane" id="tab_15">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_15" @click="loadgradeSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_16" @click="loadkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_17" @click="loadimprovedkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_18" @click="loadexoticSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_19" @click="loadhybridSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
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
                        <strong>Sales Summary</strong>
                        </p>

                        <div class="progress-group">
                        Acreage Planted
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Acreage Weeded
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Acreage Harvested</span>
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        To Be Fiiled
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
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{gradepoultryrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{gradepoultryrevenue}}</h5>
                        <span class="description-text">POULTRY REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text">COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.0</h5>
                        <span class="description-text">ABSENT COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                  </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="tab_16">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_15" @click="loadgradeSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_16" @click="loadkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_17" @click="loadimprovedkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_18" @click="loadexoticSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_19" @click="loadhybridSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                        <strong>Sales: 1 Jan, 2021 - 30 Jul, 2021</strong>
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
                        <strong>Sales Summary</strong>
                        </p>

                        <div class="progress-group">
                        Acreage Planted
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Acreage Weeded
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Acreage Harvested</span>
                        <span class="float-right"><b>0</b>/8</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        To Be Fiiled
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
                        <h5 class="description-header">Ksh.{{kienyejipoultryrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{kienyejipoultryrevenue}}</h5>
                        <span class="description-text">POULTRY REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text">COST</span>
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

                  <div class="tab-pane" id="tab_17">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_15" @click="loadgradeSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_16" @click="loadkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_17" @click="loadimprovedkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_18" @click="loadexoticSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_19" @click="loadhybridSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Sales Summary</strong>
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
                        <h5 class="description-header">Ksh.{{improvedkienyejipoultryrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{improvedkienyejipoultryrevenue}}</h5>
                        <span class="description-text">POULTRY REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text">COST</span>
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

                  <div class="tab-pane" id="tab_18">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_15" @click="loadgradeSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_16" @click="loadkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_17" @click="loadimprovedkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_18" @click="loadexoticSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_19" @click="loadhybridSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Sales Summary</strong>
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
                        <h5 class="description-header">Ksh.{{exoticpoultryrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{exoticpoultryrevenue}}</h5>
                        <span class="description-text">POULTRY REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text"> COST</span>
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

                  <div class="tab-pane" id="tab_19">
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Grade <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in gradepoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_15" @click="loadgradeSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Kienyeji<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in kienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_16" @click="loadkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Improved Kienyeji <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in improvedkienyejipoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_17" @click="loadimprovedkienyejiSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                        Other <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <ul v-for="item in exoticpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_18" @click="loadexoticSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                                        </ul>
                                        <ul v-for="item in hybridpoultrieslist" :key="item.id">
                                            <a class="dropdown-item" href="#tab_19" @click="loadhybridSales(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
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
                        <strong>Sales Summary</strong>
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
                        <h5 class="description-header">Ksh.{{hybridpoultryrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{hybridpoultryrevenue}}</h5>
                        <span class="description-text">POULTRY REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.noma</h5>
                        <span class="description-text">COST</span>
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
        data() {
            return {
                id: '',
                name: '',
                totalfeedingcosts: [],
                totalfeedcosts: [],
                totalfeedingmisccosts: [],
                totaltreatingcosts: [],
                totalvaccinecosts: [],
                totaldrugcosts: [],
                totaltreatingmisccosts: [],
                totalpoultryrevenue: [],
                totalcosts: [],
                totalmisccosts: [],
                totalrevenue: [],
                poultryfed: [],
                poultryvaccinated: [],
                poultrytreated: [],
                prevalentvaccine: {},
                prevalentdrug: [],

                gradepoultrieslist: {},
                gradefeedingcosts: [],
                gradefeedingmisccosts: [],
                gradetreatingcosts: [],
                gradevaccinecosts: [],
                gradedrugcosts: [],
                gradetotalcosts: [],
                gradepoultryrevenue: [],
                kienyejipoultrieslist: {},
                kienyejifeedingcosts: [],
                kienyejitreatingcosts: [],
                kienyejivaccinecosts: [],
                kienyejidrugcosts: [],
                kienyejitotalcosts: [],
                kienyejipoultryrevenue: [],                
                improvedkienyejipoultrieslist: {},
                improvedkienyejifeedingcosts: [],
                improvedkienyejitreatingcosts: [],
                improvedkienyejivaccinecosts: [],
                improvedkienyejidrugcosts: [],                
                improvedkienyejitotalcosts: [],
                improvedkienyejipoultryrevenue: [],                
                exoticpoultrieslist: {},
                exoticfeedingcosts: [],
                exotictreatingcosts: [],
                exoticvaccinecosts: [],
                exoticdrugcosts: [],                
                exotictotalcosts: [],
                exoticpoultryrevenue: [],                
                hybridpoultrieslist: {},
                hybridfeedingcosts: [],
                hybridtreatingcosts: [],
                hybridvaccinecosts: [],
                hybriddrugcosts: [],                
                hybridtotalcosts: [],
                hybridpoultryrevenue: [],                

            }
        },
        methods: {
            listgradePoultries(){
                axios.get('api/gradepoultrieslist').then((response) => {
                    this.gradepoultrieslist = response.data.data
                });
            },
            listkienyejiPoultries(){
                axios.get('api/kienyejipoultrieslist').then((response) => {
                    this.kienyejipoultrieslist = response.data.data
                });
            },
            listimprovedkienyejiPoultries(){
                axios.get('api/ikienyejipoultrieslist').then((response) => {
                    this.improvedkienyejipoultrieslist = response.data.data
                });
            },
            listexoticPoultries(){
                axios.get('api/exoticpoultrieslist').then((response) => {
                    this.exoticpoultrieslist = response.data.data
                });
            },
            listhybridPoultries(){
                axios.get('api/hybridpoultrieslist').then((response) => {
                    this.hybridpoultrieslist = response.data.data
                });
            },
            loadFeeding(){
                axios.get('api/feedingcosts').then(({data}) => {
                    this.totalfeedingcosts = data
                });
                axios.get('api/feedcosts').then(({data}) => {
                    this.totalfeedcosts = data
                });
                axios.get('api/feedingmisccosts').then(({data}) => {
                    this.totalfeedingmisccosts = data
                });
            },
            loadTreating(){
                axios.get('api/treatingcosts').then(({data}) => {
                    this.totaltreatingcosts = data
                });
                axios.get('api/vaccinecosts').then(({data}) => {
                    this.totalvaccinecosts = data
                });
                axios.get('api/drugcosts').then(({data}) => {
                    this.totaldrugcosts = data
                });
                axios.get('api/treatingmisccosts').then(({data}) => {
                    this.totaltreatingmisccosts = data
                });
            },
            loadSales(){
                axios.get('api/poultrysales').then(({data}) => {
                    this.totalpoultryrevenue = data
                });
            },
            loadgradeDetails(id){
                axios.get('api/gradefeedingcosts/'+ id).then(({data}) => {
                    this.gradefeedingcosts = data
                });
                axios.get('api/gradetreatingcosts/'+ id).then(({data}) => {
                    this.gradetreatingcosts = data
                });
                axios.get('api/gradetotalcosts/'+ id).then(({data}) => {
                    this.gradetotalcosts = data
                });
            },
            loadkienyejiDetails(id){
                axios.get('api/kienyejifeedingcosts/'+ id).then(({data}) => {
                    this.kienyejifeedingcosts = data
                });
                axios.get('api/kienyejitreatingcosts/'+ id).then(({data}) => {
                    this.kienyejitreatingcosts = data
                });
                axios.get('api/kienyejitotalcosts/'+ id).then(({data}) => {
                    this.kienyejitotalcosts = data
                });
            },
            loadimprovedkienyejiDetails(id){
                axios.get('api/ikienyejifeedingcosts/'+ id).then(({data}) => {
                    this.improvedkienyejifeedingcosts = data
                });
                axios.get('api/ikienyejitreatingcosts/'+ id).then(({data}) => {
                    this.improvedkienyejitreatingcosts = data
                });
                axios.get('api/ikienyejitotalcosts/'+ id).then(({data}) => {
                    this.improvedkienyejitotalcosts = data
                });
            },
            loadexoticDetails(id){
                axios.get('api/exoticfeedingcosts/'+ id).then(({data}) => {
                    this.exoticfeedingcosts = data
                });
                axios.get('api/exotictreatingcosts/'+ id).then(({data}) => {
                    this.exotictreatingcosts = data
                });
                axios.get('api/exotictotalcosts/'+ id).then(({data}) => {
                    this.exotictotalcosts = data
                });
            },
            loadhybridDetails(id){
                axios.get('api/hybridfeedingcosts/'+ id).then(({data}) => {
                    this.hybridfeedingcosts = data
                });
                axios.get('api/hybridtreatingcosts/'+ id).then(({data}) => {
                    this.hybridtreatingcosts = data
                });
                axios.get('api/hybridtotalcosts/'+ id).then(({data}) => {
                    this.hybridtotalcosts = data
                });
            },
            loadgeneralDetails(){
                axios.get('api/poultrycosts').then(({data}) => {
                    this.totalcosts = data
                });
                axios.get('api/poultrysales').then(({data}) => {
                    this.totalrevenue = data
                });
                axios.get('api/poultryfed').then(({data}) => {
                    this.poultryfed = data
                });
                axios.get('api/poultryvaccinated').then(({data}) => {
                    this.poultryvaccinated = data
                });  
                axios.get('api/poultrytreated').then(({data}) => {
                    this.poultrytreated = data
                }); 
                axios.get('api/prevalentvaccine').then(({data}) => {
                    this.prevalentvaccine = data
                });
                axios.get('api/prevalentdrug').then(({data}) => {
                    this.prevalentdrug = data
                });                                                                             
            },
            loadgradeTreating(id){
                axios.get('api/gradevaccinecosts/'+ id).then(({data}) => {
                    this.gradevaccinecosts = data
                });
                axios.get('api/gradedrugcosts/'+ id).then(({data}) => {
                    this.gradedrugcosts = data
                });
                axios.get('api/gradetreatingcosts/'+ id).then(({data}) => {
                    this.gradetreatingcosts = data
                });
            },
            loadkienyejiTreating(id){
                axios.get('api/kienyejivaccinecosts/'+ id).then(({data}) => {
                    this.kienyejivaccinecosts = data
                });
                axios.get('api/kienyejidrugcosts/'+ id).then(({data}) => {
                    this.kienyejidrugcosts = data
                });
                axios.get('api/kienyejitreatingcosts/'+ id).then(({data}) => {
                    this.kienyejitreatingcosts = data
                });
            },
            loadimprovedkienyejiTreating(id){
                axios.get('api/ikienyejivaccinecosts/'+ id).then(({data}) => {
                    this.improvedkienyejivaccinecosts = data
                });
                axios.get('api/ikienyejidrugcosts/'+ id).then(({data}) => {
                    this.improvedkienyejidrugcosts = data
                });
                axios.get('api/ikienyejitreatingcosts/'+ id).then(({data}) => {
                    this.improvedkienyejitreatingcosts = data
                });
            },
            loadexoticTreating(id){
                axios.get('api/exoticvaccinecosts/'+ id).then(({data}) => {
                    this.exoticvaccinecosts = data
                });
                axios.get('api/exoticdrugcosts/'+ id).then(({data}) => {
                    this.exoticdrugcosts = data
                });
                axios.get('api/exotictreatingcosts/'+ id).then(({data}) => {
                    this.exotictreatingcosts = data
                });
            },
            loadhybridTreating(id){
                axios.get('api/hybridvaccinecosts/'+ id).then(({data}) => {
                    this.hybridvaccinecosts = data
                });
                axios.get('api/hybriddrugcosts/'+ id).then(({data}) => {
                    this.hybriddrugcosts = data
                });
                axios.get('api/hybridtreatingcosts/'+ id).then(({data}) => {
                    this.hybridtreatingcosts = data
                });
            },            
            loadgradeSales(id){
                axios.get('api/gradepoultrysales/'+ id).then(({data}) => {
                    this.gradepoultryrevenue = data
                });
            },
            loadkienyejiSales(id){
                axios.get('api/kienyejipoultrysales/'+ id).then(({data}) => {
                    this.kienyejipoultryrevenue = data
                });
            },
            loadimprovedkienyejiSales(id){
                axios.get('api/ikienyejipoultrysales/'+ id).then(({data}) => {
                    this.improvedkienyejipoultryrevenue = data
                });
            },
            loadexoticSales(id){
                axios.get('api/exoticpoultrysales/'+ id).then(({data}) => {
                    this.exoticpoultryrevenue = data
                });
            },
            loadhybridSales(id){
                axios.get('api/hybridpoultrysales/'+ id).then(({data}) => {
                    this.hybridpoultryrevenue = data
                });
            },
        },
        mounted() {
            this.listgradePoultries();
            this.listkienyejiPoultries();
            this.listimprovedkienyejiPoultries();
            this.listexoticPoultries();
            this.listhybridPoultries();
            this.loadgeneralDetails();
        }
    }
</script>
