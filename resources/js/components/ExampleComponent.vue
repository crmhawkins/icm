<template>
    <div class="tpv">
      <div class="categories">
        <h2>Categorías</h2>
        <div v-for="category in categories" :key="category.id" @click="selectCategory(category.id)" class="category">
          <img :src="category.image" alt="" />
          <p>{{ category.name }}</p>
        </div>
      </div>

      <div class="products">
        <h2>Productos</h2>
        <div v-for="product in products" :key="product.id" @click="addToCart(product)" class="product">
          <img :src="product.image" alt="" />
          <p>{{ product.name }}</p>
          <p>{{ product.price }} €</p>
        </div>
      </div>

      <div class="cart">
        <h2>Carrito</h2>
        <div v-for="item in cart" :key="item.id" class="cart-item">
          <p>{{ item.name }} x {{ item.quantity }}</p>
          <p>{{ item.price * item.quantity }} €</p>
        </div>
        <button @click="storeOrder">Guardar Orden</button>
        <button @click="closeOrder">Cerrar Orden</button>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        categories: [],
        products: [],
        cart: [],
        selectedOrder: null,
      };
    },
    methods: {
      async fetchCategories() {
        const response = await axios.get('/api/categories');
        this.categories = response.data;
      },
      async selectCategory(categoryId) {
        const response = await axios.get(`/api/products/${categoryId}`);
        this.products = response.data;
      },
      addToCart(product) {
        const existing = this.cart.find(item => item.id === product.id);
        if (existing) {
          existing.quantity++;
        } else {
          this.cart.push({ ...product, quantity: 1 });
        }
      },
      async storeOrder() {
        const response = await axios.post('/api/orders');
        this.selectedOrder = response.data;

        for (const item of this.cart) {
          await axios.post(`/api/orders/${this.selectedOrder.id}/add-item`, {
            product_id: item.id,
            quantity: item.quantity,
            price: item.price * item.quantity,
          });
        }
      },
      async closeOrder() {
        await axios.patch(`/api/orders/${this.selectedOrder.id}/close`);
        this.cart = [];
        this.selectedOrder = null;
      },
    },
    mounted() {
      this.fetchCategories();
    },
  };
  </script>

  <style>
  /* Estilos para un diseño profesional */
  .tpv {
    display: flex;
    gap: 20px;
  }

  .categories, .products, .cart {
    flex: 1;
    border: 1px solid #ddd;
    padding: 20px;
  }

  .category, .product, .cart-item {
    cursor: pointer;
    margin-bottom: 10px;
  }

  .category img, .product img {
    width: 100%;
    height: auto;
  }
  </style>
