<template>
  <div>
    <h1>Products Listing</h1>

    <div>
      <select v-model="selectedCategory" @change="filterProducts">
        <option value="">All Categories</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
      </select>
    </div>

    <div>
      <button @click="sortByPrice('asc')">Sort by price: Low To High</button>
      <button @click="sortByPrice('desc')">Sort by price: High To Low</button>
    </div>

    <div v-if="loading">Loading products...</div>
    <div v-else>
      <div v-if="error">{{ error }}</div>
      <div v-else>
        <div v-for="product in filteredProducts" :key="product.id">
          <h2>{{ product.name }}</h2>
          <h4>${{ product.price }}</h4>
          <p>Description: {{ product.description }}</p>
          <p>Categories: {{ product.categories.map(c => c.name).join(', ') }}</p>
          <img :src="product.image" alt="Product Image" width="100">
          <button @click="editProduct(product.id)">Edit</button>
          <button @click="deleteProduct(product.id)">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
//original 
const products = ref([]);
const loading = ref(false);
const error = ref('');
const categories = ref([]);
const selectedCategory = ref('');
const sortOrder = ref('asc');

const fetchProducts = async (categoryId = null) => {
  try {
    loading.value = true;
    const response = await axios.get('/api/products', {
      params: {
        category_id: categoryId
      }
    });
    products.value = response.data;
  } catch (err) {
    error.value = `Error fetching products: ${err.message}`;
  } finally {
    loading.value = false;
  }
};

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/categories');
    categories.value = response.data;
  } catch (err) {
    error.value = `Error fetching categories: ${err.message}`;
  }
};

onMounted(() => {
  fetchProducts();
  fetchCategories();
});

const router = useRouter();

const filterProducts = () => {
  fetchProducts(selectedCategory.value);
};

const sortByPrice = (order) => {
  sortOrder.value = order;
  products.value.sort((a, b) => {
    if (order === 'asc') {
      return a.price - b.price;
    } else {
      return b.price - a.price;
    }
  });
};

const filteredProducts = computed(() => {
  return products.value;
});

const editProduct = (id) => {
  router.push({ name: 'products.edit', params: { id } });
};

const deleteProduct = async (id) => {
  try {
    loading.value = true;
    await axios.delete(`/api/products/${id}`);
    products.value = products.value.filter(p => p.id !== id);
  } catch (err) {
    error.value = `Error deleting product: ${err.message}`;
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>

</style>
