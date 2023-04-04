<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Planting Records</h3>
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
                            <h3 class="card-title">Planting Details</h3>
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
                                <th style="width: 10px">Date of Planting</th>
                                <th>Crop Planted</th>
                                <th>Acreage Planted</th>
                                <th>Quantity of Seed</th>
                                <th>Fertilizer Applied</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subplantingdetails.data" :key="item.id">
                                <td>{{item.date_of_planting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_planted}}</td>
                                <td>{{item.seed_quantity}}  </td>
                                <td>
                                    <span v-if="item.fertilizer_type == 'FOLIAR'" class="badge bg-danger">FOLIAR</span>
                                    <span v-else-if="item.fertilizer_type == 'NPK'" class="badge bg-success">NPK</span>
                                    <span v-else-if="item.fertilizer_type == 'DAP'" class="badge bg-info">DAP</span>
                                    <span v-else-if="item.fertilizer_type == 'MANURE'" class="badge bg">MANURE</span>
                                    <span v-else class="badge bg-primary">{{item.fertilizer_type | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editsubcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubPlantingDetail(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubPlantingDetail() : createsubPlantingDetail()">
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
                                            <label>Date of Planting</label>
                                            <input v-model="form.date_of_planting" type="date" name="planting_date"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('planting_date') }">
                                                <div v-if="form.errors.has('planting_date')" v-html="form.errors.get('planting_date')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Fertilizer Applied</label>  
                                                    <input type="text" list="fertilizers" v-model="form.fertilizer_type" id="fertilizer_type"
                                                    name="fertilizer_type" class="form-control" :class="{ 'is-invalid': form.errors.has('fertilizer_type') }"/>
                                                    <datalist id="fertilizers">
                                                    <option value="FOLIAR">FOLIAR</option>
                                                    <option value="DAP">DAP</option>
                                                    <option value="NPK">NPK</option>
                                                    <option value="MANURE">MANURE(MAN)</option>
                                                    </datalist>                                                    
                                                    <div v-if="form.errors.has('fertilizer_type')" v-html="form.errors.get('fertilizer_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Fertilizer Applied</label>  
                                                    <textarea v-model="form.fertilizer_quantity" id="fertilizer_quantity"
                                                    name="fertilizer_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('fertilizer_quantity')" v-html="form.errors.get('fertilizer_quantity')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Seed Used</label>  
                                                    <textarea v-model="form.seed_quantity" id="seed_quantity"
                                                    name="seed_quantity" placeholder="Brief description of the quantity(e.g 2 packets)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('seed_quantity')" v-html="form.errors.get('seed_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Planted</label>
                                            <input v-model="form.acreage_planted" type="text" name="acreage" placeholder="In acres(approx)"
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
                        <pagination :data="subplantingdetails" @pagination-change-page="getsubPlantingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Planting Costs</h3>
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
                                <tr v-for="item in subplantingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubPlantingOtherCost(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubPlantingOtherCost() : createsubPlantingOtherCost()">
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
                        <pagination :data="subplantingothercosts" @pagination-change-page="getsubPlantingOtherCosts"></pagination>
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
                            <h3 class="card-title">Planting Details</h3>
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
                                <th style="width: 10px">Date of Planting</th>
                                <th>Crop Planted</th>
                                <th>Acreage Planted</th>
                                <th>Quantity of Seed</th>
                                <th>Fertilizer Applied</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cashplantingdetails.data" :key="item.id">
                                <td>{{item.date_of_planting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_planted}}</td>
                                <td>{{item.seed_quantity}}</td>
                                <td>
                                    <span v-if="item.fertilizer_type == 'FOLIAR'" class="badge bg-danger">FOLIAR</span>
                                    <span v-else-if="item.fertilizer_type == 'NPK'" class="badge bg-success">NPK</span>
                                    <span v-else-if="item.fertilizer_type == 'DAP'" class="badge bg-info">DAP</span>
                                    <span v-else class="badge bg-primary">{{item.fertilizer_type | capitalize}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletecashPlantingDetail(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashPlantingDetail() : createcashPlantingDetail()">
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
                                            <label>Date of Planting</label>
                                            <input v-model="form.date_of_planting" type="date" name="planting_date"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('planting_date') }">
                                                <div v-if="form.errors.has('planting_date')" v-html="form.errors.get('planting_date')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Fertilizer Applied</label>  
                                                    <input type="text" list="fertilizers" v-model="form.fertilizer_type" id="fertilizer_type"
                                                    name="fertilizer_type" class="form-control" :class="{ 'is-invalid': form.errors.has('fertilizer_type') }"/>
                                                    <datalist id="fertilizers">
                                                    <option value="FOLIAR">FOLIAR</option>
                                                    <option value="DAP">DAP</option>
                                                    <option value="NPK">NPK</option>
                                                    <option value="MANURE">MANURE(MAN)</option>
                                                    </datalist>                                                    
                                                    <div v-if="form.errors.has('fertilizer_type')" v-html="form.errors.get('fertilizer_type')" />
                                        </div>   
                                        <div class="form-group">
                                            <label>Quantity of Fertilizer Applied</label>  
                                                    <textarea v-model="form.fertilizer_quantity" id="fertilizer_quantity"
                                                    name="fertilizer_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('fertilizer_quantity')" v-html="form.errors.get('fertilizer_quantity')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Seed(ling) Used</label>  
                                                    <textarea v-model="form.seed_quantity" id="seed_quantity"
                                                    name="seed_quantity" placeholder="Brief description of the quantity(e.g 2 packets)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('seed_quantity')" v-html="form.errors.get('seed_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Planted</label>
                                            <input v-model="form.acreage_planted" type="text" name="acreage" placeholder="In acres(approx)"
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
                            <pagination :data="cashplantingdetails" @pagination-change-page="getcashPlantingDetails"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Planting Costs</h3>
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
                                <tr v-for="item in cashplantingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletecashPlantingOtherCost(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecashPlantingOtherCost() : createcashPlantingOtherCost()">
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
                            <pagination :data="cashplantingothercosts" @pagination-change-page="getcashPlantingOtherCosts"></pagination>
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
                            <h3 class="card-title">Planting Details</h3>
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
                                <th style="width: 10px">Date of Planting</th>
                                <th>Crop Planted</th>
                                <th>Acreage Planted</th>
                                <th>Quantity of Seed</th>
                                <th>Fertilizer Applied</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashplantingdetails.data" :key="item.id">
                                <td>{{item.date_of_planting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.acreage_planted}}</td>
                                <td>{{item.seed_quantity}}</td>
                                <td>
                                    <span v-if="item.fertilizer_type == 'FOLIAR'" class="badge bg-danger">FOLIAR</span>
                                    <span v-else-if="item.fertilizer_type == 'NPK'" class="badge bg-success">NPK</span>
                                    <span v-else-if="item.fertilizer_type == 'DAP'" class="badge bg-info">DAP</span>
                                    <span v-else class="badge bg-primary">{{item.fertilizer_type | capitalize}}</span>
                                </td>                                <td>                                  
                                    <a href="#" @click="editsubcashcropModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPlantingDetail(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPlantingDetail() : createsubcashPlantingDetail()">
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
                                            <label>Date of Planting</label>
                                            <input v-model="form.date_of_planting" type="date" name="planting_date"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('planting_date') }">
                                                <div v-if="form.errors.has('planting_date')" v-html="form.errors.get('planting_date')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Fertilizer Applied</label>  
                                                    <input type="text" list="fertilizers" v-model="form.fertilizer_type" id="fertilizer_type"
                                                    name="fertilizer_type" class="form-control" :class="{ 'is-invalid': form.errors.has('fertilizer_type') }"/>
                                                    <datalist id="fertilizers">
                                                    <option value="FOLIAR">FOLIAR</option>
                                                    <option value="DAP">DAP</option>
                                                    <option value="NPK">NPK</option>
                                                    <option value="MANURE">MANURE(MAN)</option>
                                                    </datalist>                                                    
                                                    <div v-if="form.errors.has('fertilizer_type')" v-html="form.errors.get('fertilizer_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Fertilizer Applied</label>  
                                                    <textarea v-model="form.fertilizer_quantity" id="fertilizer_quantity"
                                                    name="fertilizer_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('fertilizer_quantity')" v-html="form.errors.get('fertilizer_quantity')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Seed(ling) Used</label>  
                                                    <textarea v-model="form.seed_quantity" id="seed_quantity"
                                                    name="seed_quantity" placeholder="Brief description of the quantity(e.g 2 packets)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('seed_quantity')" v-html="form.errors.get('seed_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Planted</label>
                                            <input v-model="form.acreage_planted" type="text" name="acreage" placeholder="In acres(approx)"
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
                            <pagination :data="subcashplantingdetails" @pagination-change-page="getsubcashPlantingDetails"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Planting Fertilizer Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashfertilizerModal">
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
                                <th style="width:10px">Fertilizer</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashplantingfertilizercosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.fertilizer_type == 'FOLIAR'" class="badge bg-danger">FOLIAR</span>
                                    <span v-else-if="item.fertilizer_type == 'NPK'" class="badge bg-success">NPK</span>
                                    <span v-else-if="item.fertilizer_type == 'DAP'" class="badge bg-info">DAP</span>
                                    <span v-else-if="item.fertilizer_type == 'MANURE'" class="badge bg">MANURE</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editsubcashfertilizerModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPlantingFertilizerCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- SubCash Fertilizer Modal -->
                        <div class="modal fade" id="subcashFertilizer" tabindex="-1" role="dialog" aria-labelledby="subcashFertilizer" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Fertilizer Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Fertilizer Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPlantingFertilizerCost() : createsubcashPlantingFertilizerCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Fertilizer</label>  
                                                    <input type="text" list="fertilizers" v-model="form.fertilizer_type" id="fertilizer_type"
                                                    name="fertilizer_type" class="form-control" :class="{ 'is-invalid': form.errors.has('fertilizer_type') }"/>
                                                    <datalist id="fertilizers">
                                                    <option value="FOLIAR">FOLIAR</option>
                                                    <option value="DAP">DAP</option>
                                                    <option value="NPK">NPK</option>
                                                    <option value="MANURE">MANURE(MAN)</option>
                                                    </datalist>                                                    
                                                    <div v-if="form.errors.has('fertilizer_type')" v-html="form.errors.get('fertilizer_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Crop To Fertilize</label>
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
                            <pagination :data="subcashplantingfertilizercosts" @pagination-change-page="getsubcashPlantingFertilizerCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Planting Seed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashseedModal">
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
                                <th style="width:10px">Seed(ling)</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashplantingseedcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.seed_type == 'COFFEESEEDLING'" class="badge bg">COFFEE</span>
                                    <span v-else-if="item.seed_type == 'TEASEEDLING'" class="badge bg">TEA</span>                              
                                    <span v-else-if="item.seed_type == 'SHANGIPOTATO'" class="badge bg">SHANGI</span>                              
                                    <span v-else-if="item.seed_type == 'MILLET'" class="badge bg">MILLET</span>                              
                                    <span v-else-if="item.seed_type == 'MAIZE618'" class="badge bg">MAIZE-618</span>                              
                                    <span v-else-if="item.seed_type == 'MAIZE614'" class="badge bg">MAIZE-614</span>                              
                                    <span v-else-if="item.seed_type == 'KENYASEED'" class="badge bg">KENYASEED</span>                              
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editsubcashseedModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPlantingSeedCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- SubCash Seed Modal -->
                        <div class="modal fade" id="subcashSeed" tabindex="-1" role="dialog" aria-labelledby="subcashSeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Seed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Seed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPlantingSeedCost() : createsubcashPlantingSeedCost()">
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
                                            <label>Type of Seed</label>  
                                                    <input type="text" list="seeds" v-model="form.seed_type" id="seed_type"
                                                    name="seed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('seed_type') }">
                                                    <datalist id = "seeds">
                                                    <option value="">Select Seed Type</option>
                                                    <option value="COFFEESEEDLING">Coffee Seedling</option>
                                                    <option value="TEASEEDLING">Tea Seedling</option>
                                                    <option value="SHANGIPOTATO">Potato - Shangi</option>
                                                    <option value="MILLET">Millet</option>
                                                    <option value="KENYASEED">KENYASEED</option>
                                                    <option value="MAIZE614">Maize - 614</option>
                                                    <option value="MAIZE618">Maize - 618</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('seed_type')" v-html="form.errors.get('seed_type')" />
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
                            <pagination :data="subcashplantingseedcosts" @pagination-change-page="getsubcashPlantingSeedCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Planting Labour Costs</h3>
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
                                <tr v-for="item in subcashplantinglabourcosts.data" :key="item.id">
                                <td>{{item.date_of_work}}</td>
                                <td>{{item.no_of_persons}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                   
                                    <a href="#" @click="editsubcashlabourModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPlantingLabourCost(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Labour Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Labour Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPlantingLabourCost() : createsubcashPlantingLabourCost()">
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
                            <pagination :data="subcashplantinglabourcosts" @pagination-change-page="getsubcashPlantingLabourCosts"></pagination>
                            </ul>
                        </div>                                                
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Planting Costs</h3>
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
                                <tr v-for="item in subcashplantingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editsubcashothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletesubcashPlantingOtherCost(item.id)" v-show="$gate.isAdmin()">
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
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashPlantingOtherCost() : createsubcashPlantingOtherCost()">
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
                            <pagination :data="subcashplantingothercosts" @pagination-change-page="getsubcashPlantingOtherCosts"></pagination>
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
                    date_of_planting: '',
                    acreage_planted: '',
                    fertilizer_quantity: '',
                    seed_quantity: '',
                    fertilizer_type: '',
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
               subplantingdetails: {},
               subplantinglabourcosts: {},
               subplantingfertilizercosts: {},
               subplantingothercosts: {},
               subplantingseedcosts: {},

               cashcropslist: {},
               cashplantingdetails: {},
               cashplantinglabourcosts: {},
               cashplantingfertilizercosts: {},
               cashplantingothercosts: {},
               cashplantingseedcosts: {}, 

               subcashcropslist: {},
               subcashplantingdetails: {},
               subcashplantinglabourcosts: {},
               subcashplantingfertilizercosts: {},
               subcashplantingothercosts: {},
               subcashplantingseedcosts: {},                               
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
            createsubPlantingDetail(){
                this.$Progress.start();
                this.form.post('api/subplantingdetail').then(() => {
                    $('#subCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubPlantingDetail(){
                this.$Progress.start();
                this.form.put('api/subplantingdetail/'+this.form.id).then(() => {
                    $('#subCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingDetails')
                }).catch(() => {
                this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubPlantingDetail(id){
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
                  this.form.delete('api/subplantingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Planting detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPlantingDetails');
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
            createsubPlantingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subplantinglabourcost').then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingLabourCosts')
                }).catch(() => {
                this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubPlantingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subplantinglabourcost/'+this.form.id).then(() => {
                    $('#subLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubPlantingLabourCost(id){
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
                  this.form.delete('api/subplantinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPlantingLabourCosts');
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
            subfertilizerModal(){
                this.editmode = false;
                this.form.reset();
                $('#subFertilizer').modal('show');
            },
            editsubfertilizerModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subFertilizer').modal('show');
                this.form.fill(item)
            },
            createsubPlantingFertilizerCost(){
                this.$Progress.start();
                this.form.post('api/subplantingfertilizercost').then(() => {
                    $('#subFertilizer').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingFertilizerCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatesubPlantingFertilizerCost(){
                this.$Progress.start();
                this.form.put('api/subplantingfertilizercost/'+this.form.id).then(() => {
                    $('#subFertilizer').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingFertilizerCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubPlantingFertilizerCost(id){
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
                  this.form.delete('api/subplantingfertilizercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Fertilizer cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPlantingFertilizerCosts');
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
            createsubPlantingOtherCost(){
                this.$Progress.start();
                this.form.post('api/subplantingothercost').then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatesubPlantingOtherCost(){
                this.$Progress.start();
                this.form.put('api/subplantingothercost/'+this.form.id).then(() => {
                    $('#subOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubPlantingOtherCost(id){
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
                  this.form.delete('api/subplantingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPlantingOtherCosts');
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
            subseedModal(){
                this.editmode = false;
                this.form.reset();
                $('#subSeed').modal('show');
            },
            editsubseedModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subSeed').modal('show');
                this.form.fill(item)
            }, 
            createsubPlantingSeedCost(){
                this.form.post('api/subplantingseedcost').then(() => {
                    $('#subSeed').modal('hide')
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingSeedCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubPlantingSeedCost(){
                this.form.put('api/subplantingseedcost/'+this.form.id).then(() => {
                    $('#subSeed').modal('hide')
                    console.log('success')
                    Fire.$emit('RefreshsubPlantingSeedCosts')                    
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubPlantingSeedCost(id){
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
                  this.form.delete('api/subplantingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Seed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubPlantingSeedCosts');
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
                        
            loadsubPlantingDetails(){
                axios.get('api/subplantingdetail').then((response) => {
                    this.subplantingdetails = response.data
                });
            },
            loadsubPlantingLabourCosts(){
                axios.get('api/subplantinglabourcost').then((response) => {
                    this.subplantinglabourcosts = response.data
                });
            },
            loadsubPlantingFertilizerCosts(){
                axios.get('api/subplantingfertilizercost').then((response) => {
                    this.subplantingfertilizercosts = response.data
                });                
            },
            loadsubPlantingOtherCosts(){
                axios.get('api/subplantingothercost').then((response) => {
                    this.subplantingothercosts = response.data
                });                
            },
            loadsubPlantingSeedCosts(){
                axios.get('api/subplantingseedcost').then((response) => {
                    this.subplantingseedcosts = response.data
                });                
            },

            //pagination of subcrops
		    getsubPlantingDetails(page = 1) {
			axios.get('api/subplantingdetail?page=' + page)
				.then(response => {
					this.subplantingdetails = response.data;
				})                
            },
		    getsubPlantingFertilizerCosts(page = 1) {
			axios.get('api/subplantingfertilizercost?page=' + page)
				.then(response => {
					this.subplantingfertilizercosts = response.data;
				})                
            },
		    getsubPlantingSeedCosts(page = 1) {
			axios.get('api/subplantingseedcost?page=' + page)
				.then(response => {
					this.subplantingseedcosts = response.data;
				})                
            },
		    getsubPlantingLabourCosts(page = 1) {
			axios.get('api/subplantinglabourcost?page=' + page)
				.then(response => {
					this.subplantinglabourcosts = response.data;
				})                
            },
		    getsubPlantingOtherCosts(page = 1) {
			axios.get('api/subplantingothercost?page=' + page)
				.then(response => {
					this.subplantingothercosts = response.data;
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
            createcashPlantingDetail(){
                this.$Progress.start();
                this.form.post('api/cashplantingdetail').then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecashPlantingDetail(){
                this.$Progress.start();
                this.form.put('api/cashplantingdetail/'+this.form.id).then(() => {
                    $('#cashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPlantingDetail(id){
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
                  this.form.delete('api/cashplantingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Planting detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashPlantingDetails');
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
            createcashPlantingLabourCost(){
                this.$Progress.start();
                this.form.post('api/cashplantinglabourcost').then(() => {
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
            updatecashPlantingLabourCost(){
                this.$Progress.start();
                this.form.put('api/cashplantinglabourcost/'+this.form.id).then(() => {
                    $('#cashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPlantingLabourCost(id){
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
                  this.form.delete('api/cashplantinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashPlantingLabourCosts');
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
            cashfertilizerModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashFertilizer').modal('show');
            },
            editcashfertilizerModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashFertilizer').modal('show');
                this.form.fill(item)
            },
            createcashPlantingFertilizerCost(){
                this.$Progress.start();
                this.form.post('api/cashplantingfertilizercost').then(() => {
                    $('#cashFertilizer').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingFertilizerCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatecashPlantingFertilizerCost(){
                this.$Progress.start();
                this.form.put('api/cashplantingfertilizercost/'+this.form.id).then(() => {
                    $('#cashFertilizer').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingFertilizerCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPlantingFertilizerCost(id){
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
                  this.form.delete('api/cashplantingfertilizercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Fertilizer cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashPlantingFertilizerCosts');
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
            createcashPlantingOtherCost(){
                this.$Progress.start();
                this.form.post('api/cashplantingothercost').then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatecashPlantingOtherCost(){
                this.$Progress.start();
                this.form.put('api/cashplantingothercost/'+this.form.id).then(() => {
                    $('#cashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPlantingOtherCost(id){
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
                  this.form.delete('api/cashplantingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcashPlantingOtherCosts');
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
            cashseedModal(){
                this.editmode = false;
                this.form.reset();
                $('#cashSeed').modal('show');
            },
            editcashseedModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cashSeed').modal('show');
                this.form.fill(item)
            }, 
            createcashPlantingSeedCost(){
                this.$Progress.start();
                this.form.post('api/cashplantingseedcost').then(() => {
                    $('#cashSeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingSeedCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecashPlantingSeedCost(){
                this.$Progress.start();
                this.form.put('api/cashplantingseedcost/'+this.form.id).then(() => {
                    $('#cashSeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshcashPlantingSeedCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecashPlantingSeedCost(id){
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
                  this.form.delete('api/subcashplantingseedcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Seed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPlantingSeedCosts');
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
            loadcashPlantingDetails(){
                axios.get('api/cashplantingdetail').then((response) => {
                    this.cashplantingdetails = response.data
                });
            },
            loadcashPlantingLabourCosts(){
                axios.get('api/cashplantinglabourcost').then((response) => {
                    this.cashplantinglabourcosts = response.data
                });
            },
            loadcashPlantingFertilizerCosts(){
                axios.get('api/cashplantingfertilizercost').then((response) => {
                    this.cashplantingfertilizercosts = response.data
                });                
            },
            loadcashPlantingOtherCosts(){
                axios.get('api/cashplantingothercost').then((response) => {
                    this.cashplantingothercosts = response.data
                });                
            },
            loadcashPlantingSeedCosts(){
                axios.get('api/cashplantingseedcost').then((response) => {
                    this.cashplantingseedcosts = response.data
                });                
            },
  
            //pagination of cashcrops
		    getcashPlantingDetails(page = 1) {
			axios.get('api/cashplantingdetail?page=' + page)
				.then(response => {
					this.cashplantingdetails = response.data;
				})                
            },
		    getcashPlantingFertilizerCosts(page = 1) {
			axios.get('api/cashplantingfertilizercost?page=' + page)
				.then(response => {
					this.cashplantingfertilizercosts = response.data;
				})                
            },
		    getcashPlantingSeedCosts(page = 1) {
			axios.get('api/cashplantingseedcost?page=' + page)
				.then(response => {
					this.cashplantingseedcosts = response.data;
				})                
            },
		    getcashPlantingLabourCosts(page = 1) {
			axios.get('api/cashplantinglabourcost?page=' + page)
				.then(response => {
					this.cashplantinglabourcosts = response.data;
				})                
            },
		    getcashPlantingOtherCosts(page = 1) {
			axios.get('api/cashplantingothercost?page=' + page)
				.then(response => {
					this.cashplantingothercosts = response.data;
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
            createsubcashPlantingDetail(){
                this.$Progress.start();
                this.form.post('api/subcashplantingdetail').then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubcashPlantingDetail(){
                this.$Progress.start();
                this.form.put('api/subcashplantingdetail/'+this.form.id).then(() => {
                    $('#subcashCrop').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashPlantingDetail(id){
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
                  this.form.delete('api/subcashplantingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPlantingDetails');
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
            createsubcashPlantingLabourCost(){
                this.$Progress.start();
                this.form.post('api/subcashplantinglabourcost').then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubcashPlantingLabourCost(){
                this.$Progress.start();
                this.form.put('api/subcashplantinglabourcost/'+this.form.id).then(() => {
                    $('#subcashLabour').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingLabourCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashPlantingLabourCost(id){
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
                  this.form.delete('api/subcashplantinglabourcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Labour cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPlantingLabourCosts');
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
            subcashfertilizerModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashFertilizer').modal('show');
            },
            editsubcashfertilizerModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashFertilizer').modal('show');
                this.form.fill(item)
            },
            createsubcashPlantingFertilizerCost(){
                this.$Progress.start();
                this.form.post('api/subcashplantingfertilizercost').then(() => {
                    $('#subcashFertilizer').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingFertilizerCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatesubcashPlantingFertilizerCost(){
                this.$Progress.start();
                this.form.put('api/subcashplantingfertilizercost/'+this.form.id).then(() => {
                    $('#subcashFertilizer').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingFertilizerCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashPlantingFertilizerCost(id){
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
                  this.form.delete('api/subcashplantingfertilizercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Fertilizer cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPlantingFertilizerCosts');
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
            createsubcashPlantingOtherCost(){
                this.$Progress.start();
                this.form.post('api/subcashplantingothercost').then(() => {
                    $('#subcashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            updatesubcashPlantingOtherCost(){
                this.$Progress.start();
                this.form.put('api/subcashplantingothercost/'+this.form.id).then(() => {
                    $('#subcashOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire({
                      icon: 'success',
                      title: 'Update successful'
                      });
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashPlantingOtherCost(id){
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
                  this.form.delete('api/subcashplantingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPlantingOtherCosts');
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
            subcashseedModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashSeed').modal('show');
            },
            editsubcashseedModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashSeed').modal('show');
                this.form.fill(item)
            }, 
            createsubcashPlantingSeedCost(){
                this.form.post('api/subcashplantingseedcost').then(() => {
                    $('#subcashSeed').modal('hide')
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingSeedCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatesubcashPlantingSeedCost(){
                this.form.put('api/subcashplantingseedcost/'+this.form.id).then(() => {
                    $('#subcashSeed').modal('hide')
                    console.log('success')
                    Fire.$emit('RefreshsubcashPlantingSeedCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletesubcashPlantingSeedCost(id){
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
                  this.form.delete('api/subcashplantingseedcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Seed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashPlantingSeedCosts');
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
            loadsubcashPlantingDetails(){
                axios.get('api/subcashplantingdetail').then((response) => {
                    this.subcashplantingdetails = response.data
                });
            },
            loadsubcashPlantingLabourCosts(){
                axios.get('api/subcashplantinglabourcost').then((response) => {
                    this.subcashplantinglabourcosts = response.data
                });
            },
            loadsubcashPlantingFertilizerCosts(){
                axios.get('api/subcashplantingfertilizercost').then((response) => {
                    this.subcashplantingfertilizercosts = response.data
                });                
            },
            loadsubcashPlantingOtherCosts(){
                axios.get('api/subcashplantingothercost').then((response) => {
                    this.subcashplantingothercosts = response.data
                });                
            },
            loadsubcashPlantingSeedCosts(){
                axios.get('api/subcashplantingseedcost').then((response) => {
                    this.subcashplantingseedcosts = response.data
                });                
            },
            
            //pagination of subcashcrops
		    getsubcashPlantingDetails(page = 1) {
			axios.get('api/subcashplantingdetail?page=' + page)
				.then(response => {
					this.subcashplantingdetails = response.data;
				})                
            },
		    getsubcashPlantingFertilizerCosts(page = 1) {
			axios.get('api/subcashplantingfertilizercost?page=' + page)
				.then(response => {
					this.subcashplantingfertilizercosts = response.data;
				})                
            },
		    getsubcashPlantingSeedCosts(page = 1) {
			axios.get('api/subcashplantingseedcost?page=' + page)
				.then(response => {
					this.subcashplantingseedcosts = response.data;
				})                
            },
		    getsubcashPlantingLabourCosts(page = 1) {
			axios.get('api/subcashplantinglabourcost?page=' + page)
				.then(response => {
					this.subcashplantinglabourcosts = response.data;
				})                
            },
		    getsubcashPlantingOtherCosts(page = 1) {
			axios.get('api/subcashplantingothercost?page=' + page)
				.then(response => {
					this.subcashplantingothercosts = response.data;
				})                
            },            
        },
        mounted() {
            this.listsubCrops();
            this.loadsubPlantingDetails();
            this.loadsubPlantingFertilizerCosts();
            this.loadsubPlantingLabourCosts();
            this.loadsubPlantingOtherCosts();
            this.loadsubPlantingSeedCosts();

            //event listeners for subsistence crops
            Fire.$on('RefreshsubPlantingDetails',() => {
                this.loadsubPlantingDetails();
            });
            Fire.$on('RefreshsubPlantingFertilizerCosts',() => {
                this.loadsubPlantingFertilizerCosts();
            });
            Fire.$on('RefreshsubPlantingLabourCosts',() => {
                this.loadsubPlantingLabourCosts();
            });
            Fire.$on('RefreshsubPlantingOtherCosts',() => {
                this.loadsubPlantingOtherCosts();
            });
            Fire.$on('RefreshsubPlantingSeedCosts',() => {
                this.loadsubPlantingSeedCosts();
            });
                                                
            this.listcashCrops();
            this.loadcashPlantingDetails();
            this.loadcashPlantingFertilizerCosts();
            this.loadcashPlantingLabourCosts();
            this.loadcashPlantingOtherCosts();
            this.loadcashPlantingSeedCosts();
            
            //event listeners for cash crops
            Fire.$on('RefreshcashPlantingDetails',() => {
                this.loadcashPlantingDetails();
            });
            Fire.$on('RefreshcashPlantingFertilizerCosts',() => {
                this.loadcashPlantingFertilizerCosts();
            });
            Fire.$on('RefreshcashPlantingLabourCosts',() => {
                this.loadcashPlantingLabourCosts();
            });
            Fire.$on('RefreshcashPlantingOtherCosts',() => {
                this.loadcashPlantingOtherCosts();
            });
            Fire.$on('RefreshcashPlantingSeedCosts',() => {
                this.loadcashPlantingSeedCosts();
            });            
            
            this.listsubcashCrops();
            this.loadsubcashPlantingDetails();
            this.loadsubcashPlantingFertilizerCosts();
            this.loadsubcashPlantingLabourCosts();
            this.loadsubcashPlantingOtherCosts();
            this.loadsubcashPlantingSeedCosts(); 
            
            //event listeners for subcash crops
            Fire.$on('RefreshsubcashPlantingDetails',() => {
                this.loadsubcashPlantingDetails();
            });
            Fire.$on('RefreshsubcashPlantingFertilizerCosts',() => {
                this.loadsubcashPlantingFertilizerCosts();
            });
            Fire.$on('RefreshsubcashPlantingLabourCosts',() => {
                this.loadsubcashPlantingLabourCosts();
            });
            Fire.$on('RefreshsubcashPlantingOtherCosts',() => {
                this.loadsubcashPlantingOtherCosts();
            });
            Fire.$on('RefreshsubcashPlantingSeedCosts',() => {
                this.loadsubcashPlantingSeedCosts();
            });            
            console.log('Component mounted.')
        }
    }
</script>
