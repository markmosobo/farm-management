<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Overall Report</h5>

                <div class="card-tools">
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">General</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" @click="loadProduction()" data-toggle="tab">Production</a></li>
		          <li class="nav-item"><a class="nav-link" href="#tab_3" @click="loadExpenses()" data-toggle="tab">Expenses</a></li>
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
                        <strong>Summary</strong>
                        </p>

                        <div class="progress-group">
                        Crop Costs/Revenue
                        <span class="float-right"><b>{{totalcropcosts}}</b>/{{totalcroprevenue}}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                        Animal Costs/Revenue
                        <span class="float-right"><b>{{totalanimalcosts}}</b>/{{totalanimalrevenue}}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        <span class="progress-text">Poultry Costs/Revenue</span>
                        <span class="float-right"><b>{{totalpoultrycosts}}</b>/{{totalpoultryrevenue}}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Resource Costs/Revenue
                        <span class="float-right"><b>{{totalresourcecosts}}</b>/{{totalresourcerevenue}}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                        Miscellaneous Costs
                        <span class="float-right"><b>{{totalmisccosts}}</b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar green" style="width: 50%"></div>
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
                        <span class="description-text"> TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{totalrevenue - totalcosts}}</h5>
                        <span class="description-text"> TOTAL PROFIT</span>                                              
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header"></h5>
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
                        <h5 class="description-header">Ksh.{{totalproduced}}</h5>
                        <span class="description-text"> TOTAL PRODUCED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">unknown</h5>
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
                        <h5 class="description-header">Ksh.{{totalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">unknown</h5>
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
                        <span class="description-text"> TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">unknown</h5>
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
        data() {
            return {
                totalrevenue: [],
                totalsales: [],
                totalcosts: [],
                totalprofit: [],
                totalproduced: [],
                totalcropcosts: [],
                totalcroprevenue: [],
                totalanimalcosts: [],
                totalanimalrevenue: [],
                totalpoultrycosts: [],
                totalpoultryrevenue: [],
                totalresourcecosts: [],
                totalresourcerevenue: [],
                totalmisccosts: []

            }
        },
        methods: {
            loadGeneral(){
                axios.get('api/allsales').then(({data}) => {
                    this.totalrevenue = data
                });
                axios.get('api/allcosts').then(({data}) => {
                    this.totalcosts = data
                });
                axios.get('api/allcropcosts').then(({data}) => {
                    this.totalcropcosts = data
                }); 
                axios.get('api/allcropsales').then(({data}) => {
                    this.totalcroprevenue = data
                }); 
                axios.get('api/allanimalcosts').then(({data}) => {
                    this.totalanimalcosts = data
                });
                axios.get('api/allanimalsales').then(({data}) => {
                    this.totalanimalrevenue = data
                });
                axios.get('api/allpoultrycosts').then(({data}) => {
                    this.totalpoultrycosts = data
                });
                axios.get('api/allpoultrysales').then(({data}) => {
                    this.totalpoultryrevenue = data
                });
                axios.get('api/allresourcecosts').then(({data}) => {
                    this.totalresourcecosts = data
                });
                axios.get('api/allresourcesales').then(({data}) => {
                    this.totalresourcerevenue = data
                }); 
                axios.get('api/allmisccosts').then(({data}) => {
                    this.totalmisccosts = data
                });                                                                                                                                              
            },
            loadProduction(){
                axios.get('api/allproduced').then(({data}) => {
                    this.totalproduced = data
                });
            },
            loadExpenses(){
                axios.get('api/allcosts').then(({data}) => {
                    this.totalcosts = data
                });
            },
            loadSales(){
                axios.get('api/allsales').then(({data}) => {
                    this.totalrevenue = data
                });
            }
        },
        created() {
            this.loadGeneral();
        }
    }
</script>
