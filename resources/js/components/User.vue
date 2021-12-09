<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="userModal()">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Registered On</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.role | capitalizeFirstLetter}}</td>
                      <td>{{user.created_at }}</td>
                                <td>                                   
                                    <a href="#" @click="edituserModal(user)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(user.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td> 
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

                        <!-- User Modal -->
                        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New User</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? editUser() : createUser()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input v-model="form.name" type="text" name="name"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input v-model="form.email" type="text" name="email"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                                <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>  
                                                    <input type="text" list="roles" v-model="form.role" id="role"
                                                    name="role" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }" />
                                                    <datalist id= "roles">
                                                    <option value="">Select Role</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="farmer">Farmer</option>
                                                    <option value="user">User</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('role')" v-html="form.errors.get('role')" />
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input v-model="form.password" type="password" name="password"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                                <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" /> 
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
        data () {
            return {
                editmode: false,
                form: new Form({
                id: '',    
                name: '',
                role: '',
                email: '',
                password: ''                    
                }),
                users: {}
            }
        },
        methods: {
            userModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');                

            },
            edituserModal(item){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(item)
            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/user').then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'User has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshUsers')
                }).catch(() => {
                    console.log('error')
                })
            },
            editUser(){
                this.$Progress.start();
                this.form.put('api/user/'+ this.form.id).then(() => {
                    $('#addNew').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'User has been updated',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshUsers')
                }).catch(() => {
                    console.log('error')
                })
            },
            deleteUser(id){
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
                  this.form.delete('api/user/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'User has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshUsers');
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
        loadUsers(){
            axios.get('api/user').then(({data}) => {
                this.users = data
            })
        }
        },
        mounted() {
            this.loadUsers();
            Fire.$on('RefreshUsers',()=>{
                this.loadUsers();
            });
            console.log('Component mounted.')
        }
    }
</script>
