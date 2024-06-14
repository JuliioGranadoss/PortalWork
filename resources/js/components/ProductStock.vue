<template>
    <div class="modal fade" id="ajaxProductStock" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Insertar código de barras</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="checkBeforeSubmit" id="barcodeForm" name="barcodeForm"
                        class="form-horizontal">
                        <div class="mb-3">
                            <label for="barcodeInput" class="form-label">Código de Barras</label>
                            <input type="text" class="form-control" id="barcodeInput" v-model="model.barcode"
                                placeholder="Ingrese el código de barras" required @input="autoSearch">
                        </div>
                        <div v-if="products.length > 0" class="mb-3">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning text-dark" @click="clearAll">Limpiar</button>
                    <button type="button" class="btn btn-primary" @click="saveChanges">Guardar</button>
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
                provider_id: $('#provider_id').val(),
                name: null,
                description: null,
                stock: null,
                status: 1,
                barcode: null
            },
            products: [],
            typingTimer: null,
            doneTypingInterval: 1500
        }
    },
    methods: {
        submit() {
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
        checkBeforeSubmit() {
            if (!this.model.barcode) {
                this.alert = "Por favor, completa todos los campos obligatorios.";
            } else {
                this.alert = null;
                this.submit();
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
                    this.submit();
                }
            }, this.doneTypingInterval);
        },
        clearBarcodeInput() {
            this.model.barcode = '';
        },
        clearAll() {
            this.clearTable();
            this.clearBarcodeInput();
        },
        saveChanges() {
            let self = this;
            this.$swal.fire({
                icon: 'loading',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    self.$swal.showLoading();
                },
            });

            axios.post('/stockmovements/updateProducts', { products: this.products })
                .then(response => {
                    self.$swal.fire(
                        'Actualizado',
                        'Los productos han sido actualizados correctamente.',
                        'success'
                    );
                })
                .catch(error => {
                    console.error('Error al actualizar los productos:', error);
                    self.$swal.fire(
                        'Error',
                        'Se produjo un error al intentar actualizar los productos.',
                        'error'
                    );
                });
        }
    },
    mounted() {
        let self = this;

        $('#nav-products-tab[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            self.ajustTable();
        });

        $('#createNewProductStock').click(function () {
            $('#ajaxProductStock').modal('show');
        });
    }
}
</script>
