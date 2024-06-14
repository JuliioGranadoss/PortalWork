<template>
    <div class="modal fade" id="ajaxCategoryProduct" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">{{ title }}</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="CategoryProductForm" name="CategoryProductForm"
                        class="form-horizontal">
                        <div v-if="alert" class="card bg-danger text-white shadow m-2">
                            <div class="card-body p-3">
                                Alerta
                                <div class="text-white-50 small">{{ alert }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" v-model="product_id">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="category_id" class="control-label">Categoría</label>
                                <select class="form-control" name="category_id" v-model="model.category_id" required>
                                    <option v-for="category in availableCategories" :value="category.id">{{category.name }}</option>
                                </select>
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
            title: 'Asignar categoría al producto',
            alert: null,
            disable: false,
            product_id: $('#product_id').val(),
            model: {
                product_id: this.product_id,
                category_id: null,
            },
            availableCategories: [] // Lista de categorías disponibles
        }
    },
    methods: {
        // Método para obtener las categorías disponibles
        getAvailableCategories() {
            axios.get('/categoryproducts/' + this.product_id + '/available-categories')
                .then(response => {
                    this.availableCategories = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener las categorías:', error);
                });
        },
        // Método para enviar el formulario
        submit() {
            let self = this;
            this.disable = true;
            axios.post('/categoryproducts', this.model)
                .then(function (response) {
                    $('#CategoryProductForm').trigger("reset");
                    $('#ajaxCategoryProduct').modal('hide');
                    self.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    self.disable = false;
                    $('#categoryproduct-table').DataTable().draw();
                })
                .catch(function (error) {
                    console.log('Error:', error);
                    self.disable = false;
                    self.alert = 'Error al guardar la categoría.';
                });
        },

        // Método para verificar el formulario antes de enviar
        checkBeforeSubmit() {
            this.alert = "";
            if (!this.model.category_id) {
                this.alert = "Debes seleccionar una categoría.";
                return;
            }
            this.submit();
        },

        // Método para reiniciar el modelo del formulario
        resetModel() {
            this.model = {
                product_id: this.product_id,
                category_id: null,
            };
        },
        // Método para ajustar la tabla de categorías
        ajustTable() {
            $('#categoryproduct-table').DataTable().columns.adjust().draw();
        }
    },
    mounted() {
        let self = this;

        // Ajustar la tabla cuando se muestra la pestaña de categorías
        $('#nav-categoryproducts-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        // Obtener las categorías disponibles al abrir el modal
        $('#ajaxCategoryProduct').on('show.bs.modal', function (e) {
            self.getAvailableCategories(); // Llamar al método para cargar las categorías disponibles
        });

        $('#createNewCategoryProduct').click(function () {
            self.title = 'Seleccionar categoría';
            self.resetModel();
            $('#ajaxCategoryProduct').modal('show');
        });

        $('body').on('click', '.deleteCategoryProduct', function () {
            var category_id = $(this).data("category_id");
            var product_id = $(this).data("product_id");
            self.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar esta categoría?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then((data) => {
                if (data.isConfirmed) {
                    axios.delete('/categoryproducts/' + product_id + '/' + category_id + '/destroy')
                        .then(function (response) {
                            $('#categoryproduct-table').DataTable().draw();
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
