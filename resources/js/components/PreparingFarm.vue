<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Preparation Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Subsistence</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Cash Crop</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Subsistence/CashCrop</a></li>              
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Preparing Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcropModal">
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
                                <th style="width: 10px">Date of Preparing</th>
                                <th>Activity</th>
                                <th>Acreage Prepared</th>
                                <th>Tools Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subpreparingdetails.data" :key="item.id">
                                <td>{{item.date_of_preparing}}</td>
                                <td>{{item.activity}}</td>
                                <td>{{item.acreage_prepared}}</td>
                                <td>
                                    <span v-if="item.tools_used == 'TRACTOR'" class="badge bg-danger">TRACTOR</span>
                                    <span v-else-if="item.tools_used == 'OXEN'" class="badge bg-success">OXEN</span>
                                    <span v-else-if="item.tools_used == 'JEMBE'" class="badge bg-info">JEMBE</span>
                                    <span v-else-if="item.tools_used == 'FIRE'" class="badge bg">FIRE</span>
                                    <span v-else class="badge bg-primary">{{item.tools_used | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editsubcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubPreparingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Subsistence Crop Modal -->
                        <div class="modal fade" id="subCrop" tabindex="-1" role="dialog" aria-labelledby="subCrop" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubPreparingDetail() : createsubPreparingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop(optional)</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop</option>
                                            <option 
                                                v-for="crop in subcropslist" :key="crop.id"
                                                :value="crop.id"
                                                :selected="crop.id == form.crop_id">{{ crop.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Preparing</label>
                                            <input v-model="form.date_of_preparing" type="date" name="preparing_date"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('preparing_date') }">
                                                <div v-if="form.errors.has('preparing_date')" v-html="form.errors.get('preparing_date')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Activity</label>  
                                                    <textarea v-model="form.activity" id="activity"
                                                    name="activity" placeholder="Brief description of the process(e.g burning,ploughing)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('activity')" v-html="form.errors.get('activity')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Tools or Equipment Used</label>  
                                                    <input type="text" list="preparationtools" v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" class="form-control" :class="{ 'is-invalid': form.errors.has('tools_used') }"/>
                                                    <datalist id="preparationtools">
                                                    <option value="TRACTOR">TRACTOR</option>
                                                    <option value="OXEN">OXEN</option>
                                                    <option value="JEMBE">JEMBE</option>
                                                    <option value="FIRE">FIRE</option>
                                                    </datalist>                                                    
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>                                                                                   
                                        <div class="form-group">
                                            <label>Acreage Prepared</label>
                                            <input v-model="form.acreage_prepared" type="text" name="acreage" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage') }">
                                                <div v-if="form.errors.has('acreage')" v-html="form.errors.get('acreage')" /> 
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
                        <pagination :data="subpreparingdetails" @pagination-change-page="getsubPreparingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Preparing Labour Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="sublabourModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                       
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date of Work</th>
                                <th>No of Person(s)</th>
                                <th>Amount Paid</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subpreparinglabourcosts.data" :key="item.id">
                                <td>{{item.date_of_work}}</td>
                                <td>{{item.no_of_persons}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                   
                                    <a href="#" @click="editsublabourModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubPreparingLabourCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Subsistence Labour Modal -->
                        <div class="modal fade" id="subLabour" tabindex="-1" role="dialog" aria-labelledby="subLabour" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Labour Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Labour Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubpreparingLabourCost() : createsubPreparingLabourCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop(optional)</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop</option>
                                            <option 
                                                v-for="crop in subcropslist" :key="crop.id"
                                                :value="crop.id"
                                                :selected="crop.id == form.crop_id">{{ crop.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Work</label>
                                            <input v-model="form.date_of_work" type="date" name="date_of_work"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_work') }">
                                                <div v-if="form.errors.has('date_of_work')" v-html="form.errors.get('date_of_work')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number of Person(s)</label>
                                            <input v-model="form.no_of_persons" type="text" name="no_of_persons"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_persons') }">
                                                <div v-if="form.errors.has('no_of_persons')" v-html="form.errors.get('no_of_persons')" /> 
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
                        <pagination :data="subpreparinglabourcosts" @pagination-change-page="getsubPreparingLabourCosts"></pagination>
                            </ul>
                        </div>                                                
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Preparing Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subothercostModal">
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
                                <th style="width: 10px">Date of Payment</th>
                                <th>Name of Activity</th>
                                <th style="width: 10px">Amount Paid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subpreparingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubPreparingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Subsistence Other Cost Modal -->
                        <div class="modal fade" id="subOtherCost" tabindex="-1" role="dialog" aria-labelledby="subOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubPreparingOtherCost() : createsubPreparingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to preparing(e.g ploughing)"
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
                        <pagination :data="subpreparingothercosts" @pagination-change-page="getsubPreparingOtherCosts"></pagination>
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
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Preparing Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cashcropModal">
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
                                <th style="width: 10px">Date of Preparing</th>
                                <th>Activity</th>
                                <th>Acreage Prepared</th>
                                <th>Tools or Equipment Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashpreparingdetails.data" :key="item.id">
                                <td>{{item.date_of_preparing}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_prepared}</td>
                                <td>{{item.activity}}</td>
                                <td>
                                    <span v-if="item.tools_used == 'TRACTOR'" class="badge bg-danger">TRACTOR</span>
                                    <span v-else-if="item.tools_used == 'OXEN'" class="badge bg-success">OXEN</span>
                                    <span v-else-if="item.tools_used == 'JEMBE'" class="badge bg-info">JEMBE</span>
                                    <span v-else-if="item.tools_used == 'FIRE'" class="badge bg">FIRE</span>
                                    <span v-else class="badge bg-primary">{{item.tools_used | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click= "editcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click= "deletecashPreparingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Cash Crop Modal -->
                        <div class="modal fade" id="cashCrop" tabindex="-1" role="dialog" aria-labelledby="cashCrop" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashPreparingDetail() : createcashPreparingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop(optional)</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop</option>
                                            <option 
                                                v-for="crop in cashcropslist" :key="crop.id"
                                                :value="crop.id"
                                                :selected="crop.id == form.crop_id">{{ crop.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Preparing</label>
                                            <input v-model="form.date_of_preparing" type="date" name="preparing_date"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('preparing_date') }">
                                                <div v-if="form.errors.has('preparing_date')" v-html="form.errors.get('preparing_date')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Activity</label>  
                                                    <textarea v-model="form.activity" id="activity"
                                                    name="activity" placeholder="Brief description of the process(e.g burning,ploughing)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('activity')" v-html="form.errors.get('activity')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Tools or Equipment Used</label>  
                                                    <input type="text" list="preparationtools" v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" class="form-control" :class="{ 'is-invalid': form.errors.has('tools_used') }"/>
                                                    <datalist id="preparationtools">
                                                    <option value="TRACTOR">TRACTOR</option>
                                                    <option value="OXEN">OXEN</option>
                                                    <option value="JEMBE">JEMBE</option>
                                                    <option value="FIRE">FIRE</option>
                                                    </datalist>                                                    
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>    
                                        <div class="form-group">
                                            <label>Acreage Prepared</label>
                                            <input v-model="form.acreage_prepared" type="text" name="acreage" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage') }">
                                                <div v-if="form.errors.has('acreage')" v-html="form.errors.get('acreage')" /> 
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
                            <pagination :data="cashpreparingdetails" @pagination-change-page="getcashPreparingDetails"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Preparing Labour Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cashlabourModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                       
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date of Work</th>
                                <th>No of Person(s)</th>
                                <th>Amount Paid</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashpreparinglabourcosts.data" :key="item.id">
                                <td>{{item.date_of_work}}</td>
                                <td>{{item.no_of_persons}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                   
                                    <a href="#" @click="editcashlabourModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletecashPreparingLabourCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Cash Labour Modal -->
                        <div class="modal fade" id="cashLabour" tabindex="-1" role="dialog" aria-labelledby="cashLabour" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Labour Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Labour Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashPreparingLabourCost() : createcashPreparingLabourCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop(optional)</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop</option>
                                            <option 
                                                v-for="crop in cashcropslist" :key="crop.id"
                                                :value="crop.id"
                                                :selected="crop.id == form.crop_id">{{ crop.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Work</label>
                                            <input v-model="form.date_of_work" type="date" name="date_of_work"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_work') }">
                                                <div v-if="form.errors.has('date_of_work')" v-html="form.errors.get('date_of_work')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number of Person(s)</label>
                                            <input v-model="form.no_of_persons" type="text" name="no_of_persons"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_persons') }">
                                                <div v-if="form.errors.has('no_of_persons')" v-html="form.errors.get('no_of_persons')" /> 
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
                            <pagination :data="cashpreparinglabourcosts" @pagination-change-page="getcashPreparingLabourCosts"></pagination>
                            </ul>
                        </div>                                                
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Preparing Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cashothercostModal">
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
                                <th style="width: 10px">Date of Payment</th>
                                <th>Name of Activity</th>
                                <th style="width: 10px">Amount Paid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashpreparingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletecashPreparingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Cash Other Cost Modal -->
                        <div class="modal fade" id="cashOtherCost" tabindex="-1" role="dialog" aria-labelledby="cashOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashPreparingOtherCost() : createcashPreparingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to preparing(e.g ploughing)"
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
                            <pagination :data="cashpreparingothercosts" @pagination-change-page="getcashPreparingOtherCosts"></pagination>
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
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Preparing Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashcropModal">
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
                                <th style="width: 10px">Date of Preparing</th>
                                <th>Activity</th>
                                <th>Acreage Prepared</th>
                                <th>Tools or Equipment Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashpreparingdetails.data" :key="item.id">
                                <td>{{item.date_of_preparing}}</td>
                                <td>{{item.activity}}</td>
                                <td>{{item.acreage_prepared}</td>
                                <td>
                                    <span v-if="item.tools_used == 'TRACTOR'" class="badge bg-danger">TRACTOR</span>
                                    <span v-else-if="item.tools_used == 'OXEN'" class="badge bg-success">OXEN</span>
                                    <span v-else-if="item.tools_used == 'JEMBE'" class="badge bg-info">JEMBE</span>
                                    <span v-else-if="item.tools_used == 'FIRE'" class="badge bg">FIRE</span>
                                    <span v-else class="badge bg-primary">{{item.tools_used | capitalize}}</span>
                                </td>                               <td>                                  
                                    <a href="#" @click="editsubcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPreparingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- SubCash Crop Modal -->
                        <div class="modal fade" id="subcashCrop" tabindex="-1" role="dialog" aria-labelledby="subcashCrop" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPreparingDetail() : createsubcashPreparingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop(optional)</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop</option>
                                            <option 
                                                v-for="crop in subcashcropslist" :key="crop.id"
                                                :value="crop.id"
                                                :selected="crop.id == form.crop_id">{{ crop.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Preparing</label>
                                            <input v-model="form.date_of_preparing" type="date" name="preparing_date"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('preparing_date') }">
                                                <div v-if="form.errors.has('preparing_date')" v-html="form.errors.get('preparing_date')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Activity</label>  
                                                    <textarea v-model="form.activity" id="activity"
                                                    name="activity" placeholder="Brief description of the process(e.g burning,ploughing)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('activity')" v-html="form.errors.get('activity')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Tools or Equipment Used</label>  
                                                    <input type="text" list="preparationtools" v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" class="form-control" :class="{ 'is-invalid': form.errors.has('tools_used') }"/>
                                                    <datalist id="preparationtools">
                                                    <option value="TRACTOR">TRACTOR</option>
                                                    <option value="OXEN">OXEN</option>
                                                    <option value="JEMBE">JEMBE</option>
                                                    <option value="FIRE">FIRE</option>
                                                    </datalist>                                                    
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>                                                                                  
                                        <div class="form-group">
                                            <label>Acreage Prepared</label>
                                            <input v-model="form.acreage_prepared" type="text" name="acreage" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage') }">
                                                <div v-if="form.errors.has('acreage')" v-html="form.errors.get('acreage')" /> 
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
                            <pagination :data="subcashpreparingdetails" @pagination-change-page="getsubcashPreparingDetails"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Preparing Labour Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashlabourModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                       
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date of Work</th>
                                <th>No of Person(s)</th>
                                <th>Amount Paid</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashpreparinglabourcosts.data" :key="item.id">
                                <td>{{item.date_of_work}}</td>
                                <td>{{item.no_of_persons}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                   
                                    <a href="#" @click="editsubcashlabourModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPreparingLabourCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- SubCash Labour Modal -->
                        <div class="modal fade" id="subcashLabour" tabindex="-1" role="dialog" aria-labelledby="subcashLabour" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Labour Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Labour Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPreparingLabourCost() : createsubcashPreparingLabourCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop(optional)</option>
                                            <option 
                                                v-for="crop in subcashcropslist" :key="crop.id"
                                                :value="crop.id"
                                                :selected="crop.id == form.crop_id">{{ crop.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Work</label>
                                            <input v-model="form.date_of_work" type="date" name="date_of_work"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_work') }">
                                                <div v-if="form.errors.has('date_of_work')" v-html="form.errors.get('date_of_work')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number of Person(s)</label>
                                            <input v-model="form.no_of_persons" type="text" name="no_of_persons"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_persons') }">
                                                <div v-if="form.errors.has('no_of_persons')" v-html="form.errors.get('no_of_persons')" /> 
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
                            <pagination :data="subcashpreparinglabourcosts" @pagination-change-page="getsubcashPreparingLabourCosts"></pagination>
                            </ul>
                        </div>                                                
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Preparing Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashothercostModal">
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
                                <th style="width: 10px">Date of Payment</th>
                                <th>Name of Activity</th>
                                <th style="width: 10px">Amount Paid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashpreparingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPreparingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- SubCash Other Cost Modal -->
                        <div class="modal fade" id="subcashOtherCost" tabindex="-1" role="dialog" aria-labelledby="subcashOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Preparing Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Preparing Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPreparingOtherCost() : createsubcashPreparingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to preparing(e.g ploughing)"
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
                            <pagination :data="subcashpreparingothercosts" @pagination-change-page="getsubcashPreparingOtherCosts"></pagination>
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
            return {
               editmode: false,
               form: new Form({
                    id: '',
                    crop_id: '',
                    date_of_preparing: '',
                    acreage_prepared: '',
                    activity: '',
                    activity: '',
                    tools_used: '',
                    date_of_work: '',
                    no_of_persons: '',
                    amount_paid: '',
                    date_of_purchase: '',
                    quantity_bought: '',
                    date_of_payment: '',
                    name: '',
                    seed_type: ''
               }),
               subcropslist: {},
               subpreparingdetails: {},
               subpreparinglabourcosts: {},
               subpreparingfertilizercosts: {},
               subpreparingothercosts: {},
               subpreparingseedcosts: {},

               cashcropslist: {},
               cashpreparingdetails: {},
               cashpreparinglabourcosts: {},
               cashpreparingfertilizercosts: {},
               cashpreparingothercosts: {},
               cashpreparingseedcosts: {}, 

               subcashcropslist: {},
               subcashpreparingdetails: {},
               subcashpreparinglabourcosts: {},
               subcashpreparingfertilizercosts: {},
               subcashpreparingothercosts: {},
               subcashpreparingseedcosts: {},                               
            }
        },
        methods: {
            subcropModal(){
                this.editmode = false;
                this.form.reset();
                $('#subCrop').modal('show');                
            },
            editsubcropModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subCrop').modal('show');
                this.form.fill(item)
            },
            createsubPreparingDetail(){
                this.$Progress.start();
                this.form.post('api/subpreparingdetail').then(() => {
                    $('#subCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPreparingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubPreparingDetail(){
                this.$Progress.start();
                this.form.put('api/subpreparingdetail/'+this.form.id).then(() => {
                    $('#subCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPreparingDetails')
                }).catch(() => {
                this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubPreparingDetail(id){
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
                  this.form.delete('api/subpreparingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'preparing detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPreparingDetails');
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
            sublabourModal(){
                this.editmode = false;
                this.form.reset();
                $('#subLabour').modal('show');
            },
            editsublabourModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subLabour').modal('show');
                this.form.fill(item)
            },
            createsubPreparingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subpreparinglabourcost').then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPreparingLabourCosts')
                }).catch(() => {
                this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubPreparingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subpreparinglabourcost/'+this.form.id).then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPreparingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubPreparingLabourCost(id){
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
                  this.form.delete('api/subpreparinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPreparingLabourCosts');
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
            subothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#subOtherCost').modal('show');
            },
            editsubothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subOtherCost').modal('show');
                this.form.fill(item)
            },
            createsubPreparingOtherCost(){
                this.$Progress.start();
                this.form.post('api/subpreparingothercost').then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPreparingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatesubPreparingOtherCost(){
                this.$Progress.start();
                this.form.put('api/subpreparingothercost/'+this.form.id).then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPreparingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubPreparingOtherCost(id){
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
                  this.form.delete('api/subpreparingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPreparingOtherCosts');
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
            listsubCrops(){
                axios.get('api/subcroplist').then((response) => {
                    this.subcropslist = response.data.data
                });
            },
                        
            loadsubPreparingDetails(){
                axios.get('api/subpreparingdetail').then((response) => {
                    this.subpreparingdetails = response.data
                });
            },
            loadsubPreparingLabourCosts(){
                axios.get('api/subpreparinglabourcost').then((response) => {
                    this.subpreparinglabourcosts = response.data
                });
            },
            loadsubPreparingOtherCosts(){
                axios.get('api/subpreparingothercost').then((response) => {
                    this.subpreparingothercosts = response.data
                });                
            },

            //pagination of subcrops
		    getsubPreparingDetails(page = 1) {
			axios.get('api/subpreparingdetail?page=' + page)
				.then(response => {
					this.subpreparingdetails = response.data;
				})                
            },
		    getsubPreparingLabourCosts(page = 1) {
			axios.get('api/subpreparinglabourcost?page=' + page)
				.then(response => {
					this.subpreparinglabourcosts = response.data;
				})                
            },
		    getsubPreparingOtherCosts(page = 1) {
			axios.get('api/subpreparingothercost?page=' + page)
				.then(response => {
					this.subpreparingothercosts = response.data;
				})                
            },                                                


            //start of cash crop methods
            cashcropModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashCrop').modal('show');                
            },
            editcashcropModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashCrop').modal('show');
                this.form.fill(item)
            },             
            createcashPreparingDetail(){
                this.$Progress.start();
                this.form.post('api/cashpreparingdetail').then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPreparingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecashPreparingDetail(){
                this.$Progress.start();
                this.form.put('api/cashpreparingdetail/'+this.form.id).then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPreparingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPreparingDetail(id){
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
                  this.form.delete('api/cashpreparingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'preparing detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashPreparingDetails');
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
            cashlabourModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashLabour').modal('show');
            },
            editcashlabourModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashLabour').modal('show');
                this.form.fill(item)
            },
            createcashPreparingLabourCost(){
                this.$Progress.start();
                this.form.post('api/cashpreparinglabourcost').then(() => {
                    $('#cashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecashPreparingLabourCost(){
                this.$Progress.start();
                this.form.put('api/cashpreparinglabourcost/'+this.form.id).then(() => {
                    $('#cashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPreparingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPreparingLabourCost(id){
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
                  this.form.delete('api/cashpreparinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashPreparingLabourCosts');
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
            cashothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashOtherCost').modal('show');
            },
            editcashothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashOtherCost').modal('show');
                this.form.fill(item)
            },
            createcashPreparingOtherCost(){
                this.$Progress.start();
                this.form.post('api/cashpreparingothercost').then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPreparingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatecashPreparingOtherCost(){
                this.$Progress.start();
                this.form.put('api/cashpreparingothercost/'+this.form.id).then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPreparingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPreparingOtherCost(id){
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
                  this.form.delete('api/cashpreparingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashPreparingOtherCosts');
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

            listcashCrops(){
                axios.get('api/cashcroplist').then((response) => {
                    this.cashcropslist = response.data.data
                });
            },                       
            loadcashPreparingDetails(){
                axios.get('api/cashpreparingdetail').then((response) => {
                    this.cashpreparingdetails = response.data
                });
            },
            loadcashPreparingLabourCosts(){
                axios.get('api/cashpreparinglabourcost').then((response) => {
                    this.cashpreparinglabourcosts = response.data
                });
            },
            loadcashPreparingOtherCosts(){
                axios.get('api/cashpreparingothercost').then((response) => {
                    this.cashpreparingothercosts = response.data
                });                
            },
  
            //pagination of cashcrops
		    getcashPreparingDetails(page = 1) {
			axios.get('api/cashpreparingdetail?page=' + page)
				.then(response => {
					this.cashpreparingdetails = response.data;
				})                
            },
		    getcashPreparingLabourCosts(page = 1) {
			axios.get('api/cashpreparinglabourcost?page=' + page)
				.then(response => {
					this.cashpreparinglabourcosts = response.data;
				})                
            },
		    getcashPreparingOtherCosts(page = 1) {
			axios.get('api/cashpreparingothercost?page=' + page)
				.then(response => {
					this.cashpreparingothercosts = response.data;
				})                
            },  
            
            //start of subcash crop methods
            subcashcropModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashCrop').modal('show');                
            },
            editsubcashcropModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashCrop').modal('show');
                this.form.fill(item)
            },             
            createsubcashPreparingDetail(){
                this.$Progress.start();
                this.form.post('api/subcashpreparingdetail').then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPreparingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubcashPreparingDetail(){
                this.$Progress.start();
                this.form.put('api/subcashpreparingdetail/'+this.form.id).then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPreparingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashPreparingDetail(id){
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
                  this.form.delete('api/subcashpreparingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPreparingDetails');
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

            subcashlabourModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashLabour').modal('show');
            },
            editsubcashlabourModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashLabour').modal('show');
                this.form.fill(item)
            },
            createsubcashPreparingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subcashpreparinglabourcost').then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPreparingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubcashPreparingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subcashpreparinglabourcost/'+this.form.id).then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPreparingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashPreparingLabourCost(id){
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
                  this.form.delete('api/subcashpreparinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPreparingLabourCosts');
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
            subcashothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashOtherCost').modal('show');
            },
            editsubcashothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashOtherCost').modal('show');
                this.form.fill(item)
            },
            createsubcashPreparingOtherCost(){
                this.$Progress.start();
                this.form.post('api/subcashpreparingothercost').then(() => {
                    $('#subcashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPreparingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatesubcashPreparingOtherCost(){
                this.$Progress.start();
                this.form.put('api/subcashpreparingothercost/'+this.form.id).then(() => {
                    $('#subcashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPreparingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashPreparingOtherCost(id){
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
                  this.form.delete('api/subcashpreparingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPreparingOtherCosts');
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
           
            listsubcashCrops(){
                axios.get('api/subcashcroplist').then((response) => {
                    this.subcashcropslist = response.data.data
                });
            },                       
            loadsubcashPreparingDetails(){
                axios.get('api/subcashpreparingdetail').then((response) => {
                    this.subcashpreparingdetails = response.data
                });
            },
            loadsubcashPreparingLabourCosts(){
                axios.get('api/subcashpreparinglabourcost').then((response) => {
                    this.subcashpreparinglabourcosts = response.data
                });
            },
            loadsubcashPreparingOtherCosts(){
                axios.get('api/subcashpreparingothercost').then((response) => {
                    this.subcashpreparingothercosts = response.data
                });                
            },
            
            //pagination of subcashcrops
		    getsubcashPreparingDetails(page = 1) {
			axios.get('api/subcashpreparingdetail?page=' + page)
				.then(response => {
					this.subcashpreparingdetails = response.data;
				})                
            },
		    getsubcashPreparingLabourCosts(page = 1) {
			axios.get('api/subcashpreparinglabourcost?page=' + page)
				.then(response => {
					this.subcashpreparinglabourcosts = response.data;
				})                
            },
		    getsubcashPreparingOtherCosts(page = 1) {
			axios.get('api/subcashpreparingothercost?page=' + page)
				.then(response => {
					this.subcashpreparingothercosts = response.data;
				})                
            },            
        },
        mounted() {
            this.listsubCrops();
            this.loadsubPreparingDetails();
            this.loadsubPreparingLabourCosts();
            this.loadsubPreparingOtherCosts();

            //event listeners for subsistence crops
            Fire.$on('RefreshsubPreparingDetails',() => {
                this.loadsubPreparingDetails();
            });
            Fire.$on('RefreshsubPreparingLabourCosts',() => {
                this.loadsubPreparingLabourCosts();
            });
            Fire.$on('RefreshsubPreparingOtherCosts',() => {
                this.loadsubPreparingOtherCosts();
            });
                                                
            this.listcashCrops();
            this.loadcashPreparingDetails();
            this.loadcashPreparingLabourCosts();
            this.loadcashPreparingOtherCosts();
            
            //event listeners for cash crops
            Fire.$on('RefreshcashPreparingDetails',() => {
                this.loadcashPreparingDetails();
            });
            Fire.$on('RefreshcashPreparingLabourCosts',() => {
                this.loadcashPreparingLabourCosts();
            });
            Fire.$on('RefreshcashPreparingOtherCosts',() => {
                this.loadcashPreparingOtherCosts();
            });           
            
            this.listsubcashCrops();
            this.loadsubcashPreparingDetails();
            this.loadsubcashPreparingLabourCosts();
            this.loadsubcashPreparingOtherCosts();
            
            //event listeners for subcash crops
            Fire.$on('RefreshsubcashPreparingDetails',() => {
                this.loadsubcashPreparingDetails();
            });
            Fire.$on('RefreshsubcashPreparingLabourCosts',() => {
                this.loadsubcashPreparingLabourCosts();
            });
            Fire.$on('RefreshsubcashPreparingOtherCosts',() => {
                this.loadsubcashPreparingOtherCosts();
            });            
            console.log('Component mounted.')
        }
    }
</script>
