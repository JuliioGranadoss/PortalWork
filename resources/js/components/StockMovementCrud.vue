<template>
    <div class="modal fade" id="ajaxModelMovement" aria-hidden="true">
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
                                <label for="place_id" class="control-label">Lugar*</label>
                                <v-select label="name" :reduce="place => place.id" v-model="model.place_id"
                                    :options="places"></v-select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="personal_id" class="control-label">Personal*</label>
                                <v-select label="name" :reduce="personal => personal.id" v-model="model.personal_id"
                                    :options="personals"></v-select>
                            </div>
                        </div>

                        <div class="mb-3" v-if="edit == false">
                            <label for="barcodeInput" class="form-label">Código de Barras</label>
                            <input type="text" class="form-control" id="barcodeInput" v-model="model.barcode"
                                placeholder="Ingrese el código de barras" @input="autoSearch">
                        </div>
                        <div v-if="products.length > 0 && edit == false" class="mb-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products" :key="index">
                                        <td>{{ product.name }}</td>
                                        <td>
                                            <input type="number" class="form-control" v-model="product.stock">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger"
                                                @click="removeProduct(index)">Borrar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-if="model.stock_history.length > 0 && edit == true" class="mb-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in model.stock_history" :key="index">
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>
                                            <span v-if="product.type === 1">Entrada</span>
                                            <span v-else>Salida</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary" :disabled="disable">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

export default {
    components: {
        vSelect
    },
    data() {
        return {
            title: null,
            alert: null,
            disable: false,
            edit: false,
            model: {
                id: null,
                stock_history: [],
                place_id: null,
                personal_id: null,
                signature_id: null,
                status: 1,
                barcode: null
            },
            places: [],
            personals: [],
            products: [],
            typingTimer: null,
            doneTypingInterval: 1500
        }
    },
    methods: {
        getPlaces() {
            axios.get('/stockplaces/get/data')
                .then(response => {
                    this.places = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener los lugares:', error);
                });
        },
        getPersonal() {
            axios.get('/stockpersonals/get/data')
                .then(response => {
                    this.personals = response.data;
                })
                .catch(error => {
                    console.error('Error al obtener el personal:', error);
                });
        },
        submit() {
            this.disable = true;
            this.model.products = this.products;
            axios.post('/stockmovements', this.model)
                .then(response => {
                    $('#modelForm').trigger("reset");
                    $('#ajaxModelMovement').modal('hide');
                    this.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Guardado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    this.disable = false;
                    $('#stock-movement-table').DataTable().draw();
                })
                .catch(error => {
                    console.log('Error:', error);
                    this.disable = false;
                    this.alert = 'Error al guardar el movimiento.';
                });
        },
        checkBeforeSubmit() {
            this.alert = "";

            if (!this.model.place_id || !this.model.personal_id) {
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
                place_id: null,
                personal_id: null,
                signature_id: null,
                stock_history: [],
                status: 1,
                barcode: null
            };
        },
        ajustTable() {
            $('#stock-movement-table').DataTable().columns.adjust().draw();
        },
        searchByBarcode() {
            let self = this;
            this.disable = true;

            self.$swal.fire({
                icon: 'loading',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    self.$swal.showLoading();
                },
            })

            axios.get(`/stockmovements/searchByBarcode/${this.model.barcode}`)
                .then(function (response) {
                    self.$swal.close();

                    if (response.data.product) {
                        let merge = false;
                        let item = {
                            id: response.data.product.id,
                            name: response.data.product.name,
                            stock: 1,
                        };
                        self.products.forEach(function (product, key) {
                            if (product.id == item.id) {
                                merge = true;
                                self.products[key].stock += item.stock;
                            }
                        });
                        if (!merge) {
                            self.products.push(item);
                        }
                    } else {
                        self.$swal({
                            icon: 'error',
                            title: 'Producto no encontrado',
                            text: 'El producto no fue encontrado en la base de datos.'
                        });
                    }
                })
                .catch(function (error) {
                    console.log('Error:', error);

                    self.$swal.close();
                })
                .finally(function () {
                    self.disable = false;
                });
        },
        checkBeforeSubmitBarcode() {
            if (!this.model.barcode) {
                this.alert = "Por favor, completa todos los campos obligatorios.";
            } else {
                this.alert = null;
                this.searchByBarcode();
            }
        },
        clearTable() {
            this.products = [];
        },
        removeProduct(index) {
            this.products.splice(index, 1);
            this.$swal.fire(
                'Eliminado',
                'El producto ha sido eliminado correctamente.',
                'success'
            );
        },
        autoSearch() {
            clearTimeout(this.typingTimer);

            this.typingTimer = setTimeout(() => {
                if (this.model.barcode.trim() !== "") {
                    this.searchByBarcode();
                }
            }, this.doneTypingInterval);
        },
        clearBarcodeInput() {
            this.model.barcode = '';
        },
        clearAll() {
            this.clearTable();
            this.clearBarcodeInput();
        }
    },
    mounted() {
        this.getPlaces();
        this.getPersonal();

        $('#nav-stockmovements-tab[data-toggle="tab"]').on('shown.bs.tab', this.ajustTable);

        $('#createNewModelMovement').click(() => {
            this.title = 'Añadir nuevo movimiento';
            this.edit = false;
            this.resetModel();
            $('#ajaxModelMovement').modal('show');
        });

        $('body').on('click', '.editModelMovement', event => {
            const id = $(event.currentTarget).data('id');
            axios.get(`/stockmovements/${id}/edit`)
                .then(response => {
                    this.title = 'Editar movimiento';
                    this.edit = true;
                    $('#ajaxModelMovement').modal('show');
                    this.setModel(response.data);
                })
                .catch(error => {
                    console.log('Error:', error);
                });
        });

        $('body').on('click', '.deleteModelMovement', event => {
            const id = $(event.currentTarget).data("id");
            this.$swal({
                title: "¿Estás seguro?",
                text: "¿Estás seguro de que quieres eliminar este movimiento?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Eliminar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(data => {
                if (data.isConfirmed) {
                    axios.delete(`/stockmovements/${id}`)
                        .then(response => {
                            $('#stock-movement-table').DataTable().draw();
                        })
                        .catch(error => {
                            console.log('Error:', error);
                        });
                }
            });
        });
    }
}
</script>
