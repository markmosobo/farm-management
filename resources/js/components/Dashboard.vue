<template>
    <div class="container">
<div class="row mt-3">
          <div class="col-md-6">
            <div class="card collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Configure Farm</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" @click="farmModal">
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
                      <th style="width: 10px">#</th>
                      <th>Owner</th>
                      <th>Acreage</th>
                      <th style="width: 40px">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="fam in farms.data" :key="fam.id">
                      <td>{{fam.id}}</td>
                      <td>{{fam.owner.name}}</td>
                      <td>{{fam.acreage}}</td>
                      <td>                        
                        <a href="#" @click="editfarmModal(fam)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteFarm(fam.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td> 
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="card-footer">
                  <ul class="pagination pagination-sm m-0 float-right">
                  <pagination :data="farms" @pagination-change-page="getFarms"></pagination>
                  </ul>
              </div>              
            </div>
            <!-- /.card -->

            <div class="card collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Configure Crop</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" @click="cropModal">
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
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th style="width: 40px">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="crop in crops.data" :key="crop.id">
                      <td>{{crop.id}}</td>
                      <td>{{crop.name}}</td>
                      <td>{{crop.type}}</td>
                      <td>
                        
                        <a href="#" @click="editModal(crop)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteCrop(crop.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <ul class="pagination pagination-sm m-0 float-right">
                  <pagination :data="crops" @pagination-change-page="getCrops"></pagination>
                  </ul>
              </div>              
            </div>
            <!-- /.card -->

            <div class="card collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Configure Resource
                   <span class="badge badge-danger">New</span>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" @click="resourceModal">
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
                      <th style="width: 10px">#</th>
                      <th>Owner</th>
                      <th>Name</th>
                      <th style="width: 40px">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in resources.data" :key="item.id">
                      <td>{{item.id}}</td>
                      <td>{{item.owner.name}}</td>
                      <td>{{item.name}}</td>
                      <td>                        
                        <a href="#" @click="editresourceModal(item)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteResource(item.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td> 
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="card-footer">
                  <ul class="pagination pagination-sm m-0 float-right">
                  <pagination :data="resources" @pagination-change-page="getResources"></pagination>
                  </ul>
              </div>              
            </div>
            <!-- /.card -->            
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Configure Animals</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" @click="animalModal">
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
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th>Description</th>
                      <th style="width: 40px">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="animal in animals.data" :key="animal.id">
                      <td>{{animal.id}}</td>
                      <td>{{animal.name}}</td>
                      <td>{{animal.type}}</td>
                      <td>
                          {{animal.description}}
                      </td>
                      <td>                        
                        <a href="#" @click="editanimalModal(animal)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteAnimal(animal.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>   
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <ul class="pagination pagination-sm m-0 float-right">
                  <pagination :data="animals" @pagination-change-page="getAnimals"></pagination>
                  </ul>
              </div>              
            </div>
            <!-- /.card -->

            <div class="card collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Configure Poultry</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-sm btn-primary" @click="poultryModal">
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
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Type</th>
                      <th style="width: 40px">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="poultry in poultries.data" :key="poultry.id">
                      <td>{{poultry.id}}</td>
                      <td>{{poultry.name}}</td>
                      <td>
                          {{poultry.type}}
                      </td>
                      <td>                        
                        <a href="#" @click="editpoultryModal(poultry)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deletePoultry(poultry.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td> 
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                  <ul class="pagination pagination-sm m-0 float-right">
                  <pagination :data="poultries" @pagination-change-page="getPoultries"></pagination>
                  </ul>
              </div>               
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

        <!-- Farm Modal -->
        <div class="modal fade" id="farmNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Farm</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Farm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateFarm() : createFarm()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Owner</label>
                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('owner_id') }" v-model="form.owner_id">
                               <option value="">Select Owner</option>
                               <option 
                                  v-for="item in userslist" :key="item.id"
                                  :value="item.id"
                                  :selected="item.id == form.owner_id">{{ item.name }}</option>
                            </select>
                            <div v-if="form.errors.has('owner_id')" v-html="form.errors.get('owner_id')" />
                        </div>   
                        <div class="form-group">
                            <label>Size of Land</label>
                            <input v-model="form.acreage" type="text" name="acreage" placeholder="In acres(approx)"
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

        <!-- Crop Modal -->
        <div class="modal fade" id="cropNew" tabindex="-1" role="dialog" aria-labelledby="cropNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Crop</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Crop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateCrop() : createCrop()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Owner</label>
                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('owner_id') }" v-model="form.owner_id">
                               <option value="">Select Owner</option>
                               <option 
                                  v-for="person in userslist" :key="person.id"
                                  :value="person.id"
                                  :selected="person.id == form.owner_id">{{ person.name }}</option>
                            </select>
                            <div v-if="form.errors.has('owner_id')" v-html="form.errors.get('owner_id')" />
                        </div> 
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                        </div>
                        <div class="form-group">
                            <label>Type</label>  
                                    <select v-model="form.type" id="type"
                                    name="role" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select Crop Type</option>
                                    <option value="subsistence">Subsistence</option>
                                    <option value="cashcrop">Cash Crop</option>
                                    <option value="subcashcrop">Subsistence/Cash Crop</option>
                                    </select>
                                    <div v-if="form.errors.has('type')" v-html="form.errors.get('type')" />
                        </div>                                                                 
                        <div class="form-group">
                            <label>Description</label>  
                                    <textarea v-model="form.description" id="description"
                                    name="description" placeholder="Short description of the crop(optional)" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('description')" v-html="form.errors.get('description')" />
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

        <!-- Animal Modal -->
        <div class="modal fade" id="animalNew" tabindex="-1" role="dialog" aria-labelledby="animalNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Animal</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Animal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateAnimal() : createAnimal()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Owner</label>
                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('owner_id') }" v-model="form.owner_id">
                               <option value="">Select Owner</option>
                               <option 
                                  v-for="user in userslist" :key="user.id"
                                  :value="user.id"
                                  :selected="user.id == form.owner_id">{{ user.name }}</option>
                            </select>
                            <div v-if="form.errors.has('owner_id')" v-html="form.errors.get('owner_id')" />
                        </div> 
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                        </div>
                        <div class="form-group">
                            <label>Type</label>  
                                    <select v-model="form.type" id="type"
                                    name="role" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select Animal Type</option>
                                    <option value="domestic">Domestic</option>
                                    <option value="pet">Pet</option>
                                    </select>
                                    <div v-if="form.errors.has('type')" v-html="form.errors.get('type')" />
                        </div> 
                        <div class="form-group">
                            <label>Number</label>
                            <input v-model="form.no_of_animals" type="integer" name="no_of_animals"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_animals') }">
                                <div v-if="form.errors.has('no_of_animals')" v-html="form.errors.get('no_of_animals')" /> 
                        </div>                                                                
                        <div class="form-group">
                            <label>Description</label>  
                                    <textarea v-model="form.description" id="description"
                                    name="description" placeholder="Short description of the animal(optional)" class="form-control">
                                    </textarea>
                                    <div v-if="form.errors.has('description')" v-html="form.errors.get('description')" />
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

        <!-- Poultry Modal -->
        <div class="modal fade" id="poultryNew" tabindex="-1" role="dialog" aria-labelledby="poultryNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Poultry</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Poultry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updatePoultry() : createPoultry()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Owner</label>
                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('owner_id') }" v-model="form.owner_id">
                               <option value="">Select Owner</option>
                               <option 
                                  v-for="user in userslist" :key="user.id"
                                  :value="user.id"
                                  :selected="user.id == form.owner_id">{{ user.name }}</option>
                            </select>
                            <div v-if="form.errors.has('owner_id')" v-html="form.errors.get('owner_id')" />
                        </div> 
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                        </div>
                        <div class="form-group">
                            <label>Type</label>  
                                    <select v-model="form.type" id="type"
                                    name="role" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select Poultry Type</option>
                                    <option value="grade">Grade</option>
                                    <option value="exotic">Exotic</option>
                                    <option value="hybrid">Hybrid</option>
                                    <option value="kienyeji">Kienyeji</option>
                                    <option value="improved kienyeji">Improved Kienyeji</option>
                                    </select>
                                    <div v-if="form.errors.has('type')" v-html="form.errors.get('type')" />
                        </div> 
                        <div class="form-group">
                            <label>Number</label>
                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
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

        <!-- Resource Modal -->
        <div class="modal fade" id="resourceNew" tabindex="-1" role="dialog" aria-labelledby="resourceNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Resource</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Resource</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateResource() : createResource()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Owner</label>
                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('owner_id') }" v-model="form.owner_id">
                               <option value="">Select Owner</option>
                               <option 
                                  v-for="item in userslist" :key="item.id"
                                  :value="item.id"
                                  :selected="item.id == form.owner_id">{{ item.name }}</option>
                            </select>
                            <div v-if="form.errors.has('owner_id')" v-html="form.errors.get('owner_id')" />
                        </div>   
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode:false,
                form: new Form({
                      id: '',
                      owner_id: '',
                      acreage: '',
                      farm_id: '',
                      name: '',
                      type: '',
                      description: '',
                      no_of_animals: '',
                      no_of_poultries: ''
                }),
                userslist: {},
                farms: {},
                crops: {},
                animals: {},
                poultries: {},
                resources: {}
            }
        },
        methods: {
            farmModal(){
              this.editmode = false;
              this.form.reset();
              $('#farmNew').modal('show');                
            },
            editfarmModal(fam){
              this.editmode = true;
              this.form.reset();
              $('#farmNew').modal('show');
              this.form.fill(fam);              
            },
            createFarm(){
              this.$Progress.start();
              this.form.post('api/farm').then(() => {
              $('#farmNew').modal('hide') 
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Farm created successfully'
              })
              console.log('success')               
              Fire.$emit('RefreshFarm')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error occurred!')
              })
            },
            updateFarm(){
              this.$Progress.start();
              this.form.put('api/farm/'+this.form.id).then(() => {
              $('#farmNew').modal('hide') 
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Farm updated successfully'
              })
              console.log('success')               
              Fire.$emit('RefreshFarm')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error occurred!')
              })
            },
            deleteFarm(id){
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
                  this.form.delete('api/farm/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Farm has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshFarm');
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
            getFarms(page = 1) {
              axios.get('api/farm?page=' + page).then(({ data }) => (this.farms = data));
            },                       
            cropModal(){
              this.editmode = false;
              this.form.reset();
              $('#cropNew').modal('show');                
            }, 
            editModal(crop){
              this.editmode = true;
              this.form.reset();
              $('#cropNew').modal('show');
              this.form.fill(crop);  
            },                    
            createCrop(){
              this.$Progress.start();
              this.form.post('api/crop').then(() => {
              $('#cropNew').modal('hide') 
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Crop created successfully'
              })
              console.log('success')               
              Fire.$emit('RefreshCrop')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error occurred!')
              })
            },
            updateCrop(){
              this.$Progress.start();
              this.form.put('api/crop/'+this.form.id).then(() => {
              $('#cropNew').modal('hide')
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Crop updated successfully'
              })
              console.log('success')                
              Fire.$emit('RefreshCrop')
              }).catch(() => {
                this.$Progress.finish();
                console.log('error')
              })
            },
            deleteCrop(id){
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
                  this.form.delete('api/crop/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Crop has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshCrop');
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
            getCrops(page = 1) {
              axios.get('api/crop?page=' + page).then(({ data }) => (this.crops = data));
            },             
            animalModal(){
              this.editmode = false;
              this.form.reset();
              $('#animalNew').modal('show');                
            },
            editanimalModal(animal){
              this.editmode = true;
              this.form.reset();
              $('#animalNew').modal('show');
              this.form.fill(animal); 
            },
            createAnimal(){
              this.$Progress.start();
              this.form.post('api/animal').then(() => {
              $('#animalNew').modal('hide')
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Animal created successfully'
              })
              console.log('success')                
              Fire.$emit('RefreshAnimal')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error occurred!')
              })
            },
            updateAnimal(){
              this.$Progress.start();
              this.form.put('api/animal/'+this.form.id).then(() => {
              $('#animalNew').modal('hide') 
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Animal updated successfully'
              })
              console.log('success')               
              Fire.$emit('RefreshAnimal')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error')
              })
            },
            deleteAnimal(id){
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
                  this.form.delete('api/animal/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Animal has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshAnimal');
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
            getAnimals(page = 1) {
              axios.get('api/animal?page=' + page).then(({ data }) => (this.animals = data));
            },                    
            poultryModal(){
              this.editmode = false;
              this.form.reset();
              $('#poultryNew').modal('show');                
            },
            editpoultryModal(poultry){
              this.editmode = true;
              this.form.reset();
              $('#poultryNew').modal('show');
              this.form.fill(poultry); 
            },
            createPoultry(){
              this.$Progress.start();
              this.form.post('api/poultry').then(() => {
              $('#poultryNew').modal('hide')
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Poultry created successfully'
              })
              console.log('success')                
              Fire.$emit('RefreshPoultry')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error occurred!')
              })
            },
            updatePoultry(){
              this.$Progress.start();
              this.form.put('api/poultry/'+this.form.id).then(() => {
              $('#poultryNew').modal('hide')  
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Poultry updated successfully'
              })
              console.log('success')              
              Fire.$emit('RefreshPoultry')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error')
              })
            },
            deletePoultry(id){
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
                  this.form.delete('api/poultry/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Poultry has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshPoultry');
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
            getPoultries(page = 1) {
              axios.get('api/poultry?page=' + page).then(({ data }) => (this.poultries = data));
            }, 
            
            resourceModal(){
              this.editmode = false;
              this.form.reset();
              $('#resourceNew').modal('show');                
            },
            editresourceModal(item){
              this.editmode = true;
              this.form.reset();
              $('#resourceNew').modal('show');
              this.form.fill(item);              
            },
            createResource(){
              this.$Progress.start();
              this.form.post('api/resource').then(() => {
              $('#resourceNew').modal('hide')
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Resource created successfully'
              })
              console.log('success')                
              Fire.$emit('RefreshResource')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error occurred!')
              })
            },
            updateResource(){
              this.$Progress.start();
              this.form.put('api/resource/'+this.form.id).then(() => {
              $('#resourceNew').modal('hide')
              this.$Progress.finish();
              toast.fire({
                  icon: 'success',
                  title: 'Resource updated successfully'
              })
              console.log('success')                
              Fire.$emit('RefreshResource')
              }).catch(() => {
                this.$Progress.fail();
                console.log('error occurred!')
              })
            },
            deleteResource(id){
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
                  this.form.delete('api/resource/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Resource has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshResource');
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
            getResources(page = 1) {
              axios.get('api/resource?page=' + page).then(({ data }) => (this.resources = data));
            },                       

            getCrops(page = 1) {
              axios.get('api/crop?page=' + page).then(({ data }) => (this.crops = data));
            },            

            listUsers(){
              axios.get('api/listusers').then((response) => {
                this.userslist = response.data.data
              });
            },
            loadFarms(){
              axios.get('api/farm').then((response) =>
                   {this.farms = response.data;
              });
            },
            loadCrops(){
              axios.get('api/crop').then((response) => {
                this.crops = response.data
              });
            },
            loadAnimals(){
              axios.get('api/animal').then((response) => {
                this.animals = response.data
              });
            },
            loadPoultries(){
              axios.get('api/poultry').then((response) => {
                this.poultries = response.data
              });
            },
            loadResources(){
              axios.get('api/resource').then((response) => {
                this.resources = response.data
              });
            }                        
        },
        mounted() {
           this.listUsers();
           this.loadFarms();
           this.loadCrops();
           this.loadAnimals();
           this.loadPoultries();
           this.loadResources();
           Fire.$on('RefreshFarm',() => {
             this.loadFarms()
           });
           Fire.$on('RefreshCrop',() => {
             this.loadCrops()
           });
           Fire.$on('RefreshAnimal',() => {
             this.loadAnimals()
           });
           Fire.$on('RefreshPoultry',() => {
             this.loadPoultries()
           });
           Fire.$on('RefreshResource',() => {
             this.loadResources()
           });           
        }
    }
</script>
