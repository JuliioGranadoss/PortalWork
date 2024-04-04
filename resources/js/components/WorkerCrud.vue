<template>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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
                        <input type="hidden" name="id" v-model="model.id">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="control-label">Nombre*</label>
                                <input type="text" class="form-control" v-model="model.name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="surname" class="control-label">Apellidos*</label>
                                <input type="text" class="form-control" v-model="model.surname" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dni" class="control-label">DNI*</label>
                                <input type="text" class="form-control" id="dni" name="dni" pattern="[0-9]{8}[A-Za-z]"
                                    title="Formato de DNI incorrecto (8 dígitos seguidos de una letra)" v-model="model.dni" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">Email*</label>
                                <input type="email" class="form-control" v-model="model.email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birth_date" class="control-label">Fecha de Nacimiento*</label>
                                <input type="date" class="form-control" v-model="model.birth_date" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="description" class="control-label">Descripción</label>
                                <textarea type="text" class="form-control" v-model="model.description"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address" class="control-label">Dirección</label>
                                <input type="text" class="form-control" v-model="model.address">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postal_code" class="control-label">Código Postal</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                    pattern="[0-9]{5}" title="El código postal debe contener 5 dígitos numéricos" v-model="model.postal_code">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="province" class="control-label">Provincia</label>
                                <input type="text" class="form-control" v-model="model.province">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="location" class="control-label">Localidad</label>
                                <input type="text" class="form-control" v-model="model.location">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone" class="control-label">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{9}"
                                    title="El teléfono debe contener 9 dígitos numéricos" v-model="model.phone">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status" class="control-label">Estado*</label>
                                <select class="select form-control" name="status" id="status" v-model="model.status" required>
                                    <option value="0">Baja</option>
                                    <option value="1">Alta</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary" v-bind:disabled="disable">Guardar trabajador</button>
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
            disable: false,
            model: {
                id: null,
                name: null,
                surname: null,
                dni: null,
                email: null,
                birth_date: null,
                description: null,
                address: null,
                postal_code: null,
                province: null,
                location: null,
                phone: null,
                status: 1
            }
        }
    },
    methods: {
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/workers', this.model)
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
                    $('#worker-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar el trabajador.';
                });
        },

        sendEmail() {
            this.$swal({
                title: '¿Enviar correo electrónico?',
                text: '¿Estás seguro de que quieres enviar un correo electrónico a este trabajador?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí iría la lógica para enviar el correo electrónico
                    this.$swal('¡Correo electrónico enviado!', 'El correo electrónico ha sido enviado correctamente.', 'success');
                }
            });
        },

        
        checkBeforeSubmit() {
            this.alert = "";

            if (!this.model.name || !this.model.surname || !this.model.dni || !this.model.email || !this.model.birth_date) {
                this.alert = "Por favor, completa todos los campos obligatorios.";
                return;
            }

            this.submit();
        },
        setModel(data) {
            this.model = data;
            this.model.birth_date = moment(String(this.model.birth_date)).format('YYYY-MM-DD');
        },
        resetModel() {
            this.model = {
                id: null,
                name: null,
                surname: null,
                dni: null,
                email: null,
                birth_date: null,
                description: null,
                address: null,
                postal_code: null,
                province: null,
                location: null,
                phone: null,
                status: 1
            };
        },
        ajustTable() {
            $('#worker-table').DataTable().columns.adjust().draw();
        }
    },
    mounted() {
        let self = this;

        $('#nav-workers-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        $('#createNewModel').click(function () {
            self.title = 'Añadir nuevo trabajador';
            self.resetModel();
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editModel', function () {
            var id = $(this).data('id');
            axios.get('/workers/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar trabajador';
                    $('#ajaxModel').modal('show');
                    self.setModel(response.data);
                })
                .catch(function (error) {
                    console.log('Error:', error);
                });
        });

        $('body').on('click', '.deleteModel', function () {
            var id = $(this).data("id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar este trabajador?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/workers/' + id)
                        .then(function (response) {
                            $('#worker-table').DataTable().draw();
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