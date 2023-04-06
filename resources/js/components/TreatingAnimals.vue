<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Treating Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Domestic</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Pet</a></li>
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
                            <button type="button" class="btn btn-sm btn-primary" @click="domesticvaccinatingdetailModal">
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
                                <th>Animal Vacc.</th>
                                <th>Number Vacc.</th>
                                <th>Vaccine Used</th>
                                <th>Quantity Admin.</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in domesticvaccinatingdetails.data" :key="item.id">
                                <td>{{item.date_of_vaccinating}}</td>
                                <td>{{item.animal.name}}</td>
                                <td>{{item.no_of_animals}}</td>
                                <td>
                                    <span v-if="item.vaccine_type == 'FOTIVAX'" class="badge bg-danger">FOTIVAX</span>
                                    <span v-else-if="item.vaccine_type == 'CAPRIVAX'" class="badge bg-success">CAPRIVAX</span>
                                    <span v-else-if="item.vaccine_type == 'ORFVAX'" class="badge bg-info">ORFVAX</span>
                                    <span v-else-if="item.vaccine_type == 'LUMPIVAX'" class="badge bg-info">LUMPIVAX</span>
                                    <span v-else-if="item.vaccine_type == 'RIFTVAX'" class="badge bg-secondary">RIFTVAX</span>
                                    <span v-else-if="item.vaccine_type == 'CONTAVAX'" class="badge bg-info">CONTAVAX</span>
                                    <span v-else-if="item.vaccine_type == 'FOWLVAX'" class="badge bg-info">FOWLVAX</span>
                                    <span v-else-if="item.vaccine_type == 'BLUVAX'" class="badge bg-info">BLUVAX</span>
                                    <span v-else class="badge bg-primary">{{item.vaccine_type | capitalize}}</span>

                                </td>
                                <td>{{item.vaccine_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editdomesticvaccinatingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletedomesticVaccinatingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- domestic Vaccinating Detail Modal -->
                        <div class="modal fade" id="domesticVaccinatingDetail" tabindex="-1" role="dialog" aria-labelledby="domesticVaccinatingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Vaccinating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Vaccinating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatedomesticVaccinatingDetail() : createdomesticVaccinatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Vaccinating</label>
                                            <input v-model="form.date_of_vaccinating" type="date" name="date_of_vaccinating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_vaccinating') }">
                                                <div v-if="form.errors.has('date_of_vaccinating')" v-html="form.errors.get('date_of_vaccinating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in domesticanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Animals Vaccinated</label>
                                            <input v-model="form.no_of_animals" type="text" name="no_of_animals"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_animals') }">
                                                <div v-if="form.errors.has('no_of_animals')" v-html="form.errors.get('no_of_animals')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Vaccine Used</label>  
                                                    <input type="text" list="vaccines" v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }" />
                                                    <datalist id="vaccines">
                                                    <option value="">Select Vaccine Type</option>
                                                    <option value="FOTIVAX">FOTIVAX</option>
                                                    <option value="CAPRIVAX">CAPRIVAX</option>
                                                    <option value="ORFVAX">ORFVAX</option>
                                                    <option value="LUMPIVAX">LUMPIVAX</option>
                                                    <option value="RIFTVAX">RIFTVAX</option>
                                                    <option value="CONTAVAX">CONTAVAX</option>
                                                    <option value="FOWLVAX">FOWLVAX</option>
                                                    <option value="BLUVAX">BLUVAX</option>
                                                    </datalist>
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
                        <pagination :data="domesticvaccinatingdetails" @pagination-change-page="getdomesticVaccinatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="domesticdetailModal">
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
                                <th>Animal Treated</th>
                                <th>No. Treated</th>
                                <th>Drug Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in domestictreatingdetails.data" :key="item.id">
                                <td>{{item.date_of_treating}}</td>
                                <td>{{item.animal.name}}</td>
                                <td>{{item.no_of_animals}}</td>
                                <td>
                                    <span v-if="item.drug_type == 'FORMALIN'" class="badge bg-danger">FORMALIN</span>
                                    <span v-else-if="item.drug_type == 'EPSOM SALT'" class="badge bg-success">EPSOM</span>
                                    <span v-else-if="item.drug_type == 'SPIRIT'" class="badge bg-info">SPIRIT</span>
                                    <span v-else-if="item.drug_type == 'ACARICIDE'" class="badge bg-info">ACARICIDE</span>
                                    <span v-else-if="item.drug_type == 'ANTHELMINTIC'" class="badge bg-info">ANTHELMINTIC</span>
                                    <span v-else class="badge bg-primary">{{item.drug_type | capitalize}}</span>
                                </td>
                                <td>{{item.drug_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editdomesticdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletedomesticTreatingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- domestic Detail Modal -->
                        <div class="modal fade" id="domesticDetail" tabindex="-1" role="dialog" aria-labelledby="domesticDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatedomesticTreatingDetail() : createdomesticTreatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Treating</label>
                                            <input v-model="form.date_of_treating" type="date" name="date_of_treating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_treating') }">
                                                <div v-if="form.errors.has('date_of_treating')" v-html="form.errors.get('date_of_treating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in domesticanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Animal Treated</label>
                                            <input v-model="form.no_of_animals" type="text" name="no_of_animals"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_animals') }">
                                                <div v-if="form.errors.has('no_of_animals')" v-html="form.errors.get('no_of_animals')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Drug Administered</label>  
                                                    <input type="text" list="drugs" v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <datalist id="drugs">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="FORMALIN">FORMALIN</option>
                                                    <option value="EPSOM SALT">EPSOM SALT</option>
                                                    <option value="SPIRIT">SPIRIT</option>
                                                    <option value="ACARICIDE">ACARICIDE</option>
                                                    <option value="ANTHELMINTIC">ANTHELMINTIC(Worm Medicine)</option>
                                                    </datalist>
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
                        <pagination :data="domestictreatingdetails" @pagination-change-page="getdomesticTreatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="domesticothercostModal">
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
                                <tr v-for="item in domestictreatingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editdomesticothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletedomesticTreatingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- domestic Other Cost Modal -->
                        <div class="modal fade" id="domesticOtherCost" tabindex="-1" role="dialog" aria-labelledby="domesticOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatedomesticTreatingOtherCost() : createdomesticTreatingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with treating"
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
                                            <label>Amount</label>
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
                        <pagination :data="domestictreatingothercosts" @pagination-change-page="getdomesticTreatingOtherCosts"></pagination>
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
                            <button type="button" class="btn btn-sm btn-primary" @click="petvaccinatingdetailModal">
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
                                <th>Animal Vaccinated</th>
                                <th>No. Vaccinated</th>
                                <th>Vaccine Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in petvaccinatingdetails.data" :key="item.id">
                                <td>{{item.date_of_vaccinating}}</td>
                                <td>{{item.animal.name}}</td>
                                <td>{{item.no_of_animals}}</td>
                                <td>
                                    <span v-if="item.vaccine_type == 'FOTIVAX'" class="badge bg-danger">FOTIVAX</span>
                                    <span v-else-if="item.vaccine_type == 'CAPRIVAX'" class="badge bg-success">CAPRIVAX</span>
                                    <span v-else-if="item.vaccine_type == 'ORFVAX'" class="badge bg-info">ORFVAX</span>
                                    <span v-else-if="item.vaccine_type == 'LUMPIVAX'" class="badge bg-info">LUMPIVAX</span>
                                    <span v-else-if="item.vaccine_type == 'RIFTVAX'" class="badge bg-secondary">RIFTVAX</span>
                                    <span v-else-if="item.vaccine_type == 'CONTAVAX'" class="badge bg-info">CONTAVAX</span>
                                    <span v-else-if="item.vaccine_type == 'FOWLVAX'" class="badge bg-info">FOWLVAX</span>
                                    <span v-else-if="item.vaccine_type == 'BLUVAX'" class="badge bg-info">BLUVAX</span>
                                    <span v-else class="badge bg-primary">{{item.vaccine_type | capitalize}}</span>
                                </td>
                                <td>{{item.vaccine_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editpetvaccinatingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletepetVaccinatingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- pet Vaccinating Detail Modal -->
                        <div class="modal fade" id="petVaccinatingDetail" tabindex="-1" role="dialog" aria-labelledby="petVaccinatingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Vaccinating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Vaccinating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatepetVaccinatingDetail() : createpetVaccinatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Vaccinating</label>
                                            <input v-model="form.date_of_vaccinating" type="date" name="date_of_vaccinating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_vaccinating') }">
                                                <div v-if="form.errors.has('date_of_vaccinating')" v-html="form.errors.get('date_of_vaccinating')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in petanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Animal Vaccinated</label>
                                            <input v-model="form.no_of_animals" type="text" name="no_of_animals"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_animals') }">
                                                <div v-if="form.errors.has('no_of_animals')" v-html="form.errors.get('no_of_animals')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Vaccine Used</label>  
                                                    <input type="text" list="vaccines" v-model="form.vaccine_type" id="vaccine_type"
                                                    name="vaccine_type" class="form-control" :class="{ 'is-invalid': form.errors.has('vaccine_type') }" />
                                                    <datalist id="vaccines">
                                                    <option value="">Select Vaccine Type</option>
                                                    <option value="FOTIVAX">FOTIVAX</option>
                                                    <option value="CAPRIVAX">CAPRIVAX</option>
                                                    <option value="ORFVAX">ORFVAX</option>
                                                    <option value="LUMPIVAX">LUMPIVAX</option>
                                                    <option value="RIFTVAX">RIFTVAX</option>
                                                    <option value="CONTAVAX">CONTAVAX</option>
                                                    <option value="FOWLVAX">FOWLVAX</option>
                                                    <option value="BLUVAX">BLUVAX</option>
                                                    </datalist>
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
                        <pagination :data="petvaccinatingdetails" @pagination-change-page="getpetVaccinatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="petdetailModal">
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
                                <th>Animal Treated</th>
                                <th>No. Treated</th>
                                <th>Drug Used</th>
                                <th>Quantity Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in pettreatingdetails.data" :key="item.id">
                                <td>{{item.date_of_treating}}</td>
                                <td>{{item.animal.name}}</td>
                                <td>{{item.no_of_animals}}</td>
                                <td>
                                    <span v-if="item.drug_type == 'FORMALIN'" class="badge bg-danger">FORMALIN</span>
                                    <span v-else-if="item.drug_type == 'EPSOM SALT'" class="badge bg-success">EPSOM</span>
                                    <span v-else-if="item.drug_type == 'SPIRIT'" class="badge bg-info">SPIRIT</span>
                                    <span v-else-if="item.drug_type == 'ACARICIDE'" class="badge bg-info">ACARICIDE</span>
                                    <span v-else-if="item.drug_type == 'ANTHELMINTIC'" class="badge bg-info">ANTHELMINTIC</span>
                                    <span v-else class="badge bg-primary">{{item.drug_type | capitalize}}</span>
                                </td>
                                <td>{{item.drug_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editpetdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletepetTreatingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- pet Detail Modal -->
                        <div class="modal fade" id="petDetail" tabindex="-1" role="dialog" aria-labelledby="petDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatepetTreatingDetail() : createpetTreatingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Treating</label>
                                            <input v-model="form.date_of_treating" type="date" name="date_of_treating"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_treating') }">
                                                <div v-if="form.errors.has('date_of_treating')" v-html="form.errors.get('date_of_treating')" /> 
                                        </div>                                      
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in petanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Animal Treated</label>
                                            <input v-model="form.no_of_animals" type="text" name="no_of_animals"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_animals') }">
                                                <div v-if="form.errors.has('no_of_animals')" v-html="form.errors.get('no_of_animals')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Drug Used</label>  
                                                    <input type="text" list="drugs" v-model="form.drug_type" id="drug_type"
                                                    name="drug_type" class="form-control" :class="{ 'is-invalid': form.errors.has('drug_type') }">
                                                    <datalist id="drugs">
                                                    <option value="">Select Drug Type</option>
                                                    <option value="FORMALIN">FORMALIN</option>
                                                    <option value="EPSOM SALT">EPSOM SALT</option>
                                                    <option value="SPIRIT">SPIRIT</option>
                                                    <option value="ACARICIDE">ACARICIDE</option>
                                                    <option value="ANTHELMINTIC">ANTHELMINTIC(Worm Medicine)</option>
                                                    </datalist>
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
                        <pagination :data="pettreatingdetails" @pagination-change-page="getpetTreatingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Treating Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="petothercostModal">
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
                                <tr v-for="item in pettreatingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editpetothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletepetTreatingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- pet Other Cost Modal -->
                        <div class="modal fade" id="petOtherCost" tabindex="-1" role="dialog" aria-labelledby="petOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Treating Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Treating Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatepetTreatingOtherCost() : createpetTreatingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with treating"
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
                                            <label>Amount</label>
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
                        <pagination :data="pettreatingothercosts" @pagination-change-page="getpetTreatingOtherCosts"></pagination>
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
                        animal_id: '',
                        drug_type: '',
                        drug_quantity: '',
                        vaccine_type: '',
                        vaccine_quantity: '',
                        date_of_vaccinating: '',
                        date_of_treating: '',
                        no_of_animals: '',
                        date_of_purchase: '',
                        quantity_bought: '',
                        amount_paid: '',
                        date_of_payment: '',
                        name: ''
                 }),
                 domesticanimalslist: {},
                 domesticvaccinatingdetails: {},
                 domestictreatingdetails: {},
                 domesticvaccinecosts: {},
                 domesticdrugcosts: {},
                 domestictreatingothercosts: {},

                 petanimalslist: {},
                 petvaccinatingdetails: {},
                 pettreatingdetails: {},
                 petvaccinecosts: {},
                 petdrugcosts: {},
                 pettreatingothercosts: {},
                                 
             }   
        },
        methods: {
            domesticvaccinatingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticVaccinatingDetail').modal('show');                
            },
            editdomesticvaccinatingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticVaccinatingDetail').modal('show');
                this.form.fill(item)
            },
            createdomesticVaccinatingDetail(){
                this.$Progress.start();                
                this.form.post('api/domesticvaccinatingdetail').then(() => {
                    $('#domesticVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccinating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshdomesticVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatedomesticVaccinatingDetail(){
                this.$Progress.start();
                this.form.put('api/domesticvaccinatingdetail/'+this.form.id).then(() => {
                    $('#domesticVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccinating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshdomesticVaccinatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletedomesticVaccinatingDetail(id){
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
                  this.form.delete('api/domesticvaccinatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccinating Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticVaccinatingDetails');
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
            domesticdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticDetail').modal('show');                
            },
            editdomesticdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticDetail').modal('show');
                this.form.fill(item)
            },
            createdomesticTreatingDetail(){
                this.$Progress.start();
                this.form.post('api/domestictreatingdetail').then(() => {
                    $('#domesticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Treating detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshdomesticTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatedomesticTreatingDetail(){
                this.$Progress.start();
                this.form.put('api/domestictreatingdetail/'+this.form.id).then(() => {
                    $('#domesticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Treating detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshdomesticTreatingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletedomesticTreatingDetail(id){
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
                  this.form.delete('api/domestictreatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Treating Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticTreatingDetails');
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
            domesticvaccinecostModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticVaccine').modal('show');                
            },
            editdomesticvaccinecostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticVaccine').modal('show');
                this.form.fill(item)
            },
            createdomesticVaccineCost(){
                this.$Progress.start();
                this.form.post('api/domesticvaccinecost').then(() => {
                    $('#domesticVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccine cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshdomesticVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatedomesticVaccineCost(){
                this.$Progress.start();
                this.form.put('api/domesticvaccinecost/'+this.form.id).then(() => {
                    $('#domesticVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccine cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshdomesticVaccineCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletedomesticVaccineCost(id){
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
                  this.form.delete('api/domesticvaccinecost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccine cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticVaccineCosts');
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
            domesticdrugcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticDrug').modal('show');                
            },
            editdomesticdrugcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticDrug').modal('show');
                this.form.fill(item)
            },
            createdomesticDrugCost(){
                this.$Progress.start();
                this.form.post('api/domesticdrugcost').then(() => {
                    $('#domesticDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Drug cost has been created',
                        'success'
                      );

                    console.log('success')
                    Fire.$emit('RefreshdomesticDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatedomesticDrugCost(){
                this.$Progress.start();
                this.form.put('api/domesticdrugcost/'+this.form.id).then(() => {
                    $('#domesticDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Drug cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshdomesticDrugCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletedomesticDrugCost(id){
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
                  this.form.delete('api/domesticdrugcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Drug cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticDrugCosts');
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
            domesticothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticOtherCost').modal('show');                
            },
            editdomesticothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticOtherCost').modal('show');
                this.form.fill(item)
            },
            createdomesticTreatingOtherCost(){
                this.$Progress.start();
                this.form.post('api/domestictreatingothercost').then(() => {
                    $('#domesticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshdomesticTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatedomesticTreatingOtherCost(){
                this.$Progress.start();
                this.form.put('api/domestictreatingothercost/'+this.form.id).then(() => {
                    $('#domesticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshdomesticTreatingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletedomesticTreatingOtherCost(id){
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
                  this.form.delete('api/domestictreatingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticTreatingOtherCosts');
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

            listdomesticAnimals(){
                axios.get('api/domesticanimalslist').then((response) => {
                    this.domesticanimalslist = response.data.data
                });
            },
            loaddomesticVaccinatingDetails(){
                axios.get('api/domesticvaccinatingdetail').then((response) => {
                    this.domesticvaccinatingdetails = response.data
                });
            },                        
            loaddomesticTreatingDetails(){
                axios.get('api/domestictreatingdetail').then((response) => {
                    this.domestictreatingdetails = response.data
                });
            },
            loaddomesticVaccineCosts(){
                axios.get('api/domesticvaccinecost').then((response) => {
                    this.domesticvaccinecosts = response.data
                });
            },
            loaddomesticDrugCosts(){
                axios.get('api/domesticdrugcost').then((response) => {
                    this.domesticdrugcosts = response.data
                });
            },            
            loaddomesticTreatingOtherCosts(){
                axios.get('api/domestictreatingothercost').then((response) => {
                    this.domestictreatingothercosts = response.data
                });
            },

            //pagination
            getdomesticVaccinatingDetails(page = 1) {
            axios.get('api/domesticvaccinatingdetail?page=' + page)
                .then(response => {
                    this.domesticvaccinatingdetails = response.data;
                })                
            },            
            getdomesticTreatingDetails(page = 1) {
            axios.get('api/domestictreatingdetail?page=' + page)
                .then(response => {
                    this.domestictreatingdetails = response.data;
                })                
            },
            getdomesticVaccineCosts(page = 1) {
            axios.get('api/domesticvaccinecost?page=' + page)
                .then(response => {
                    this.domesticvaccinecosts = response.data;
                })                
            },
            getdomesticDrugCosts(page = 1) {
            axios.get('api/domesticdrugcost?page=' + page)
                .then(response => {
                    this.domesticdrugcosts = response.data;
                })                
            },            
            getdomesticTreatingOtherCosts(page = 1) {
            axios.get('api/domestictreatingothercost?page=' + page)
                .then(response => {
                    this.domestictreatingothercosts = response.data;
                })                
            }, 
            
            //methods for pet animals
            petvaccinatingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#petVaccinatingDetail').modal('show');                
            },
            editpetvaccinatingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petVaccinatingDetail').modal('show');
                this.form.fill(item)
            },
            createpetVaccinatingDetail(){
                this.$Progress.start();
                this.form.post('api/petvaccinatingdetail').then(() => {
                    $('#petVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccinating detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetVaccinatingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetVaccinatingDetail(){
                this.$Progress.start();
                this.form.put('api/petvaccinatingdetail/'+this.form.id).then(() => {
                    $('#petVaccinatingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccinating detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetVaccinatingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetVaccinatingDetail(id){
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
                  this.form.delete('api/petvaccinatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccinating detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetVaccinatingDetails');
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
            petdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#petDetail').modal('show');                
            },
            editpetdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petDetail').modal('show');
                this.form.fill(item)
            },
            createpetTreatingDetail(){
                this.$Progress.start();
                this.form.post('api/pettreatingdetail').then(() => {
                    $('#petDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Treating detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetTreatingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetTreatingDetail(){
                this.$Progress.start();
                this.form.put('api/pettreatingdetail/'+this.form.id).then(() => {
                    $('#petDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Treating detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetTreatingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetTreatingDetail(id){
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
                  this.form.delete('api/pettreatingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Treating detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetTreatingDetails');
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
            petvaccinecostModal(){
                this.editmode = false;
                this.form.reset();
                $('#petVaccine').modal('show');                
            },
            editpetvaccinecostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petVaccine').modal('show');
                this.form.fill(item)
            },
            createpetVaccineCost(){
                this.$Progress.start();
                this.form.post('api/petvaccinecost').then(() => {
                    $('#petVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Vaccine cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetVaccineCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetVaccineCost(){
                this.$Progress.start();
                this.form.put('api/petvaccinecost/'+this.form.id).then(() => {
                    $('#petVaccine').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Vaccine cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetVaccineCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetVaccineCost(id){
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
                  this.form.delete('api/petvaccinecost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Vaccine cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetVaccineCosts');
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
            petdrugcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#petDrug').modal('show');                
            },
            editpetdrugcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petDrug').modal('show');
                this.form.fill(item)
            },
            createpetDrugCost(){
                this.$Progress.start();
                this.form.post('api/petdrugcost').then(() => {
                    $('#petDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Drug cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetDrugCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetDrugCost(){
                this.$Progress.start();
                this.form.put('api/petdrugcost/'+this.form.id).then(() => {
                    $('#petDrug').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Drug cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetDrugCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetDrugCost(id){
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
                  this.form.delete('api/petdrugcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Drug cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetDrugCosts');
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
            petothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#petOtherCost').modal('show');                
            },
            editpetothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petOtherCost').modal('show');
                this.form.fill(item)
            },
            createpetTreatingOtherCost(){
                this.$Progress.start();
                this.form.post('api/pettreatingothercost').then(() => {
                    $('#petOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetTreatingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetTreatingOtherCost(){
                this.$Progress.start();
                this.form.put('api/pettreatingothercost/'+this.form.id).then(() => {
                    $('#petOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetTreatingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetTreatingOtherCost(id){
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
                  this.form.delete('api/pettreatingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetTreatingOtherCosts');
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

            listpetAnimals(){
                axios.get('api/petanimalslist').then((response) => {
                    this.petanimalslist = response.data.data
                });
            },

            loadpetVaccinatingDetails(){
                axios.get('api/petvaccinatingdetail').then((response) => {
                    this.petvaccinatingdetails = response.data
                });
            },
            loadpetTreatingDetails(){
                axios.get('api/pettreatingdetail').then((response) => {
                    this.pettreatingdetails = response.data
                });
            },
            loadpetVaccineCosts(){
                axios.get('api/petvaccinecost').then((response) => {
                    this.petvaccinecosts = response.data
                });
            },
            loadpetDrugCosts(){
                axios.get('api/petdrugcost').then((response) => {
                    this.petdrugcosts = response.data
                });
            },            
            loadpetTreatingOtherCosts(){
                axios.get('api/pettreatingothercost').then((response) => {
                    this.pettreatingothercosts = response.data
                });
            },

            //pagination
            getpetVaccinatingDetails(page = 1) {
            axios.get('api/petvaccinatingdetail?page=' + page)
                .then(response => {
                    this.petvaccinatingdetails = response.data;
                })                
            },            
            getpetTreatingDetails(page = 1) {
            axios.get('api/pettreatingdetail?page=' + page)
                .then(response => {
                    this.pettreatingdetails = response.data;
                })                
            },
            getpetVaccineCosts(page = 1) {
            axios.get('api/petvaccinecost?page=' + page)
                .then(response => {
                    this.petvaccinecosts = response.data;
                })                
            },
            getpetDrugCosts(page = 1) {
            axios.get('api/petdrugcost?page=' + page)
                .then(response => {
                    this.petdrugcosts = response.data;
                })                
            },            
            getpetTreatingOtherCosts(page = 1) {
            axios.get('api/pettreatingothercost?page=' + page)
                .then(response => {
                    this.pettreatingothercosts = response.data;
                })                
            }, 
                       
        },
        mounted() {
            this.listdomesticAnimals();
            this.loaddomesticVaccinatingDetails();
            this.loaddomesticTreatingDetails();
            this.loaddomesticVaccineCosts();
            this.loaddomesticDrugCosts();
            this.loaddomesticTreatingOtherCosts();

            this.listpetAnimals();
            this.loadpetVaccinatingDetails();
            this.loadpetTreatingDetails();
            this.loadpetVaccineCosts();
            this.loadpetDrugCosts();
            this.loadpetTreatingOtherCosts();            

            //event listeners 
            Fire.$on('RefreshdomesticVaccinatingDetails',() => {
                this.loaddomesticVaccinatingDetails();
            });            
            Fire.$on('RefreshdomesticTreatingDetails',() => {
                this.loaddomesticTreatingDetails();
            });
            Fire.$on('RefreshdomesticVaccineCosts',() => {
                this.loaddomesticVaccineCosts();
            });
             Fire.$on('RefreshdomesticDrugCosts',() => {
                this.loaddomesticDrugCosts();
            });
            Fire.$on('RefreshdomesticTreatingOtherCosts',() => {
                this.loaddomesticTreatingOtherCosts();
            }); 
            Fire.$on('RefreshpetVaccinatingDetails',() => {
                this.loadpetVaccinatingDetails();
            });             
            Fire.$on('RefreshpetTreatingDetails',() => {
                this.loadpetTreatingDetails();
            });
            Fire.$on('RefreshpetVaccineCosts',() => {
                this.loadpetVaccineCosts();
            });
            Fire.$on('RefreshpetDrugCosts',() => {
                this.loadpetDrugCosts();
            });
            Fire.$on('RefreshpetTreatingOtherCosts',() => {
                this.loadpetTreatingOtherCosts();
            });                                  
            console.log('Component mounted.')
        }
    }
</script>
