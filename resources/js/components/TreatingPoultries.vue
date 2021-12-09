<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Treating Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Grade</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Kienyeji</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Improved Kienyeji</a></li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Other <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" tabindex="-1" href="#tab_4" data-toggle="tab">Exotic</a>
                      <a class="dropdown-item" tabindex="-1" href="#tab_5" data-toggle="tab">Hybrid</a>
                    </div>
                  </li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Vaccinating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradevaccinatingdetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Vacc. Date</th>
                                <th>Poultry Vacc.</th>
                                <th>No. Vacc.</th>
                                <th>Vaccine Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradevaccinatingdetails.data" :key="item.id">
                                <td>{{item.date_of_vaccinating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.vaccine_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.vaccine_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.vaccine_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.vaccine_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editgradevaccinatingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeVaccinatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Vaccinating Detail Modal -->
                        <div class="modal fade" id="gradeVaccinatingDetail" tabindex="-1" role="dialog" aria-labelledby="gradeVaccinatingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Vaccinating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Vaccinating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeVaccinatingDetail() : creategradeVaccinatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Vaccinating</label>
                                            <input v-model="form.date_of_vaccinating" type="date" name="date_of_vaccinating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_vaccinating') }">
                                                <div v-if="form.errors.has('date_of_vaccinating')" v-html="form.errors.get('date_of_vaccinating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Vaccinated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Vaccine Used</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Vaccine Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Vaccine Administered</label>  
                                                    <textarea v-model="form.vaccine_quantity" id="vaccine_quantity"
                                                    name="vaccine_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('vaccine_quantity')" v-html="form.errors.get('vaccine_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradevaccinatingdetails" @pagination-change-page="getgradeVaccinatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradedetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date of Treating</th>
                                <th>Poultry Treated</th>
                                <th>No. Treated</th>
                                <th>Drug Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradetreatingdetails.data" :key="item.id">
                                <td>{{item.date_of_treating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.drug_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.drug_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.drug_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.drug_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editgradedetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeTreatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Detail Modal -->
                        <div class="modal fade" id="gradeDetail" tabindex="-1" role="dialog" aria-labelledby="gradeDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeTreatingDetail() : creategradeTreatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Treating</label>
                                            <input v-model="form.date_of_treating" type="date" name="date_of_treating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_treating') }">
                                                <div v-if="form.errors.has('date_of_treating')" v-html="form.errors.get('date_of_treating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Treated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Drug Used</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Drug Administered</label>  
                                                    <textarea v-model="form.drug_quantity" id="drug_quantity"
                                                    name="drug_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('drug_quantity')" v-html="form.errors.get('drug_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradetreatingdetails" @pagination-change-page="getgradeTreatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Vaccine Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradevaccinecostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradevaccinecosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.vaccine_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editgradevaccinecostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeVaccineCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Vaccine Cost Modal -->
                        <div class="modal fade" id="gradeVaccine" tabindex="-1" role="dialog" aria-labelledby="gradeVaccine" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Vaccine Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Vaccine Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeVaccineCost() : creategradeVaccineCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Vaccine</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradevaccinecosts" @pagination-change-page="getgradeVaccineCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Drug Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradedrugcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradedrugcosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.drug_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editgradedrugcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeDrugCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Drug Cost Modal -->
                        <div class="modal fade" id="gradeDrug" tabindex="-1" role="dialog" aria-labelledby="gradeDrug" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Drug Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Drug Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeDrugCost() : creategradeDrugCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Drug</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradedrugcosts" @pagination-change-page="getgradeDrugCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Treating Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradeothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradetreatingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editgradeothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeTreatingOtherCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Other Cost Modal -->
                        <div class="modal fade" id="gradeOtherCost" tabindex="-1" role="dialog" aria-labelledby="gradeOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeTreatingOtherCost() : creategradeTreatingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div> 
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradetreatingothercosts" @pagination-change-page="getgradeTreatingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div>                   
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Vaccinating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejivaccinatingdetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Vacc. Date</th>
                                <th>Poultry Vacc.</th>
                                <th>No. Vacc.</th>
                                <th>Vaccine Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejivaccinatingdetails.data" :key="item.id">
                                <td>{{item.date_of_vaccinating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.vaccine_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.vaccine_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.vaccine_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.vaccine_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editkienyejivaccinatingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletekienyejiVaccinatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Vaccinating Detail Modal -->
                        <div class="modal fade" id="kienyejiVaccinatingDetail" tabindex="-1" role="dialog" aria-labelledby="gradeVaccinatingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Vaccinating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Vaccinating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiVaccinatingDetail() : createkienyejiVaccinatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Vaccinating</label>
                                            <input v-model="form.date_of_vaccinating" type="date" name="date_of_vaccinating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_vaccinating') }">
                                                <div v-if="form.errors.has('date_of_vaccinating')" v-html="form.errors.get('date_of_vaccinating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Vaccinated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Vaccine Used</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Vaccine Administered</label>  
                                                    <textarea v-model="form.vaccine_quantity" id="vaccine_quantity"
                                                    name="vaccine_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('vaccine_quantity')" v-html="form.errors.get('vaccine_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="kienyejivaccinatingdetails" @pagination-change-page="getkienyejiVaccinatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejidetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date of Treating</th>
                                <th>Poultry Treated</th>
                                <th>No. Treated</th>
                                <th>Drug Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejitreatingdetails.data" :key="item.id">
                                <td>{{item.date_of_treating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.drug_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.drug_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.drug_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.drug_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editkienyejidetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletekienyejiTreatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Detail Modal -->
                        <div class="modal fade" id="kienyejiDetail" tabindex="-1" role="dialog" aria-labelledby="kienyejiDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiTreatingDetail() : createkienyejiTreatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Treating</label>
                                            <input v-model="form.date_of_treating" type="date" name="date_of_treating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_treating') }">
                                                <div v-if="form.errors.has('date_of_treating')" v-html="form.errors.get('date_of_treating')" /> 
                                        </div>                                      
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in kienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Treated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Drug Used</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Drug Administered</label>  
                                                    <textarea v-model="form.drug_quantity" id="drug_quantity"
                                                    name="drug_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('drug_quantity')" v-html="form.errors.get('drug_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="kienyejitreatingdetails" @pagination-change-page="getkienyejiTreatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Vaccine Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejivaccinecostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejivaccinecosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.vaccine_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editkienyejivaccinecostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteKienyejiVaccineCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Vaccine Cost Modal -->
                        <div class="modal fade" id="kienyejiVaccine" tabindex="-1" role="dialog" aria-labelledby="kienyejiVaccine" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Vaccine Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Vaccine Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiVaccineCost() : createkienyejiVaccineCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Vaccine</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Vaccine Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry to Feed</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in kienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradevaccinecosts" @pagination-change-page="getkienyejiVaccineCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Drug Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejidrugcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejidrugcosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.drug_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editkienyejidrugcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteKienyejiDrugCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Drug Cost Modal -->
                        <div class="modal fade" id="kienyejiDrug" tabindex="-1" role="dialog" aria-labelledby="kienyejiDrug" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Drug Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Drug Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiDrugCost() : createkienyejiDrugCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Drug</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in kienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="kienyejidrugcosts" @pagination-change-page="getkienyejiDrugCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Treating Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejiothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejitreatingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editkienyejiothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteKienyejiTreatingOtherCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Other Cost Modal -->
                        <div class="modal fade" id="kienyejiOtherCost" tabindex="-1" role="dialog" aria-labelledby="kienyejiOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiTreatingOtherCost() : createkienyejiTreatingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div> 
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="kienyejitreatingothercosts" @pagination-change-page="getkienyejiTreatingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div> 
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_3">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Vaccinating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejivaccinatingdetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Vacc. Date</th>
                                <th>Poultry Vacc.</th>
                                <th>No. Vacc.</th>
                                <th>Vaccine Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejivaccinatingdetails.data" :key="item.id">
                                <td>{{item.date_of_vaccinating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.vaccine_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.vaccine_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.vaccine_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.vaccine_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editimprovedkienyejivaccinatingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteimprovedkienyejiVaccinatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Improved Kienyeji Vaccinating Detail Modal -->
                        <div class="modal fade" id="improvedkienyejiVaccinatingDetail" tabindex="-1" role="dialog" aria-labelledby="improvedkienyejiVaccinatingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Vaccinating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Vaccinating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiVaccinatingDetail() : createimprovedkienyejiVaccinatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Vaccinating</label>
                                            <input v-model="form.date_of_vaccinating" type="date" name="date_of_vaccinating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_vaccinating') }">
                                                <div v-if="form.errors.has('date_of_vaccinating')" v-html="form.errors.get('date_of_vaccinating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in improvedkienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Vaccinated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Vaccine Used</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Vaccine Administered</label>  
                                                    <textarea v-model="form.vaccine_quantity" id="vaccine_quantity"
                                                    name="vaccine_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('vaccine_quantity')" v-html="form.errors.get('vaccine_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="improvedkienyejivaccinatingdetails" @pagination-change-page="getimprovedkienyejiVaccinatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejidetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date of Treating</th>
                                <th>Poultry Treated</th>
                                <th>No. Treated</th>
                                <th>Drug Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejitreatingdetails.data" :key="item.id">
                                <td>{{item.date_of_treating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.drug_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.drug_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.drug_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.drug_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editimprovedkienyejidetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteimprovedkienyejiTreatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- improvedkienyeji Detail Modal -->
                        <div class="modal fade" id="improvedkienyejiDetail" tabindex="-1" role="dialog" aria-labelledby="improvedkienyejiDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiTreatingDetail() : createimprovedkienyejiTreatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Treating</label>
                                            <input v-model="form.date_of_treating" type="date" name="date_of_treating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_treating') }">
                                                <div v-if="form.errors.has('date_of_treating')" v-html="form.errors.get('date_of_treating')" /> 
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in improvedkienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Treated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Drug Used</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Drug Used</label>  
                                                    <textarea v-model="form.drug_quantity" id="drug_quantity"
                                                    name="drug_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('drug_quantity')" v-html="form.errors.get('drug_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="improvedkienyejitreatingdetails" @pagination-change-page="getimprovedkienyejiTreatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Vaccine Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejivaccinecostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejivaccinecosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.vaccine_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editimprovedkienyejivaccinecostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteimprovedkienyejiVaccineCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- improvedkienyeji Vaccine Cost Modal -->
                        <div class="modal fade" id="improvedkienyejiVaccine" tabindex="-1" role="dialog" aria-labelledby="improvedkienyejiVaccine" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Vaccine Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Vaccine Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiVaccineCost() : createimprovedkienyejiVaccineCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Vaccine</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Vaccine Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry to Feed</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in improvedkienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="improvedkienyejivaccinecosts" @pagination-change-page="getimprovedkienyejiVaccineCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Drug Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejidrugcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejidrugcosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.drug_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editimprovedkienyejidrugcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteimprovedkienyejiDrugCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- improvedkienyeji Drug Cost Modal -->
                        <div class="modal fade" id="improvedkienyejiDrug" tabindex="-1" role="dialog" aria-labelledby="improvedkienyejiDrug" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Drug Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Drug Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiDrugCost() : createimprovedkienyejiDrugCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Drug</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in improvedkienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="improvedkienyejidrugcosts" @pagination-change-page="getimprovedkienyejiDrugCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Treating Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejiothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejitreatingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editimprovedkienyejiothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteimprovedkienyejiTreatingOtherCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- improvedkienyeji Other Cost Modal -->
                        <div class="modal fade" id="improvedkienyejiOtherCost" tabindex="-1" role="dialog" aria-labelledby="improvedkienyejiOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiTreatingOtherCost() : createimprovedkienyejiTreatingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div> 
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="improvedkienyejitreatingothercosts" @pagination-change-page="getimprovedkienyejiTreatingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div> 
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_4">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Vaccinating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticvaccinatingdetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Vacc. Date</th>
                                <th>Poultry Vacc.</th>
                                <th>No. Vacc.</th>
                                <th>Vaccine Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticvaccinatingdetails.data" :key="item.id">
                                <td>{{item.date_of_vaccinating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.vaccine_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.vaccine_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.vaccine_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.vaccine_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editexoticvaccinatingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticVaccinatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Vaccinating Detail Modal -->
                        <div class="modal fade" id="exoticVaccinatingDetail" tabindex="-1" role="dialog" aria-labelledby="exoticVaccinatingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Vaccinating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Vaccinating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticVaccinatingDetail() : createexoticVaccinatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Vaccinating</label>
                                            <input v-model="form.date_of_vaccinating" type="date" name="date_of_vaccinating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_vaccinating') }">
                                                <div v-if="form.errors.has('date_of_vaccinating')" v-html="form.errors.get('date_of_vaccinating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in exoticpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Vaccinated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Vaccine Used</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Vaccine Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Vaccine Administered</label>  
                                                    <textarea v-model="form.vaccine_quantity" id="vaccine_quantity"
                                                    name="vaccine_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('vaccine_quantity')" v-html="form.errors.get('vaccine_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="exoticvaccinatingdetails" @pagination-change-page="getexoticVaccinatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticdetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date of Treating</th>
                                <th>Poultry Treated</th>
                                <th>No. Treated</th>
                                <th>Drug Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exotictreatingdetails.data" :key="item.id">
                                <td>{{item.date_of_treating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.drug_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.drug_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.drug_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.drug_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editexoticdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticTreatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Detail Modal -->
                        <div class="modal fade" id="exoticDetail" tabindex="-1" role="dialog" aria-labelledby="exoticDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticTreatingDetail() : createexoticTreatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Treating</label>
                                            <input v-model="form.date_of_treating" type="date" name="date_of_treating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_treating') }">
                                                <div v-if="form.errors.has('date_of_treating')" v-html="form.errors.get('date_of_treating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in exoticpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Treated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Drug Used</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Drug Administered</label>  
                                                    <textarea v-model="form.drug_quantity" id="drug_quantity"
                                                    name="drug_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('drug_quantity')" v-html="form.errors.get('drug_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="exotictreatingdetails" @pagination-change-page="getexoticTreatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Vaccine Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticvaccinecostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticvaccinecosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.vaccine_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editexoticvaccinecostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticVaccineCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Vaccine Cost Modal -->
                        <div class="modal fade" id="exoticVaccine" tabindex="-1" role="dialog" aria-labelledby="exoticVaccine" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Vaccine Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Vaccine Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticVaccineCost() : createexoticVaccineCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Vaccine</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in exoticpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="exoticvaccinecosts" @pagination-change-page="getexoticVaccineCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Drug Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticdrugcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticdrugcosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.drug_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editexoticdrugcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticDrugCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Drug Cost Modal -->
                        <div class="modal fade" id="exoticDrug" tabindex="-1" role="dialog" aria-labelledby="exoticDrug" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Drug Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Drug Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticDrugCost() : createexoticDrugCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Drug</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in exoticpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="exoticdrugcosts" @pagination-change-page="getexoticDrugCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Treating Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exotictreatingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editexoticothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticTreatingOtherCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Other Cost Modal -->
                        <div class="modal fade" id="exoticOtherCost" tabindex="-1" role="dialog" aria-labelledby="exoticOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticTreatingOtherCost() : createexoticTreatingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div> 
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="exotictreatingothercosts" @pagination-change-page="getexoticTreatingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div>                   
                  </div>
                  <!-- /.tab-pane --> 
                  <div class="tab-pane" id="tab_5">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Vaccinating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridvaccinatingdetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Vacc. Date</th>
                                <th>Poultry Vacc.</th>
                                <th>No. Vacc.</th>
                                <th>Vaccine Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridvaccinatingdetails.data" :key="item.id">
                                <td>{{item.date_of_vaccinating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.vaccine_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.vaccine_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.vaccine_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.vaccine_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="edithybridvaccinatingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridVaccinatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Vaccinating Detail Modal -->
                        <div class="modal fade" id="hybridVaccinatingDetail" tabindex="-1" role="dialog" aria-labelledby="hybridVaccinatingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Vaccinating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Vaccinating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridVaccinatingDetail() : createhybridVaccinatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Vaccinating</label>
                                            <input v-model="form.date_of_vaccinating" type="date" name="date_of_vaccinating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_vaccinating') }">
                                                <div v-if="form.errors.has('date_of_vaccinating')" v-html="form.errors.get('date_of_vaccinating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in hybridpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Vaccinated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Vaccine Used</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Vaccine Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Vaccine Administered</label>  
                                                    <textarea v-model="form.vaccine_quantity" id="vaccine_quantity"
                                                    name="vaccine_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('vaccine_quantity')" v-html="form.errors.get('vaccine_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="hybridvaccinatingdetails" @pagination-change-page="gethybridVaccinatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybriddetailModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date of Treating</th>
                                <th>Poultry Treated</th>
                                <th>No. Treated</th>
                                <th>Drug Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridtreatingdetails.data" :key="item.id">
                                <td>{{item.date_of_treating}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.drug_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.drug_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.drug_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.drug_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="edithybriddetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridTreatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Detail Modal -->
                        <div class="modal fade" id="hybridDetail" tabindex="-1" role="dialog" aria-labelledby="hybridDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridTreatingDetail() : createhybridTreatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Treating</label>
                                            <input v-model="form.date_of_treating" type="date" name="date_of_treating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_treating') }">
                                                <div v-if="form.errors.has('date_of_treating')" v-html="form.errors.get('date_of_treating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in hybridpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Treated</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Drug Used</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Drug Administered</label>  
                                                    <textarea v-model="form.drug_quantity" id="drug_quantity"
                                                    name="drug_quantity" placeholder="Brief description of the quantity(e.g 20 ml)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('drug_quantity')" v-html="form.errors.get('drug_quantity')" />
                                        </div>                                                                                                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="hybridtreatingdetails" @pagination-change-page="gethybridTreatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Vaccine Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridvaccinecostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridvaccinecosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.vaccine_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="edithybridvaccinecostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridVaccineCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Vaccine Cost Modal -->
                        <div class="modal fade" id="hybridVaccine" tabindex="-1" role="dialog" aria-labelledby="hybridVaccine" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Vaccine Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Vaccine Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridVaccineCost() : createhybridVaccineCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Vaccine</label>  
                                                    <select v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('vaccine_type')" v-html="form.errors.get('vaccine_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in hybridpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="hybridvaccinecosts" @pagination-change-page="gethybridVaccineCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Drug Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybriddrugcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybriddrugcosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.drug_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="edithybriddrugcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridDrugCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Drug Cost Modal -->
                        <div class="modal fade" id="hybridDrug" tabindex="-1" role="dialog" aria-labelledby="hybridDrug" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Drug Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Drug Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridDrugCost() : createhybridDrugCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Drug</label>  
                                                    <select v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('drug_type')" v-html="form.errors.get('drug_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in hybridpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>                         
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="hybriddrugcosts" @pagination-change-page="gethybridDrugCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Treating Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridtreatingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="edithybridothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridTreatingOtherCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Other Cost Modal -->
                        <div class="modal fade" id="hybridOtherCost" tabindex="-1" role="dialog" aria-labelledby="hybridOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridTreatingOtherCost() : createhybridTreatingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
                                        </div>                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div> 
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="hybridtreatingothercosts" @pagination-change-page="gethybridTreatingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div>                   
                  </div>
                  <!-- /.tab-pane -->                                   
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>
    </div>
</template>

<script>
    export default {
        data() {
             return{
                 editmode: false,
                 form: new Form({
                        id: '',
                        poultry_id: '',
                        drug_type: '',
                        drug_quantity: '',
                        vaccine_type: '',
                        vaccine_quantity: '',
                        date_of_vaccinating: '',
                        date_of_treating: '',
                        no_of_poultries: '',
                        date_of_purchase: '',
                        quantity_bought: '',
                        amount_paid: '',
                        date_of_payment: '',
                        name: ''
                 }),
                 gradepoultrieslist: {},
                 gradevaccinatingdetails: {},
                 gradetreatingdetails: {},
                 gradevaccinecosts: {},
                 gradedrugcosts: {},
                 gradetreatingothercosts: {},

                 kienyejipoultrieslist: {},
                 kienyejivaccinatingdetails: {},
                 kienyejitreatingdetails: {},
                 kienyejivaccinecosts: {},
                 kienyejidrugcosts: {},
                 kienyejitreatingothercosts: {},
                 
                 improvedkienyejipoultrieslist: {},
                 improvedkienyejivaccinatingdetails: {},
                 improvedkienyejitreatingdetails: {},
                 improvedkienyejivaccinecosts: {},
                 improvedkienyejidrugcosts: {},
                 improvedkienyejitreatingothercosts: {},

                 exoticpoultrieslist: {},
                 exoticvaccinatingdetails: {},
                 exotictreatingdetails: {},
                 exoticvaccinecosts: {},
                 exoticdrugcosts: {},
                 exotictreatingothercosts: {},                 
                 
                 hybridpoultrieslist: {},
                 hybridvaccinatingdetails: {},
                 hybridtreatingdetails: {},
                 hybridvaccinecosts: {},
                 hybriddrugcosts: {},
                 hybridtreatingothercosts: {}                 
             }   
        },
        methods: {
            gradevaccinatingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeVaccinatingDetail').modal('show');                
            },
            editgradevaccinatingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeVaccinatingDetail').modal('show');
                this.form.fill(item)
            },
            creategradeVaccinatingDetail(){
                this.$Progress.start();                
                this.form.post('api/gradevaccinatingdetail').then(() => {
                    $('#gradeVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccinating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeVaccinatingDetail(){
                this.$Progress.start();
                this.form.put('api/gradevaccinatingdetail/'+this.form.id).then(() => {
                    $('#gradeVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccinating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeVaccinatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/gradevaccinatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccinating detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeVaccinatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            gradedetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeDetail').modal('show');                
            },
            editgradedetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeDetail').modal('show');
                this.form.fill(item)
            },
            creategradeTreatingDetail(){
                this.$Progress.start();
                this.form.post('api/gradetreatingdetail').then(() => {
                    $('#gradeDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Treating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeTreatingDetail(){
                this.$Progress.start();
                this.form.put('api/gradetreatingdetail/'+this.form.id).then(() => {
                    $('#gradeDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Treating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeTreatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/gradetreatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Treating Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeTreatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            gradevaccinecostModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeVaccine').modal('show');                
            },
            editgradevaccinecostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeVaccine').modal('show');
                this.form.fill(item)
            },
            creategradeVaccineCost(){
                this.$Progress.start();
                this.form.post('api/gradevaccinecost').then(() => {
                    $('#gradeVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccine cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeVaccineCost(){
                this.$Progress.start();
                this.form.put('api/gradevaccinecost/'+this.form.id).then(() => {
                    $('#gradeVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccine cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeVaccineCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/gradevaccinecost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccine cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeVaccineCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            gradedrugcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeDrug').modal('show');                
            },
            editgradedrugcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeDrug').modal('show');
                this.form.fill(item)
            },
            creategradeDrugCost(){
                this.$Progress.start();
                this.form.post('api/gradedrugcost').then(() => {
                    $('#gradeDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Drug cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeDrugCost(){
                this.$Progress.start();
                this.form.put('api/gradedrugcost/'+this.form.id).then(() => {
                    $('#gradeDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Drug cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeDrugCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/gradedrugcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Drug cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeDrugCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            gradeothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeOtherCost').modal('show');                
            },
            editgradeothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeOtherCost').modal('show');
                this.form.fill(item)
            },
            creategradeTreatingOtherCost(){
                this.$Progress.start();
                this.form.post('api/gradetreatingothercost').then(() => {
                    $('#gradeOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeTreatingOtherCost(){
                this.$Progress.start();
                this.form.put('api/gradetreatingothercost/'+this.form.id).then(() => {
                    $('#gradeOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeTreatingOtherCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/gradetreatingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeTreatingOtherCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },

            listgradePoultries(){
                axios.get('api/gradepoultrieslist').then((response) => {
                    this.gradepoultrieslist = response.data.data
                });
            },
            loadgradeVaccinatingDetails(){
                axios.get('api/gradevaccinatingdetail').then((response) => {
                    this.gradevaccinatingdetails = response.data
                });
            },                        
            loadgradeTreatingDetails(){
                axios.get('api/gradetreatingdetail').then((response) => {
                    this.gradetreatingdetails = response.data
                });
            },
            loadgradeVaccineCosts(){
                axios.get('api/gradevaccinecost').then((response) => {
                    this.gradevaccinecosts = response.data
                });
            },
            loadgradeDrugCosts(){
                axios.get('api/gradedrugcost').then((response) => {
                    this.gradedrugcosts = response.data
                });
            },            
            loadgradeTreatingOtherCosts(){
                axios.get('api/gradetreatingothercost').then((response) => {
                    this.gradetreatingothercosts = response.data
                });
            },

            //pagination
            getgradeVaccinatingDetails(page = 1) {
            axios.get('api/gradevaccinatingdetail?page=' + page)
                .then(response => {
                    this.gradevaccinatingdetails = response.data;
                })                
            },            
            getgradeTreatingDetails(page = 1) {
            axios.get('api/gradetreatingdetail?page=' + page)
                .then(response => {
                    this.gradetreatingdetails = response.data;
                })                
            },
            getgradeVaccineCosts(page = 1) {
            axios.get('api/gradevaccinecost?page=' + page)
                .then(response => {
                    this.gradevaccinecosts = response.data;
                })                
            },
            getgradeDrugCosts(page = 1) {
            axios.get('api/gradedrugcost?page=' + page)
                .then(response => {
                    this.gradedrugcosts = response.data;
                })                
            },            
            getgradeTreatingOtherCosts(page = 1) {
            axios.get('api/gradetreatingothercost?page=' + page)
                .then(response => {
                    this.gradetreatingothercosts = response.data;
                })                
            }, 
            
            //methods for kienyeji poultry
            kienyejivaccinatingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiVaccinatingDetail').modal('show');                
            },
            editkienyejivaccinatingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiVaccinatingDetail').modal('show');
                this.form.fill(item)
            },
            createkienyejiVaccinatingDetail(){
                this.$Progress.start();
                this.form.post('api/kienyejivaccinatingdetail').then(() => {
                    $('#kienyejiVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccinating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.finish();
                    console.log('error')
                })
            }, 
            updatekienyejiVaccinatingDetail(){
                this.$Progress.start();
                this.form.put('api/kienyejivaccinatingdetail/'+this.form.id).then(() => {
                    $('#kienyejiVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccinating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiVaccinatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/kienyejivaccinatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccinating detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiVaccinatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            kienyejidetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiDetail').modal('show');                
            },
            editkienyejidetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiDetail').modal('show');
                this.form.fill(item)
            },
            createkienyejiTreatingDetail(){
                this.$Progress.start();
                this.form.post('api/kienyejitreatingdetail').then(() => {
                    $('#kienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Treating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiTreatingDetail(){
                this.$Progress.start();
                this.form.put('api/kienyejitreatingdetail/'+this.form.id).then(() => {
                    $('#kienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Treating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiTreatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/gradetreatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Treating detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeTreatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            kienyejivaccinecostModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiVaccine').modal('show');                
            },
            editkienyejivaccinecostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiVaccine').modal('show');
                this.form.fill(item)
            },
            createkienyejiVaccineCost(){
                this.$Progress.start();
                this.form.post('api/kienyejivaccinecost').then(() => {
                    $('#kienyejiVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccine cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiVaccineCost(){
                this.$Progress.start();
                this.form.put('api/kienyejivaccinecost/'+this.form.id).then(() => {
                    $('#kienyejiVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccine cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiVaccineCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/kienyejivaccinecost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccine cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiVaccineCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            kienyejidrugcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiDrug').modal('show');                
            },
            editkienyejidrugcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiDrug').modal('show');
                this.form.fill(item)
            },
            createkienyejiDrugCost(){
                this.$Progress.start();
                this.form.post('api/kienyejidrugcost').then(() => {
                    $('#kienyejiDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Drug cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiDrugCost(){
                this.$Progress.start();
                this.form.put('api/kienyejidrugcost/'+this.form.id).then(() => {
                    $('#kienyejiDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Drug cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiDrugCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/kienyejidrugcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Drug cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiDrugCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            kienyejiothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiOtherCost').modal('show');                
            },
            editkienyejiothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiOtherCost').modal('show');
                this.form.fill(item)
            },
            createkienyejiTreatingOtherCost(){
                this.$Progress.start();
                this.form.post('api/kienyejitreatingothercost').then(() => {
                    $('#kienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiTreatingOtherCost(){
                this.$Progress.start();
                this.form.put('api/kienyejitreatingothercost/'+this.form.id).then(() => {
                    $('#kienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiTreatingOtherCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/kienyejitreatingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiTreatingOtherCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },

            listkienyejiPoultries(){
                axios.get('api/kienyejipoultrieslist').then((response) => {
                    this.kienyejipoultrieslist = response.data.data
                });
            },

            loadkienyejiVaccinatingDetails(){
                axios.get('api/kienyejivaccinatingdetail').then((response) => {
                    this.kienyejivaccinatingdetails = response.data
                });
            },
            loadkienyejiTreatingDetails(){
                axios.get('api/kienyejitreatingdetail').then((response) => {
                    this.kienyejitreatingdetails = response.data
                });
            },
            loadkienyejiVaccineCosts(){
                axios.get('api/kienyejivaccinecost').then((response) => {
                    this.kienyejivaccinecosts = response.data
                });
            },
            loadkienyejiDrugCosts(){
                axios.get('api/kienyejidrugcost').then((response) => {
                    this.kienyejidrugcosts = response.data
                });
            },            
            loadkienyejiTreatingOtherCosts(){
                axios.get('api/kienyejitreatingothercost').then((response) => {
                    this.kienyejitreatingothercosts = response.data
                });
            },

            //pagination
            getkienyejiVaccinatingDetails(page = 1) {
            axios.get('api/kienyejivaccinatingdetail?page=' + page)
                .then(response => {
                    this.kienyejivaccinatingdetails = response.data;
                })                
            },            
            getkienyejiTreatingDetails(page = 1) {
            axios.get('api/kienyejitreatingdetail?page=' + page)
                .then(response => {
                    this.kienyejitreatingdetails = response.data;
                })                
            },
            getkienyejiVaccineCosts(page = 1) {
            axios.get('api/kienyejivaccinecost?page=' + page)
                .then(response => {
                    this.kienyejivaccinecosts = response.data;
                })                
            },
            getkienyejiDrugCosts(page = 1) {
            axios.get('api/kienyejidrugcost?page=' + page)
                .then(response => {
                    this.kienyejidrugcosts = response.data;
                })                
            },            
            getkienyejiTreatingOtherCosts(page = 1) {
            axios.get('api/kienyejitreatingothercost?page=' + page)
                .then(response => {
                    this.kienyejitreatingothercosts = response.data;
                })                
            }, 
            
            //methods for improved kienyeji poultry
            improvedkienyejivaccinatingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiVaccinatingDetail').modal('show');                
            },
            editimprovedkienyejivaccinatingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiVaccinatingDetail').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiVaccinatingDetail(){
                this.$Progress.start();
                this.form.post('api/ikienyejivaccinatingdetail').then(() => {
                    $('#improvedkienyejiVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccinating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiVaccinatingDetail(){
                this.$Progress.start();
                this.form.put('api/ikienyejivaccinatingdetail/'+this.form.id).then(() => {
                    $('#improvedkienyejiVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccinating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiVaccinatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/ikienyejivaccinatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccinating detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshimprovedkienyejiVaccinatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            improvedkienyejidetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiDetail').modal('show');                
            },
            editimprovedkienyejidetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiDetail').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiTreatingDetail(){
                this.$Progress.start();
                this.form.post('api/ikienyejitreatingdetail').then(() => {
                    $('#improvedkienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Treating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiTreatingDetail(){
                this.$Progress.start();
                this.form.put('api/ikienyejitreatingdetail/'+this.form.id).then(() => {
                    $('#improvedkienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Treating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiTreatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/ikienyejitreatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Treating detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshimprovedkienyejiTreatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            improvedkienyejivaccinecostModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiVaccine').modal('show');                
            },
            editimprovedkienyejivaccinecostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiVaccine').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiVaccineCost(){
                this.$Progress.start();
                this.form.post('api/ikienyejivaccinecost').then(() => {
                    $('#improvedkienyejiVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccine cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiVaccineCost(){
                this.$Progress.start();
                this.form.put('api/ikienyejivaccinecost/'+this.form.id).then(() => {
                    $('#improvedkienyejiVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccine cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiVaccineCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/ikienyejivaccinecost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccine cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshimprovedkienyejiVaccineCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            improvedkienyejidrugcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiDrug').modal('show');                
            },
            editimprovedkienyejidrugcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiDrug').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiDrugCost(){
                this.$Progress.start();
                this.form.post('api/ikienyejidrugcost').then(() => {
                    $('#improvedkienyejiDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Drug cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiDrugCost(){
                this.$Progress.start();
                this.form.put('api/ikienyejidrugcost/'+this.form.id).then(() => {
                    $('#improvedkienyejiDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Drug cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiDrugCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/ikienyejidrugcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Drug cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshimprovedkienyejiDrugCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            improvedkienyejiothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiOtherCost').modal('show');                
            },
            editimprovedkienyejiothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiOtherCost').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiTreatingOtherCost(){
                this.$Progress.start();
                this.form.post('api/ikienyejitreatingothercost').then(() => {
                    $('#improvedkienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiTreatingOtherCost(){
                this.$Progress.start();
                this.form.put('api/ikienyejitreatingothercost/'+this.form.id).then(() => {
                    $('#improvedkienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiTreatingOtherCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/ikienyejitreatingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshimprovedkienyejiTreatingOtherCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },

            listimprovedkienyejiPoultries(){
                axios.get('api/ikienyejipoultrieslist').then((response) => {
                    this.improvedkienyejipoultrieslist = response.data.data
                });
            },

            loadimprovedkienyejiVaccinatingDetails(){
                axios.get('api/ikienyejivaccinatingdetail').then((response) => {
                    this.improvedkienyejivaccinatingdetails = response.data
                });
            },
            loadimprovedkienyejiTreatingDetails(){
                axios.get('api/ikienyejitreatingdetail').then((response) => {
                    this.improvedkienyejitreatingdetails = response.data
                });
            },
            loadimprovedkienyejiVaccineCosts(){
                axios.get('api/ikienyejivaccinecost').then((response) => {
                    this.improvedkienyejivaccinecosts = response.data
                });
            },
            loadimprovedkienyejiDrugCosts(){
                axios.get('api/ikienyejidrugcost').then((response) => {
                    this.improvedkienyejidrugcosts = response.data
                });
            },            
            loadimprovedkienyejiTreatingOtherCosts(){
                axios.get('api/ikienyejitreatingothercost').then((response) => {
                    this.improvedkienyejitreatingothercosts = response.data
                });
            },

            //pagination
            getimprovedkienyejiVaccinatingDetails(page = 1) {
            axios.get('api/ikienyejivaccinatingdetail?page=' + page)
                .then(response => {
                    this.improvedkienyejivaccinatingdetails = response.data;
                })                
            },            
            getimprovedkienyejiTreatingDetails(page = 1) {
            axios.get('api/ikienyejitreatingdetail?page=' + page)
                .then(response => {
                    this.improvedkienyejitreatingdetails = response.data;
                })                
            },
            getimprovedkienyejiVaccineCosts(page = 1) {
            axios.get('api/ikienyejivaccinecost?page=' + page)
                .then(response => {
                    this.improvedkienyejivaccinecosts = response.data;
                })                
            },
            getimprovedkienyejiDrugCosts(page = 1) {
            axios.get('api/ikienyejidrugcost?page=' + page)
                .then(response => {
                    this.improvedkienyejidrugcosts = response.data;
                })                
            },            
            getimprovedkienyejiTreatingOtherCosts(page = 1) {
            axios.get('api/ikienyejitreatingothercost?page=' + page)
                .then(response => {
                    this.improvedkienyejitreatingothercosts = response.data;
                })                
            }, 
            
            //methods for exotic
            exoticvaccinatingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticVaccinatingDetail').modal('show');                
            },
            editexoticvaccinatingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticVaccinatingDetail').modal('show');
                this.form.fill(item)
            },
            createexoticVaccinatingDetail(){
                this.$Progress.start();                
                this.form.post('api/exoticvaccinatingdetail').then(() => {
                    $('#exoticVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccinating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticVaccinatingDetail(){
                this.$Progress.start();
                this.form.put('api/exoticvaccinatingdetail/'+this.form.id).then(() => {
                    $('#exoticVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccinating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticVaccinatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/exoticvaccinatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccinating Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticVaccinatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            exoticdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticDetail').modal('show');                
            },
            editexoticdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticDetail').modal('show');
                this.form.fill(item)
            },
            createexoticTreatingDetail(){
                this.$Progress.start();
                this.form.post('api/exotictreatingdetail').then(() => {
                    $('#exoticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Treating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticTreatingDetail(){
                this.$Progress.start();
                this.form.put('api/exotictreatingdetail/'+this.form.id).then(() => {
                    $('#exoticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Treating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticTreatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/exotictreatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Treating Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticTreatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            exoticvaccinecostModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticVaccine').modal('show');                
            },
            editexoticvaccinecostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticVaccine').modal('show');
                this.form.fill(item)
            },
            createexoticVaccineCost(){
                this.$Progress.start();
                this.form.post('api/exoticvaccinecost').then(() => {
                    $('#exoticVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccine cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticVaccineCost(){
                this.$Progress.start();
                this.form.put('api/exoticvaccinecost/'+this.form.id).then(() => {
                    $('#exoticVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccine cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticVaccineCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/exoticvaccinecost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccine cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticVaccineCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            exoticdrugcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticDrug').modal('show');                
            },
            editexoticdrugcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticDrug').modal('show');
                this.form.fill(item)
            },
            createexoticDrugCost(){
                this.$Progress.start();
                this.form.post('api/exoticdrugcost').then(() => {
                    $('#exoticDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Drug cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticDrugCost(){
                this.$Progress.start();
                this.form.put('api/exoticdrugcost/'+this.form.id).then(() => {
                    $('#exoticDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Drug cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticDrugCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/exoticdrugcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Drug cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticDrugCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            exoticothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticOtherCost').modal('show');                
            },
            editexoticothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticOtherCost').modal('show');
                this.form.fill(item)
            },
            createexoticTreatingOtherCost(){
                this.$Progress.start();
                this.form.post('api/exotictreatingothercost').then(() => {
                    $('#exoticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticTreatingOtherCost(){
                this.$Progress.start();
                this.form.put('api/exotictreatingothercost/'+this.form.id).then(() => {
                    $('#exoticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticTreatingOtherCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/exotictreatingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticTreatingOtherCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },

            listexoticPoultries(){
                axios.get('api/exoticpoultrieslist').then((response) => {
                    this.exoticpoultrieslist = response.data.data
                });
            },
            loadexoticVaccinatingDetails(){
                axios.get('api/exoticvaccinatingdetail').then((response) => {
                    this.exoticvaccinatingdetails = response.data
                });
            },                        
            loadexoticTreatingDetails(){
                axios.get('api/exotictreatingdetail').then((response) => {
                    this.exotictreatingdetails = response.data
                });
            },
            loadexoticVaccineCosts(){
                axios.get('api/exoticvaccinecost').then((response) => {
                    this.exoticvaccinecosts = response.data
                });
            },
            loadexoticDrugCosts(){
                axios.get('api/exoticdrugcost').then((response) => {
                    this.exoticdrugcosts = response.data
                });
            },            
            loadexoticTreatingOtherCosts(){
                axios.get('api/exotictreatingothercost').then((response) => {
                    this.exotictreatingothercosts = response.data
                });
            },

            //pagination
            getexoticVaccinatingDetails(page = 1) {
            axios.get('api/exoticvaccinatingdetail?page=' + page)
                .then(response => {
                    this.exoticvaccinatingdetails = response.data;
                })                
            },            
            getexoticTreatingDetails(page = 1) {
            axios.get('api/exotictreatingdetail?page=' + page)
                .then(response => {
                    this.exotictreatingdetails = response.data;
                })                
            },
            getexoticVaccineCosts(page = 1) {
            axios.get('api/exoticvaccinecost?page=' + page)
                .then(response => {
                    this.exoticvaccinecosts = response.data;
                })                
            },
            getexoticDrugCosts(page = 1) {
            axios.get('api/exoticdrugcost?page=' + page)
                .then(response => {
                    this.exoticdrugcosts = response.data;
                })                
            },            
            getexoticTreatingOtherCosts(page = 1) {
            axios.get('api/exotictreatingothercost?page=' + page)
                .then(response => {
                    this.exotictreatingothercosts = response.data;
                })                
            },
            
            //methods for hybrid
            hybridvaccinatingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridVaccinatingDetail').modal('show');                
            },
            edithybridvaccinatingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridVaccinatingDetail').modal('show');
                this.form.fill(item)
            },
            createhybridVaccinatingDetail(){
                this.$Progress.start();                
                this.form.post('api/hybridvaccinatingdetail').then(() => {
                    $('#hybridVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccinating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridVaccinatingDetail(){
                this.$Progress.start();
                this.form.put('api/hybridvaccinatingdetail/'+this.form.id).then(() => {
                    $('#hybridVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccinating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridVaccinatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/hybridvaccinatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccinating Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridVaccinatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            hybriddetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridDetail').modal('show');                
            },
            edithybriddetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridDetail').modal('show');
                this.form.fill(item)
            },
            createhybridTreatingDetail(){
                this.$Progress.start();
                this.form.post('api/hybridtreatingdetail').then(() => {
                    $('#hybridDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Treating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridTreatingDetail(){
                this.$Progress.start();
                this.form.put('api/hybridtreatingdetail/'+this.form.id).then(() => {
                    $('#hybridDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Treating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridTreatingDetail(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/hybridtreatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Treating Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridTreatingDetails');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            hybridvaccinecostModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridVaccine').modal('show');                
            },
            edithybridvaccinecostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridVaccine').modal('show');
                this.form.fill(item)
            },
            createhybridVaccineCost(){
                this.$Progress.start();
                this.form.post('api/hybridvaccinecost').then(() => {
                    $('#hybridVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccine cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridVaccineCost(){
                this.$Progress.start();
                this.form.put('api/hybridvaccinecost/'+this.form.id).then(() => {
                    $('#hybridVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccine cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridVaccineCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/hybridvaccinecost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccine cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridVaccineCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            hybriddrugcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridDrug').modal('show');                
            },
            edithybriddrugcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridDrug').modal('show');
                this.form.fill(item)
            },
            createhybridDrugCost(){
                this.$Progress.start();
                this.form.post('api/hybriddrugcost').then(() => {
                    $('#hybridDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Drug cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridDrugCost(){
                this.$Progress.start();
                this.form.put('api/hybriddrugcost/'+this.form.id).then(() => {
                    $('#hybridDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Drug cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridDrugCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/hybriddrugcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Drug cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridDrugCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            hybridothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridOtherCost').modal('show');                
            },
            edithybridothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridOtherCost').modal('show');
                this.form.fill(item)
            },
            createhybridTreatingOtherCost(){
                this.$Progress.start();
                this.form.post('api/hybridtreatingothercost').then(() => {
                    $('#hybridOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridTreatingOtherCost(){
                this.$Progress.start();
                this.form.put('api/hybridtreatingothercost/'+this.form.id).then(() => {
                    $('#hybridOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridTreatingOtherCost(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/hybridtreatingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridTreatingOtherCosts');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },

            listhybridPoultries(){
                axios.get('api/hybridpoultrieslist').then((response) => {
                    this.hybridpoultrieslist = response.data.data
                });
            },
            loadhybridVaccinatingDetails(){
                axios.get('api/hybridvaccinatingdetail').then((response) => {
                    this.hybridvaccinatingdetails = response.data
                });
            },                        
            loadhybridTreatingDetails(){
                axios.get('api/hybridtreatingdetail').then((response) => {
                    this.hybridtreatingdetails = response.data
                });
            },
            loadhybridVaccineCosts(){
                axios.get('api/hybridvaccinecost').then((response) => {
                    this.hybridvaccinecosts = response.data
                });
            },
            loadhybridDrugCosts(){
                axios.get('api/hybriddrugcost').then((response) => {
                    this.hybriddrugcosts = response.data
                });
            },            
            loadhybridTreatingOtherCosts(){
                axios.get('api/hybridtreatingothercost').then((response) => {
                    this.hybridtreatingothercosts = response.data
                });
            },

            //pagination
            gethybridVaccinatingDetails(page = 1) {
            axios.get('api/hybridvaccinatingdetail?page=' + page)
                .then(response => {
                    this.hybridvaccinatingdetails = response.data;
                })                
            },            
            gethybridTreatingDetails(page = 1) {
            axios.get('api/hybridtreatingdetail?page=' + page)
                .then(response => {
                    this.hybridtreatingdetails = response.data;
                })                
            },
            gethybridVaccineCosts(page = 1) {
            axios.get('api/hybridvaccinecost?page=' + page)
                .then(response => {
                    this.hybridvaccinecosts = response.data;
                })                
            },
            gethybridDrugCosts(page = 1) {
            axios.get('api/hybriddrugcost?page=' + page)
                .then(response => {
                    this.hybriddrugcosts = response.data;
                })                
            },            
            gethybridTreatingOtherCosts(page = 1) {
            axios.get('api/hybridtreatingothercost?page=' + page)
                .then(response => {
                    this.hybridtreatingothercosts = response.data;
                })                
            },            
        },
        created() {
            this.listgradePoultries();
            this.loadgradeVaccinatingDetails();
            this.loadgradeTreatingDetails();
            this.loadgradeVaccineCosts();
            this.loadgradeDrugCosts();
            this.loadgradeTreatingOtherCosts();

            this.listkienyejiPoultries();
            this.loadkienyejiVaccinatingDetails();
            this.loadkienyejiTreatingDetails();
            this.loadkienyejiVaccineCosts();
            this.loadkienyejiDrugCosts();
            this.loadkienyejiTreatingOtherCosts();
            
            this.listimprovedkienyejiPoultries();
            this.loadimprovedkienyejiVaccinatingDetails();
            this.loadimprovedkienyejiTreatingDetails();
            this.loadimprovedkienyejiVaccineCosts();
            this.loadimprovedkienyejiDrugCosts();
            this.loadimprovedkienyejiTreatingOtherCosts(); 
            
            this.listexoticPoultries();
            this.loadexoticVaccinatingDetails();
            this.loadexoticTreatingDetails();
            this.loadexoticVaccineCosts();
            this.loadexoticDrugCosts();
            this.loadexoticTreatingOtherCosts();
            
            this.listhybridPoultries();
            this.loadhybridVaccinatingDetails();
            this.loadhybridTreatingDetails();
            this.loadhybridVaccineCosts();
            this.loadhybridDrugCosts();
            this.loadhybridTreatingOtherCosts();            

            //event listeners 
            Fire.$on('RefreshgradeVaccinatingDetails',() => {
                this.loadgradeVaccinatingDetails();
            });            
            Fire.$on('RefreshgradeTreatingDetails',() => {
                this.loadgradeTreatingDetails();
            });
            Fire.$on('RefreshgradeVaccineCosts',() => {
                this.loadgradeVaccineCosts();
            });
             Fire.$on('RefreshgradeDrugCosts',() => {
                this.loadgradeDrugCosts();
            });
            Fire.$on('RefreshgradeTreatingOtherCosts',() => {
                this.loadgradeTreatingOtherCosts();
            }); 
            Fire.$on('RefreshkienyejiVaccinatingDetails',() => {
                this.loadkienyejiVaccinatingDetails();
            });             
            Fire.$on('RefreshkienyejiTreatingDetails',() => {
                this.loadkienyejiTreatingDetails();
            });
            Fire.$on('RefreshkienyejiVaccineCosts',() => {
                this.loadkienyejiVaccineCosts();
            });
            Fire.$on('RefreshkienyejiDrugCosts',() => {
                this.loadkienyejiDrugCosts();
            });
            Fire.$on('RefreshkienyejiTreatingOtherCosts',() => {
                this.loadkienyejiTreatingOtherCosts();
            });
            Fire.$on('RefreshimprovedkienyejiVaccinatingDetails',() => {
                this.loadimprovedkienyejiVaccinatingDetails();
            });
            Fire.$on('RefreshimprovedkienyejiTreatingDetails',() => {
                this.loadimprovedkienyejiTreatingDetails();
            });
            Fire.$on('RefreshimprovedkienyejiVaccineCosts',() => {
                this.loadimprovedkienyejiVaccineCosts();
            });
            Fire.$on('RefreshimprovedkienyejiDrugCosts',() => {
                this.loadimprovedkienyejiDrugCosts();
            });
            Fire.$on('RefreshimprovedkienyejiTreatingOtherCosts',() => {
                this.loadimprovedkienyejiTreatingOtherCosts();
            }); 
            Fire.$on('RefreshexoticVaccinatingDetails',() => {
                this.loadexoticVaccinatingDetails();
            });            
            Fire.$on('RefreshexoticTreatingDetails',() => {
                this.loadexoticTreatingDetails();
            });
            Fire.$on('RefreshexoticVaccineCosts',() => {
                this.loadexoticVaccineCosts();
            });
             Fire.$on('RefreshexoticDrugCosts',() => {
                this.loadexoticDrugCosts();
            });
            Fire.$on('RefreshexoticTreatingOtherCosts',() => {
                this.loadexoticTreatingOtherCosts();
            });
            Fire.$on('RefreshhybridVaccinatingDetails',() => {
                this.loadhybridVaccinatingDetails();
            });            
            Fire.$on('RefreshhybridTreatingDetails',() => {
                this.loadhybridTreatingDetails();
            });
            Fire.$on('RefreshhybridVaccineCosts',() => {
                this.loadhybridVaccineCosts();
            });
             Fire.$on('RefreshhybridDrugCosts',() => {
                this.loadhybridDrugCosts();
            });
            Fire.$on('RefreshhybridTreatingOtherCosts',() => {
                this.loadhybridTreatingOtherCosts();
            });                                                         
            console.log('Component mounted.')
        }
    }
</script>
