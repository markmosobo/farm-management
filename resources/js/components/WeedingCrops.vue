<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Weeding Records</h3>
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
                            <h3 class="card-title">Weeding Details</h3>
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
                                <th style="width: 10px">Date of Weeding</th>
                                <th>Crop Weeded</th>
                                <th>Acreage Weeded</th>
                                <th>Tools and Equipment</th>
                                <th>Chemical Applied</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subweedingdetails.data" :key="item.id">
                                <td>{{item.date_of_weeding}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_weeded}}</td>
                                <td>{{item.tools_used | capitalizeFirstLetter}} </td>
                                <td>
                                    <span v-if="item.chemical_type == 'ROUNDUP'" class="badge bg-danger">ROUNDUP</span>
                                    <span v-else-if="item.chemical_type == 'NONE'" class="badge bg-success">NONE</span>
                                    <span v-else class="badge bg-primary">{{item.chemical_type | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editsubcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubWeedingDetail(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Weeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Weeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubWeedingDetail() : createsubWeedingDetail()">
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
                                            <label>Date of Weeding</label>
                                            <input v-model="form.date_of_weeding" type="date" name="date_of_weeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_weeding') }">
                                                <div v-if="form.errors.has('date_of_weeding')" v-html="form.errors.get('date_of_weeding')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Chemical Applied</label>  
                                                    <input type="text" list="chemicals" v-model="form.chemical_type" id="chemical_type"
                                                    name="chemical_type" class="form-control" :class="{ 'is-invalid': form.errors.has('chemical_type') }" />
                                                    <datalist id= "chemicals">
                                                    <option value="">Select Chemical Type</option>
                                                    <option value="NONE">NO CHEMICALS USED</option>
                                                    <option value="ROUNDUP">ROUNDUP</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('chemical_type')" v-html="form.errors.get('chemical_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Chemical Applied</label>  
                                                    <textarea v-model="form.chemical_quantity" id="chemical_quantity"
                                                    name="chemical_quantity" placeholder="Brief description of the quantity e.g 20 grams(optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('chemical_quantity')" v-html="form.errors.get('chemical_quantity')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Tool(s) Used</label>  
                                                    <textarea v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" placeholder="Brief description of the quantity(e.g Knapsacksprayer)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Weeded</label>
                                            <input v-model="form.acreage_weeded" type="text" name="acreage_weeded" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage_weeded') }">
                                                <div v-if="form.errors.has('acreage_weeded')" v-html="form.errors.get('acreage_weeded')" /> 
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
                            <pagination :data="subweedingdetails" @pagination-change-page="getsubWeedingDetails"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Weeding Costs</h3>
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
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subweedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubWeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Weeding Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Weeding Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubWeedingOtherCost() : createsubWeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to weeding(e.g ploughing)"
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
                            <pagination :data="subweedingothercosts" @pagination-change-page="getsubWeedingOtherCosts"></pagination>
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
                            <h3 class="card-title">Weeding Details</h3>
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
                                <th style="width: 10px">Date of Weeding</th>
                                <th>Crop Weeded</th>
                                <th>Acreage Weeded</th>
                                <th>Tools and Equipment</th>
                                <th>Chemical Applied</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashweedingdetails.data" :key="item.id">
                                <td>{{item.date_of_weeding}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_weeded}}</td>
                                <td>{{item.tools_used | capitalizeFirstLetter}} </td>
                                <td>
                                    <span v-if="item.chemical_type == 'ROUNDUP'" class="badge bg-danger">ROUNDUP</span>
                                    <span v-else-if="item.chemical_type == 'NONE'" class="badge bg-success">NONE</span>
                                    <span v-else class="badge bg-primary">{{item.chemical_type | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletecashWeedingDetail(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Weeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Weeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashWeedingDetail() : createcashWeedingDetail()">
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
                                            <label>Date of Weeding</label>
                                            <input v-model="form.date_of_weeding" type="date" name="date_of_weeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_weeding') }">
                                                <div v-if="form.errors.has('date_of_weeding')" v-html="form.errors.get('date_of_weeding')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Chemical Applied</label>  
                                                    <input type="text" list="chemicals" v-model="form.chemical_type" id="chemical_type"
                                                    name="chemical_type" class="form-control" :class="{ 'is-invalid': form.errors.has('chemical_type') }" />
                                                    <datalist id= "chemicals">
                                                    <option value="">Select Chemical Type</option>
                                                    <option value="NONE">NO CHEMICALS USED</option>
                                                    <option value="ROUNDUP">ROUNDUP</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('chemical_type')" v-html="form.errors.get('chemical_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Chemical Applied</label>  
                                                    <textarea v-model="form.chemical_quantity" id="chemical_quantity"
                                                    name="chemical_quantity" placeholder="Brief description of the quantity e.g 20 grams(optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('chemical_quantity')" v-html="form.errors.get('chemical_quantity')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Tool(s) Used</label>  
                                                    <textarea v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" placeholder="Brief description of the quantity(e.g Knapsacksprayer)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Weeded</label>
                                            <input v-model="form.acreage_weeded" type="text" name="acreage_weeded" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage_weeded') }">
                                                <div v-if="form.errors.has('acreage_weeded')" v-html="form.errors.get('acreage_weeded')" /> 
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
                            <pagination :data="cashweedingdetails" @pagination-change-page="getcashWeedingDetails"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                         

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Weeding Costs</h3>
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
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashweedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletecashWeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Weeding Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Weeding Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashWeedingOtherCost() : createcashWeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to weeding(e.g ploughing)"
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
                            <pagination :data="cashweedingothercosts" @pagination-change-page="getcashWeedingOtherCosts"></pagination>
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
                            <h3 class="card-title">Weeding Details</h3>
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
                                <th style="width: 10px">Date of Weeding</th>
                                <th>Crop Weeded</th>
                                <th>Acreage Weeded</th>
                                <th>Tools and Equipment</th>
                                <th>Chemical Applied</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashweedingdetails.data" :key="item.id">
                                <td>{{item.date_of_weeding}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_weeded}}</td>
                                <td>{{item.tools_used | capitalizeFirstLetter}} </td>
                                <td>
                                    <span v-if="item.chemical_type == 'ROUNDUP'" class="badge bg-danger">ROUNDUP</span>
                                    <span v-else-if="item.chemical_type == 'NONE'" class="badge bg-success">NONE</span>
                                    <span v-else class="badge bg-primary">{{item.chemical_type | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editsubcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashWeedingDetail(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Weeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Weeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashWeedingDetail() : createsubcashWeedingDetail()">
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
                                            <label>Date of Weeding</label>
                                            <input v-model="form.date_of_weeding" type="date" name="date_of_weeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_weeding') }">
                                                <div v-if="form.errors.has('date_of_weeding')" v-html="form.errors.get('date_of_weeding')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Chemical Applied</label>  
                                                    <input type="text" list="chemicals" v-model="form.chemical_type" id="chemical_type"
                                                    name="chemical_type" class="form-control" :class="{ 'is-invalid': form.errors.has('chemical_type') }" />
                                                    <datalist id= "chemicals">
                                                    <option value="">Select Chemical Type</option>
                                                    <option value="NONE">NO CHEMICALS USED</option>
                                                    <option value="ROUNDUP">ROUNDUP</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('chemical_type')" v-html="form.errors.get('chemical_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Chemical Applied</label>  
                                                    <textarea v-model="form.chemical_quantity" id="chemical_quantity"
                                                    name="chemical_quantity" placeholder="Brief description of the quantity e.g 20 grams(optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('chemical_quantity')" v-html="form.errors.get('chemical_quantity')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Tool(s) Used</label>  
                                                    <textarea v-model="form.tools_used" id="tools_used"
                                                    name="tools_used" placeholder="Brief description of the quantity(e.g Knapsacksprayer)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('tools_used')" v-html="form.errors.get('tools_used')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Weeded</label>
                                            <input v-model="form.acreage_weeded" type="text" name="acreage_weeded" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage_weeded') }">
                                                <div v-if="form.errors.has('acreage_weeded')" v-html="form.errors.get('acreage_weeded')" /> 
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
                            <pagination :data="subcashweedingdetails" @pagination-change-page="getsubcashWeedingDetails"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                         

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Weeding Costs</h3>
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
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashweedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashWeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Weeding Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Weeding Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashWeedingOtherCost() : createsubcashWeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity related to weeding(e.g ploughing)"
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
                            <pagination :data="subcashweedingothercosts" @pagination-change-page="getsubcashWeedingOtherCosts"></pagination>
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
                    date_of_weeding: '',
                    acreage_weeded: '',
                    tools_used: '',
                    chemical_quantity: '',
                    chemical_type: '',
                    date_of_purchase: '',
                    amount_paid: '',
                    tool_type: '',
                    quantity_bought: ''
               }),
               subcropslist: {}, 
               subweedingdetails: {},
               subweedinglabourcosts: {},
               subweedingchemicalcosts: {},
               subweedingothercosts: {},
               subweedingtoolcosts: {},

               cashcropslist: {}, 
               cashweedingdetails: {},
               cashweedinglabourcosts: {},
               cashweedingchemicalcosts: {},
               cashweedingothercosts: {},
               cashweedingtoolcosts: {},

               subcashcropslist: {}, 
               subcashweedingdetails: {},
               subcashweedinglabourcosts: {},
               subcashweedingchemicalcosts: {},
               subcashweedingothercosts: {},
               subcashweedingtoolcosts: {}                             
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
            createsubWeedingDetail(){
                this.$Progress.start();
                this.form.post('api/subweedingdetail').then(() => {
                    $('#subCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Weeding detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubWeedingDetail(){
                this.$Progress.start();
                this.form.put('api/subweedingdetail/'+this.form.id).then(() => {
                    $('#subCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Weeding detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubWeedingDetail(id){
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
                  this.form.delete('api/subweedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Weeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubWeedingDetails');
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
            createsubWeedingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subweedinglabourcost').then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Labour cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubWeedingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subweedinglabourcost/'+this.form.id).then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Labour cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubWeedingLabourCost(id){
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
                  this.form.delete('api/subweedinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubWeedingLabourCosts');
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
            subchemicalModal(){
                this.editmode = false;
                this.form.reset();
                $('#subChemical').modal('show');
            },
            editsubchemicalModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subChemical').modal('show');
                this.form.fill(item)
            },
            createsubWeedingChemicalCost(){
                this.$Progress.start();
                this.form.post('api/subweedingchemicalcost').then(() => {
                    $('#subChemical').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Chemical cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingChemicalCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubWeedingChemicalCost(){
                this.$Progress.start();
                this.form.put('api/subweedingchemicalcost/'+this.form.id).then(() => {
                    $('#subChemical').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Chemical cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingChemicalCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubWeedingChemicalCost(id){
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
                  this.form.delete('api/subweedingchemicalcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Chemical cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubWeedingChemicalCosts');
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
            createsubWeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/subweedingothercost').then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubWeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/subweedingothercost/'+this.form.id).then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubWeedingOtherCost(id){
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
                  this.form.delete('api/subweedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubWeedingOtherCosts');
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
            subtoolModal(){
                this.editmode = false;
                this.form.reset();
                $('#subTool').modal('show');
            },
            editsubtoolModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subTool').modal('show');
                this.form.fill(item)
            }, 
            createsubWeedingToolCost(){
                this.$Progress.start();
                this.form.post('api/subweedingtoolcost').then(() => {
                    $('#subTool').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Tool cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingToolCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubWeedingToolCost(){
                this.$Progress.start();
                this.form.put('api/subweedingtoolcost/'+this.form.id).then(() => {
                    $('#subTool').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Tool cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubWeedingToolCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubWeedingToolCost(id){
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
                  this.form.delete('api/subweedingtoolcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Tool cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubWeedingToolCosts');
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
            loadsubWeedingDetails(){
                axios.get('api/subweedingdetail').then((response) => {
                    this.subweedingdetails = response.data
                });
            },
            loadsubWeedingLabourCosts(){
                axios.get('api/subweedinglabourcost').then((response) => {
                    this.subweedinglabourcosts = response.data
                });
            },
            loadsubWeedingChemicalCosts(){
                axios.get('api/subweedingchemicalcost').then((response) => {
                    this.subweedingchemicalcosts = response.data
                });                
            },
            loadsubWeedingOtherCosts(){
                axios.get('api/subweedingothercost').then((response) => {
                    this.subweedingothercosts = response.data
                });                
            },
            loadsubWeedingToolCosts(){
                axios.get('api/subweedingtoolcost').then((response) => {
                    this.subweedingtoolcosts = response.data
                });                
            },

            //pagination of subcrops
            getsubWeedingDetails(page = 1){
			    axios.get('api/subweedingdetail?page=' + page)
                    .then(response => {
                        this.subweedingdetails = response.data;
				});                
            },
            getsubWeedingChemicalCosts(page = 1){
			    axios.get('api/subweedingchemicalcost?page=' + page)
                    .then(response => {
                        this.subweedingchemicals = response.data;
				});                
            },
            getsubWeedingToolCosts(page = 1){
			    axios.get('api/subweedingtoolcost?page=' + page)
                    .then(response => {
                        this.subweedingtoolcosts = response.data;
				});                
            },
            getsubWeedingLabourCosts(page = 1){
			    axios.get('api/subweedinglabourcost?page=' + page)
                    .then(response => {
                        this.subweedinglabourcosts = response.data;
				});                
            },
            getsubWeedingOtherCosts(page = 1){
			    axios.get('api/subweedingothercost?page=' + page)
                    .then(response => {
                        this.subweedingothercosts = response.data;
				});                
            },                                                
            
            //cash crop methods
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
            createcashWeedingDetail(){
                this.$Progress.start();
                this.form.post('api/cashweedingdetail').then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Weeding detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatecashWeedingDetail(){
                this.$Progress.start();
                this.form.put('api/cashweedingdetail/'+this.form.id).then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Weeding detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashWeedingDetail(id){
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
                  this.form.delete('api/cashweedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Weeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashWeedingDetails');
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
            createcashWeedingLabourCost(){
                this.$Progress.start();
                this.form.post('api/cashweedinglabourcost').then(() => {
                    $('#cashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Labour cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatecashWeedingLabourCost(){
                this.$Progress.start();
                this.form.put('api/cashweedinglabourcost/'+this.form.id).then(() => {
                    $('#cashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Labour cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashWeedingLabourCost(id){
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
                  this.form.delete('api/cashweedinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashWeedingLabourCosts');
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
            cashchemicalModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashChemical').modal('show');
            },
            editcashchemicalModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashChemical').modal('show');
                this.form.fill(item)
            },
            createcashWeedingChemicalCost(){
                this.$Progress.start();
                this.form.post('api/cashweedingchemicalcost').then(() => {
                    $('#cashChemical').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Chemical cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingChemicalCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatecashWeedingChemicalCost(){
                this.$Progress.start();
                this.form.put('api/cashweedingchemicalcost/'+this.form.id).then(() => {
                    $('#cashChemical').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Chemical cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingChemicalCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashWeedingChemicalCost(id){
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
                  this.form.delete('api/cashweedingchemicalcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Chemical cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashWeedingChemicalCosts');
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
            createcashWeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/cashweedingothercost').then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatecashWeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/cashweedingothercost/'+this.form.id).then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashWeedingOtherCost(id){
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
                  this.form.delete('api/cashweedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashWeedingOtherCosts');
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
            cashtoolModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashTool').modal('show');
            },
            editcashtoolModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashTool').modal('show');
                this.form.fill(item)
            }, 
            createcashWeedingToolCost(){
                this.$Progress.start();
                this.form.post('api/cashweedingtoolcost').then(() => {
                    $('#cashTool').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Tool cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingToolCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatecashWeedingToolCost(){
                this.$Progress.start();
                this.form.put('api/cashweedingtoolcost/'+this.form.id).then(() => {
                    $('#cashTool').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Tool cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshcashWeedingToolCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletecashWeedingToolCost(id){
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
                  this.form.delete('api/cashweedingtoolcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Tool cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashWeedingToolCosts');
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
            loadcashWeedingDetails(){
                axios.get('api/cashweedingdetail').then((response) => {
                    this.cashweedingdetails = response.data
                });
            },
            loadcashWeedingLabourCosts(){
                axios.get('api/cashweedinglabourcost').then((response) => {
                    this.cashweedinglabourcosts = response.data
                });
            },
            loadcashWeedingChemicalCosts(){
                axios.get('api/cashweedingchemicalcost').then((response) => {
                    this.cashweedingchemicalcosts = response.data
                });                
            },
            loadcashWeedingOtherCosts(){
                axios.get('api/cashweedingothercost').then((response) => {
                    this.cashweedingothercosts = response.data
                });                
            },
            loadcashWeedingToolCosts(){
                axios.get('api/cashweedingtoolcost').then((response) => {
                    this.cashweedingtoolcosts = response.data
                });                
            },

            //pagination of cashcrops
            getcashWeedingDetails(page = 1){
			    axios.get('api/cashweedingdetail?page=' + page)
                    .then(response => {
                        this.cashweedingdetails = response.data;
				});                
            },
            getcashWeedingChemicalCosts(page = 1){
			    axios.get('api/cashweedingchemicalcost?page=' + page)
                    .then(response => {
                        this.cashweedingchemicals = response.data;
				});                
            },
            getcashWeedingToolCosts(page = 1){
			    axios.get('api/cashweedingtoolcost?page=' + page)
                    .then(response => {
                        this.cashweedingtoolcosts = response.data;
				});                
            },
            getcashWeedingLabourCosts(page = 1){
			    axios.get('api/cashweedinglabourcost?page=' + page)
                    .then(response => {
                        this.cashweedinglabourcosts = response.data;
				});                
            },
            getcashWeedingOtherCosts(page = 1){
			    axios.get('api/cashweedingothercost?page=' + page)
                    .then(response => {
                        this.cashweedingothercosts = response.data;
				});                
            },            
            
            //subcashcrop methods
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
            createsubcashWeedingDetail(){
                this.$Progress.start();
                this.form.post('api/subcashweedingdetail').then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Weeding detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubcashWeedingDetail(){
                this.$Progress.start();
                this.form.put('api/subcashweedingdetail/'+this.form.id).then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Weeding detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashWeedingDetail(id){
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
                  this.form.delete('api/subcashweedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Weeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashWeedingDetails');
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
            createsubcashWeedingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subcashweedinglabourcost').then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Labour cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubcashWeedingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subcashweedinglabourcost/'+this.form.id).then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Labour cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingLabourCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashWeedingLabourCost(id){
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
                  this.form.delete('api/subcashweedinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashWeedingLabourCosts');
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
            subcashchemicalModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashChemical').modal('show');
            },
            editsubcashchemicalModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashChemical').modal('show');
                this.form.fill(item)
            },
            createsubcashWeedingChemicalCost(){
                this.$Progress.start();
                this.form.post('api/subcashweedingchemicalcost').then(() => {
                    $('#subcashChemical').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Chemical cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingChemicalCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubcashWeedingChemicalCost(){
                this.$Progress.start();
                this.form.put('api/subcashweedingchemicalcost/'+this.form.id).then(() => {
                    $('#subcashChemical').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Chemical cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingChemicalCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashWeedingChemicalCost(id){
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
                  this.form.delete('api/subcashweedingchemicalcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Chemical cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashWeedingChemicalCosts');
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
            createsubcashWeedingOtherCost(){
                this.form.post('api/subcashweedingothercost').then(() => {
                    $('#subcashOtherCost').modal('hide')
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            updatesubcashWeedingOtherCost(){
                this.form.put('api/subcashweedingothercost/'+this.form.id).then(() => {
                    $('#subcashOtherCost').modal('hide')
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashWeedingOtherCost(id){
                this.form.delete('api/subcashweedingothercost/'+id).then(() => {
                    console.log('deleted')
                    Fire.$emit('RefreshsubcashWeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            subcashtoolModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashTool').modal('show');
            },
            editsubcashtoolModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashTool').modal('show');
                this.form.fill(item)
            }, 
            createsubcashWeedingToolCost(){
                this.$Progress.start();
                this.form.post('api/subcashweedingtoolcost').then(() => {
                    $('#subcashTool').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Tool cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingToolCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubcashWeedingToolCost(){
                this.$Progress.start();
                this.form.put('api/subcashweedingtoolcost/'+this.form.id).then(() => {
                    $('#subcashTool').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Tool cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshsubcashWeedingToolCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashWeedingToolCost(id){
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
                  this.form.delete('api/subcashweedingtoolcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Chemical cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashWeedingToolCosts');
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
            loadsubcashWeedingDetails(){
                axios.get('api/subcashweedingdetail').then((response) => {
                    this.subcashweedingdetails = response.data
                });
            },
            loadsubcashWeedingLabourCosts(){
                axios.get('api/subcashweedinglabourcost').then((response) => {
                    this.subcashweedinglabourcosts = response.data
                });
            },
            loadsubcashWeedingChemicalCosts(){
                axios.get('api/subcashweedingchemicalcost').then((response) => {
                    this.subcashweedingchemicalcosts = response.data
                });                
            },
            loadsubcashWeedingOtherCosts(){
                axios.get('api/subcashweedingothercost').then((response) => {
                    this.subcashweedingothercosts = response.data
                });                
            },
            loadsubcashWeedingToolCosts(){
                axios.get('api/subcashweedingtoolcost').then((response) => {
                    this.subcashweedingtoolcosts = response.data
                });                
            },
            
            //pagination of subcashcrops
            getsubcashWeedingDetails(page = 1){
			    axios.get('api/subcashweedingdetail?page=' + page)
                    .then(response => {
                        this.subcashweedingdetails = response.data;
				});                
            },
            getsubcashWeedingChemicalCosts(page = 1){
			    axios.get('api/subcashweedingchemicalcost?page=' + page)
                    .then(response => {
                        this.subcashweedingchemicals = response.data;
				});                
            },
            getsubcashWeedingToolCosts(page = 1){
			    axios.get('api/subcashweedingtoolcost?page=' + page)
                    .then(response => {
                        this.subcashweedingtoolcosts = response.data;
				});                
            },
            getsubcashWeedingLabourCosts(page = 1){
			    axios.get('api/subcashweedinglabourcost?page=' + page)
                    .then(response => {
                        this.subcashweedinglabourcosts = response.data;
				});                
            },
            getsubcashWeedingOtherCosts(page = 1){
			    axios.get('api/subcashweedingothercost?page=' + page)
                    .then(response => {
                        this.subcashweedingothercosts = response.data;
				});                
            }            
        },
        mounted() {
            this.listsubCrops();
            this.loadsubWeedingDetails();
            this.loadsubWeedingChemicalCosts();
            this.loadsubWeedingLabourCosts();
            this.loadsubWeedingOtherCosts();
            this.loadsubWeedingToolCosts(); 
            
            //events
            Fire.$on('RefreshsubWeedingToolCosts',() => {
                this.loadsubWeedingToolCosts();
            });
            Fire.$on('RefreshsubWeedingOtherCosts',() => {
                this.loadsubWeedingOtherCosts();
            });
            Fire.$on('RefreshsubWeedingLabourCosts',() => {
                this.loadsubWeedingLabourCosts();
            });
            Fire.$on('RefreshsubWeedingChemicalCosts',() => {
                this.loadsubWeedingChemicalCosts();
            });
            Fire.$on('RefreshsubWeedingDetails',() => {
                this.loadsubWeedingDetails();
            });

            this.listcashCrops();
            this.loadcashWeedingDetails();
            this.loadcashWeedingChemicalCosts();
            this.loadcashWeedingLabourCosts();
            this.loadcashWeedingOtherCosts();
            this.loadcashWeedingToolCosts(); 
            
            //event listeners for cashcrops
            Fire.$on('RefreshcashWeedingToolCosts',() => {
                this.loadcashWeedingToolCosts();
            });
            Fire.$on('RefreshcashWeedingOtherCosts',() => {
                this.loadcashWeedingOtherCosts();
            });
            Fire.$on('RefreshcashWeedingLabourCosts',() => {
                this.loadcashWeedingLabourCosts();
            });
            Fire.$on('RefreshcashWeedingChemicalCosts',() => {
                this.loadcashWeedingChemicalCosts();
            });
            Fire.$on('RefreshcashWeedingDetails',() => {
                this.loadcashWeedingDetails();
            });
            
            this.listsubcashCrops();
            this.loadsubcashWeedingDetails();
            this.loadsubcashWeedingChemicalCosts();
            this.loadsubcashWeedingLabourCosts();
            this.loadsubcashWeedingOtherCosts();
            this.loadsubcashWeedingToolCosts(); 
            
            //event listeners for subcashcrops
            Fire.$on('RefreshsubcashWeedingToolCosts',() => {
                this.loadsubcashWeedingToolCosts();
            });
            Fire.$on('RefreshsubcashWeedingOtherCosts',() => {
                this.loadsubcashWeedingOtherCosts();
            });
            Fire.$on('RefreshsubcashWeedingLabourCosts',() => {
                this.loadsubcashWeedingLabourCosts();
            });
            Fire.$on('RefreshsubcashWeedingChemicalCosts',() => {
                this.loadsubcashWeedingChemicalCosts();
            });
            Fire.$on('RefreshsubcashWeedingDetails',() => {
                this.loadsubcashWeedingDetails();
            });            
            console.log('Component mounted.')
        }
    }
</script>
