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
                                <label for="name" class="control-label">Nombre del producto*</label>
                                <input type="text" class="form-control" v-model="model.name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="description" class="control-label">Descripción</label>
                                <input type="text" class="form-control" v-model="model.description">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="stock" class="control-label">Cantidad*</label>
                                <input type="number" class="form-control" v-model="model.stock" min="0" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status" class="control-label">Proveedor</label>
                                <v-select label="name" :reduce="provider => provider.id" v-model="model.provider_id" :options="providers"></v-select>                            
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status" class="control-label">Estado del producto*</label>
                                <select class="select form-control" name="status" id="status" v-model="model.status" required>
                                    <option value="0">No disponible</option>
                                    <option value="1">Disponible</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary" v-bind:disabled="disable">Guardar producto</button>
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
            providers: [],
            model: {
                id: null,
                provider_id: $('#provider_id').val(),
                name: null,
                description: null,
                stock: null,
                status: 1
            }
        }
    },
    methods: {
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/products', this.model)
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
                    $('#product-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar el producto.';
                });
        },
        checkBeforeSubmit() {
            this.alert = "";

            if (!this.model.name || !this.model.stock ||!this.model.status) {
                this.alert = "Por favor, completa todos los campos obligatorios.";
                return;
            }

            this.submit();
        },
        setModel(data) {
            this.model = data;
        },
        resetModel() {
            this.model = {
                id: null,
                provider_id: $('#provider_id').val(),
                name: null,
                description: null,
                stock: null,
                status: 1
            };
        },
        ajustTable() {
            $('#product-table').DataTable().columns.adjust().draw();
        },
        getProviders() {
            axios.get('/providers/get/data')
                .then(response => {
                    this.providers = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener los proveedores:', error);
                });

        }
    },
    mounted() {
        let self = this;
        this.getProviders();

        $('#nav-products-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        $('#createNewModel').click(function () {
            self.title = 'Añadir nuevo producto';
            self.resetModel();
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editModel', function () {
            var id = $(this).data('id');
            axios.get('/products/' + id + '/edit')
                .then(function (response) {
                    self.title = 'Editar producto';
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
                text: "¿Estás seguro de que quieres eliminar este producto?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/products/' + id)
                        .then(function (response) {
                            $('#product-table').DataTable().draw();
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
