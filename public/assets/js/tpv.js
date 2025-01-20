const categoriesContainer = document.getElementById('category-container');
const productsContainer = document.getElementById('product-container');
const openOrdersList = document.getElementById('open-orders-list');
const orderSummaryList = document.getElementById('order-summary-list');
const finalizeOrderButton = document.getElementById('finalize-order');

let order = [];

// Cargar categorías
function fetchCategories() {
  fetch('/categories')
    .then(response => response.json())
    .then(categories => {
      categoriesContainer.innerHTML = '';
      categories.forEach(category => {
        const button = document.createElement('button');
        button.innerHTML = `
          <img src="${category.image}" alt="${category.name}">
          <span>${category.name}</span>
        `;
        button.addEventListener('click', () => fetchProducts(category.id));
        categoriesContainer.appendChild(button);
      });
    });
}

// Cargar productos de una categoría
function fetchProducts(categoryId) {
  fetch(`/categories/${categoryId}/products`)
    .then(response => response.json())
    .then(products => {
      productsContainer.innerHTML = '';
      products.forEach(product => {
        const button = document.createElement('button');
        button.innerHTML = `
          <img src="${product.image}" alt="${product.name}">
          <span>${product.name}</span>
        `;
        button.addEventListener('click', () => addToOrder(product));
        productsContainer.appendChild(button);
      });
    });
}

// Añadir un producto al pedido
function addToOrder(product) {
  const existingItem = order.find(item => item.product.id === product.id);
  if (existingItem) {
    existingItem.quantity++;
    existingItem.total = existingItem.quantity * product.price;
  } else {
    order.push({ product, quantity: 1, total: product.price });
  }
  renderOrderSummary();
}

// Renderizar resumen del pedido
function renderOrderSummary() {
  orderSummaryList.innerHTML = '';
  order.forEach(item => {
    const li = document.createElement('li');
    li.textContent = `${item.product.name} x ${item.quantity} - ${item.total.toFixed(2)} €`;
    orderSummaryList.appendChild(li);
  });
}

// Finalizar pedido
function finalizeOrder() {
  if (order.length === 0) {
    alert('No hay productos en el pedido.');
    return;
  }

  const total = order.reduce((sum, item) => sum + item.total, 0);
  const items = order.map(item => ({
    product_id: item.product.id,
    quantity: item.quantity,
    price: item.product.price
  }));

  fetch('/orders', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ items, total })
  })
    .then(() => {
      alert('Pedido finalizado.');
      order = [];
      renderOrderSummary();
      fetchOpenOrders();
    });
}

// Cargar cuentas abiertas
function fetchOpenOrders() {
  fetch('/orders/open')
    .then(response => response.json())
    .then(orders => {
      openOrdersList.innerHTML = '';
      orders.forEach(order => {
        const li = document.createElement('li');
        li.textContent = `${order.numero} - ${order.total.toFixed(2)} €`;
        openOrdersList.appendChild(li);
      });
    });
}

// Inicializar
fetchCategories();
fetchOpenOrders();
finalizeOrderButton.addEventListener('click', finalizeOrder);
