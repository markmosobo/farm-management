<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Harvesting Records</h3>
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
                            <h3 class="card-title">Harvesting Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcropModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Harv. Date</th>
                                <th>Crop Harv.</th>
                                <th>Acreage Harv.</th>
                                <th>Harvest Quantity</th>
                                <th>Tool(s) or Equipment</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subharvestingdetails.data" :key="item.id">
                                <td>{{item.date_of_harvesting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_harvested}}</td>
                                <td>{{item.harvest_quantity}}  </td>
                                <td>
                                    <span v-if="item.tools_used == 'KNIFE'" class="badge bg-danger">KNIFE</span>
                                    <span v-else-if="item.tools_used == 'JEMBE'" class="badge bg-success">JEMBE</span>
                                    <span v-else-if="item.tools_used == 'FORKJEMBE'" class="badge bg-info">FORKJEMBE</span>
                                    <span v-else-if="item.tools_used == 'HANDS'" class="badge bg-secondary">HANDS</span>
                                    <span v-else class="badge bg-primary">{{item.tools_used | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editsubcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubHarvestingDetail(item.id)">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubHarvestingDetail() : createsubHarvestingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
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
                                            <label>Date of Harvesting</label>
                                            <input v-model="form.date_of_harvesting" type="date" name="date_of_harvesting"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_harvesting') }">
                                                <div v-if="form.errors.has('date_of_harvesting')" v-html="form.errors.get('date_of_harvesting')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Tools or Equipment Used</label>  
                                                    <input type="text" list="tools" v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" class="form-control" :class="{ 'is-invalid': form.errors.has('tools_used') }" />
                                                    <datalist id="tools">
                                                    <option value="">Select Tool/Equipment Type</option>
                                                    <option value="KNIFE">Knife</option>
                                                    <option value="JEMBE">Jembe</option>
                                                    <option value="FORKJEMBE">Fork Jembe</option>
                                                    <option value="HANDS">Hands</option>
                                                    <option value="OTHER">Other</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Frequency/Quantity of Equipment Used</label>  
                                                    <textarea v-model="form.tools_usagerate" id="tools_usagerate"
                                                    name="tools_usagerate" placeholder="Brief description of the frequency e.g 2 trips by tractor(optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('tools_usagerate')" v-html="form.errors.get('tools_usagerate')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Harvest Realized</label>  
                                                    <textarea v-model="form.harvest_quantity" id="harvest_quantity"
                                                    name="harvest_quantity" placeholder="Brief description of the quantity(e.g 20 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('harvest_quantity')" v-html="form.errors.get('harvest_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Harvested</label>
                                            <input v-model="form.acreage_harvested" type="text" name="acreage_harvested" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage_harvested') }">
                                                <div v-if="form.errors.has('acreage_harvested')" v-html="form.errors.get('acreage_harvested')" /> 
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
                        <pagination :data="subharvestingdetails" @pagination-change-page="getsubHarvestingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Harv. Transport Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subtransportModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Means</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subharvestingtransportcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.transport_type == 'TRACTOR'" class="badge bg">TRACTOR</span>
                                    <span v-else-if="item.transport_type == 'MOTORBIKE'" class="badge bg">MOTORBIKE</span>
                                    <span v-else-if="item.transport_type == 'DONKEY'" class="badge bg">DONKEY</span>
                                    <span v-else-if="item.transport_type == 'HUMAN'" class="badge bg">HUMAN</span>                               
                                    <span v-else-if="item.transport_type == 'OTHER'" class="badge bg">OTHER</span>                               
                                </td>
                                <td>{{item.harvest_quantity}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editsubtransportModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubHarvestingTransportCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Subsistence Transport Modal -->
                        <div class="modal fade" id="subTransport" tabindex="-1" role="dialog" aria-labelledby="subTransport" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Transport Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Transport Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubHarvestingTransportCost() : createsubHarvestingTransportCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop To Plant</label>
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
                                            <label>Means of Transport</label>  
                                                    <input type="text" list="transports" v-model="form.transport_type" id="transport_type"
                                                    name="transport_type" class="form-control" :class="{ 'is-invalid': form.errors.has('transport_type') }" />
                                                    <datalist id="transports">
                                                    <option value="">Select Transport Means</option>
                                                    <option value="TRACTOR">Tractor</option>
                                                    <option value="MOTORBIKE">Motorbike</option>
                                                    <option value="DONKEY">Donkey</option>
                                                    <option value="HUMAN">Human</option>
                                                    <option value="OTHER">Other</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('transport_type')" v-html="form.errors.get('transport_type')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Date of Transaction</label>
                                            <input v-model="form.date_of_transaction" type="date" name="date_of_transaction"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_transaction') }">
                                                <div v-if="form.errors.has('date_of_transaction')" v-html="form.errors.get('date_of_transaction')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Harvest Transported</label>
                                            <input v-model="form.harvest_quantity" type="text" name="harvest_quantity" placeholder="approx quantity (e.g 5 trailers)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('harvest_quantity') }">
                                                <div v-if="form.errors.has('harvest_quantity')" v-html="form.errors.get('harvest_quantity')" /> 
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
                        <pagination :data="subharvestingtransportcosts" @pagination-change-page="getsubHarvestingTransportCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Harv. Labour Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="sublabourModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                       
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date</th>
                                <th>Person(s)</th>
                                <th>Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subharvestinglabourcosts.data" :key="item.id">
                                <td>{{item.date_of_work}}</td>
                                <td>{{item.no_of_persons}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                   
                                    <a href="#" @click="editsublabourModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubHarvestingLabourCost(item.id)">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Labour Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Labour Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubHarvestingLabourCost() : createsubHarvestingLabourCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
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
                        <pagination :data="subharvestinglabourcosts" @pagination-change-page="getsubHarvestingLabourCosts"></pagination>
                            </ul>
                        </div>                                                
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Harvesting Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
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
                                <tr v-for="item in subharvestingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubHarvestingOtherCost(item.id)">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit HarvestingOther Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubHarvestingOtherCost() : createsubHarvestingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to planting(e.g ploughing)"
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
                        <pagination :data="subharvestingothercosts" @pagination-change-page="getsubHarvestingOtherCosts"></pagination>
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
                            <h3 class="card-title">Harvesting Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cashcropModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Harv. Date</th>
                                <th>Crop Harv.</th>
                                <th>Acreage Harv.</th>
                                <th>Harvest Quantity</th>
                                <th>Tool(s) or Equipment</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashharvestingdetails.data" :key="item.id">
                                <td>{{item.date_of_harvesting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_harvested}}</td>
                                <td>{{item.harvest_quantity}}  </td>
                                <td>
                                    <span v-if="item.tools_used == 'KNIFE'" class="badge bg-danger">KNIFE</span>
                                    <span v-else-if="item.tools_used == 'JEMBE'" class="badge bg-success">JEMBE</span>
                                    <span v-else-if="item.tools_used == 'FORKJEMBE'" class="badge bg-info">FORKJEMBE</span>
                                    <span v-else-if="item.tools_used == 'HANDS'" class="badge bg-secondary">HANDS</span>
                                    <span v-else class="badge bg-primary">{{item.tools_used | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletecashHarvestingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- cash Crop Modal -->
                        <div class="modal fade" id="cashCrop" tabindex="-1" role="dialog" aria-labelledby="cashCrop" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashHarvestingDetail() : createcashHarvestingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
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
                                            <label>Date of Harvesting</label>
                                            <input v-model="form.date_of_harvesting" type="date" name="date_of_harvesting"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_harvesting') }">
                                                <div v-if="form.errors.has('date_of_harvesting')" v-html="form.errors.get('date_of_harvesting')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Tools or Equipment Used</label>  
                                                    <input type="text" list="tools" v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" class="form-control" :class="{ 'is-invalid': form.errors.has('tools_used') }" />
                                                    <datalist id="tools">
                                                    <option value="">Select Tool/Equipment Type</option>
                                                    <option value="KNIFE">Knife</option>
                                                    <option value="JEMBE">Jembe</option>
                                                    <option value="FORKJEMBE">Fork Jembe</option>
                                                    <option value="HANDS">Hands</option>
                                                    <option value="OTHER">Other</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Frequency/Quantity of Equipment Used</label>  
                                                    <textarea v-model="form.tools_usagerate" id="tools_usagerate"
                                                    name="tools_usagerate" placeholder="Brief description of the frequency e.g 2 trips by tractor(optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('tools_usagerate')" v-html="form.errors.get('tools_usagerate')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Harvest Realized</label>  
                                                    <textarea v-model="form.harvest_quantity" id="harvest_quantity"
                                                    name="harvest_quantity" placeholder="Brief description of the quantity(e.g 20 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('harvest_quantity')" v-html="form.errors.get('harvest_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Harvested</label>
                                            <input v-model="form.acreage_harvested" type="text" name="acreage_harvested" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage_harvested') }">
                                                <div v-if="form.errors.has('acreage_harvested')" v-html="form.errors.get('acreage_harvested')" /> 
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
                        <pagination :data="cashharvestingdetails" @pagination-change-page="getcashHarvestingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Harv. Transport Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cashtransportModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Means</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashharvestingtransportcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.transport_type == 'TRACTOR'" class="badge bg">TRACTOR</span>
                                    <span v-else-if="item.transport_type == 'MOTORBIKE'" class="badge bg">MOTORBIKE</span>
                                    <span v-else-if="item.transport_type == 'DONKEY'" class="badge bg">DONKEY</span>
                                    <span v-else-if="item.transport_type == 'HUMAN'" class="badge bg">HUMAN</span> 
                                    <span v-else-if="item.transport_type == 'OTHER'" class="badge bg">OTHER</span>                               
                                </td>
                                <td>{{item.harvest_quantity}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editcashtransportModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletecashHarvestingTransportCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- cashcrop Transport Modal -->
                        <div class="modal fade" id="cashTransport" tabindex="-1" role="dialog" aria-labelledby="cashTransport" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Transport Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Transport Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashHarvestingTransportCost() : createcashHarvestingTransportCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop To Harvest</label>
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
                                            <label>Means of Transport</label>  
                                                    <input type="text" list="transports" v-model="form.transport_type" id="transport_type"
                                                    name="transport_type" class="form-control" :class="{ 'is-invalid': form.errors.has('transport_type') }" />
                                                    <datalist id="transports">
                                                    <option value="">Select Transport Means</option>
                                                    <option value="TRACTOR">Tractor</option>
                                                    <option value="MOTORBIKE">Motorbike</option>
                                                    <option value="DONKEY">Donkey</option>
                                                    <option value="HUMAN">Human</option>
                                                    <option value="OTHER">Other</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('transport_type')" v-html="form.errors.get('transport_type')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Date of Transaction</label>
                                            <input v-model="form.date_of_transaction" type="date" name="date_of_transaction"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_transaction') }">
                                                <div v-if="form.errors.has('date_of_transaction')" v-html="form.errors.get('date_of_transaction')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Harvest Transported</label>
                                            <input v-model="form.harvest_quantity" type="text" name="harvest_quantity" placeholder="approx quantity (e.g 5 trailers)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('harvest_quantity') }">
                                                <div v-if="form.errors.has('harvest_quantity')" v-html="form.errors.get('harvest_quantity')" /> 
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
                        <pagination :data="cashharvestingtransportcosts" @pagination-change-page="getcashHarvestingTransportCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Harv. Labour Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cashlabourModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                       
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date</th>
                                <th>Person(s)</th>
                                <th>Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashharvestinglabourcosts.data" :key="item.id">
                                <td>{{item.date_of_work}}</td>
                                <td>{{item.no_of_persons}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                   
                                    <a href="#" @click="editcashlabourModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletecashHarvestingLabourCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- cashcrop Labour Modal -->
                        <div class="modal fade" id="cashLabour" tabindex="-1" role="dialog" aria-labelledby="cashLabour" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Labour Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Labour Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashHarvestingLabourCost() : createcashHarvestingLabourCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
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
                        <pagination :data="cashharvestinglabourcosts" @pagination-change-page="getcashHarvestingLabourCosts"></pagination>
                            </ul>
                        </div>                                                
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Harvesting Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cashothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
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
                                <tr v-for="item in cashharvestingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletecashHarvestingOtherCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- cash Other Cost Modal -->
                        <div class="modal fade" id="cashOtherCost" tabindex="-1" role="dialog" aria-labelledby="cashOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit HarvestingOther Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashHarvestingOtherCost() : createcashHarvestingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to planting(e.g ploughing)"
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
                        <pagination :data="cashharvestingothercosts" @pagination-change-page="getcashHarvestingOtherCosts"></pagination>
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
                            <h3 class="card-title">Harvesting Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashcropModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Harv. Date</th>
                                <th>Crop Harv.</th>
                                <th>Acreage Harv.</th>
                                <th>Harvest Quantity</th>
                                <th>Tool(s) or Equipment</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashharvestingdetails.data" :key="item.id">
                                <td>{{item.date_of_harvesting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_harvested}}</td>
                                <td>{{item.harvest_quantity}}  </td>
                                <td>
                                    <span v-if="item.tools_used == 'KNIFE'" class="badge bg-danger">KNIFE</span>
                                    <span v-else-if="item.tools_used == 'JEMBE'" class="badge bg-success">JEMBE</span>
                                    <span v-else-if="item.tools_used == 'FORKJEMBE'" class="badge bg-info">FORKJEMBE</span>
                                    <span v-else-if="item.tools_used == 'HANDS'" class="badge bg-secondary">HANDS</span>
                                    <span v-else class="badge bg-primary">{{item.tools_used | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editsubcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubcashHarvestingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- subcash Crop Modal -->
                        <div class="modal fade" id="subcashCrop" tabindex="-1" role="dialog" aria-labelledby="subcashCrop" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashHarvestingDetail() : createsubcashHarvestingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
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
                                            <label>Date of Harvesting</label>
                                            <input v-model="form.date_of_harvesting" type="date" name="date_of_harvesting"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_harvesting') }">
                                                <div v-if="form.errors.has('date_of_harvesting')" v-html="form.errors.get('date_of_harvesting')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Tools or Equipment Used</label>  
                                                    <input type="text" list="harvesttools" v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" class="form-control" :class="{ 'is-invalid': form.errors.has('tools_used') }" />
                                                    <datalist id="harvesttools">
                                                    <option value="">Select Tool/Equipment Type</option>
                                                    <option value="KNIFE">Knife</option>
                                                    <option value="JEMBE">Jembe</option>
                                                    <option value="FORKJEMBE">Fork Jembe</option>
                                                    <option value="HANDS">Hands</option>
                                                    <option value="OTHER">Other</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Frequency/Quantity of Equipment Used</label>  
                                                    <textarea v-model="form.transports_usagerate" id="tools_usagerate"
                                                    name="tools_usagerate" placeholder="Brief description of the frequency e.g 2 trips by tractor(optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('tools_usagerate')" v-html="form.errors.get('tools_usagerate')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Harvest Realized</label>  
                                                    <textarea v-model="form.harvest_quantity" id="harvest_quantity"
                                                    name="harvest_quantity" placeholder="Brief description of the quantity(e.g 20 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('harvest_quantity')" v-html="form.errors.get('harvest_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Harvested</label>
                                            <input v-model="form.acreage_harvested" type="text" name="acreage_harvested" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage_harvested') }">
                                                <div v-if="form.errors.has('acreage_harvested')" v-html="form.errors.get('acreage_harvested')" /> 
                                        </div>                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="subcashmit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="subcashmit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="subcashharvestingdetails" @pagination-change-page="getsubcashHarvestingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Harv. Transport Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashtransportModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Means</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashharvestingtransportcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.transport_type == 'TRACTOR'" class="badge bg">TRACTOR</span>
                                    <span v-else-if="item.transport_type == 'MOTORBIKE'" class="badge bg">MOTORBIKE</span>
                                    <span v-else-if="item.transport_type == 'DONKEY'" class="badge bg">DONKEY</span>
                                    <span v-else-if="item.transport_type == 'HUMAN'" class="badge bg">HUMAN</span>  
                                    <span v-else-if="item.transport_type == 'OTHER'" class="badge bg">OTHER</span>                               
                                </td>
                                <td>{{item.harvest_quantity}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editsubcashtransportModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubcashHarvestingTransportCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- subcashcrop Transport Modal -->
                        <div class="modal fade" id="subcashTransport" tabindex="-1" role="dialog" aria-labelledby="subcashTransport" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Transport Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Transport Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashHarvestingTransportCost() : createsubcashHarvestingTransportCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop To Plant</label>
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
                                            <label>Means of Transport</label>  
                                                    <input type="text" list="transports" v-model="form.transport_type" id="transport_type"
                                                    name="transport_type" class="form-control" :class="{ 'is-invalid': form.errors.has('transport_type') }" />
                                                    <datalist id="transports">
                                                    <option value="">Select Transport Means</option>
                                                    <option value="TRACTOR">Tractor</option>
                                                    <option value="MOTORBIKE">Motorbike</option>
                                                    <option value="DONKEY">Donkey</option>
                                                    <option value="HUMAN">Human</option>
                                                    <option value="OTHER">Other</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('transport_type')" v-html="form.errors.get('transport_type')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Date of Transaction</label>
                                            <input v-model="form.date_of_transaction" type="date" name="date_of_transaction"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_transaction') }">
                                                <div v-if="form.errors.has('date_of_transaction')" v-html="form.errors.get('date_of_transaction')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Harvest Transported</label>
                                            <input v-model="form.harvest_quantity" type="text" name="harvest_quantity" placeholder="approx quantity (e.g 5 trailers)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('harvest_quantity') }">
                                                <div v-if="form.errors.has('harvest_quantity')" v-html="form.errors.get('harvest_quantity')" /> 
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
                        <pagination :data="subcashharvestingtransportcosts" @pagination-change-page="getsubcashHarvestingTransportCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Harv. Labour Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashlabourModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                       
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date</th>
                                <th>Person(s)</th>
                                <th>Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashharvestinglabourcosts.data" :key="item.id">
                                <td>{{item.date_of_work}}</td>
                                <td>{{item.no_of_persons}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                   
                                    <a href="#" @click="editsubcashlabourModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubcashHarvestingLabourCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- subcashcrop Labour Modal -->
                        <div class="modal fade" id="subcashLabour" tabindex="-1" role="dialog" aria-labelledby="subcashLabour" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Labour Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Harvesting Labour Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashHarvestingLabourCost() : createsubcashHarvestingLabourCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
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
                        <pagination :data="subcashharvestinglabourcosts" @pagination-change-page="getsubcashHarvestingLabourCosts"></pagination>
                            </ul>
                        </div>                                                
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Harvesting Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-transport" data-card-widget="collapse">
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
                                <tr v-for="item in subcashharvestingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletesubcashHarvestingOtherCost(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- subcash Other Cost Modal -->
                        <div class="modal fade" id="subcashOtherCost" tabindex="-1" role="dialog" aria-labelledby="subcashOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Harvesting Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit HarvestingOther Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashHarvestingOtherCost() : createsubcashHarvestingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to planting(e.g ploughing)"
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
                        <pagination :data="subcashharvestingothercosts" @pagination-change-page="getsubcashHarvestingOtherCosts"></pagination>
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
                    date_of_harvesting: '',
                    acreage_harvested: '',
                    harvest_quantity: '',
                    amount_paid: '',
                    no_of_persons: '',
                    date_of_work: '',
                    transport_type: '',
                    trips_made: '',
                    tools_used: '',
                    tools_usagerate: '',
                    date_of_transaction: '',
                    date_of_payment: '',
                    name: ''
               }),
               subcropslist: {},
               subharvestingdetails: {},
               subharvestingtransportcosts: {},
               subharvestinglabourcosts: {},
               subharvestingothercosts: {},
               
               cashcropslist: {},
               cashharvestingdetails: {},
               cashharvestingtransportcosts: {},
               cashharvestinglabourcosts: {},
               cashharvestingothercosts: {},
               
               subcashcropslist: {},
               subcashharvestingdetails: {},
               subcashharvestingtransportcosts: {},
               subcashharvestinglabourcosts: {},
               subcashharvestingothercosts: {}                
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
            createsubHarvestingDetail(){
                this.$Progress.start();
                this.form.post('api/subharvestingdetail').then(() => {
                    $('#subCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Harvesting detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubHarvestingDetail(){
                this.$Progress.start();
                this.form.put('api/subharvestingdetail/'+this.form.id).then(() => {
                    $('#subCrop').modal('hide')
                    this.$$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Harvesting detail has been updated',
                        'success'
                    );                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubHarvestingDetail(id){
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
                  this.form.delete('api/subharvestingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Harvesting detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubHarvestingDetails');
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
            createsubHarvestingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subharvestinglabourcost').then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Labour cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubHarvestingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subharvestinglabourcost/'+this.form.id).then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Labour cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubHarvestingLabourCost(id){
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
                  this.form.delete('api/subharvestinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubHarvestingLabourCosts');
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
            subtransportModal(){
                this.editmode = false;
                this.form.reset();
                $('#subTransport').modal('show');
            },
            editsubtransportModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subTransport').modal('show');
                this.form.fill(item)
            },
            createsubHarvestingTransportCost(){
                this.$Progress.start();
                this.form.post('api/subharvestingtransportcost').then(() => {
                    $('#subTransport').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Transport cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingTransportCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubHarvestingTransportCost(){
                this.$Progress.start();
                this.form.put('api/subharvestingtransportcost/'+this.form.id).then(() => {
                    $('#subTransport').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Transport cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingTransportCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubHarvestingTransportCost(id){
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
                  this.form.delete('api/subharvestingtransportcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Transport cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubHarvestingTransportCosts');
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
            createsubHarvestingOtherCost(){
                this.$Progress.start();
                this.form.post('api/subharvestingothercost').then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubHarvestingOtherCost(){
                this.$Progress.start();
                this.form.put('api/subharvestingothercost/'+this.form.id).then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubHarvestingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubHarvestingOtherCost(id){
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
                  this.form.delete('api/subharvestingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubHarvestingOtherCosts');
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
            loadsubHarvestingDetails(){
                axios.get('api/subharvestingdetail').then((response) => {
                    this.subharvestingdetails = response.data
                });
            },
            loadsubHarvestingLabourCosts(){
                axios.get('api/subharvestinglabourcost').then((response) => {
                    this.subharvestinglabourcosts = response.data
                });
            },
            loadsubHarvestingTransportCosts(){
                axios.get('api/subharvestingtransportcost').then((response) => {
                    this.subharvestingtransportcosts = response.data
                });                
            },
            loadsubHarvestingOtherCosts(){
                axios.get('api/subharvestingothercost').then((response) => {
                    this.subharvestingothercosts = response.data
                });                
            },
            
            //pagination of subcrops
            getsubHarvestingDetails(page = 1){
			    axios.get('api/subharvestingdetail?page=' + page)
                    .then(response => {
                        this.subharvestingdetails = response.data;
				});                
            },
            getsubHarvestingTransportCosts(page = 1){
			    axios.get('api/subharvestingtransportcost?page=' + page)
                    .then(response => {
                        this.subharvestingtransportcosts = response.data;
				});                
            },
            getsubHarvestingLabourCosts(page = 1){
			    axios.get('api/subharvestinglabourcost?page=' + page)
                    .then(response => {
                        this.subharvestinglabourcosts = response.data;
				});                
            },
            getsubHarvestingOtherCosts(page = 1){
			    axios.get('api/subharvestingothercost?page=' + page)
                    .then(response => {
                        this.subharvestingothercosts = response.data;
				});                
            },
            
            //methods for cashcrops
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
            createcashHarvestingDetail(){
                this.$Progress.start();
                this.form.post('api/cashharvestingdetail').then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Harvesting detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatecashHarvestingDetail(){
                this.$Progress.start();
                this.form.put('api/cashharvestingdetail/'+this.form.id).then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Harvesting detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashHarvestingDetail(id){
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
                  this.form.delete('api/cashharvestingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Harvesting detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashHarvestingDetails');
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
            createcashHarvestingLabourCost(){
                this.$Progress.start();
                this.form.post('api/cashharvestinglabourcost').then(() => {
                    $('#cashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Labour cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatecashHarvestingLabourCost(){
                this.$Progress.start();
                this.form.put('api/cashharvestinglabourcost/'+this.form.id).then(() => {
                    $('#cashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Labour cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashHarvestingLabourCost(id){
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
                  this.form.delete('api/cashharvestinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashHarvestingLabourCosts');
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
            cashtransportModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashTransport').modal('show');
            },
            editcashtransportModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashTransport').modal('show');
                this.form.fill(item)
            },
            createcashHarvestingTransportCost(){
                this.$Progress.start();
                this.form.post('api/cashharvestingtransportcost').then(() => {
                    $('#cashTransport').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Transport cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingTransportCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatecashHarvestingTransportCost(){
                this.$Progress.start();
                this.form.put('api/cashharvestingtransportcost/'+this.form.id).then(() => {
                    $('#cashTransport').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Transport cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingTransportCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashHarvestingTransportCost(id){
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
                  this.form.delete('api/cashharvestingtransportcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Transport cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashHarvestingTransportCosts');
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
            createcashHarvestingOtherCost(){
                this.$Progress.start();
                this.form.post('api/cashharvestingothercost').then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatecashHarvestingOtherCost(){
                this.$Progress.start();
                this.form.put('api/cashharvestingothercost/'+this.form.id).then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashHarvestingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashHarvestingOtherCost(id){
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
                  this.form.delete('api/cashharvestingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashHarvestingOtherCosts');
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
            loadcashHarvestingDetails(){
                axios.get('api/cashharvestingdetail').then((response) => {
                    this.cashharvestingdetails = response.data
                });
            },
            loadcashHarvestingLabourCosts(){
                axios.get('api/cashharvestinglabourcost').then((response) => {
                    this.cashharvestinglabourcosts = response.data
                });
            },
            loadcashHarvestingTransportCosts(){
                axios.get('api/cashharvestingtransportcost').then((response) => {
                    this.cashharvestingtransportcosts = response.data
                });                
            },
            loadcashHarvestingOtherCosts(){
                axios.get('api/cashharvestingothercost').then((response) => {
                    this.cashharvestingothercosts = response.data
                });                
            },
            
            //pagination of cashcrops
            getcashHarvestingDetails(page = 1){
			    axios.get('api/cashharvestingdetail?page=' + page)
                    .then(response => {
                        this.cashharvestingdetails = response.data;
				});                
            },
            getcashHarvestingTransportCosts(page = 1){
			    axios.get('api/cashharvestingtransportcost?page=' + page)
                    .then(response => {
                        this.cashharvestingtransportcosts = response.data;
				});                
            },
            getcashHarvestingLabourCosts(page = 1){
			    axios.get('api/cashharvestinglabourcost?page=' + page)
                    .then(response => {
                        this.cashharvestinglabourcosts = response.data;
				});                
            },
            getcashHarvestingOtherCosts(page = 1){
			    axios.get('api/cashharvestingothercost?page=' + page)
                    .then(response => {
                        this.cashharvestingothercosts = response.data;
				});                
            },
            
            //methods for subcashcrops
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
            createsubcashHarvestingDetail(){
                this.$Progress.start();
                this.form.post('api/subcashharvestingdetail').then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Harvesting detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubcashHarvestingDetail(){
                this.$Progress.start();
                this.form.put('api/subcashharvestingdetail/'+this.form.id).then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Harvesting detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashHarvestingDetail(id){
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
                  this.form.delete('api/subcashharvestingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Harvesting detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashHarvestingDetails');
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
            createsubcashHarvestingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subcashharvestinglabourcost').then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Labour cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubcashHarvestingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subcashharvestinglabourcost/'+this.form.id).then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Labour cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashHarvestingLabourCost(id){
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
                  this.form.delete('api/subcashharvestinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashHarvestingLabourCosts');
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
            subcashtransportModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashTransport').modal('show');
            },
            editsubcashtransportModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashTransport').modal('show');
                this.form.fill(item)
            },
            createsubcashHarvestingTransportCost(){
                this.$Progress.start();
                this.form.post('api/subcashharvestingtransportcost').then(() => {
                    $('#subcashTransport').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Transport cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingTransportCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubcashHarvestingTransportCost(){
                this.$Progress.start();
                this.form.put('api/subcashharvestingtransportcost/'+this.form.id).then(() => {
                    $('#subcashTransport').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Transport cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingTransportCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashHarvestingTransportCost(id){
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
                  this.form.delete('api/subcashharvestingtransportcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Transport cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashHarvestingTransportCosts');
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
            createsubcashHarvestingOtherCost(){
                this.$Progress.start();
                this.form.post('api/subcashharvestingothercost').then(() => {
                    $('#subcashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubcashHarvestingOtherCost(){
                this.$Progress.start();
                this.form.put('api/subcashharvestingothercost/'+this.form.id).then(() => {
                    $('#subcashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashHarvestingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashHarvestingOtherCost(id){
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
                  this.form.delete('api/subcashharvestingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashHarvestingOtherCosts');
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
            loadsubcashHarvestingDetails(){
                axios.get('api/subcashharvestingdetail').then((response) => {
                    this.subcashharvestingdetails = response.data
                });
            },
            loadsubcashHarvestingLabourCosts(){
                axios.get('api/subcashharvestinglabourcost').then((response) => {
                    this.subcashharvestinglabourcosts = response.data
                });
            },
            loadsubcashHarvestingTransportCosts(){
                axios.get('api/subcashharvestingtransportcost').then((response) => {
                    this.subcashharvestingtransportcosts = response.data
                });                
            },
            loadsubcashHarvestingOtherCosts(){
                axios.get('api/subcashharvestingothercost').then((response) => {
                    this.subcashharvestingothercosts = response.data
                });                
            },
            
            //pagination of subcashcrops
            getsubcashHarvestingDetails(page = 1){
			    axios.get('api/subcashharvestingdetail?page=' + page)
                    .then(response => {
                        this.subcashharvestingdetails = response.data;
				});                
            },
            getsubcashHarvestingTransportCosts(page = 1){
			    axios.get('api/subcashharvestingtransportcost?page=' + page)
                    .then(response => {
                        this.subcashharvestingtransportcosts = response.data;
				});                
            },
            getsubcashHarvestingLabourCosts(page = 1){
			    axios.get('api/subcashharvestinglabourcost?page=' + page)
                    .then(response => {
                        this.subcashharvestinglabourcosts = response.data;
				});                
            },
            getsubcashHarvestingOtherCosts(page = 1){
			    axios.get('api/subcashharvestingothercost?page=' + page)
                    .then(response => {
                        this.subcashharvestingothercosts = response.data;
				});                
            },            

        },
        mounted() {
            this.listsubCrops();
            this.loadsubHarvestingDetails();
            this.loadsubHarvestingTransportCosts();
            this.loadsubHarvestingLabourCosts();
            this.loadsubHarvestingOtherCosts();
             
            //events
            Fire.$on('RefreshsubHarvestingOtherCosts',() => {
                this.loadsubHarvestingOtherCosts();
            });
            Fire.$on('RefreshsubHarvestingLabourCosts',() => {
                this.loadsubHarvestingLabourCosts();
            });
            Fire.$on('RefreshsubHarvestingTransportCosts',() => {
                this.loadsubHarvestingTransportCosts();
            });
            Fire.$on('RefreshsubHarvestingDetails',() => {
                this.loadsubHarvestingDetails();
            });

            //cashcrops
            this.listcashCrops();
            this.loadcashHarvestingDetails();
            this.loadcashHarvestingTransportCosts();
            this.loadcashHarvestingLabourCosts();
            this.loadcashHarvestingOtherCosts();
             
            //events
            Fire.$on('RefreshcashHarvestingOtherCosts',() => {
                this.loadcashHarvestingOtherCosts();
            });
            Fire.$on('RefreshcashHarvestingLabourCosts',() => {
                this.loadcashHarvestingLabourCosts();
            });
            Fire.$on('RefreshcashHarvestingTransportCosts',() => {
                this.loadcashHarvestingTransportCosts();
            });
            Fire.$on('RefreshcashHarvestingDetails',() => {
                this.loadcashHarvestingDetails();
            });
            
            //subcashcrops
            this.listsubcashCrops();
            this.loadsubcashHarvestingDetails();
            this.loadsubcashHarvestingTransportCosts();
            this.loadsubcashHarvestingLabourCosts();
            this.loadsubcashHarvestingOtherCosts();
             
            //events
            Fire.$on('RefreshsubcashHarvestingOtherCosts',() => {
                this.loadsubcashHarvestingOtherCosts();
            });
            Fire.$on('RefreshsubcashHarvestingLabourCosts',() => {
                this.loadsubcashHarvestingLabourCosts();
            });
            Fire.$on('RefreshsubcashHarvestingTransportCosts',() => {
                this.loadsubcashHarvestingTransportCosts();
            });
            Fire.$on('RefreshsubcashHarvestingDetails',() => {
                this.loadsubcashHarvestingDetails();
            });            
            
            
            console.log('Component mounted.')
        }
    }
</script>
