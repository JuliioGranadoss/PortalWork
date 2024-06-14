<template>
    <div class="row mb-3 no-gutters">
        <div class="col-md-12">
            <h5 class="border-bottom">Filtros</h5>
        </div>
        <div class="form-group pl-2">
            <label><strong>Nombre:</strong></label>
            <input type="text" id="name" class="form-control" placeholder="Nombre del producto" v-model="name">
        </div>

        <div class="form-group pl-2">
            <label><strong>Descripción:</strong></label>
            <input type="text" id="description" class="form-control" placeholder="Descripción" v-model="description">
        </div>
        <div class="form-group pl-2">
            <label><strong>Cantidad:</strong></label>
            <input type="number" min="0" id="stock" class="form-control" placeholder="Cantidad" v-model="stock">
        </div>
        <div class="form-group pl-2">
            <label><strong>Proveedor:</strong></label>
            <select id="provider" class="form-control" v-model="provider">
                <option value="">Selecciona proveedor</option>
                <option v-for="provider in providers" :value="provider.id" :key="provider.id">
                    {{ provider.name }}
                </option>
            </select>
        </div>
        <div class="form-group pl-2">
            <label><strong>Categoría:</strong></label>
            <select id="category" class="form-control" v-model="category">
                <option value="">Selecciona categoría</option>
                <option v-for="category in categories" :value="category.id" :key="category.id">
                    {{ category.name }}
                </option>
            </select>
        </div>
        <div class="form-group pl-2">
            <label><strong>Estado:</strong></label>
            <select id="status" class="form-control" v-model="status">
                <option value="">Selecciona estado</option>
                <option value="1">Disponible</option>
                <option value="0">No disponible</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            description: "",
            stock: "",
            provider: "",
            category: "",
            status: "",
            categories: [],
            providers: [],
        };
    },
    watch: {
        name() {
            $('#product-table').DataTable().columns(2).search(this.name).draw();
        },
        description() {
            $('#product-table').DataTable().columns(3).search(this.description).draw();
        },
        stock() {
            $('#product-table').DataTable().columns(7).search(this.stock).draw();
        },
        provider() {
            $('#product-table').DataTable().columns(1).search(this.provider).draw();
        },
        category() {
            $('#product-table').DataTable().columns(4).search(this.category).draw();
        },
        status() {
            $('#product-table').DataTable().columns(8).search(this.status).draw();
        },
    },
    methods: {
        getCategories() {
            axios.get('/categories/get/data')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getProviders() {
            axios.get('/providers/get/data')
                .then(response => {
                    this.providers = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.getCategories();
        this.getProviders();
    },
};
</script>
