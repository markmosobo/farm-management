<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Quarterly Crop Report</h5>

                <div class="card-tools">
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">General</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" @click="loadPlanting()" data-toggle="tab">Planting</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" @click="loadWeeding()" data-toggle="tab">Weeding</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_4" @click="loadHarvesting()" data-toggle="tab">Harvest</a></li>
                </ul>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">  
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadsubDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_6" @click="loadcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadsubcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       

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
                        <h5 class="description-header">Ksh.{{plantingcosts}}</h5>
                        <span class="description-text">TOTAL PLANTING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{weedingcosts}}</h5>
                        <span class="description-text">TOTAL WEEDING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{harvestingcosts}}</h5>
                        <span class="description-text">TOTAL HARVEST COST</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_8" @click="loadsubDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_9" @click="loadcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_10" @click="loadsubcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{plantingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>                   
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{fertilizercosts}}</h5>
                        <span class="description-text">TOTAL FERTILIZER COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{seedcosts}}</h5>
                        <span class="description-text">TOTAL SEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{plantinglabourcosts}}</h5>
                        <span class="description-text">TOTAL LABOUR COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_11" @click="loadsubWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_12" @click="loadcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_13" @click="loadsubcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{weedingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{chemicalcosts}}</h5>
                        <span class="description-text">TOTAL CHEMICAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{toolcosts}}</h5>
                        <span class="description-text">TOTAL TOOL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">{{weedinglabourcosts}}</h5>
                        <span class="description-text">TOTAL LABOUR COST</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_14" @click="loadsubHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_15" @click="loadcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_16" @click="loadsubcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div> 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{harvestingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{transportcosts}}</h5>
                        <span class="description-text">TOTAL TRANSPORT COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{harvestinglabourcosts}}</h5>
                        <span class="description-text">TOTAL LABOUR COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">{{harvestingmisccosts}}</h5>
                        <span class="description-text">TOTAL MISC. COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <!-- general info per crop type   -->
                  <div class="tab-pane" id="tab_5">                                         
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadsubDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_6" @click="loadcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadsubcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{subtotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>                   
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subplantingcosts}}</h5>
                        <span class="description-text">PLANTING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subweedingcosts}}</h5>
                        <span class="description-text">WEEDING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subharvestingcosts}}</h5>
                        <span class="description-text">HARVEST COST</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadsubDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_6" @click="loadcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadsubcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                      

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{cashrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{cashtotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{cashrevenue - cashtotalcosts}}</h5>
                        <span class="description-text">TOTAL PROFIT</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_5" @click="loadsubDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_6" @click="loadcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_7" @click="loadsubcashDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div> 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subcashrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subcashtotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subcashrevenue - subcashtotalcosts}}</h5>
                        <span class="description-text">TOTAL PROFIT</span>
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
                            <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_8" @click="loadsubPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_9" @click="loadcashPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_10" @click="loadsubcashPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{subplantingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>                   
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subfertilizercosts}}</h5>
                        <span class="description-text">FERTILIZER COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subseedcosts}}</h5>
                        <span class="description-text">SEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subplantinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane -->  

                  <div class="tab-pane" id="tab_9"> 
                    <div class="card-tools">
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_8" @click="loadsubPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_9" @click="loadcashPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_10" @click="loadsubcashPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                      

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{cashplantingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{cashfertilizercosts}}</h5>
                        <span class="description-text">FERTILIZER COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{cashseedcosts}}</h5>
                        <span class="description-text">SEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">Ksh.{{cashplantinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
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
                            <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_8" @click="loadsubPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_9" @click="loadcashPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_10" @click="loadsubcashPlanting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>  

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subcashplantingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subcashfertilizercosts}}</h5>
                        <span class="description-text">FERTILIZER COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subcashseedcosts}}</h5>
                        <span class="description-text">SEED COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">{{subcashplantinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_11" @click="loadsubWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_12" @click="loadcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_13" @click="loadsubcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subweedingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subchemicalcosts}}</h5>
                        <span class="description-text">CHEMICAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subtoolcosts}}</h5>
                        <span class="description-text">TOOL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">{{subweedinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_11" @click="loadsubWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_12" @click="loadcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_13" @click="loadsubcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{cashweedingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{cashchemicalcosts}}</h5>
                        <span class="description-text">CHEMICAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{cashtoolcosts}}</h5>
                        <span class="description-text">TOOL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">{{cashweedinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_11" @click="loadsubWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_12" @click="loadcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_13" @click="loadsubcashWeeding(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div>                                       

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subcashweedingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subcashchemicalcosts}}</h5>
                        <span class="description-text">CHEMICAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subcashtoolcosts}}</h5>
                        <span class="description-text">TOOL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">{{subcashweedinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_14" @click="loadsubHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_15" @click="loadcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_16" @click="loadsubcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div> 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subharvestingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subtransportcosts}}</h5>
                        <span class="description-text">TRANSPORT COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subharvestinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">0</h5>
                        <span class="description-text">MISC. COST</span>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_14" @click="loadsubHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_15" @click="loadcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_16" @click="loadsubcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div> 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{cashharvestingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{cashtransportcosts}}</h5>
                        <span class="description-text">TRANSPORT COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{cashharvestinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">0</h5>
                        <span class="description-text">MISC. COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
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
                            Subsistence <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_14" @click="loadsubHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Cash Crop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in cashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_15" @click="loadcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            Subsistence/CashCrop <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                            <ul v-for="item in subcashcropslist" :key="item.id">
                            <a class="dropdown-item" href="#tab_16" @click="loadsubcashHarvesting(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                            </ul>
                            </div>
                        </li>
                    </ul>
                    </div> 

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{subcashharvestingcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{subcashtransportcosts}}</h5>
                        <span class="description-text">TRANSPORT COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{subcashharvestinglabourcosts}}</h5>
                        <span class="description-text">LABOUR COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">0</h5>
                        <span class="description-text">MISC. COST</span>
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
                subcropslist: {},
                cashcropslist: {},
                subcashcropslist: {},
                subplantingcosts: {},
                subweedingcosts: {},
                subharvestingcosts: {}, 
                subacreageplanted: {},
                subacreageweeded: {},
                subacreageharvested: {},
                subharvestingcosts: {},
                subharvestinglabourused: {},
                subprevalenttransportmeans: {},
                subtransportcosts: {},
                subharvestinglabourcosts: {},               
                subtotalcosts: {},
                subweedinglabourcosts: {},
                subweedinglabourused: {},
                subprevalentchemical: {},
                subweedingmisccosts: {},
                subchemicalcosts: {},
                subtoolcosts: {},
                cashplantingcosts: {},
                cashweedingcosts: {},
                cashharvestingcosts: {}, 
                cashacreageplanted: {},
                cashacreageweeded: {},
                cashacreageharvested: {},
                cashharvestingcosts: {},
                cashharvestinglabourused: {},
                cashprevalenttransportmeans: {},
                cashtransportcosts: {},
                cashharvestinglabourcosts: {},                 
                cashrevenue: {},                
                cashtotalcosts: {},
                cashweedinglabourcosts: {},
                cashweedinglabourused: {},
                cashprevalentchemical: {},
                cashweedingmisccosts: {},
                cashchemicalcosts: {},
                cashtoolcosts: {},                
                subcashacreageplanted: {},
                subcashacreageweeded: {},
                subcashharvestingcosts: {},
                subcashacreageharvested: {},
                subcashharvestinglabourused: {},
                subcashprevalenttransportmeans: {},
                subcashtransportcosts: {},
                subcashharvestinglabourcosts: {},                 
                subcashtotalcosts: {},
                subcashweedingcosts: {},
                subcashweedinglabourcosts: {},
                subcashweedinglabourused: {},
                subcashprevalentchemical: {},
                subcashweedingmisccosts: {},
                subcashchemicalcosts: {},
                subcashtoolcosts: {},                
                subcashrevenue: {},
                totalcosts: {}, 
                plantingcosts: [],
                acreageplanted: [],
                plantinglabourused: [],
                prevalentfertilizer: [],
                weedingcosts: [],
                acreageweeded: [],
                weedinglabourused: [],
                prevalentchemical: [],
                fertilizercosts: [],
                seedcosts: [],
                plantinglabourcosts: [],
                plantingmisccosts: [],
                chemicalcosts: [],
                toolcosts: [],
                weedinglabourcosts: [],
                weedingmisccosts: [],
                transportcosts: [],
                harvestingcosts: [],
                harvestinglabourused: [],
                harvestingmisccosts: [],
                acreageharvested: [],
                prevalenttransportmeans: [],
                transportcosts: [],
                harvestinglabourcosts: [],
                subplantingcosts: [],
                subfertilizercosts: [],
                subseedcosts: [],
                subplantinglabourcosts: [],
                subplantinglabourused: [],
                subprevalentfertilizer: [],
                cashplantingcosts: [],
                cashfertilizercosts: [],
                cashseedcosts: [],
                cashplantinglabourcosts: [],
                cashplantinglabourused: [],
                cashprevalentfertilizer: [],
                subcashplantingcosts: [],
                subcashfertilizercosts: [],
                subcashseedcosts: [],
                subcashplantinglabourcosts: [],
                subcashplantinglabourused: [],
                subcashprevalentfertilizer: []                                               
            }
        },
        methods: {
            listsubCrops(){
                axios.get('api/subcroplist').then((response) => {
                    this.subcropslist = response.data.data
                });
            },
            listcashCrops(){
                axios.get('api/cashcroplist').then((response) => {
                    this.cashcropslist = response.data.data
                });
            },
            listsubcashCrops(){
                axios.get('api/subcashcroplist').then((response) => {
                    this.subcashcropslist = response.data.data
                });
            },
            loadPlanting(){
                axios.get('api/fertilizercosts').then(({data}) => {
                    this.fertilizercosts = data
                });
                axios.get('api/seedcosts').then(({data}) => {
                    this.seedcosts = data
                });
                axios.get('api/plantinglabourcosts').then(({data}) => {
                    this.plantinglabourcosts = data
                }); 
                axios.get('api/plantingmisccosts').then(({data}) => {
                    this.plantingmisccosts = data
                });
                axios.get('api/acreageplanted').then(({data}) => {
                    this.acreageplanted = data
                });
                axios.get('api/plantinglabourused').then(({data}) => {
                    this.plantinglabourused = data
                });
                axios.get('api/prevalentfertilizer').then(({data}) => {
                    this.prevalentfertilizer = data
                });                                                                                               
            },
            loadWeeding(){
                axios.get('api/chemicalcosts').then(({data}) => {
                    this.chemicalcosts = data
                });
                axios.get('api/toolcosts').then(({data}) => {
                    this.toolcosts = data
                });
                axios.get('api/weedinglabourcosts').then(({data}) => {
                    this.weedinglabourcosts = data
                }); 
                axios.get('api/weedingmisccosts').then(({data}) => {
                    this.weedingmisccosts = data
                });
                axios.get('api/acreageweeded').then(({data}) => {
                    this.acreageweeded = data
                });
                axios.get('api/weedinglabourused').then(({data}) => {
                    this.weedinglabourused = data
                });
                axios.get('api/prevalentchemical').then(({data}) => {
                    this.prevalentchemical = data
                });
            },
            loadHarvesting(){
                axios.get('api/acreageharvested').then(({data}) => {
                    this.acreageharvested = data
                });                
                axios.get('api/harvestingcosts').then(({data}) => {
                    this.harvestingcosts = data
                });
                axios.get('api/transportcosts').then(({data}) => {
                    this.transportcosts = data
                });
                axios.get('api/harvestinglabourcosts').then(({data}) => {
                    this.harvestinglabourcosts = data
                }); 
                axios.get('api/harvestinglabourused').then(({data}) => {
                    this.harvestinglabourused = data
                });                 
                axios.get('api/harvestingmisccosts').then(({data}) => {
                    this.harvestingmisccosts = data
                });
            },
            loadsubDetails(id){
                axios.get('api/subcosts/'+ id).then(({data}) => {
                    this.subtotalcosts = data
                });
                axios.get('api/subplantingcosts/'+ id).then(({data}) => {
                    this.subplantingcosts = data
                });

                axios.get('api/subweedingcosts/'+ id).then(({data}) => {
                    this.subweedingcosts = data
                });

                axios.get('api/subharvestcosts/'+ id).then(({data}) => {
                    this.subharvestcosts = data
                });
                
                axios.get('api/subacreageplanted/'+ id).then(({data}) => {
                    this.subacreageplanted = data
                });
                
                axios.get('api/subacreageweeded/'+ id).then(({data}) => {
                    this.subacreageweeded = data
                });
                
                axios.get('api/subacreageharvested/'+ id).then(({data}) => {
                    this.subacreageharvested = data
                });                
            }, 
            loadcashDetails(id){
                axios.get('api/cashcosts/'+ id).then(({data}) => {
                    this.cashtotalcosts = data
                });

                axios.get('api/cashplantingcosts/'+ id).then(({data}) => {
                    this.cashplantingcosts = data
                });

                axios.get('api/cashweedingcosts/'+ id).then(({data}) => {
                    this.cashweedingcosts = data
                });

                axios.get('api/cashharvestcosts/'+ id).then(({data}) => {
                    this.cashharvestcosts = data
                });
                
                axios.get('api/cashacreageplanted/'+ id).then(({data}) => {
                    this.cashacreageplanted = data
                });
                
                axios.get('api/cashacreageweeded/'+ id).then(({data}) => {
                    this.cashacreageweeded = data
                });
                
                axios.get('api/cashacreageharvested/'+ id).then(({data}) => {
                    this.cashacreageharvested = data
                }); 
                axios.get('api/cashsales/'+ id).then(({data}) => {
                    this.cashrevenue = data
                });                               
            },
            loadsubcashDetails(id){
                axios.get('api/subcashcosts/'+ id).then(({data}) => {
                    this.subcashtotalcosts = data
                });
                axios.get('api/subcashsales/'+ id).then(({data}) => {
                    this.subcashrevenue = data
                }); 
                axios.get('api/subcashacreageplanted/'+ id).then(({data}) => {
                    this.subcashacreageplanted = data
                });
                
                axios.get('api/subcashacreageweeded/'+ id).then(({data}) => {
                    this.subcashacreageweeded = data
                });
                
                axios.get('api/subcashacreageharvested/'+ id).then(({data}) => {
                    this.subcashacreageharvested = data
                });                               
            },
            loadsubPlanting(id){
                axios.get('api/subplantingcosts/'+ id).then(({data}) => {
                    this.subplantingcosts = data
                }); 
                axios.get('api/subacreageplanted/'+ id).then(({data}) => {
                    this.subacreageplanted = data
                });  
                axios.get('api/subfertilizercosts/'+ id).then(({data}) => {
                    this.subfertilizercosts = data
                });
                axios.get('api/subseedcosts/'+ id).then(({data}) => {
                    this.subseedcosts = data
                }); 
                axios.get('api/subplantinglabourcosts/'+ id).then(({data}) => {
                    this.subplantinglabourcosts = data
                });
                axios.get('api/subplantinglabourused/'+ id).then(({data}) => {
                    this.subplantinglabourused = data
                });
                axios.get('api/subprevalentfertilizer/'+ id).then(({data}) => {
                    this.subprevalentfertilizer = data
                });                                                                                             
            },
            loadcashPlanting(id){
                axios.get('api/cashplantingcosts/'+ id).then(({data}) => {
                    this.cashplantingcosts = data
                }); 
                axios.get('api/cashacreageplanted/'+ id).then(({data}) => {
                    this.cashacreageplanted = data
                });  
                axios.get('api/cashfertilizercosts/'+ id).then(({data}) => {
                    this.cashfertilizercosts = data
                });
                axios.get('api/cashseedcosts/'+ id).then(({data}) => {
                    this.cashseedcosts = data
                }); 
                axios.get('api/cashplantinglabourcosts/'+ id).then(({data}) => {
                    this.cashplantinglabourcosts = data
                });
                axios.get('api/cashplantinglabourused/'+ id).then(({data}) => {
                    this.cashplantinglabourused = data
                });
                axios.get('api/cashprevalentfertilizer/'+ id).then(({data}) => {
                    this.cashprevalentfertilizer = data
                });
            },
            loadsubcashPlanting(id){
                axios.get('api/subcashplantingcosts/'+ id).then(({data}) => {
                    this.subcashplantingcosts = data
                }); 
                axios.get('api/subcashacreageplanted/'+ id).then(({data}) => {
                    this.subcashacreageplanted = data
                });  
                axios.get('api/subcashfertilizercosts/'+ id).then(({data}) => {
                    this.subcashfertilizercosts = data
                });
                axios.get('api/subcashseedcosts/'+ id).then(({data}) => {
                    this.subcashseedcosts = data
                }); 
                axios.get('api/subcashplantinglabourcosts/'+ id).then(({data}) => {
                    this.subcashplantinglabourcosts = data
                });
                axios.get('api/subcashplantinglabourused/'+ id).then(({data}) => {
                    this.subcashplantinglabourused = data
                });
                axios.get('api/subcashprevalentfertilizer/'+ id).then(({data}) => {
                    this.subcashprevalentfertilizer = data
                });
            }, 
            loadsubWeeding(id){
                axios.get('api/subweedingcosts/'+ id).then(({data}) => {
                    this.subweedingcosts = data
                }); 
                axios.get('api/subacreageweeded/'+ id).then(({data}) => {
                    this.subacreageweeded = data
                });  
                axios.get('api/subchemicalcosts/'+ id).then(({data}) => {
                    this.subchemicalcosts = data
                });
                axios.get('api/subtoolcosts/'+ id).then(({data}) => {
                    this.subtoolcosts = data
                }); 
                axios.get('api/subweedinglabourcosts/'+ id).then(({data}) => {
                    this.subweedinglabourcosts = data
                });
                axios.get('api/subweedinglabourused/'+ id).then(({data}) => {
                    this.subweedinglabourused = data
                });
                axios.get('api/subprevalentchemical/'+ id).then(({data}) => {
                    this.subprevalentchemical = data
                });
            },
            loadcashWeeding(id){
                axios.get('api/cashweedingcosts/'+ id).then(({data}) => {
                    this.cashweedingcosts = data
                }); 
                axios.get('api/cashacreageweeded/'+ id).then(({data}) => {
                    this.cashacreageweeded = data
                });  
                axios.get('api/cashchemicalcosts/'+ id).then(({data}) => {
                    this.cashchemicalcosts = data
                });
                axios.get('api/cashtoolcosts/'+ id).then(({data}) => {
                    this.cashtoolcosts = data
                }); 
                axios.get('api/cashweedinglabourcosts/'+ id).then(({data}) => {
                    this.cashweedinglabourcosts = data
                });
                axios.get('api/cashweedinglabourused/'+ id).then(({data}) => {
                    this.cashweedinglabourused = data
                });
                axios.get('api/cashprevalentchemical/'+ id).then(({data}) => {
                    this.cashprevalentchemical = data
                });
            },
            loadsubcashWeeding(id){
                axios.get('api/subcashweedingcosts/'+ id).then(({data}) => {
                    this.subcashweedingcosts = data
                }); 
                axios.get('api/subcashacreageweeded/'+ id).then(({data}) => {
                    this.subcashacreageweeded = data
                });  
                axios.get('api/subcashchemicalcosts/'+ id).then(({data}) => {
                    this.subcashchemicalcosts = data
                });
                axios.get('api/subcashtoolcosts/'+ id).then(({data}) => {
                    this.subcashtoolcosts = data
                }); 
                axios.get('api/subcashweedinglabourcosts/'+ id).then(({data}) => {
                    this.subcashweedinglabourcosts = data
                });
                axios.get('api/subcashweedinglabourused/'+ id).then(({data}) => {
                    this.subcashweedinglabourused = data
                });
                axios.get('api/subcashprevalentchemical/'+ id).then(({data}) => {
                    this.subcashprevalentchemical = data
                });
            }, 
            loadsubHarvesting(id){
                axios.get('api/subacreageharvested/'+ id).then(({data}) => {
                    this.subacreageharvested = data
                });                
                axios.get('api/subharvestingcosts/'+ id).then(({data}) => {
                    this.subharvestingcosts = data
                });
                axios.get('api/subtransportcosts/'+ id).then(({data}) => {
                    this.subtransportcosts = data
                });
                axios.get('api/subharvestinglabourcosts/'+ id).then(({data}) => {
                    this.subharvestinglabourcosts = data
                }); 
                axios.get('api/subharvestinglabourused/'+ id).then(({data}) => {
                    this.subharvestinglabourused = data
                }); 
            },
            loadcashHarvesting(id){
                axios.get('api/cashacreageharvested/'+ id).then(({data}) => {
                    this.cashacreageharvested = data
                });                
                axios.get('api/cashharvestingcosts/'+ id).then(({data}) => {
                    this.cashharvestingcosts = data
                });
                axios.get('api/cashtransportcosts/'+ id).then(({data}) => {
                    this.cashtransportcosts = data
                });
                axios.get('api/cashharvestinglabourcosts/'+ id).then(({data}) => {
                    this.cashharvestinglabourcosts = data
                }); 
                axios.get('api/cashharvestinglabourused/'+ id).then(({data}) => {
                    this.cashharvestinglabourused = data
                });
            },
            loadsubcashHarvesting(id){
                axios.get('api/subcashacreageharvested/'+ id).then(({data}) => {
                    this.subcashacreageharvested = data
                });                
                axios.get('api/subcashharvestingcosts/'+ id).then(({data}) => {
                    this.subcashharvestingcosts = data
                });
                axios.get('api/subcashtransportcosts/'+ id).then(({data}) => {
                    this.subcashtransportcosts = data
                });
                axios.get('api/subcashharvestinglabourcosts/'+ id).then(({data}) => {
                    this.subcashharvestinglabourcosts = data
                }); 
                axios.get('api/subcashharvestinglabourused/'+ id).then(({data}) => {
                    this.subcashharvestinglabourused = data
                });
            },                                   
            loadgeneralDetails(){
                axios.get('api/generalcosts').then(({data}) => {
                    this.totalcosts = data
                });
                axios.get('api/plantingcosts').then(({data}) => {
                    this.plantingcosts = data
                });
                axios.get('api/weedingcosts').then(({data}) => {
                    this.weedingcosts = data
                }); 
                axios.get('api/harvestingcosts').then(({data}) => {
                    this.harvestingcosts = data
                });                                               
            }                                                                        
        },
        created() {
            this.listsubCrops();
            this.listcashCrops();
            this.listsubcashCrops();
            this.loadgeneralDetails();
        }
    }
</script>
