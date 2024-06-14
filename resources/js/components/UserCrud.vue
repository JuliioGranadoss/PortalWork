<template>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="modelForm" name="modelForm" class="form-horizontal">
                        <div v-if="alert" class="card bg-danger text-white shadow m-2">
                            <div class="card-body p-3">
                                Alerta
                                <div class="text-white-50 small">{{ alert }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="id" v-model="user.id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12 control-label">Nombre*</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" placeholder="Nombre" v-model="user.name" required>
                                    </div>
                                </div>
        
                                <div class="form-group">
                                    <label for="email" class="col-sm-12 control-label">Email*</label>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" placeholder="Email" v-model="user.email" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email" class="col-sm-12 control-label">Role*</label>
                                    <div class="col-sm-12">
                                        <select class="select form-control" name="role" id="role" v-model="user.role">
                                            <option value="admin">Administrador</option>      
                                            <option value="manager">Manager</option>                                            
                                            <option value="worker">Trabajador</option>                                            
                                        </select>
                                    </div>
                                </div>                            

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label">Contraseña<span v-if="type == 'create'">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" placeholder="Contraseña" v-model="user.password" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="passwordVerify" class="col-sm-12 control-label">Repetir contraseña<span>*</span></label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" placeholder="Repetir contraseña" v-model="user.passwordVerify" autocomplete="off">
                                    </div>
                                </div>                        
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary" v-bind:disabled="disable">Guardar</button>
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
                title: null,
                alert: null,
                type: null,
                disable: false,
                oldEmail: null,
                user: {}
            }
        },
        methods: {
            submit() {
                let self = this;
                this.disable = true;
                axios.post('/users', this.user)
                .then(function (response) {
                    $('#modelForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#total_users').html(response.data.total);
                    $('#users-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    $('#saveBtn').html('Guardar cambios');
                });
            },
            checkBeforeSubmit() {
                this.alert = "";

                if (!this.user.name) {
                    this.alert = "Nombre es un campo obligatorio";
                    return;
                }

                if (this.user.password && this.user.password !== this.user.passwordVerify) {
                    this.alert = "Contraseñas no coinciden";
                    return;
                }

                this.checkEmail();
            },
            checkEmail() {
                var self = this;

                if (!this.user.email) {
                    this.alert = "Email es un campo obligatorio";
                    return 2;
                }

                if (this.type == 'create') {
                    if (!this.user.password) {
                        this.alert = "Contraseña es un campo obligatorio";
                        return 2;
                    }
                }

                if (this.user.email == this.user.oldEmail) {
                    this.submit();
                    return 2;
                }

                axios.post('/users/check-email', {email: this.user.email})
                .then(function (response) {
                    if (response.data) {
                        self.alert = "Ya hay un usaurio registrado con este email.";
                    } else {
                        self.submit();
                    }
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
            },
            setUser(data) {
                this.user = data;
                this.user.oldEmail = data.email;
            },
            resetUser() {
                this.user = {
                    id: null,
                    name: null,
                    email: null,
                    role: 'worker',
                    password: null,
                    passwordVerify: null
                };
            },
        },
        mounted() {
            let self = this;

            $('#createNewModel').click(function () {
                self.title = 'Crear nuevo usuario';
                self.type = 'create';
                self.resetUser();
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editModel', function () {
                var id = $(this).data('id');
                axios.get('users/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar usuario';
                    $('#ajaxModel').modal('show');
                    self.type = 'update';
                    self.setUser(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
            });

            $('body').on('click', '.deleteModel', function () {
                var id = $(this).data("id");
                self.$swal({
                    title: "¿Estas seguro?",
                    text: "¿Estas seguro de que quieres eliminar este usuario?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then((data) => {
                    if (data.isConfirmed) {
                        axios.delete('users/' + id)
                            .then(function (response) {
                                $('#users-table').DataTable().draw();
                            })
                            .catch(function (error) {
                                console.log('Error:', error);
                            });
                    }
                });
            });

        }
    }
</script>
